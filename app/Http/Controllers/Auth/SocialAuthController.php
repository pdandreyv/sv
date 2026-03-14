<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        if (in_array($provider, ['google', 'facebook'], true)) {
            return Socialite::driver($provider)->redirect();
        }

        if ($provider === 'telegram') {
            $botId = (string) config('services.telegram.bot_id');
            $redirect = (string) config('services.telegram.redirect');

            if ($botId === '' || $redirect === '') {
                return redirect()->route('login')
                    ->with('warning', 'Telegram вход не настроен. Укажите TELEGRAM_BOT_ID и TELEGRAM_REDIRECT_URI.');
            }

            $query = http_build_query([
                'bot_id' => $botId,
                'origin' => parse_url(config('app.url'), PHP_URL_HOST),
                'return_to' => $redirect,
                'request_access' => 'write',
            ]);

            return redirect()->away('https://oauth.telegram.org/auth?' . $query);
        }

        abort(404);
    }

    public function callback(string $provider): RedirectResponse
    {
        try {
            if (in_array($provider, ['google', 'facebook'], true)) {
                $socialUser = Socialite::driver($provider)->user();

                $providerId = (string) $socialUser->getId();
                $email = $socialUser->getEmail()
                    ? Str::lower((string) $socialUser->getEmail())
                    : "{$provider}_{$providerId}@no-email.local";
                $name = trim((string) ($socialUser->getName() ?: $socialUser->getNickname() ?: 'Пользователь'));
                $avatar = $socialUser->getAvatar();

                $user = $this->resolveUser($provider, $providerId, $email, $name, $avatar, null);
                Auth::login($user, true);

                return redirect()->route('profile.my-page', ['id' => $user->id]);
            }

            if ($provider === 'telegram') {
                $botToken = (string) config('services.telegram.bot_token');
                if ($botToken === '') {
                    return redirect()->route('login')
                        ->with('warning', 'Telegram вход не настроен. Укажите TELEGRAM_BOT_TOKEN.');
                }

                if (!$this->validateTelegramAuth($botToken)) {
                    return redirect()->route('login')
                        ->with('warning', 'Не удалось подтвердить Telegram авторизацию.');
                }

                $tgId = (string) request('id', '');
                if ($tgId === '') {
                    return redirect()->route('login')
                        ->with('warning', 'Не получен Telegram ID пользователя.');
                }

                $firstName = trim((string) request('first_name', ''));
                $lastName = trim((string) request('last_name', ''));
                $username = trim((string) request('username', ''));
                $photoUrl = trim((string) request('photo_url', ''));

                $name = trim($firstName . ' ' . $lastName);
                if ($name === '') {
                    $name = $username !== '' ? "@{$username}" : 'Telegram пользователь';
                }

                $email = "telegram_{$tgId}@telegram.local";
                $user = $this->resolveUser('telegram', $tgId, $email, $name, $photoUrl, $username !== '' ? $username : null);

                Auth::login($user, true);

                return redirect()->route('profile.my-page', ['id' => $user->id]);
            }
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->with('warning', 'Не удалось выполнить вход через ' . ucfirst($provider) . '.');
        }

        abort(404);
    }

    private function resolveUser(
        string $provider,
        string $providerId,
        string $email,
        string $name,
        ?string $avatar,
        ?string $telegramUsername
    ): User {
        $user = User::where('social_provider', $provider)
            ->where('social_id', $providerId)
            ->first();

        if (!$user && $email !== '') {
            $user = User::where('email', $email)->first();
        }

        if (!$user) {
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make(Str::random(40));
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $user->email_verified_at = now();
            }
        } else {
            if (!$user->name) {
                $user->name = $name;
            }
        }

        $user->social_provider = $provider;
        $user->social_id = $providerId;
        if ($avatar) {
            $user->avatar = $avatar;
        }
        if ($telegramUsername !== null) {
            $user->telegram_username = $telegramUsername;
        }
        if ($provider === 'telegram' && !$user->email) {
            $user->email = $email;
        }

        $user->save();

        return $user;
    }

    private function validateTelegramAuth(string $botToken): bool
    {
        $data = request()->except('hash');
        $hash = (string) request('hash', '');
        if ($hash === '' || empty($data)) {
            return false;
        }

        ksort($data);
        $checkData = [];
        foreach ($data as $key => $value) {
            $checkData[] = $key . '=' . $value;
        }
        $dataCheckString = implode("\n", $checkData);

        $secret = hash('sha256', $botToken, true);
        $calculatedHash = hash_hmac('sha256', $dataCheckString, $secret);

        if (!hash_equals($calculatedHash, $hash)) {
            return false;
        }

        $authDate = (int) request('auth_date', 0);
        if ($authDate > 0 && (time() - $authDate) > 86400) {
            return false;
        }

        return true;
    }
}
