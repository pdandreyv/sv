<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $fillable = [
        'user_id', 
        'ups1', 
        'ups2',
        'ups3',        
    ];

    protected $table = 'network';
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function ups1User()
    {
        return $this->belongsTo('App\User', 'ups1');
    }
    
    public function ups2User()
    {
        return $this->belongsTo('App\User', 'ups2');
    }
    
    public function ups3User()
    {
        return $this->belongsTo('App\User', 'ups3');
    }
}