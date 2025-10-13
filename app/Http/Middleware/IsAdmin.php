<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class IsAdmin
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->user()) {
            $hasAdmin = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->where('id', auth()->user()->id)->get();

            if (!count($hasAdmin)) {
                return redirect('/home');
            }
        } else {
            return redirect('/');
        }

        return $next($request);
    }
}


