<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Subscribers;
use App\User;

class SubscribeController extends Controller
{	
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function subscribe(Request $request){
        
        Subscribers::create([
            'user_id' => $request->id,
            'subscriber_id' => Auth::user()->id
        ]);
        
        return redirect()
            ->back();
    }
    
    public function unsubscribe(Request $request){
        
        $subscribe = Subscribers::where('user_id', $request->id)
                ->where('subscriber_id', Auth::user()->id)->first();
        
        $subscribe->delete();
        
        return redirect()
            ->back();
    }    

}

