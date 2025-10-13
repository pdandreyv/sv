<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $fillable = ['id','name', 'description'];
    protected $table = 'units';

    public function resources()
    {
        return $this->hasMany('App\Resources', 'unit_id');
    }
}
