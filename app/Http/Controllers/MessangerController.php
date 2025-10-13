<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageRequest;
use App\User;
use App\Message;
use Illuminate\Support\Facades\Auth;
use DB;

class MessangerController extends Controller
{	
    
    public function chats(){              
        $chats = DB::select(
                'SELECT (CASE
                    WHEN from_user_id = '.intval(auth()->user()->id).' THEN to_user_id                    
                    ELSE from_user_id
                END) as contact_id, 
                max(created_at) as last_message_date, 
                min((CASE
                    WHEN from_user_id = '.intval(auth()->user()->id).' THEN 1                    
                    ELSE is_readed
                END)) as all_message_read
                FROM users__messages
                WHERE from_user_id = '.intval(auth()->user()->id).' OR to_user_id = '.intval(auth()->user()->id).'
                GROUP BY (CASE
                    WHEN from_user_id = '.intval(auth()->user()->id).' THEN to_user_id                    
                    ELSE from_user_id
                END)
                ORDER BY max(created_at) DESC');                
        $data = [
            'menu_item' => 'messanger',   
            'chats' => $chats
        ];
        return view('messanger/chats', $data);
    }
    
    public function newMessage($user_to_id = null, Request $request){
        
        $data = [
            'menu_item' => 'messanger',            
        ];
        
        if($user_to_id != null){
            $userTo = User::findOrFail($user_to_id);
            $data['userTo'] = $userTo;
        }                
        
        return view('messanger/new', $data);
    }
    
    public function usersDropDown($userName){        
        $users = User::where('name', 'like', $userName.'%')
            ->orWhere('first_name', 'like', $userName.'%')
            ->orWhere('last_name', 'like', $userName.'%')
            ->select('id', 'name', 'first_name', 'last_name', 'middle_name', 'photo')
            ->get()
            ->toArray();    
        return json_encode($users);
    }

    public function usersFind($userName){        
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
    
    public function storeMessage(StoreMessageRequest $request){
        
        $data = [
            'to_user_id' => $request->to_user_id, 
            'from_user_id' => Auth::user()->id, 
            'message_text' => $request->message_text,                        
        ];
        Message::create($data);         
        return redirect()
            ->route('messanger.dialog', ['id' => $request->to_user_id]);
    }
    
    public function showDialog($id, Request $request){
        Message::where('to_user_id', Auth::user()->id)
        ->where('from_user_id', $id)
        ->update([
            'is_readed' => 1
        ]);
        
        $mesCount = DB::table('users__messages')
                ->where([
                    ['to_user_id', '=', auth()->user()->id],
                    ['is_readed', '=', 0],
                ])
                ->select('from_user_id')
                ->distinct()
                ->get();       
        $request->attributes->add(['mesCount' => count($mesCount)]);
        
        $dialog = Message::whereRaw('(to_user_id = ? AND from_user_id = ?) 
            OR (to_user_id = ? AND from_user_id = ?)', 
            [Auth::user()->id, $id, $id, Auth::user()->id])
            ->orderBy('created_at')
            ->get();
        $data = [
            'contact' => User::findOrFail($id),
            'dialog' => $dialog,
        ];
        return view('messanger/dialog', $data);
    }
    
    public function update($id){
        $message = Message::findOrFail($id);
        $data = [
            'menu_item' => 'messanger', 
            'message' => $message
        ];                
        
        return view('messanger/edit', $data);
    }
    
    public function updatePost($id, StoreMessageRequest $request){
        $message = Message::findOrFail($id);
        $messageDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at);
        $mesTime = $messageDateTime->getTimestamp();
        $curTime = time();                    
        $diff = $curTime - $mesTime;        
        if($diff>1200){
            return view('messanger/no-edit', [
                'menu_item' => 'messanger',             
            ]);
        }
        $mesData = [
            'to_user_id' => $request->to_user_id,  
            'message_text' => $request->message_text,
        ];

        $message->update($mesData);
        
        return redirect()
            ->route('messanger.dialog', ['id' => $request->to_user_id]);
    }
    
    public function delete($id){
        $message = Message::findOrFail($id);
        $messageDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at);
        $mesTime = $messageDateTime->getTimestamp();
        $curTime = time();                    
        $diff = $curTime - $mesTime;        
        if($diff>1200){
            return view('messanger/no-edit', [
                'menu_item' => 'messanger',             
            ]);
        }
                      
        $message->delete();

        return back();
    }
}

