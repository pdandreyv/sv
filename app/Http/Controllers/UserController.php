<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'users' => User::paginate(10),
            'menu_item' => 'users-list',
        ];
        return view('users.list', $data);
    }

    public function usersDropDown($userName)
    {
        $users = User::where('name', 'like', $userName.'%')
            ->orWhere('first_name', 'like', $userName.'%')
            ->orWhere('last_name', 'like', $userName.'%')
            ->select('id', 'name', 'first_name', 'last_name', 'middle_name', 'photo')
            ->get()
            ->toArray();
        return json_encode($users);
    }

    public function usersFind($userName)
    {
        $user = User::where('name', 'like', $userName.'%')
            ->orWhere('first_name', 'like', $userName.'%')
            ->orWhere('last_name', 'like', $userName.'%')
            ->select('id', 'name', 'first_name', 'last_name', 'middle_name', 'photo')
            ->first();
        if($user){
            return json_encode($user->toArray());
        } else {
            return json_encode(['error'=>'not_find']);
        }
    }
}

