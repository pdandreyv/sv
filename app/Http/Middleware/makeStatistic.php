<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class makeStatistic
{
    public function handle($request, Closure $next)
    {
        $data = [
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'ip' => $request->ip(),
            'url' => $request->url(),
            'created_at' => date('Y-m-d h:i:s', time()),
        ];
        DB::table('users__visit_statistic')->insert($data);
        return $next($request);
    }
}


