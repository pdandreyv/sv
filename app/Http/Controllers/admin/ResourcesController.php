<?php

namespace App\Http\Controllers\Admin;

use App\Resources;
use App\ResourcesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCategory;
use \App\Http\Requests\Admin\ResourceRequest;
use App\User;
use App\Units;

class ResourcesController extends Controller
{

    public function index()
    {

        $resources = Resources::with('category')
                ->with('unit')
                ->withCount('choosed')
                ->paginate(20);

        $resources_chosen_count = [];
        foreach ($resources as $resource) {
            $resources_chosen_count[$resource->id] = $resource->choosed_count;
        }
        $data = [
            'menu_item' => 'resources',
            'users' => User::get(),
            'categories' => ProductCategory::whereNull('parent_id')
                ->orderBy('title', 'asc')
                ->with('children')
                ->with('resources')
                ->where('for_service', 0)
                ->get(),
            'resources' => Resources::with('category')
                ->with('unit')
                ->with('choosed')
                ->paginate(20),
            'resources_chosen_count' => $resources_chosen_count
        ];
        return view('admin.resources.index', $data);
    }

    public function add()
    {
        $data = [
            'menu_item' => 'resources', 
            'categories' => ProductCategory::whereNull("parent_id")
                ->orderBy('title', 'asc')
                ->with('children')
                ->where('for_service', 0)
                ->get(),
            'units' => Units::orderBy('description', 'asc')->get(),
            'page_title'=>'Добавить новый ресурс',
            'submit_title'=>'Добавить ресурс',
            'form_route' => "admin.resources.create",
            'back_route'=>"admin.resources.index"
        ];
        return view('admin.resources.edit', $data);
    }

    public function create(ResourceRequest $request)
    {
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id
        ];
        $resource = Resources::create($data);
        return redirect()->route('admin.resources.index');
    }

    public function edit($id)
    {
        $data = [
            'menu_item' => 'resources',
            'resource' => Resources::findOrFail($id),
            'categories' => ProductCategory::whereNull("parent_id")
                ->orderBy('title', 'asc')
                ->with('children')
                ->where('for_service', 0)
                ->get(),
            'units' => Units::orderBy('description', 'asc')->get(),
            'page_title'=>'Редактировать ресурс',
            'submit_title'=>'Обновить ресурс',
            'form_route' => "admin.resources.update",
            'back_route'=>"admin.resources.index"
        ];
        return view('admin.resources.edit', $data);
    }

    public function update($id, ResourceRequest $request)
    {
        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id
        ];
        Resources::findOrFail($id)->update($data);
        return redirect()->route('admin.resources.index');
    }

    public function delete($id)
    {
        Resources::findOrFail($id)->delete();
        return redirect()->route('admin.resources.index');
    }
}
