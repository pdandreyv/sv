<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Network;
use App\User;
use App\Http\Requests\Admin\StoreNetworkNodePost;

class NetworkController extends Controller
{	

    public function index()
    {   
        $data = [            
            'menu_item' => 'network',
            'nodes' => Network::paginate(20),            
        ];
        return view('admin.network.index', $data);
    }

    public function create(Request $request)
    {     
        $data = [
            'menu_item' => 'network',            
        ];
        return view('admin.network.create', $data);
    }

    public function usersDropDown($userName, $userType){
        //echo $userName.' '.$userType;
        switch ($userType) {
            case 'user_id':
                $users = User::whereDoesntHave('roles', function ($query) {                        
                            $query->where('name', 'ups3');
                    })
                    ->where(function($query) use ($userName){
                        $query->where('name', 'like', $userName.'%')
                            ->orWhere('first_name', 'like', $userName.'%')
                            ->orWhere('last_name', 'like', $userName.'%');
                    })
                    ->select('id', 'name', 'first_name', 'last_name', 'middle_name', 'photo')
                    ->get()
                    ->toArray();

                break;
            case 'ups1_id':
                $users = User::whereHas('roles', function ($query) {
                        $query->where('name', 'ups1')
                            ->orWhere('name', 'ups2')
                            ->orWhere('name', 'ups3');
                    })
                    ->where(function($query) use ($userName){
                        $query->where('name', 'like', $userName.'%')
                            ->orWhere('first_name', 'like', $userName.'%')
                            ->orWhere('last_name', 'like', $userName.'%');
                    })                    
                    ->select('id', 'name', 'first_name', 'last_name', 'middle_name', 'photo')                    
                    ->get()
                    ->toArray();

                break;
            case 'ups2_id':
                $users = User::whereHas('roles', function ($query) {                        
                            $query->where('name', 'ups2')
                            ->orWhere('name', 'ups3');
                    })
                    ->where(function($query) use ($userName){
                        $query->where('name', 'like', $userName.'%')
                            ->orWhere('first_name', 'like', $userName.'%')
                            ->orWhere('last_name', 'like', $userName.'%');
                    })                                        
                    ->select('id', 'name', 'first_name', 'last_name', 'middle_name', 'photo')                    
                    ->get()
                    ->toArray();

                break;
            case 'ups3_id':                
                $users = User::whereHas('roles', function ($query) {                        
                            $query->where('name', 'ups3');
                    })
                    ->where(function($query) use ($userName){
                        $query->where('name', 'like', $userName.'%')
                            ->orWhere('first_name', 'like', $userName.'%')
                            ->orWhere('last_name', 'like', $userName.'%');
                    })                   
                    ->select('id', 'name', 'first_name', 'last_name', 'middle_name', 'photo')                    
                    ->get()
                    ->toArray();

                break;
            default:
                break;
        }
        
        return json_encode($users);
    }
    
    public function usersFind($userName, $userType)
    {        
        switch ($userType) {
            case 'user_id':
                $user = User::whereDoesntHave('roles', function ($query) {                        
                            $query->where('name', 'ups3');
                    })
                    ->where(function($query) use ($userName){
                        $query->where('name', 'like', $userName.'%')
                            ->orWhere('first_name', 'like', $userName.'%')
                            ->orWhere('last_name', 'like', $userName.'%');
                    })
                    ->first();
                    
                    if($user){
                        $userInfo = [
                            'id' => $user->id,
                            'fullName' => $user->fullName()
                        ];
                        
                        $resArr['user'] = $userInfo;
                        
                        return json_encode(['user' => $userInfo]);
                    } else {
                        return json_encode(['error'=>'not_find']);
                    }
                break;
            case 'ups1_id':
                $user = User::whereHas('roles', function ($query) {
                        $query->where('name', 'ups1')
                            ->orWhere('name', 'ups2')
                            ->orWhere('name', 'ups3');
                    })
                    ->where(function($query) use ($userName){
                        $query->where('name', 'like', $userName.'%')
                            ->orWhere('first_name', 'like', $userName.'%')
                            ->orWhere('last_name', 'like', $userName.'%');
                    })                    
                    ->first();
                    if($user){
                        
                        $resArr = $this->generateResArrForParentNodesUps1($user->id);
                        
                        $userInfo = [
                            'id' => $user->id,
                            'fullName' => $user->fullName()
                        ];
                        
                        $resArr['user'] = $userInfo;                        
                        
                        return json_encode($resArr);
                    } else {
                        return json_encode(['error'=>'not_find']);
                    }
                break;
            default:
                break;
        }                
    }
    
    public function ups1GetParentNodes($userId){        
        
        $resArr = $this->generateResArrForParentNodesUps1($userId);
        
        return json_encode($resArr);
    }
    
    private function generateResArrForParentNodesUps1($userId){
        $ups1Node = Network::where('user_id', $userId)->first();
        
        $resArr = [];
        
        if($ups1Node){
            $ups2User = $ups1Node->ups1User;
            $ups2Info = [
                'id' => $ups2User->id,
                'fullName' => $ups2User->fullName()
            ];
            
            $resArr['ups2'] = $ups2Info;
            
            $ups3User = $ups1Node->ups2User;
            if($ups3User) {
                $ups3Info = [
                    'id' => $ups3User->id,
                    'fullName' => $ups3User->fullName()
                ];
                $resArr['ups3'] = $ups3Info;
            }                        
        }
        
        return $resArr;
    }


    public function store(StoreNetworkNodePost $request)
    {             
        
        $networkData = [
          'user_id' => $request->user_id,
          'ups1' => $request->ups1_id,          
          'ups2' => $request->ups2_id,
          'ups3' => $request->ups3_id,
        ]; 

        Network::create($networkData);
        
        return redirect()
            ->route('admin.network');
    }
    
    /*public function updateItem($id)
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
    }*/



    public function delete($id)
    {
        $node = Network::find($id);        
        $node->delete();

        return back();
    }
}
