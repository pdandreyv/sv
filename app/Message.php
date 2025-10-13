<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'to_user_id', 
        'from_user_id', 
        'message_text',
        'chain_id',
        'is_readed'        
    ];

    protected $table = 'users__messages';
    
    public function from_user()
    {
        return $this->belongsTo('App\User', 'from_user_id');
    }

    public function to_user()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }
}
