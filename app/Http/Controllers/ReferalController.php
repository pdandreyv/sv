<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ReferalController extends Controller
{	
    public function index($id)
    {    
    	if(!auth()->user()){
            $user = User::find($id);        
	        if($user){
	        	$referrerId = $user->id;            
	        } else {
	        	$user = User::where('alias', $id)->first();
	        	$referrerId = $user->id; 
	        }
        	session(['reffererId' => $referrerId]);
        }

        return redirect('/');
        
    }

    public function myNetwork(){
        $data = [];
        $data['menu_item'] = 'my-network';
        $data['myReferrer'] = User::find(auth()->user()->referrer_id);
        $data['myInvitees'] = User::where('referrer_id', auth()->user()->id)->paginate(20);
        return view('my-network/index', $data);        
    }
}