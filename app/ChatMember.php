<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMember extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',                
    ];

    protected $table = 'chat__members';

    public function getChatDisplayName(){
    	$chat = $this->chat()->first();    	
    	if(!empty($chat->title)){
    		return $chat->title;
    	} else {
    		if(count($chat->members)==2){
    			foreach ($chat->members as $chatMember) {
					if($chatMember->user_id !== $this->user_id){
						$user = $chatMember->user()->first();
						return $user->last_name.' '.$user->first_name.' '.$user->middle_name;
					}
				}
    		} else {

    			$membersNames = ['Я'];
    			foreach ($chat->members as $chatMember) {
    				if($chatMember->user_id !== $this->user_id){
    					$user = $chatMember->user()->first();
    					$membersNames[] = $user->last_name.' '.$user->first_name.' '.$user->middle_name;
    				}
    			}

    			return implode(', ', $membersNames);

    		}    		
    	}
    }

    public function getDisplayPhoto(){
    	$chat = $this->chat()->first();
    	if(count($chat->members)==2){
			foreach ($chat->members as $chatMember) {
                if($chatMember->user_id !== $this->user_id){
    				$user = $chatMember->user()->first();
    				if($user->photo){
    					return "/images/users_photos/{$user->photo}";
    				} else {
    		        	return "/images/chat.jpg";
    				}
                }
			}
		} else {
			return "/images/chat.jpg";
		} 

    }

    public function chat()
    {
        return $this->belongsTo('App\Chat');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

