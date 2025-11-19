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
        // Хлебные крошки: от корня к текущей категории
        $breadcrumb = [];
        $parentIds = $currentCategory->getAllParents(); // упорядочено от корня к родителю
        foreach ($parentIds as $pid) {
            $cat = ProductCategory::find($pid);
            if ($cat) {
                $breadcrumb[] = $cat;
            }
        }
        $breadcrumb[] = $currentCategory;
        return view('products.category')->with([
            'currentCategory' => $currentCategory,
            'products' => $products,
            'childCategories' => $childCategories,
            'breadcrumb' => $breadcrumb,
        ]);
    }
    public function productView($product_id)
    {
        $product = Product::leftJoin('users', 'users.id', '=', 'products__products.user_id')->select('products__products.*', 'users.first_name', 'users.middle_name', 'users.last_name', 'users.photo as user_photo')->where('products__products.id',$product_id)->first();
        // Хлебные крошки для товара
        $breadcrumb = [];
        if ($product && $product->category_id) {
            $category = ProductCategory::find($product->category_id);
            if ($category) {
                $parentIds = $category->getAllParents();
                foreach ($parentIds as $pid) {
                    $cat = ProductCategory::find($pid);
                    if ($cat) {
                        $breadcrumb[] = $cat;
                    }
                }
                $breadcrumb[] = $category;
            }
        }
        return view('products.product')->with([
            'product' => $product,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}