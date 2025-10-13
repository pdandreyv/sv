<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OrderStatus;
use App\Order;
use App\OrderItem;
use App\User;
use App\ShippingAddress;
use App\Product;
use DB;
use App\Http\Requests\Admin\StoreOrderPost;

class OrderController extends Controller
{	

    public function index()
    {           
        $data = [            
            'menu_item' => 'orders',
            'orders' => Order::paginate(20),            
        ];
        return view('admin.orders.list', $data);
    }

    
    public function updateItem($id)
    {        
        $order = Order::findOrFail($id);
        $statuses = OrderStatus::all(); 
        $user = User::find($order->user_id);        
            
        $data = [
            'order' => $order,
            'menu_item' => 'orders',
            'statuses' => $statuses,
            'addresses' => $user->shippingAddresses, 
            'not_editable' => $order->status->not_editable         
        ];        

        return view('admin.orders.edit', $data);
    }

    public function updateItemPost(Request $request, $id)
    {     
        $order = Order::find($id);

        $addressId = null;
        if($request->shipping_adress){
            $shippingAddress = ShippingAddress::create([
                'user_id' => $order->user_id,
                'address' => $request->shipping_adress
            ]);
            $addressId = $shippingAddress->id;
        } else {
            $addressId = $request->address_id;
        }  
        
        $order->address_id = $addressId;
        $order->status_id = $request->status_id;
        
        $order->save();

        return redirect()
            ->route('admin.orders');
    }

    public function itemRemove(Request $request){
        $orderItem = OrderItem::find($request->item_id);
        $orderId = $orderItem->order_id;
        $orderItem->delete();        
        $order = Order::find($orderId);
        $order->updateAmount();
        return json_encode(['amount' => number_format($order->sum, 2, ",", " ")]);        
    }

    public function itemQuantityUpdate(Request $request)
    {    
        $orderItem = OrderItem::find($request->item_id);
        $orderId = $orderItem->order_id;
        $orderItem->quantity = $request->newQuantity;
        $orderItem->update();
        $order = Order::find($orderId);
        $order->updateAmount(); 
        return json_encode([
            'amount' => number_format($order->sum, 2, ",", " "),
            'itemTotal' => number_format($orderItem->quantity*$orderItem->price, 2, ",", " ")
        ]);              
    }

    public function productDropDown($productName){        
        $products = Product::from( 'products__products' )
            ->where('title', 'like', $productName.'%')             
            ->leftJoin('products__images as pim', function ($join) {
                $join->on('products__products.id', '=', 'pim.product_id')
                     ->where('pim.main', 1);
            })
            ->join('users as usr', 'products__products.user_id', '=', 'usr.id')                   
            ->select(
                'products__products.id', 
                'products__products.title', 
                'products__products.price', 
                'products__products.cooperative_price',
                'pim.new_name as image',                
                DB::raw(
                    '(CASE 
                        WHEN usr.first_name != "" 
                        AND usr.last_name != ""
                        AND usr.middle_name != "" 
                        THEN CONCAT(usr.first_name, " ", usr.last_name, " ", usr.middle_name)
                        WHEN usr.first_name != "" 
                        AND usr.last_name != ""
                        AND usr.middle_name = "" 
                        THEN CONCAT(usr.first_name, " ", usr.last_name)
                        WHEN usr.first_name != "" 
                        AND usr.last_name = ""
                        AND usr.middle_name != "" 
                        THEN CONCAT(usr.first_name, " ", usr.middle_name)
                        ELSE usr.name END) AS user_name'
                ))
            ->get()
            ->toArray();    

        return json_encode($products);
    }

    public function itemAdd($orderId, $productId){
        
        $existedItem = OrderItem::where('order_id', $orderId)
            ->where('product_id', $productId)->first();

        $order = Order::find($orderId);

        if($existedItem != null){
            
            $existedItem->quantity = $existedItem->quantity + 1;
            $existedItem->save();

            $order->updateAmount(); 

            return json_encode([
                'success' => true,
                'existed' => $existedItem->id,
                'quantity' => $existedItem->quantity,
                'itemTotal' => number_format($existedItem->quantity*$existedItem->price, 2, ",", " "),
                'amount' => number_format($order->sum, 2, ",", " ")               
            ]);
        } else {
            $product = Product::find($productId);

            $image = $product->image()->where('main', 1)->first();

            $orderItem = OrderItem::create([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->price,
                'cooperative_price' => $product->cooperative_price,
            ]);
            
            $order->updateAmount();            

            $productData = [
                'id' => $orderItem->id,
                'title' => $product->title,
                'price' => number_format($product->price, 2, ",", " "),
            ];

            if($image){
                $productData['image'] = $image->new_name;
            }

            return json_encode([
                'success' => true,
                'existed' => false,
                'product' => $productData,
                'amount' => number_format($order->sum, 2, ",", " ")
            ]); 
        }        
    }

    public function createOrder(){
        $statuses = OrderStatus::all();            
        $data = [            
            'menu_item' => 'orders',
            'statuses' => $statuses,                            
        ];  
        return view('admin.orders.create', $data);
    }

    public function getUserAddresses($userId){

        $user = User::find($userId);        
            
        $addresses = $user->shippingAddresses; 

        $responceHTML = '';
        foreach ($addresses as $address) {
            $responceHTML .= "<option value='{$address->id}'>{$address->address}</option>";            
        }  
        echo $responceHTML;      
    }

    public function storeOrder(StoreOrderPost $request){        
        $addressId = null;
        if($request->shipping_adress){            
            $shippingAddress = ShippingAddress::create([
                'user_id' => $request->to_user_id,
                'address' => $request->shipping_adress
            ]);
            $addressId = $shippingAddress->id;
        } else {
            $addressId = $request->address_id;
        }

        $order = Order::create([
            'user_id' => $request->to_user_id,
            'address_id' => $addressId,
            'status_id' => $request->status_id,
            'sum' => $request->orderTotal
        ]);

        if(!empty($request->product)){            
            foreach ($request->product as $idx=>$orderRow) {                        
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $request->productId[$idx],
                    'quantity' => $request->itemQuantity[$idx],
                    'price' => $request->price[$idx],
                    'cooperative_price' => $request->cooperative_price[$idx]
                ]);            
            }
        }

        return redirect()
            ->route('admin.orders');
    }

    public function applyOrder($id){
        $order = Order::find($id); 
        
        if($order->checkBalanceSum()){
            $order->apply();
            return json_encode(['success' => 1]);
        }  
        
        return json_encode(['success' => 0]);
    }
    
    public function unapplyOrder($id){
        $order = Order::find($id); 
        
        $order->unapply();
        return json_encode(['success' => 1]);
    }
    
    public function delete($id)
    {
        $order = Order::find($id);        
        $order->delete();

        return back();
    }
}