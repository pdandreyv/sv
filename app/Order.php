<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserBalance;
use App\FinanceOperations\AppliedFinanceOperation;

class Order extends Model
{
    protected $fillable = [
    	'user_id',    	
        'sum',
        'address_id',
        'status_id'        
    ];

    protected $table = 'orders';    

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function status()
    {
        return $this->belongsTo('App\OrderStatus', 'status_id');
    }

    public function items(){
    	return $this->hasMany('App\OrderItem');
    }

    public function updateAmount(){
        $amount = 0;
        foreach ($this->items as $item) {
            $amount += $item->price*$item->quantity;
        }
        $this->sum = $amount;
        $this->update();
    }
    
    public function apply(){        
        $this->processPayment();        
        $this->applied = 1;
        $this->update();
    }
    
    public function unapply(){
        $this->cancelPayment();
        $this->applied = 0;
        $this->update();
    }
    
    public function processPayment(){
        foreach($this->items as $item){
            $item->makeOperations();
        }        
    }
    
    public function cancelPayment(){
        $operations = AppliedFinanceOperation::where('document_id', $this->id)->get();        
        foreach ($operations as $operation){
            $operation->cancel();
        }
    }
    
    public function checkBalanceSum(){
        $balanceItem = $this->user->balance()->first();        
        if(!$balanceItem){
            return false;
        }
        return !($this->sum > $balanceItem->sum);
    }
}