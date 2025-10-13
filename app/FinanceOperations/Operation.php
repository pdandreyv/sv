<?php

namespace App\FinanceOperations;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
    	'code',    	
        'name',        
    ];

    protected $table = 'operations';

    public function appliedFinanceOperation()
    {
        return $this->hasMany('App\FinanceOperations\AppliedFinanceOperation');
    }
}


