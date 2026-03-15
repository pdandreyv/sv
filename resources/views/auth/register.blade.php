@extends('layouts.app')

@section('content')
<div class="auth-form-page">
    <div class="auth-page-title">
        <h2>Регистрация</h2>
    </div>

    <div class="auth-card auth-card-register">
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input id="name" type="text" placeholder="Имя" class="form-control auth-input" name="name" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" placeholder="Адрес E-Mail" class="form-control auth-input" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" placeholder="Пароль" class="form-control auth-input" name="password" required>
                @if ($errors->has('password'))
                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <input id="password-confirm" placeholder="Подтверждение пароля" type="password" class="form-control auth-input" name="password_confirmation" required>
            </div>

            <div class="auth-actions">
                <button type="submit" class="btn auth-btn auth-btn-primary">Зарегистрироваться</button>
            </div>
        </form>

        <div class="auth-social">
            <div class="auth-social-title">или зарегистрироваться через</div>
            <div class="auth-social-buttons">
                <a class="btn auth-social-btn auth-social-google" href="{{ route('auth.social.redirect', ['provider' => 'google']) }}">
                    <i class="fab fa-google"></i> Google
                </a>
                <a class="btn auth-social-btn auth-social-facebook" href="{{ route('auth.social.redirect', ['provider' => 'facebook']) }}">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a class="btn auth-social-btn auth-social-telegram" href="{{ route('auth.social.redirect', ['provider' => 'telegram']) }}">
                    <i class="fab fa-telegram-plane"></i> Telegram
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        if (!window.location.hash || window.location.hash.indexOf('tgAuthResult=') === -1) {
            return;
        }

        function decodeBase64Url(value) {
            var normalized = value.replace(/-/g, '+').replace(/_/g, '/');
            while (normalized.length % 4) normalized += '=';
            try {
                return atob(normalized);
            } catch (e) {
                return null;
            }
        }

        var hashParams = new URLSearchParams(window.location.hash.substring(1));
        var tgAuthResult = hashParams.get('tgAuthResult');
        if (!tgAuthResult) return;

        var decoded = decodeBase64Url(tgAuthResult);
        if (!decoded || decoded === 'false') {
            return;
        }

        var payload = {};
        try {
            payload = JSON.parse(decoded);
        } catch (e) {
            var parsed = new URLSearchParams(decoded);
            parsed.forEach(function (value, key) { payload[key] = value; });
        }

        if (!payload.id || !payload.hash) {
            return;
        }

        var query = new URLSearchParams(payload).toString();
        window.location.replace("{{ route('auth.social.callback', ['provider' => 'telegram']) }}?" + query);
    })();
</script>
@endsection
