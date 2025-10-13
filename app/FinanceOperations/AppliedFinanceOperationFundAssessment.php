<?php

namespace App\FinanceOperations;

use App\FinanceOperations\AppliedFinanceOperation;
use App\Fund;
use App\UserBalance;

class AppliedFinanceOperationFundAssessment extends AppliedFinanceOperation{
    public function cancel(){
        /* Хранилище баланса покупателя */
        $balanceItem = UserBalance::where('user_id', '=', $this->user_id)->first();
        /* Возврат денег покупателю */
        if($balanceItem){
          $balanceItem->update([
            'sum' => $balanceItem->sum + $this->sum,
          ]);
        }
        
        // начисление в фонд с паем
        // по полю user to определим было ли начисления пая,
        // если оно было, то отменим его
        
        /* Хранилище баланса пая */
        $balanceItem = UserBalance::where('user_id', '=', $this->user_to_id)->first();
        /* Возврат денег покупателю */
        if($balanceItem){
          $balanceItem->update([
            'work_pay' => $balanceItem->work_pay - $this->sum,
          ]);
        }
        
        // теперь надо снять деньги с фонда
        /* Получаем айтем фонда */
        $fundItem = Fund::find($this->fund_id);
        /* Возврат денег покупателю */
        $fundItem->update([
          'balance' => $fundItem->balance - $this->sum,
        ]);
        
        $this->delete();
    }
    
    public function apply(){
        
        // если операция была с паем, то надо его начислить
        // начисление в фонд с паем
        // по полю user to определим было ли начисления пая
        
        if($this->user_to_id){
            /* Хранилище баланса пая */
            $balanceItem = UserBalance::where('user_id', '=', $this->user_to_id)->first();            
            if($balanceItem){
              $balanceItem->update([
                'work_pay' => $balanceItem->work_pay + $this->sum,
              ]);
            } else {
                UserBalance::create([
                    'sum' => 0,
                    'work_pay' => $this->sum,
                    'user_id' => $this->user_to_id,                            
                ]); 
            }
        }
        
        // отчислим деньги в фонд
        $fundItem = Fund::where('id', '=', $this->fund_id)->first();
        if($fundItem){
          $fundItem->update([
            'balance' => $fundItem->balance + $this->sum,
          ]);
        } else {
          // генерация исключения 
        }
        
        // снятие денег с покупателя                
        $balanceItem = UserBalance::where('user_id', '=', $this->user_id)->first();
        if($balanceItem){
          $balanceItem->update([
            'sum' => $balanceItem->sum - $this->sum,
          ]);
        }                        
    }
}

?>


