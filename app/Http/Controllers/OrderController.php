<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Response;
use App\Cart;
use App\ShippingAddress;
use App\Order;
use App\OrderStatus;
use App\OrderItem;

class OrderController extends Controller
{    
    
    public function checkout(Request $request)
    {
        $data = [
            'noAddressFound' => !count(Auth::user()->shippingAddresses),
            'addresses' => Auth::user()->shippingAddresses
        ];        
        
        return view('order.checkout', $data);
    }

    public function placeOrder(Request $request){        
        $addressId = null;
        if($request->shipping_adress){
            $shippingAddress = ShippingAddress::create([
                'user_id' => Auth::user()->id,
                'address' => $request->shipping_adress
            ]);
            $addressId = $shippingAddress->id;
        } else {
            $addressId = $request->address_id;
        }

        $cartItems = Cart::where('user_id', Auth::user()->id)->get();        
        $totalAmount = 0.00;
        foreach ($cartItems as $cartItem) {            
            $totalAmount += $cartItem->quantity*$cartItem->price;
        }

        $status = OrderStatus::where('code', 'waiting_confirmation')->first();

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'address_id' => $addressId,
            'status_id' => $status->id,
            'sum' => $totalAmount
        ]);

        foreach ($cartItems as $cartItem) {                        
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'cooperative_price' => $cartItem->cooperative_price
            ]);            
        }

        foreach ($cartItems as $cartItem) {                        
            $cartItem->delete();            
        }

        return redirect()
            ->route('profile.my-page', ['id'=>'']);
    }
}
