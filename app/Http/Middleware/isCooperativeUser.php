<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class isCooperativeUser
{
    public function handle($request, Closure $next)
    {
        $memberUserType = User::isMember();
        if (auth()->user() && !$memberUserType) {
            return redirect('/home');
        }
        return $next($request);
    }
}


