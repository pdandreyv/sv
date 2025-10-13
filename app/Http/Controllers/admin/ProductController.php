<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\ProductCategory;
use Auth;
use App\Http\Requests\Admin\StoreProductRequest;
use File;
use App\ProductImage;

class ProductController extends Controller
{   

    public function index()
    {
        $data = [
            'menu_item' => 'products',
            'products' => Product::paginate(20),
        ];
        return view('admin.products.index', $data);
    }

    public function create(Request $request)
    {     
        session(['editedProduct' => null]);

        $users = User::getMembers();

        $data = [
            'menu_item' => 'products', 
            'users' => $users,
            'catLevel1' => ProductCategory::whereNull('parent_id')->where('for_service', 0)->get() 
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
            $allCategories = old('category_id');            
            if($allCategories[count($allCategories) - 1]!==null || count($allCategories) > 2){
                if($allCategories[count($allCategories) - 1]==null){
                    unset($allCategories[count($allCategories) - 1]);
                }                
                $categoriesNeighbours = [];
                foreach ($allCategories as $category_id) {
                    $category = ProductCategory::find($category_id);
                    $categoriesNeighbours[$category_id] = $category->getNeighbours();
                }
                $data['categoriesNeighbours'] = $categoriesNeighbours;
            }
            $data['uploadedFiles'] = $uploadedFiles;
        }

        return view('admin.products.create', $data);
    }

    public function store(StoreProductRequest $request)
    {                                 
        $productData = [          
            'title' => $request->title,          
            'description' => $request->description,
            'category_id' => empty($request->category_id[count($request->category_id)-1])?(isset($request->category_id[count($request->category_id)-2])?$request->category_id[count($request->category_id)-2]:null):$request->category_id[count($request->category_id)-1],          
            'price' => $request->price, 
            'cooperative_price' => $request->cooperative_price,            
            'quantity' => $request->quantity,
            'weight' => $request->weight, 
            'user_id' => $request->user_id,
            'is_service' => isset($request->is_service)?1:0,
            'is_confirmed' => isset($request->is_confirmed)?1:0,            
        ];

        if(!$request->is_service){
            $productData['production_place'] = $request->production_place;
        }

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
        
        return redirect()
            ->route('admin.products');
    }
    
    public function updateItem($id)
    {    

        session(['editedProduct' => $id]); 

        $product = Product::findOrFail($id);
       
        $uploadedFiles = $product->image()->getResults(); 

        $allCategories = $product->getAllCategories();        

        if(count($allCategories)){            
            $categoriesNeighbours = [];

            foreach ($allCategories as $category_id) {
                $category = ProductCategory::find($category_id);
                $categoriesNeighbours[$category_id] = $category->getNeighbours();
            }
        } else {            
            $categoriesNeighbours[0] = ProductCategory::whereNull('parent_id')->where('for_service', $product->is_service)->get();            
        }               

        $users = User::getMembers();

        $data = [
            'product' => $product,
            'menu_item' => 'products',
            'categoriesNeighbours' => $categoriesNeighbours,
            'users' => $users,
            'uploadedFiles' => $uploadedFiles,            
        ];        

        return view('admin.products.edit', $data);
    }

    public function updateItemPost($id, StoreProductRequest $request)
    {           
        $product = Product::findOrFail($id);

        $productData = [
            'title' => $request->title, 
            'description' => $request->description, 
            'price' => $request->price, 
            'cooperative_price' => $request->cooperative_price,
            'category_id' => empty($request->category_id[count($request->category_id)-1])?(isset($request->category_id[count($request->category_id)-2])?$request->category_id[count($request->category_id)-2]:null):$request->category_id[count($request->category_id)-1],  
            'quantity' => $request->quantity,
            'weight' => $request->weight, 
            'user_id' => $request->user_id,
            'is_service' => isset($request->is_service)?1:0,
            'is_confirmed' => isset($request->is_confirmed)?1:0,
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

        return redirect()
            ->route('admin.products');
    }



    public function delete($id)
    {
        $product = Product::find($id);        
        $product->delete();

        return back();
    }

    public function ajaxUpload(Request $request)
    {
        if ($request->file) {
            $file = $request->file;
            $old_name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/products'), $new_name);

            $editedProduct = session('editedProduct');

            if($editedProduct){                
                $image = new ProductImage();                    
                $image->old_name = $old_name;
                $image->new_name = $new_name;                
                $image->product_id = $editedProduct;
                $image->main = 0;
                $image->save();
            } else {
                $uploadedFiles = session('uploadedFiles');
                if(empty($uploadedFiles)) $uploadedFiles = [];
                $uploadedFiles[] = [
                    'old_name' => $old_name,
                    'new_name' => $new_name
                ];
                session(['uploadedFiles' => $uploadedFiles]);
            }

            echo json_encode([
                'status' => 'ok',
                'new_name' => $new_name
            ]);
        }        
    }

    public function fileRemove(Request $request)
    {
        @unlink('images/products/'.$request->name);

        if($request->product_id){
            ProductImage::where('new_name', $request->name)->delete();                            
        } else {
            $uploadedFiles = session('uploadedFiles');
            $newUploadedFiles = [];
            foreach ($uploadedFiles as $uploadedFile) {
                if($uploadedFile['new_name']!=$request->name){
                    $newUploadedFiles[] = $uploadedFile;
                }
            }                                          
            session(['uploadedFiles' => $newUploadedFiles]);
        }                
    }
}