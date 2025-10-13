<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use App\User;

class getStatistic
{
    public function handle($request, Closure $next)
    {
        $dayStatisticRes = DB::table(
            DB::raw("(SELECT DISTINCT user_id, ip, DATE_FORMAT(created_at, '%Y-%m-%d') as day 
                        FROM users__visit_statistic
                        WHERE DATE_FORMAT(created_at, '%Y-%m-%d') = '".date('Y-m-d')."') as day_statistic")
        )->selectRaw('count(*) as day_statistic')->first();

        $weekStatisticRes = DB::table(
            DB::raw("(SELECT DISTINCT user_id, ip, DATE_FORMAT(created_at, '%Y-%m-%d') as day, DATE_FORMAT(created_at, '%Y-%u') as week 
                        FROM users__visit_statistic
                        WHERE DATE_FORMAT(created_at, '%Y-%u') = '".date('Y-W')."') as week_statistic")
        )->selectRaw('count(*) as week_statistic')->first();

        $mounthStatisticRes = DB::table(
            DB::raw("(SELECT DISTINCT user_id, ip, DATE_FORMAT(created_at, '%Y-%m-%d') as day, DATE_FORMAT(created_at, '%Y-%m') as mounth 
                        FROM users__visit_statistic
                        WHERE DATE_FORMAT(created_at, '%Y-%m') = '".date('Y-m')."') as week_statistic")
        )->selectRaw('count(*) as mounth_statistic')->first();

        $allVisits = DB::table('users__visit_statistic')->count();
        $allUsers = DB::table('users')->count();
        $allCooperativeMembers = User::getMembers()->count();

        $data = [
            'dayStatistic' => $dayStatisticRes->day_statistic ?? 0,
            'weekStatistic' => $weekStatisticRes->week_statistic ?? 0,
            'mounthStatistic' => $mounthStatisticRes->mounth_statistic ?? 0,
            'allVisits' => $allVisits,
            'allUsers' => $allUsers,
            'allCooperativeMembers' => $allCooperativeMembers,
        ];

        $request->attributes->add(['statistic' => $data]);
        return $next($request);
    }
}


