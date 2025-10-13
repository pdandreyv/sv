<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity', 
        'price',
        'cooperative_price'
    ];

    protected $table = 'cart';

    public static function getCartInfo(){
        $cartItems = Cart::where('user_id', Auth::user()->id)->get();
        $totalQuantity = 0;
        $totalAmount = 0.00;
        foreach ($cartItems as $cartItem) {
            $totalQuantity += $cartItem->quantity;
            $totalAmount += $cartItem->quantity*$cartItem->price;
        }
        return [
            'totalQuantity' => count($cartItems),
            'totalAmount' => number_format($totalAmount, 2, ',', ' ')
        ];
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}