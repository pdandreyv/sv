<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourcesUsers extends Model
{
    protected $fillable = ['id','resource_id', 'category_id', 'user_id','volume'];
    protected $table = 'resources_users';

    public function category()
    {
        return $this->belongsTo('App\ProductCategory');
    }
    public function user()
    {
        return $this->belongsTo('App\Users');
    }
    public function resource()
    {
        return $this->belongsTo('App\Resource');
    }
}
