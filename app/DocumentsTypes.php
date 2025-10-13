<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentsTypes extends Model
{
    protected $fillable = [
        'code', 'name'
    ];

    protected $table = 'documents_types';
}