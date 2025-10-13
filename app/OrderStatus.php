<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
    	'code',    	
        'name',
        'not_editable'        
    ];

    protected $table = 'orders__statuses';
}