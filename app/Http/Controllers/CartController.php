<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Product;

class CartController extends Controller
{	
    
    public function index(){
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $data = [
            'cartItems' => $cart
        ];        
        return view('cart/index', $data);
    }

    public function cartAdd($product_id, $quantity){ 
        
        if(!Auth::user()){
            return json_encode(['fail' => 'not-autorised']);;
        } 

        if(!app('request')->attributes->get('isCooperative')){
            return json_encode(['fail' => 'not-cooperative']);
        }

        $product = Product::findOrFail($product_id);

        $cartItem = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $product_id)
            ->where('price', $product->price)
            ->first();
        if(!$cartItem){
            Cart::create([                
                'user_id' => Auth::user()->id, 
                'product_id' => $product_id,
                'price' => $product->price,
                'cooperative_price' => $product->cooperative_price,
                'quantity' => $quantity
            ]);
        } else {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity
            ]);
        }
        return json_encode(['success' => Cart::getCartInfo()]);    
    }

    public function remove(Request $request){
        $cartItem = Cart::where('user_id', Auth::user()->id)
            ->where('price', $request->product_price)
            ->where('product_id', $request->product_id)
            ->first();
        $cartItem->delete();
        $cartInfo = Cart::getCartInfo();
        $data = ['cartInfo' => $cartInfo];
        return json_encode($data);
    }

    public function quantityUpdate(Request $request){
        $cartItem = Cart::where('user_id', Auth::user()->id)
            ->where('price', $request->product_price)
            ->where('product_id', $request->product_id)
            ->first();

        $cartItem->update([
            'quantity' => $request->newQuantity
        ]);

        $cartInfo = Cart::getCartInfo();
        $data = [
            'cartInfo' => $cartInfo,
            'itemTotal' => number_format($cartItem->quantity*$cartItem->price, 2, ',', ' ')
        ];
        return json_encode($data);
    }

    public function checkBalanceSum(){
        $cartItems = Cart::where('user_id', Auth::user()->id)->get();        
        $totalAmount = 0.00;
        foreach ($cartItems as $cartItem) {            
            $totalAmount += $cartItem->quantity*$cartItem->price;
        }

        $balance = Auth::user()->balance()->first();        
        $hasMoney = ($balance && !($balance->sum < $totalAmount));
        $data = [
            'hasMoney' => $hasMoney
        ];
        return json_encode($data);
    }
}

