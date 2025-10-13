<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $fillable = [
    	'code',    	
        'name',
        'is_standart',
        'balance'
    ];

    protected $table = 'funds__funds';
}