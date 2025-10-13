<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductCategory;
use Auth;
use App\Http\Requests\Admin\StoreProductCategoryRequest;
use File;
use Session;

class ProductCategoryController extends Controller
{

    public function index()
    {
        $data = [
            'menu_item' => 'product_category',
            'categories' => ProductCategory::whereNull("parent_id")->with('children')->paginate(20),
        ];
        return view('admin.product_categories.index', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'menu_item' => 'product_category', 
            'catLevel1' => ProductCategory::whereNull('parent_id')->where('for_service', 0)->get()
        ];

        return view('admin.product_categories.create', $data);
    }

    public function createChild($id)
    {
        $parent = ProductCategory::where('id', $id)->first();
        return view('admin.product_categories.create-child', ['menu_item' => 'product_category', 'parent' => $parent]);
    }


    public function storeChild(StoreProductCategoryRequest $request) {
        $requestData = [
          'title' => $request->title,
          'description' => $request->description,
          'parent_id' => $request->parent_id,
          'for_service' => $request->for_service,
        ];
        if ($request->photo_file) {
            $file = $request->photo_file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/product_category_photos'), $new_name);
            $requestData['photo'] = $new_name;
        }
        if ($request->icon_file) {
            $file = $request->icon_file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/product_category_photos'), $new_name);
            $requestData['icon'] = $new_name;
        }
        try {
            ProductCategory::create($requestData);
            Session::flash('sucсess', 'Подкатегория создана успешно');
            return redirect()->route('admin.product-categories');
        } catch (Exception $e) {
            Session::flash('erorr', 'Подкатегория не была добавлена');
            return redirect()->route('admin.product-categories.create-child');
        }
    }

    public function store(StoreProductCategoryRequest $request)
    {

        $catData = [
          'title' => $request->title,
          'description' => $request->description,
          'for_service' => empty($request->for_service)?0:1,
        ];

        if ($request->photo_file) {
            $file = $request->photo_file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/product_category_photos'), $new_name);
            $catData['photo'] = $new_name;
        }

        if ($request->icon_file) {
            $file = $request->icon_file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/product_category_photos'), $new_name);
            $catData['icon'] = $new_name;
        }

        ProductCategory::create($catData);

        return redirect()
            ->route('admin.product-categories');
    }
    
    public function updateItem($id)
    {        
        $category = ProductCategory::findOrFail($id);

        $allParents = $category->getAllParents();

        if(count($allParents)){
            $parentsNeighbours = [];

            foreach ($allParents as $parent_id) {
                $parent = ProductCategory::find($parent_id);
                $parentsNeighbours[$parent_id] = $parent->getNeighbours();
            }
        } else {
            $parentsNeighbours[0] = ProductCategory::whereNull('parent_id')->where('for_service', $category->for_service)->get();
        }

        $data = [
            'category' => $category,
            'menu_item' => 'product_category',
            'parentsNeighbours' => $parentsNeighbours
        ];
        return view('admin.product_categories.edit', $data);
    }

    public function updateItemPost($id, StoreProductCategoryRequest $request)
    {
        $category = ProductCategory::findOrFail($id);

        $catData = [
          'title' => $request->title,
          'description' => $request->description,
          'parent_id' => empty($request->parent[count($request->parent)-1])?(isset($request->parent[count($request->parent)-2])?$request->parent[count($request->parent)-2]:null):$request->parent[count($request->parent)-1],
          'for_service' => empty($request->for_service)?0:1,
        ];

        if ($request->photo_file) {
            File::delete(public_path('images/product_category_photos/'.$category->photo));
            $file = $request->photo_file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/product_category_photos'), $new_name);
            $catData['photo'] = $new_name;
        }

        if ($request->icon_file) { 
            File::delete(public_path('images/product_category_photos/'.$category->icon));
            $file = $request->icon_file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/product_category_photos'), $new_name);
            $catData['icon'] = $new_name;
        }

        $category->update($catData);

        return redirect()
            ->route('admin.product-categories');
    }

    public function delete($id)
    {
        $category = ProductCategory::find($id);
        $category->delete();

        return back();
    }

    public function getChilds($id, $for_service){
        if(!empty($id)){
            $childs = ProductCategory::where([['parent_id', '=', $id], ['for_service', '=', $for_service]])->get()->toArray();
        } else {
            $childs = ProductCategory::whereNull('parent_id')->where('for_service', $for_service)->get()->toArray();
        }

        echo json_encode($childs);
    }
}

