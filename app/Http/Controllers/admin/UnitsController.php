<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Units;
use \App\Http\Requests\Admin\UnitsRequest;

class UnitsController extends Controller
{
    public function index()
    {
        $data = [
            'menu_item' => 'units',
            'units' => Units::paginate(20),
        ];
        return view('admin.units.index', $data);
    }

    public function add()
    {
        $data = [
            'menu_item' => 'units', 
            'page_title'=>'Добавить новую единицу измерения',
            'submit_title'=>'Добавить',
            'form_route' => "admin.units.create",
            'back_route'=>"admin.units.index"
        ];
        return view('admin.units.edit', $data);
    }

    public function create(UnitsRequest $request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description
        ];
        $resource = Units::create($data);
        return redirect()->route('admin.units.index');
    }

    public function edit($id)
    {
        $data = [
            'menu_item' => 'units',
            'unit' => Units::findOrFail($id),
            'page_title'=>'Редактировать единицу измерения',
            'submit_title'=>'Обновить',
            'form_route' => "admin.units.update",
            'back_route'=>"admin.units.index"
        ];
        return view('admin.units.edit', $data);
    }

    public function update($id, UnitsRequest $request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description
        ];
        Units::findOrFail($id)->update($data);
        return redirect()->route('admin.units.index');
    }

    public function delete($id)
    {
        Units::findOrFail($id)->delete();
        return redirect()->route('admin.units.index');
    }
}
