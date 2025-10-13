<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id', 
        'text',        
        'is_readed'               
    ];

    protected $table = 'chat__messages';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}