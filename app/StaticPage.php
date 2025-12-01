<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class StaticPage extends Model
{

    protected $fillable = ['display', 'h1', 'body', 'alias', 'title', 'descr'];
    public $sortable = ['h1', 'created_at', 'updated_at'];

    protected $table = 'pages';

}
