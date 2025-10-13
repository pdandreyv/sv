<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{

    protected $fillable = ['user_id', 'subscriber_id'];    

    protected $table = 'users__subscribers';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function subscriber()
    {
        return $this->belongsTo('App\User', 'subscriber_id');
    }
}
