<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Requests\ChangeProfileRequest;
use App\Http\Requests\ChangePasswordPost;
use App\Http\Requests\SendCooperationRequest;
use App\UserType;
use Illuminate\Support\Facades\Session;
use App\UserScan;
use File;
use App\Mail\RequestMail;
use App\Mail\UserChangePasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Subscribers;
use App\UserRole;
use DB;
use App\QuestionnaireAnswer;

class ProfileController extends Controller
{

    public function update($id)
    {
    $user = User::findOrFail($id);
        $data = [
            'user' => $user,
          'menu_item' => 'profile'
        ];

        return view('profile/update', $data);
    }

    public function updatePost($id, ChangeProfileRequest $request)
    {
        $user = User::findOrFail($id);        

        $userData = [
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'name' => $request->last_name. ' ' .$request->first_name. ' ' .$request->middle_name,
          'email' => $request->email,
          'city' => $request->city,
          'accomodation_address' => $request->accomodation_address,
          'phone_number' => $request->phone_number,
          'alias' => $request->alias,          
        ];

        if ($request->photo_file) {
            File::delete(public_path('images/users_photos/'.$user->photo));

            $file = $request->photo_file;            
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_photos'), $new_name);
            $userData['photo'] = $new_name;
        }

        $user->update($userData);


        return redirect()
            ->route('profile.my-page', ['id' => Auth::user()->id]);
    }

    public function changePassword($id, ChangePasswordPost $request)
    {
        $user = User::findOrFail($id);      
        $userData = [
            'password' => bcrypt($request->password),
        ];
        $user->update($userData);

        //@Mail::to($user->email)->send(new UserChangePasswordMail($user));

        return redirect()
            ->route('profile.my-page', Auth::user()->id);
    }

    public function request(Request $request)
    {

        $result = UserType::whereIn('code', ['сooperation_request', 'сooperation_member'])->pluck('id')->toArray();
        $canSendCooperativeRequest = !in_array(Auth::user()->user_type_id, $result);
        if(!$canSendCooperativeRequest){
            Session::flash('error', 'Вы не можете подать заявку!');
        }
        return view('profile/request');
    }
    
    public function requestPost(SendCooperationRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $requestUserType = UserType::whereIn('code', ['сooperation_request'])->first();

        $userData = [
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'birth_date' => $request->birth_year.'-'.$request->birth_mounth.'-'.$request->birth_day,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'passport_series' => $request->passport_series,
            'passport_number' => $request->passport_number,
            'passport_give' => $request->passport_give,
            'passport_give_date' => $request->passport_give_date,
            'registration_address' => $request->registration_address,
            'identification_code' => $request->identification_code,
            'user_type_id' => $requestUserType->id,
            'name' => $request->last_name. ' ' .$request->first_name. ' ' .$request->middle_name,
        ];

        $user->update($userData);

        if ($request->page1_file) {
            $file = $request->page1_file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('images/users_documents'), $new_name);
            UserScan::create([
                'user_id' => Auth::user()->id,
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
                'user_id' => Auth::user()->id,
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
                'user_id' => Auth::user()->id,
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
                'user_id' => Auth::user()->id,
                'type' => 'identification_code',
                'file_name' => $new_name,
            ]);
        }

        //@Mail::to($user->email)->send(new RequestMail($user));

        return redirect()
            ->route('profile.my-page', ['id' => Auth::user()->id]);
    }

    public function show($id, Request $request)
    {
        $user = User::find($id);
//        var_dump($user); exit;
        if(!$user){
            $user = User::where('alias', $id)->first();
        }

        $subscribe = (Subscribers::where('user_id', $user->id)
                ->where('subscriber_id', Auth::user()->id)->first())?true:false;

        $questionnaireAnswers = QuestionnaireAnswer::with('question')
            ->where('user_id', $user->id)
            ->whereNotNull('answer')
            ->where('answer', '!=', '')
            ->get();
        
        $data = [
            'user' => $user,
            'subscribe' => $subscribe,
            'questionnaireAnswers' => $questionnaireAnswers,
        ];
        return view('profile/show', $data);
    }

    public function my_page() {
        $user = Auth::user();

        if (empty($user->passport_series)) {
            $role_id = UserRole::where('name', 'member')->pluck('id')->first();

            DB::table('users__roles')
                ->where(['user_id' => $user->id, 'role_id' => $role_id])
                ->delete();
        }
        // Подтянуть посты пользователя для include('posts.list')
        $posts = (new \App\Posts())->getUserPosts($user->id);
        $data = [
            'user' => $user,
            'menu_item' => 'my-page',
            'posts' => $posts,
        ];
        return view('profile/my-page', $data);
    }

    public function access($id, Request $request)
    {
        $user = User::find($id);
        
        $post = $request->all();
        if(isset($post['birth_date_view']))
            $post['birth_date_view'] = 1;
        else $post['birth_date_view'] = 0;
        
        if(isset($post['city_view']))
            $post['city_view'] = 1;
        else $post['city_view'] = 0;
        
        if(isset($post['phone_number_view']))
            $post['phone_number_view'] = 1;
        else $post['phone_number_view'] = 0;

        if(isset($post['email_view']))
            $post['email_view'] = 1;
        else $post['email_view'] = 0;

        $user->fill($post);

        // var_dump($request->all());
        // exit;
        $user->save();
        return redirect()->route('profile.show', $id);
    }

}
