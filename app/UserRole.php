<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [
        'name', 'title'
    ];

    protected $table = 'users__roles_names';
}
