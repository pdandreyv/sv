<?php

namespace App\Http\Controllers;

include 'LiqPay.php';

use Illuminate\Http\Request;
use Auth;
use App\FinanceOperations\AppliedFinanceOperation;
use App\UserBalance;
use App\FinanceOperations\Operation;
use App\Http\Requests\StoreTransferRequest;
use App\User;
use Session;

class BalanceController extends Controller
{	
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function replenishBalance($page = null){      
      $data = [
        'menu_item' => 'replanish-balance'
      ];
      session(['balanceBackPage' => $page]);
      return view('balance/replanish', $data);
    }

    public function replanishBalancePost(Request $request){

      $backUrl = $request->session()->get('balanceBackPage');

      if(!$backUrl){
        $backUrl = 'profile/'.Auth::user()->id;
      }

      $insert_sum = $request->insert_sum;      

      $operation = Operation::where('code', '=', 'liqpay')->first();      
      $order = AppliedFinanceOperation::create([
                            'sum' => $insert_sum,
                            'user_id' => Auth::user()->id, 
                            'operation_type_id' => $operation->id                           
                        ]);
      $insert_id = $order->id;


      $public_key = env('LP_PUBLIC_KEY');
      $private_key= env('LP_PRIVATE_KEY');

      $liqpay = new \LiqPay($public_key, $private_key);
      $html = $liqpay->cnb_form(array(
        'version'=>'3',
        'action'         => 'pay',
        'amount'         => $insert_sum,
        'currency'       => 'UAH',      
        'description'    => 'Оплата заказа № '.$insert_id, 
        'order_id'       => $insert_id,
        // если пользователь возжелает вернуться на сайт
        'result_url'  =>  env('APP_URL').'/'.$backUrl,
        /*
          если не вернулся, то Webhook LiqPay скинет нам сюда информацию из формы,
          в частонсти все тот же order_id, чтобы заказ
           можно было обработать как оплаченый
        */
        //'server_url'  =>  'http://mydomain.site/liqpay_status/',
        'language'    =>  'ru',
        'sandbox'=>'1'
      ));
      
      $res_arr = array("status"=>1, 'form'=>$html, 'order_num'=>$insert_id);
      echo json_encode( $res_arr );   
    }

    public function replanishBalanceResponce(Request $request){
      if( isset($request->data) ){

        $result= json_decode( base64_decode($request->data) );
        // данные вернуться в base64 формат JSON

        if( $result->status == 'success' ){
            $order = AppliedFinanceOperation::findOrFail($result->order_id);
            $order->update([
              'paid' => 1,
            ]);

            $balanceItem = UserBalance::where('user_id', '=', Auth::user()->id)->first();
            if($balanceItem){
              $balanceItem->update([
                'sum' => $balanceItem->sum + $order->sum,              
              ]);
            } else {
              $order = UserBalance::create([
                  'sum' => $order->sum,
                  'user_id' => Auth::user()->id,                            
              ]); 
            }
        }
      }
    }



    public function moneyTransfer(){
        $data = [
            'menu_item' => 'money-transfer',
        ];
        
        return view('balance/transfer', $data);
    }
    
    public function moneyTransferPost(StoreTransferRequest $request){
        try {

            $fromUserBalance = UserBalance::where('user_id', Auth::user()->id)->first();
            $fromUserBalance->sum = $fromUserBalance->sum - $request->sum;
            $fromUserBalance->save();

            $toUserBalance = UserBalance::where('user_id', $request->to_user_id)->first();
            if ($toUserBalance) {
                $toUserBalance->sum = $toUserBalance->sum + $request->sum;
                $toUserBalance->save();
            } else {
                UserBalance::create([
                    'user_id' => $request->to_user_id,
                    'sum' => $request->sum
                ]);
            }

            $operation = Operation::where('code', '=', 'user_money_transfer')->first();
            AppliedFinanceOperation::create([
                'sum' => $request->sum,
                'user_id' => Auth::user()->id, 
                'operation_type_id' => $operation->id,
                'user_to_id' => $request->to_user_id
            ]);

            Session::flash('sucсess', 'Перевод осуществлён успешно');
            return redirect()->route('money.transfer');

        } catch (Exception $e) {
            Session::flash('error', 'Перевод не был осуществлён');
            return redirect()->route('money.transfer');

        }
        
        $operation = Operation::where('code', '=', 'user_money_transfer')->first();      
        AppliedFinanceOperation::create([
            'sum' => $request->sum,
            'user_id' => Auth::user()->id, 
            'operation_type_id' => $operation->id,
            'user_to_id' => $request->to_user_id
        ]);
        
        return redirect()
            ->route('profile.my-page', ['id'=>'']);
    }

}
