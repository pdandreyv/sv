<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessageReading extends Model
{
    protected $fillable = [
        'message_id',
        'user_id',               
    ];

    protected $table = 'chat__messages_reading';
}