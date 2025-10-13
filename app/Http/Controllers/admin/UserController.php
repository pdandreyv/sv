<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\UserRole;
use Auth;
use App\Http\Requests\Admin\StoreUserPost;
use App\Http\Requests\Admin\UpdateUserPost;
use DB;
use App\Http\Requests\ChangePasswordPost;
use App\UserType;
use App\UserScan;
use File;
use App\Mail\AdminUserRegistrationMail;
use App\Mail\AdminChangePasswordMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{	

    public function index()
    {   
        $data = [
            'menu_item' => 'users',
            'users' => User::paginate(120),
        ];
        return view('admin.users.users', $data);
    }

    public function create(Request $request)
    {     
        $data = [
            'menu_item' => 'users',
            'roles' => UserRole::All(),
            'types' => UserType::All()
        ];
        return view('admin.users.users_add', $data);
    }

    public function store(StoreUserPost $request)
    {

        $lettersStr = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $passStr = '';
        for($i = 0; $i < 8; $i++){
            $idx = rand(0, strlen($lettersStr)-1);    
            $passStr[$i] = $lettersStr[$idx];
        }

        $userData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'name' => $request->last_name. ' ' .$request->first_name. ' ' .$request->middle_name,
            'gender' => $request->gender,
            'registration_address' => $request->registration_address,
            'accomodation_address' => $request->accomodation_address,
            'phone_number' => $request->phone_number,          
            'password' => bcrypt($passStr),
            'user_type_id' => $request->user_type_id,
            'passport_series' => $request->passport_series,
            'passport_number' => $request->passport_number,
            'passport_give' => $request->passport_give,
            'passport_give_date' => $request->passport_give_date,
            'identification_code' => $request->identification_code,
            'city' => $request->city,
            'alias' => $request->alias,
            'verified' => 1
        ]; 

        if($request->birth_year && $request->birth_mounth && $request->birth_day){
            $userData['birth_date'] = $request->birth_year.'-'.$request->birth_mounth.'-'.$request->birth_day;
        }

        if ($request->photo_file) {
            $file = $request->photo_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_photos'), $new_name);
            $userData['photo'] = $new_name;
        }

        $user = User::create($userData);

        if (!empty($request->role)) {          
          foreach ($request->role as $role_id) {              
              DB::table('users__roles')
                ->insert([
                    'user_id' => $user->id,
                    'role_id' => $role_id,
                ]);
          }
        } else {

          $role = UserRole::where('name', 'member')->first();          

          DB::table('users__roles')
                ->insert([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                ]);
        }
        
        if ($request->page1_file) {

            $file = $request->page1_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_documents'), $new_name);
            
            UserScan::create([
                'user_id' => $user->id,
                'type' => 'passport1',
                'file_name' => $new_name,
            ]);            
        }
        
        if ($request->page2_file) {            
            
            $file = $request->page2_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_documents'), $new_name);

            UserScan::create([
                'user_id' => $user->id,
                'type' => 'passport2',
                'file_name' => $new_name,
            ]);            
        }
        
        if ($request->page3_file) {            
            $file = $request->page3_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_documents'), $new_name);
            UserScan::create([
                'user_id' => $user->id,
                'type' => 'passport3',
                'file_name' => $new_name,
            ]);            
        }
        
        if ($request->ic_file) {            
            $file = $request->ic_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_documents'), $new_name);
            UserScan::create([
                'user_id' => $user->id,
                'type' => 'identification_code',
                'file_name' => $new_name,
            ]);            
        }

        //@Mail::to($user->email)->send(new AdminUserRegistrationMail($user, $passStr));

        return redirect()
            ->route('admin.users');
    }
    
    public function updateItem($id)
    {        
        $user = User::findOrFail($id);        
        $data = [
            'user' => $user,
            'menu_item' => 'users',
            'roles' => UserRole::All(),
            'types' => UserType::All(),
            'passport1' => $user->scans()->where('type', 'passport1')->first(),
            'passport2' => $user->scans()->where('type', 'passport2')->first(),
            'passport3' => $user->scans()->where('type', 'passport3')->first(),
            'identification_code' => $user->scans()->where('type', 'identification_code')->first(),
        ];

        return view('admin.users.users_edit', $data);
    }

    public function updateItemPost($id, UpdateUserPost $request)
    {            
        $user = User::findOrFail($id);        

        $userData = [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'name' => $request->last_name. ' ' .$request->first_name. ' ' .$request->middle_name,
            'gender' => $request->gender,
            'registration_address' => $request->registration_address,
            'accomodation_address' => $request->accomodation_address,
            'phone_number' => $request->phone_number, 
            'user_type_id' => $request->user_type_id,
            'passport_series' => $request->passport_series,
            'passport_number' => $request->passport_number,
            'passport_give' => $request->passport_give,
            'passport_give_date' => $request->passport_give_date,
            'identification_code' => $request->identification_code,
            'city' => $request->city,
            'alias' => $request->alias,
        ];    

        if($request->birth_year && $request->birth_mounth && $request->birth_day){
            $userData['birth_date'] = $request->birth_year.'-'.$request->birth_mounth.'-'.$request->birth_day;
        }

        if ($request->photo_file) {            
            File::delete(public_path('images/users_photos/'.$user->photo));
            $file = $request->photo_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_photos'), $new_name);
            $userData['photo'] = $new_name;
        }

        $user->update($userData);

        /* roles start */
        $rolesOld = $user->roles()->get()->pluck('id')->toArray();

        if (isset($request->role) && count($request->role)) {
            $rolesToAdd = array_diff($request->role, $rolesOld);

            foreach($rolesToAdd as $one) {
                DB::table('users__roles')->insert([
                    ['user_id' => $user->id, 'role_id' => $one],
                ]);
            }

            $rolesToDelete = array_diff($rolesOld, $request->role);
        }
        else {
            $rolesToDelete = $rolesOld;
        }

        foreach($rolesToDelete as $one) {
            DB::table('users__roles')
                ->where(['user_id' => $user->id, 'role_id' => $one])
                ->delete();
        } 
        /*update scans*/
        if ($request->page1_file) {             
            $file = $request->page1_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;            
            $file->move(public_path('images/users_documents'), $new_name);
            
            $passport1 = $user->scans()->where('type', 'passport1')->first();
            if($passport1){
                File::delete(public_path('images/users_documents'.$passport1->file_name));
                $passport1->update([                    
                    'file_name' => $new_name,
                ]);
            } else {
                UserScan::create([
                    'user_id' => $user->id,
                    'type' => 'passport1',
                    'file_name' => $new_name,
                ]);
            }                                                
        }
        
        if ($request->page2_file) {             
            $file = $request->page2_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_documents'), $new_name);
            
            $passport2 = $user->scans()->where('type', 'passport2')->first();
            if($passport2){
                File::delete(public_path('images/users_documents'.$passport2->file_name));
                $passport2->update([                    
                    'file_name' => $new_name,
                ]);
            } else {
                UserScan::create([
                    'user_id' => $user->id,
                    'type' => 'passport2',
                    'file_name' => $new_name,
                ]);
            }                                                
        }
        
        if ($request->page3_file) {             
            $file = $request->page3_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_documents'), $new_name);
            
            $passport3 = $user->scans()->where('type', 'passport3')->first();
            if($passport3){
                File::delete(public_path('images/users_documents'.$passport3->file_name));
                $passport3->update([                    
                    'file_name' => $new_name,
                ]);
            } else {
                UserScan::create([
                    'user_id' => $user->id,
                    'type' => 'passport3',
                    'file_name' => $new_name,
                ]);
            }                                                
        }
        
        if ($request->ic_file) {             
            $file = $request->ic_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_documents'), $new_name);
            
            $identification_code = $user->scans()->where('type', 'identification_code')->first();
            if($identification_code){
                File::delete(public_path('images/users_documents'.$identification_code->file_name));
                $identification_code->update([                    
                    'file_name' => $new_name,
                ]);
            } else {
                UserScan::create([
                    'user_id' => $user->id,
                    'type' => 'identification_code',
                    'file_name' => $new_name,
                ]);
            }                                                
        }
        
        /* roles end */
        return redirect()
            ->route('admin.users');
    }



    public function delete($id)
    {
        $user = User::find($id);
        
        File::delete(public_path('images/users_photos/'.$user->photo));

        DB::table('users__roles')
                ->where(['user_id' => $user->id])
                ->delete();
        foreach($user->scans()->get() as $scan){
            if($scan->type == 'identification_code'){
                File::delete(public_path('../safe_uploads/identification_codes/'.$scan->file_name)); 
            } else {
                File::delete(public_path('../safe_uploads/passports_scans/'.$scan->file_name));
            }
            
        }
        $user->scans()->delete();
        $user->delete();

        return back();
    }

    public function changePassword($id, ChangePasswordPost $request){
        $user = User::findOrFail($id);      
        $userData = [
            'password' => bcrypt($request->password),
        ];
        $user->update($userData);
        return redirect()
            ->route('admin.users');
    }
    
    public function generatePassword($id){
        $user = User::findOrFail($id);
        $lettersStr = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $passStr = '';
        for($i = 0; $i < 8; $i++){
            $idx = rand(0, strlen($lettersStr)-1);    
            $passStr[$i] = $lettersStr[$idx];
        }            

        $userData = [
            'password' => bcrypt($passStr),
        ];
        $user->update($userData);
        //@Mail::to($user->email)->send(new AdminChangePasswordMail($user, $passStr));
        return redirect()
            ->route('admin.users');
    }

    public function getScan($id, Request $request){
        $scan = UserScan::findOrFail($id); 
        if($scan->type == 'identification_code'){
            $path = public_path('../safe_uploads/identification_codes/'.$scan->file_name); 
        } else {
            $path = public_path('../safe_uploads/passports_scans/'.$scan->file_name);
        }
        $type = explode('.',$scan->file_name);
        $type = "image/".$type[1];
        header('Content-Type:'.$type);
        header('Content-Length: ' . filesize($path));
        readfile($path);
    }
}
