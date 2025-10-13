<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\UserType;
use Illuminate\Support\Facades\DB;
use App\Cart;
use App\User;

class getStatuses
{
    public function handle($request, Closure $next)
    {
        $canSendCooperativeRequest = Auth::user() ? !User::isMember() : false;
        $request->attributes->add(['canSendCooperativeRequest' => $canSendCooperativeRequest]);
        $isCooperative = Auth::user() ? User::isMember() : false;
        $request->attributes->add(['isCooperative' => $isCooperative]);

        $userType = UserType::whereIn('code', ['сooperation_request'])->pluck('id')->toArray();

        $emptyForm = Auth::user() ? !in_array(Auth::user()->user_type_id, $userType) : false;
        $request->attributes->add(['emptyForm' => $emptyForm]);

        if ($isCooperative) {
            $request->attributes->add(['mesCount' => $this->getMessagesCount()]);
            $request->attributes->add(['cart' => Cart::getCartInfo()]);
        }

        return $next($request);
    }

    private function getMessagesCount()
    {
        return DB::table('chat__members as mem')
            ->join('chat__messages as mes', 'mes.chat_id', '=', 'mem.chat_id')
            ->leftJoin('chat__messages_reading as chr', [['chr.message_id', '=', 'mes.id'], ['chr.user_id', '=', 'mem.user_id']])
            ->where('mem.user_id', auth()->user()->id)
            ->whereNull('chr.message_id')
            ->count();
    }
}


