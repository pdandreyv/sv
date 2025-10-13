<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\ContactFormPost;
use Illuminate\Support\Facades\Validator;
use Response;
use App\User;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class ModalController extends Controller
{    
    
    public function contactFormPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required_without:phone',
            'phone' => 'required_without:email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $input = $request->all();

        if ($validator->passes()) {

            // Store your user in database 
            $admins = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->get();

            $contactFormData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'filePath' => ''
            ];

            if ($request->file) {
                $file = $request->file;
                $ext = $file->getClientOriginalExtension();
                $new_name = uniqid() . '.' . $ext;
                $file->move(public_path('images/contact-form-media'), $new_name);
                $contactFormData['filePath'] = "images/contact-form-media/$new_name";
            }

            foreach ($admins as $admin) {
                //@Mail::to($admin->email)->send(new ContactFormMail($contactFormData));
            }

            return Response::json(['success' => '1']);

        }

        return Response::json(['errors' => $validator->errors()]);
    }

    public function contactForm(){
        return view('modal.contact-form');
    }
}
