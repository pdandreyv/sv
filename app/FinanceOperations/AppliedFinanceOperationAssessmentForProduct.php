<?php

namespace App\FinanceOperations;

use App\UserBalance;

/* Финансовая операция начисление за продукт */
class AppliedFinanceOperationAssessmentForProduct extends AppliedFinanceOperation{
    
    public function apply(){
        // переход денег на баланс продавца
        $balanceItem = UserBalance::where('user_id', '=', $this->user_to_id)->first();
        if($balanceItem){
          $balanceItem->update([
            'sum' => $balanceItem->sum + $this->sum,
          ]);
        } else {
          UserBalance::create([
              'sum' => $this->sum,              
              'user_id' => $this->user_to_id,                            
          ]); 
        }
        
        // снятие денег с покупателя                
        $balanceItem = UserBalance::where('user_id', '=', $this->user_id)->first();
        if($balanceItem){
          $balanceItem->update([
            'sum' => $balanceItem->sum - $this->sum,
          ]);
        }
        
    }
    
    /* Полиморфная функция удаления операции
     * снимаем деньги с продавца с возвращаем их покупателю
     */
    public function cancel(){
        /* Хранилище баланса продавца */
        $balanceItem = UserBalance::where('user_id', '=', $this->user_to_id)->first();
        /* Снятие суммы с продавца */
        if($balanceItem){
          $balanceItem->update([
            'sum' => $balanceItem->sum - $this->sum,
          ]);
        }
        
        /* Хранилище баланса покупателя */
        $balanceItem = UserBalance::where('user_id', '=', $this->user_id)->first();
        /* Возврат денег покупателю */
        if($balanceItem){
          $balanceItem->update([
            'sum' => $balanceItem->sum + $this->sum,
          ]);
        }
        
        $this->delete();
    }
}

?>


