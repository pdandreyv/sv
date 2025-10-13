<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\FinanceOperations\Operation;
use App\FinanceOperations\AppliedFinanceOperation;
use App\UserBalance;
use App\Http\Requests\Admin\StoreOperationPost;

class BalanceController extends Controller
{	

    public function index()
    {   
        $data = [            
            'menu_item' => 'balance',
            'operations' => AppliedFinanceOperation::paginate(20),            
        ];
        return view('admin.operations.list', $data);
    }

    public function chooseType(Request $request){
        
        $operationTypes = Operation::where('code', '!=', 'liqpay')->get();
        
        $data = [
            'menu_item' => 'balance',
            'types' => $operationTypes,
        ];
        return view('admin.operations.choose-type', $data);
    }

    public function create(Request $request)
    {     
        $operationType = Operation::findOrFail($request->operation_type_id);

        $data = [
            'menu_item' => 'balance',
            'operationType' => $operationType,
            'users' => User::all()
        ];

        switch ($operationType->code) {            
            
            case 'cache':
                return view('admin.operations.add', $data);
                break;

            case 'user_money_transfer': 
                return view('admin.operations.transfer.add-transfer', $data);               
                break;

            default:
                return view('admin.operations.add', $data);
                break;
        }                
    }

    public function store(StoreOperationPost $request)
    {                     
        $operationData = [
          'user_id' => $request->user_id,
          'user_to_id' => $request->user_to_id,
          'sum' => $request->sum,
          'operation_type_id' => $request->operation_type_id,                    
        ];                

        $operation = AppliedFinanceOperation::create($operationData);        

        $operationType = Operation::findOrFail($request->operation_type_id);
        
        switch ($operationType->code) {            
            
            case 'cache':                
                $currentBalance = UserBalance::where('user_id', $request->user_id)->first(); 
                if($currentBalance){
                    $currentBalance->sum = $currentBalance->sum + $request->sum;
                    $currentBalance->save();
                } else {
                    UserBalance::create([
                        'user_id' => $request->user_id,
                        'sum' => $request->sum 
                    ]);
                }
                
                break;

            case 'user_money_transfer': 
                $currentFromBalance = UserBalance::where('user_id', $request->user_id)->first();                
                $currentFromBalance->sum = $currentFromBalance->sum - $request->sum;
                $currentFromBalance->save();
                
                $currentToBalance = UserBalance::where('user_id', $request->user_to_id)->first();
                if($currentToBalance){
                    $currentToBalance->sum = $currentToBalance->sum + $request->sum;
                    $currentToBalance->save();
                } else {
                    UserBalance::create([
                        'user_id' => $request->user_to_id,
                        'sum' => $request->sum
                    ]);
                }
                
                break;

            default:                
                break;
        }
        
        return redirect()
            ->route('admin.operations');
    }

    public function delete($id)
    {
        $operation = AppliedFinanceOperation::find($id);

        $operationType = Operation::findOrFail($operation->operation_type_id);
        
        switch ($operationType->code) {            
            
            case 'cache':                
                $currentBalance = UserBalance::where('user_id', $operation->user_id)->first();
                if($currentBalance){
                    $currentBalance->sum = $currentBalance->sum - $operation->sum;
                    $currentBalance->save();
                } else {
                    UserBalance::create([
                        'user_id' => $operation->user_id,
                        'sum' => - $operation->sum
                    ]);
                }
                
                break;

            case 'user_money_transfer': 
                $currentFromBalance = UserBalance::where('user_id', $operation->user_id)->first(); 
                
                if($currentFromBalance){
                    $currentFromBalance->sum = $currentFromBalance->sum + $operation->sum;
                    $currentFromBalance->save();
                } else {
                    UserBalance::create([
                        'user_id' => $operation->user_id,
                        'sum' => $operation->sum
                    ]);
                }
                                                
                $currentToBalance = UserBalance::where('user_id', $operation->user_to_id)->first();
                
                if($currentToBalance){
                    $currentToBalance->sum = $currentToBalance->sum - $operation->sum;
                    $currentToBalance->save();
                } else {
                    UserBalance::create([
                        'user_id' => $operation->user_to_id,
                        'sum' => - $operation->sum
                    ]);
                }                
                 
                break;

            default:                
                break;
        }        
        
        $operation->delete();

        return back();
    }
}
