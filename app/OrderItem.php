<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FundDistributionAlgorithm;
use App\FundDistributionSettings;
use App\FinanceOperations\AppliedFinanceOperation;
use App\FinanceOperations\AppliedFinanceOperationAssessmentForProduct;
use App\FinanceOperations\AppliedFinanceOperationFundAssessment;
use App\DocumentsTypes;
use App\FinanceOperations\Operation;
use App\Network;
use App\UserBalance;
use App\Fund;

class OrderItem extends Model
{
    protected $fillable = [
    	'order_id',    	
        'product_id',
        'quantity',
        'price',
        'cooperative_price'
    ];

    protected $table = 'orders__items';

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
    
    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
    
    public function makeOperations(){
        
        if($this->product->is_service){
            $algCode = 'order_service_product';
        } else {
            $algCode = 'order_product';
        }
        
        $algId = FundDistributionAlgorithm::where(['code' => $algCode])->first()->id;
        $operationSettings = FundDistributionSettings::where(['algorithm_id' => $algId])->get();                
        
        $goodAssOpTypeId = Operation::where(['code' => 'assessment_for_product'])->first()->id;                
        $fundAssOpTypeId = Operation::where(['code' => 'fund_assessment'])->first()->id;
        
        $docTypeId = DocumentsTypes::where(['code' => 'order'])->first()->id;
             
        $sum = $this->product->price - $this->product->cooperative_price;
        
        $assForProdOp = AppliedFinanceOperationAssessmentForProduct::create([            
            'operation_type_id' => $goodAssOpTypeId,
            'user_id' => $this->order->user_id,
            'sum' => $this->product->cooperative_price,
            'paid' => 1,
            'user_to_id' => $this->product->user_id,
            'document_id' => $this->order->id,
            'document_type_id' => $docTypeId,
            'order_item_id' => $this->id,            
        ]);
        
        $assForProdOp->apply();
        
        $totalFundSum = 0;        

        foreach ($operationSettings as $idx => $setting) {
            
            $fundSum = round($sum*$setting->percent/100, 2, PHP_ROUND_HALF_DOWN);
            $totalFundSum += $fundSum;
            
            // на последней итерации необходимо дополнить копейками
            
            if(($idx + 1) == count($operationSettings)){
                // итоговая сумма начислений по фондам может быть меньше, чем
                // требуемая к распределению
                if($totalFundSum < $sum){
                    // добавим недостающие копейки к последнему начислению
                    $rest = $sum - $totalFundSum;
                    $fundSum += $rest;
                }
            }
            
            // начисление в фонд без пая                
            $fundOpData = [            
                'operation_type_id' => $fundAssOpTypeId,
                'user_id' => $this->order->user_id,
                'sum' => $fundSum,
                'paid' => 1,                
                'document_id' => $this->order->id,
                'document_type_id' => $docTypeId,
                'order_item_id' => $this->id,                
            ];
            
            if($setting->need_assess_pai){
                $personFunk = $setting->find_assess_pai_user_funck;
                $person = $this->$personFunk();                
                
                if($person){                    
                    
                    $fundOpData['user_to_id'] = $person;
                    $fundOpData['fund_id'] = $setting->fund_id;
                                        
                } else {
                    // начисление в общий фонд                    
                    $fundOpData['fund_id'] = $setting->absent_case_fund_id;
                }
                
            } else {                
                $fundOpData['fund_id'] = $setting->fund_id;
            }
            $assFundOp = AppliedFinanceOperationFundAssessment::create($fundOpData);
            $assFundOp->apply();
        }        
    }
    
    private function getSuppliersUPS1(){        
        $node = Network::where('user_id', $this->product->user_id)->first();        
        $ups1_user = ($node)?$node->ups1User:null;
        if($ups1_user){
            return $ups1_user->id;
        } else {
            return false;
        }        
    }
    
    private function getSuppliersUPS2(){
        $node = Network::where('user_id', $this->product->user_id)->first();
        $ups2_user = ($node)?$node->ups2User:null;
        if($ups2_user){
            return $ups2_user->id;
        } else {
            return false;
        }        
    }
            
    private function getSuppliersUPS3(){
        $node = Network::where('user_id', $this->product->user_id)->first();
        $ups3_user = ($node)?$node->ups3User:null;
        if($ups3_user){
            return $ups3_user->id;
        } else {
            return false;
        }        
    }
    
    private function getRecipientInvitor(){
        $invitor_user = $this->order->user->invitor;
        if($invitor_user){
            return $invitor_user->id;
        } else {
            return false;
        } 
    }

    private function getSupplierInvitor(){
        $invitor_user = $this->product->user->invitor;
        if($invitor_user){
            return $invitor_user->id;
        } else {
            return false;
        } 
    }
}