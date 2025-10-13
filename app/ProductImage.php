<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [        
        'old_name',
        'new_name',
        'product_id',
        'main',
    ];

    protected $table = 'products__images';    
}