<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\MailTemplate;
use App\UserType;
use App\User;
use App\Mail\CustomMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\MailingPost;

class MailingController extends Controller
{	

    public function index()
    {           
        $data = [            
            'menu_item' => 'mailing', 
            'templates' => MailTemplate::where('is_standart', false)->get(),
            'userTypes' => UserType::all(),                    
        ];
        return view('admin.mailing.index', $data);
    }
    
    public function send(MailingPost $request)
    {             
        switch ($request->send_type) {
            case 'all':
                $users = User::all();                
                foreach ($users as $user) {
                    //@Mail::to($user->email)->send(new CustomMail($user, $request->template_id));
                }
                break;
            case 'group':
                $users = User::where('user_type_id', $request->user_type_id)->get();
                foreach ($users as $user) {
                    //@Mail::to($user->email)->send(new CustomMail($user, $request->template_id));
                }                
                break;
            case 'some_users':
                foreach ($request->to_user_id as $user_id) {
                    $user = User::find($user_id);
                    try {
                        //@Mail::to($user->email)->send(new CustomMail($user, $request->template_id));
                    } catch (Exception $e) {
                        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
                        exit;
                    }
                }
                break;
            default:
                break;
        }        
        
        return redirect()->back();
    }
}
