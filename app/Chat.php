<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'title',        
    ];

    protected $table = 'chat__chats';

    public function members(){
    	return $this->hasMany('App\ChatMember');
    }
}