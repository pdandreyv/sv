<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $fillable = [
        'alias', 
        'subject', 
        'body',
        'used_vars',
        'is_standart'        
    ];

    protected $table = 'mail__templates';
    
}