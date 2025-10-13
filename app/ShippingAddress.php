<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
    	'user_id',    	
        'address',        
    ];

    protected $table = 'users__shipping_adresses';
}