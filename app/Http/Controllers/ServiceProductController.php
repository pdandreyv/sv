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

class ServiceProductController extends Controller
{

    public function index()
    {
        $data = [
            'menu_item' => 'service-products',
            'products' => Product::where('is_service',1)
            ->where('user_id', Auth::user()->id)
            ->paginate(20),
            'page_title'=>'Мои услуги',
            'is_service'=> 1,
            'add_title'=> "Добавить услугу",
            'create_route'=> "service-products.create",
            'update_route'=>"service-products.update",
            'delete_route'=>"service-products.delete"
        ];
        return view('products.index', $data);
    }

    public function create(Request $request)
    {
        session(['editedProduct' => null]);
        $data = [
            'menu_item' => 'service-products',
            'categories' => ProductCategory::whereNull('parent_id')
                ->orderBy('title', 'asc')
                ->with('children')
                ->where('for_service', 1)
                ->get(),
            'is_service' => 1,
            'page_title' => "Добавить новую услугу",
            'submit_title'=>'Добавить услугу',
            'form_route' => "service-products.store",
            'back_route'=>"service-products"
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
            'is_service' => 1,
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
        return redirect()->route('service-products');
    }

    public function updateItem($id)
    { 
        session(['editedProduct' => $id]); 
        $product = Product::findOrFail($id);
        $uploadedFiles = $product->image()->getResults(); 
        $data = [
            'product' => $product,
            'menu_item' => 'service-products',
            'uploadedFiles' => $uploadedFiles,
            'categories' => ProductCategory::whereNull("parent_id")
                ->orderBy('title', 'asc')
                ->with('children')
                ->where('for_service', 1)
                ->get(),
            'is_service' => 1,
            'page_title' => "Редактирование услуги \"" . $product->title . "\"",
            'submit_title'=>'Обновить услугу',
            'form_route' => "service-products.update.post",
            'back_route'=>"service-products"
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
        return redirect()->route('service-products');
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return back();
    }
}