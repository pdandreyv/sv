<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OrderStatus;
use Auth;
use App\Http\Requests\Admin\StoreOrderStatusPost;

class OrderStatusController extends Controller
{	

    public function index()
    {   
        $data = [            
            'menu_item' => 'order-statuses',
            'statuses' => OrderStatus::paginate(20),            
        ];
        return view('admin.order-statuses.list', $data);
    }

    public function create(Request $request)
    {     
        $data = [
            'menu_item' => 'order-statuses',            
        ];
        return view('admin.order-statuses.add', $data);
    }

    public function store(StoreOrderStatusPost $request)
    {             
        
        $data = [
          'code' => $request->code,
          'name' => $request->name,
          'not_editable' => isset($request->not_editable)?1:0,          
        ]; 

        OrderStatus::create($data);
        
        return redirect()
            ->route('admin.order-statuses');
    }
    
    public function updateItem($id)
    {        
        $status = OrderStatus::findOrFail($id);

        $data = [
            'status' => $status,
            'menu_item' => 'order-statuses'            
        ];

        return view('admin.order-statuses.edit', $data);
    }

    public function updateItemPost($id, StoreOrderStatusPost $request)
    {           
        $orderStatus = OrderStatus::findOrFail($id);        

        $orderStatusData = [
          'name' => $request->name,
          'not_editable' => isset($request->not_editable)?1:0,          
        ];

        $orderStatus->update($orderStatusData);
                       
        return redirect()
            ->route('admin.order-statuses');
    }

    public function delete($id)
    {
        $role = OrderStatus::find($id);        
        $role->delete();

        return back();
    }
}
