<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\ProductCategory;
use Auth;
use App\Http\Requests\StoreProductRequest;
use File;
use App\ProductImage;

class ProductController extends Controller
{

    public function index()
    {
        $data = [
            'menu_item' => 'products',
            'products' => Product::where('is_service',0)
                ->where('user_id', Auth::user()->id)
                ->paginate(20),
            'page_title'=>'Мои товары',
            'is_service'=> 0,
            'add_title'=> "Добавить товар",
            'create_route'=> "products.create",
            'update_route'=>"products.update",
            'delete_route'=>"products.delete"

        ];
        return view('products.index', $data);
    }

    public function create(Request $request)
    {
        session(['editedProduct' => null]);
        $users = User::whereHas('type', function ($query) {
            $query->where('code', 'сooperation_member');
        })->get();
        $data = [
            'menu_item' => 'products', 
            'users' => $users,
            'categories' => ProductCategory::whereNull("parent_id")
                ->orderBy('title', 'asc')
                ->with('children')
                ->where('for_service', 0)
                ->get(),
            'is_service'=> 0,
            'page_title'=>'Добавить новый товар',
            'submit_title'=>'Добавить товар',
            'form_route' => "products.store",
            'back_route'=>"products"
        ];
        $uploadedFiles = session('uploadedFiles');
        if($request->session()->get('errors') === null){
            session(['uploadedFiles' => []]);
            if($uploadedFiles){
                foreach ($uploadedFiles as $uploadedFile) {
                    $newName = $uploadedFile['new_name'];
                    @unlink('images/products/'.$newName);
                }
            }
        } else {
            $data['uploadedFiles'] = $uploadedFiles;
        }
        return view('products.edit', $data);
    }

    public function store(StoreProductRequest $request)
    {
        $productData = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'cooperative_price' => $request->cooperative_price,
            'quantity' => $request->quantity,
            'weight' => $request->weight,
            'user_id' => Auth::user()->id,
            'is_service' => 0,
            'production_place' => $request->production_place, 
        ];
        $product = Product::create($productData);
        $uploadedFiles = session('uploadedFiles');
        session(['uploadedFiles' => []]);
        if($uploadedFiles){
            foreach ($uploadedFiles as $uploadedFile) {
                $image = new ProductImage();                
                $image->old_name = $uploadedFile['old_name'];
                $image->new_name = $uploadedFile['new_name']; 
                if($uploadedFile['new_name']==$request->main_photo){
                    $image->main = 1;
                }
                $image->product_id = $product->id;
                $image->save();
            }
        }
        return redirect()->route('products');
    }

    public function updateItem($id)
    {
        session(['editedProduct' => $id]);
        $product = Product::findOrFail($id);
        $uploadedFiles = $product->image()->getResults();
        $users = User::whereHas('type', function ($query) {
            $query->where('code', 'сooperation_member');
        })->get();
        $data = [
            'product' => $product,
            'menu_item' => 'products',
            'users' => $users,
            'uploadedFiles' => $uploadedFiles,
            'categories' => ProductCategory::whereNull("parent_id")->orderBy('title', 'asc')->with('children')->where('for_service', 0)->get(),
            'is_service'=> 0,
            'page_title' => "Редактирование товара \"" . $product->title . "\"",
            'submit_title'=>'Обновить товар',
            'form_route' => "products.update.post",
            'back_route'=>"products"
        ];
        return view('products.edit', $data);
    }

    public function updateItemPost($id, StoreProductRequest $request)
    {
        $product = Product::findOrFail($id);
        $productData = [
            'title' => $request->title, 
            'description' => $request->description, 
            'price' => $request->price, 
            'cooperative_price' => $request->cooperative_price,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'weight' => $request->weight,
            'production_place' => $request->production_place,
        ];
        $product->update($productData);
        ProductImage::where('product_id', $id)->update(['main' => 0]);
        $mainPhotoObj = ProductImage::where([
            ['product_id', $id],
            ['new_name', $request->main_photo],
        ])->first();    
        if($mainPhotoObj){
            $mainPhotoObj->main = 1;
            $mainPhotoObj->save();
        } 
        return redirect()->route('products');
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return back();
    }
    
}