<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserType;
use Auth;
use App\Http\Requests\Admin\StoreUserTypePost;
use App\Http\Requests\Admin\UpdateUserTypePost;

class UserTypeController extends Controller
{	

    public function index()
    {   
        $data = [            
            'menu_item' => 'user_types',
            'types' => UserType::paginate(20),            
        ];
        return view('admin.user-types.list', $data);
    }

    public function create(Request $request)
    {     
        $data = [
            'menu_item' => 'user_types',            
        ];
        return view('admin.user-types.add', $data);
    }

    public function store(StoreUserTypePost $request)
    {             
        
        $data = [
          'code' => $request->code,
          'name' => $request->name,          
        ]; 

        $role = UserType::create($data);
        
        return redirect()
            ->route('admin.user-types');
    }
    
    public function updateItem($id)
    {        
        $type = UserType::findOrFail($id);

        $data = [
            'type' => $type,
            'menu_item' => 'user_types'            
        ];

        return view('admin.user-types.edit', $data);
    }

    public function updateItemPost($id, UpdateUserTypePost $request)
    {           
        $role = UserType::findOrFail($id);        

        $roleData = [
          'name' => $request->name          
        ];

        $role->update($roleData);
                       
        return redirect()
            ->route('admin.user-types');
    }



    public function delete($id)
    {
        $role = UserType::find($id);        
        $role->delete();

        return back();
    }
}
