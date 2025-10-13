<?php

namespace App\FinanceOperations;

use Illuminate\Database\Eloquent\Model;
use App\FinanceOperations\Operation;
use App\FinanceOperations\AppliedFinanceOperationAssessmentForProduct;

class AppliedFinanceOperation extends Model
{
    protected $fillable = [
        'id',
    	'operation_type_id',
    	'user_id',
        'sum',
        'paid',
        'user_to_id',
        'document_id',
        'document_type_id',
        'order_item_id',
        'fund_id',
        'created_at',
        'updated_at'
    ]; 
    
    protected $table = 'users__replanish_balance_history';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function to_user()
    {
        return $this->belongsTo('App\User', 'user_to_id');
    }
    
    public function operation_type()
    {
        return $this->belongsTo('App\FinanceOperations\Operation');
    }
    
    public function newFromBuilder($attributes = array(), $connection = NULL)
    {        
        $opId = $attributes->operation_type_id;
        $opObj = Operation::find($opId);
        $code = $opObj->code;
        $codePartsArr = explode('_', $code);
        foreach ($codePartsArr as $key => $value) {
            $codePartsArr[$key] = ucfirst($codePartsArr[$key]);
        }        
        $classPref = implode('', $codePartsArr);        
        $className = 'AppliedFinanceOperation'. $classPref;
        
        $ncClassName = "App\\FinanceOperations\\".$className;
        
        if (!class_exists($ncClassName)) {
            $ncClassName = 'App\\FinanceOperations\\AppliedFinanceOperation';
        }
        
        $instance = new $ncClassName((array)$attributes);  

        $instance->setConnection($connection ?: $this->connection);

        $instance->exists = true;        

        return $instance;
    }
}


