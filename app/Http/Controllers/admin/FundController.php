<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fund;

class FundController extends Controller
{	

    public function index()
    {   
        $data = [            
            'menu_item' => 'funds',
            'funds' => Fund::paginate(20),            
        ];
        return view('admin.funds.index', $data);
    }

    /*public function create(Request $request)
    {     
        $data = [
            'menu_item' => 'roles',            
        ];
        return view('admin.roles.roles_add', $data);
    }

    public function store(StoreRolePost $request)
    {             
        
        $roleData = [
          'name' => $request->name,
          'title' => $request->title,          
        ]; 

        $role = UserRole::create($roleData);
        
        return redirect()
            ->route('admin.roles');
    }
    
    public function updateItem($id)
    {        
        $role = UserRole::findOrFail($id);

        $data = [
            'role' => $role,
            'menu_item' => 'role'            
        ];

        return view('admin.roles.roles_edit', $data);
    }

    public function updateItemPost($id, UpdateRolePost $request)
    {           
        $role = UserRole::findOrFail($id);        

        $roleData = [
          'title' => $request->title          
        ];

        $role->update($roleData);
                       
        return redirect()
            ->route('admin.roles');
    }



    public function delete($id)
    {
        $role = UserRole::find($id);        
        $role->delete();

        return back();
    }*/
}
