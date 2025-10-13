<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserScan extends Model
{
    protected $fillable = [
        'user_id', 'type', 'file_name'
    ];

    protected $table = 'users__scans';
}
