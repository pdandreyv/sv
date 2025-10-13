<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundDistributionSettings extends Model
{
    protected $fillable = [
    	'algorithm_id',    	
        'fund_id',
        'percent',    
        'need_assess_pai',
        'find_assess_pai_user_funck',
        'absent_case_fund_id'
    ];

    protected $table = 'funds__fund_distribution_settings';
}