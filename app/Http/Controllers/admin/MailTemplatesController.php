<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MailTemplate;
use Auth;
use App\Http\Requests\Admin\StoreMailTemplateRequest;

class MailTemplatesController extends Controller
{	

    public function index()
    {           
        $data = [            
            'menu_item' => 'mail_templates',
            'mailTemplates' => MailTemplate::paginate(20),            
        ];
        return view('admin.mail_templates.index', $data);
    }

    public function create(Request $request)
    {     
        $data = [
            'menu_item' => 'mail_templates',            
        ];
        return view('admin.mail_templates.add', $data);
    }

    public function store(StoreMailTemplateRequest $request)
    {                 
        $templateData = [
          'subject' => $request->subject,
          'body' => $request->body,
          'alias' => $request->alias
        ]; 

        $template = MailTemplate::create($templateData);
        
        return redirect()
            ->route('admin.mail-templates');
    }
    
    public function updateItem($id)
    {        
        $template = MailTemplate::findOrFail($id);

        $data = [
            'template' => $template,
            'menu_item' => 'mail_templates'            
        ];

        return view('admin.mail_templates.edit', $data);
    }

    public function updateItemPost($id, StoreMailTemplateRequest $request)
    {                   
        $template = MailTemplate::findOrFail($id);        

        $templateData = [
          'subject' => $request->subject,
          'body' => $request->body
        ];

        if(!$template->is_standart){
            $templateData['alias'] = $request->alias;
        }

        $template->update($templateData);
                       
        return redirect()
            ->route('admin.mail-templates');
    }



    public function delete($id)
    {
        $template = MailTemplate::find($id);        
        $template->delete();

        return back();
    }
}
