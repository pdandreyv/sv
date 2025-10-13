<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Совместимость со старой моделью App\User
    public static function isMember()
    {
        return \App\User::isMember();
    }

    public static function getMembers()
    {
        return \App\User::getMembers();
    }

    public static function isCooperationRequest()
    {
        return \App\User::isCooperationRequest();
    }

    // Простой эквивалент старого метода
    public function getLink()
    {
        return $this->alias ?: $this->id;
    }

    // Делегирование неизвестных методов к старой модели (instance)
    public function __call($method, $parameters)
    {
        $legacy = \App\User::find($this->id);
        if ($legacy && method_exists($legacy, $method)) {
            return $legacy->$method(...$parameters);
        }
        return parent::__call($method, $parameters);
    }
}
