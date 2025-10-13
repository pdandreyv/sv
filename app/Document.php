<?php

namespace DocumentCategoryController;
namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected $fillable = [
        'doc_category_id',
        'name',
        'file',
    ];
    protected $table = 'doc_document';

}

