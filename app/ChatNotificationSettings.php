<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatNotificationSettings extends Model
{
    protected $fillable = [
    	'user_id',
        'chat_type',
        'frequency',               
    ];

    protected $table = 'chat__messages_notification_settings';
}