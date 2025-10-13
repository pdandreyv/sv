<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    protected $fillable = [
        'user_id',
        'sum',
        'work_pay',
        'good_pay',
    ];

    protected $table = 'users__balance';
}