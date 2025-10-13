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
        $products = Arr::pluck(Product::select('category_id')->paginate(20)->items(), 'category_id');
        $categories = ProductCategory::where('for_service',0)->whereNull('parent_id')->paginate(20);
        $notEmptyCategories = [];
        foreach($categories as $category){
            if($category->hasProducts()){
                $notEmptyCategories[] = $category;
            }
        }        
        return view('products.goods')->with(['pageTitle' => 'Наши Товары', 'categories' => $notEmptyCategories, 'products' => $products]);
    }
    public function indexServices()
    {
        $products = Arr::pluck(Product::select('category_id')->paginate(20)->items(), 'category_id');
        $categories = ProductCategory::where('for_service',1)->whereNull('parent_id')->paginate(20);
        $notEmptyCategories = [];
        foreach($categories as $category){
            if($category->hasProducts()){
                $notEmptyCategories[] = $category;
            }
        }
        return view('products.goods')->with(['pageTitle' => 'Наши Услуги','categories' => $notEmptyCategories]);
    }
    public function categoryView($category_id)
    {
        $currentCategory = ProductCategory::findOrFail($category_id);
        $products = Product::leftJoin('users', 'users.id', '=', 'products__products.user_id')->select('products__products.*', 'users.first_name', 'users.middle_name', 'users.last_name', 'users.photo as user_photo')->where('category_id',$category_id)->where('is_confirmed', true)->paginate(20);
        $childCategories = ProductCategory::where('parent_id',$category_id)->paginate(20);
        $hasChilds = isset($childCategories[0]->title);
        $notEmptyCategories = [];
        foreach($childCategories as $category){
            if($category->hasProducts()){
                $notEmptyCategories[] = $category;
            }
        }
        return view('products.category')->with(['currentCategory' => $currentCategory, 'products' => $products, 'childCategories' => $notEmptyCategories]);
    }
    public function productView($product_id)
    {
        $product = Product::leftJoin('users', 'users.id', '=', 'products__products.user_id')->select('products__products.*', 'users.first_name', 'users.middle_name', 'users.last_name', 'users.photo as user_photo')->where('products__products.id',$product_id)->first();
        return view('products.product')->with('product', $product);
    }
}