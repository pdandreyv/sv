<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundDistributionAlgorithm extends Model
{
    protected $fillable = [
    	'code',    	
        'name',
        'is_standart',        
    ];

    protected $table = 'funds__fund_distribution_algorithm';
}