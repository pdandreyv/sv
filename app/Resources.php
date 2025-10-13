<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $fillable = ['id','name', 'category_id', 'unit_id'];
    protected $table = 'resources';

    public function category()
    {
        return $this->belongsTo('App\ProductCategory');
    }

    public function unit()
    {
        return $this->belongsTo('App\Units');
    }

    public function choosed()
    {
        return $this->hasMany('App\ResourcesUsers','resource_id','id');
    }
}