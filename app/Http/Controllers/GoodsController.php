<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use App\ProductCategory;
use Auth;
use App\Http\Requests\StoreProductRequest;
use File;
use App\ProductImage;
use Illuminate\Support\Arr;

class GoodsController extends Controller
{
    public function indexGoods()
    {
        $categories = ProductCategory::where('for_service', 0)
            ->whereNull('parent_id')
            ->orderBy('sort')
            ->orderBy('id')
            ->get();
        return view('products.goods')->with([
            'pageTitle' => 'Наши Товары',
            'categories' => $categories,
        ]);
    }
    public function indexServices()
    {
        $categories = ProductCategory::where('for_service', 1)
            ->whereNull('parent_id')
            ->orderBy('sort')
            ->orderBy('id')
            ->get();
        return view('products.goods')->with([
            'pageTitle' => 'Наши Услуги',
            'categories' => $categories,
        ]);
    }
    public function categoryView($category_id)
    {
        $currentCategory = ProductCategory::findOrFail($category_id);
        $products = Product::leftJoin('users', 'users.id', '=', 'products__products.user_id')->select('products__products.*', 'users.first_name', 'users.middle_name', 'users.last_name', 'users.photo as user_photo')->where('category_id',$category_id)->where('is_confirmed', true)->paginate(20);
        $childCategories = ProductCategory::where('parent_id', $category_id)
            ->orderBy('sort')
            ->orderBy('id')
            ->get();
        return view('products.category')->with([
            'currentCategory' => $currentCategory,
            'products' => $products,
            'childCategories' => $childCategories,
        ]);
    }
    public function productView($product_id)
    {
        $product = Product::leftJoin('users', 'users.id', '=', 'products__products.user_id')->select('products__products.*', 'users.first_name', 'users.middle_name', 'users.last_name', 'users.photo as user_photo')->where('products__products.id',$product_id)->first();
        return view('products.product')->with('product', $product);
    }
}