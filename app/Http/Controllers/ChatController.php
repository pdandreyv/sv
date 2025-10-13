<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreChatMessageRequest;
use App\User;
use App\Message;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Chat;
use App\ChatMember;
use App\ChatMessage;
use App\ChatMessageReading;
use App\ChatNotificationSettings;
use App\Mail\PrivateMessageMail;
use App\Mail\GroupMessageMail;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{	
    
    public function index(){              
        $chats = DB::select(
                'SELECT mes.chat_id, 
                mem.id as chat_member_id,
                max(mes.created_at) as last_message_date, 
                max(ISNULL(chr.user_id)) as not_all_message_read
                FROM chat__members as mem                
                JOIN chat__messages as mes ON mes.chat_id = mem.chat_id
                LEFT JOIN chat__messages_reading as chr ON mes.id = chr.message_id AND mem.user_id = chr.user_id
                WHERE mem.user_id = '.intval(auth()->user()->id).'
                GROUP BY mes.chat_id, mem.id
                ORDER BY max(mes.created_at) DESC'); 
                                   

        foreach ($chats as $chat) {
            $chatMember = ChatMember::find($chat->chat_member_id);

            $chat->chat_display_name = $chatMember->getChatDisplayName();

            $chat->chat_display_photo = $chatMember->getDisplayPhoto();
        }        

        $data = [
            'menu_item' => 'chat',   
            'chats' => $chats
        ];
        return view('chat/index', $data);
    }
    
    public function newMessage($user_to_id = null, Request $request){
        
        $data = [
            'menu_item' => 'chat',            
        ];
        
        if($user_to_id != null){
            $userTo = User::findOrFail($user_to_id);
            $data['userTo'] = $userTo;
        }
        
        return view('chat/new', $data);
    }
    
    public function storeMessage(StoreChatMessageRequest $request){                        

        $chat = Chat::create([
            'title' => ($request->chat_title)?$request->chat_title:''
        ]);

        ChatMember::create([   
            'chat_id' => $chat->id,         
            'user_id' => Auth::user()->id
        ]);

        foreach ($request->to_user_id as $user_to_id) {

            if (is_null($user_to_id)) {
                return redirect()
                    ->route('chat.message')
                    ->withErrors(['to_user_id' => 'Пользователя не существует']);
            }

            $chatMember = ChatMember::where('chat_id', $chat->id)
                ->where('user_id', $user_to_id)->first();
            if(!$chatMember){
                ChatMember::create([
                    'chat_id' => $chat->id,
                    'user_id' => $user_to_id
                ]);
            }                
        }        

        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'text' => $request->text,
            'user_id' => Auth::user()->id
        ]);

        ChatMessageReading::create([
            'message_id' => $message->id,
            'user_id' => Auth::user()->id 
        ]);
         
        if(count($request->to_user_id)>1){
            $chatType = 'group';
        } else {
            $chatType = 'private';
        }

        $everySettingsIds = ChatNotificationSettings::whereIn('user_id', $request->to_user_id)
            ->where('chat_type', $chatType)
            ->where('frequency', 'every')
            ->pluck('user_id');        

        foreach ($everySettingsIds as $userId) {
            $user = User::findOrFail($userId);
            if($chatType == 'private'){
                //@Mail::to($user->email)->send(new PrivateMessageMail($user, Auth::user(), $message));
            } else {
                $chatMember = ChatMember::where('user_id', $userId)
                ->where('chat_id', $chat->id)->first();
                //@Mail::to($user->email)->send(new GroupMessageMail($user, Auth::user(), $message, $chatMember, true));
            }
            
        }

        return redirect()
            ->route('chat.chats.list');
    }

    public function storeAnswerMessage(StoreChatMessageRequest $request){                                
        $message = ChatMessage::create([
            'chat_id' => $request->chat_id,
            'text' => $request->text,
            'user_id' => Auth::user()->id
        ]);

        ChatMessageReading::create([
            'message_id' => $message->id,
            'user_id' => Auth::user()->id 
        ]);
        
        $members = ChatMember::where('chat_id', $request->chat_id)->pluck('user_id');        
        if(count($members) > 2) {
            $chatType = 'group';
        } else {
            $chatType = 'private';
        }

        $everySettingsIds = ChatNotificationSettings::whereIn('user_id', $members)
            ->whereNotIn('user_id', [Auth::user()->id])
            ->where('chat_type', $chatType)
            ->where('frequency', 'every')
            ->pluck('user_id');                

        foreach ($everySettingsIds as $userId) {
            $user = User::findOrFail($userId);
            if($chatType == 'private'){
                //@Mail::to($user->email)->send(new PrivateMessageMail($user, Auth::user(), $message));
            } else {
                $chatMember = ChatMember::where('user_id', $userId)
                ->where('chat_id', $request->chat_id)->first();
                //@Mail::to($user->email)->send(new GroupMessageMail($user, Auth::user(), $message, $chatMember, false));
            }
            
        }

        return redirect()
            ->route('chat.dialog', ['id' => $request->chat_id]);
    }
    
    public function showDialog($id, Request $request){
        $chatMessages = ChatMessage::where('chat_id', $id)->get();
        foreach ($chatMessages as $chatMessage) {
            $chatMessageReading = ChatMessageReading::where('user_id', Auth::user()->id)
            ->where('message_id', $chatMessage->id)->first();
            if(!$chatMessageReading){
                ChatMessageReading::create([
                    'message_id' => $chatMessage->id,
                    'user_id' => Auth::user()->id 
                ]);
            }
        }
        
        $chatMember = ChatMember::where('chat_id', $id)
        ->where('user_id', Auth::user()->id)->first();        

        $mesCount = DB::table('chat__members as mem')
        ->join('chat__messages as mes', 'mes.chat_id', '=', 'mem.chat_id')
        ->leftJoin('chat__messages_reading as chr', [['chr.message_id', '=', 'mes.id'], ['chr.user_id', '=',  'mem.user_id']])
        ->where('mem.user_id', auth()->user()->id)
        ->whereNull('chr.message_id')
        ->count();       
        $request->attributes->add(['mesCount' => $mesCount]);
        
        $dialog = ChatMessage::where('chat_id', $id)            
            ->orderBy('created_at')
            ->get();

        $members = ChatMember::where('chat_id', $id)->get();

        $data = [            
            'dialog' => $dialog,
            'chatName' => $chatMember->getChatDisplayName(),
            'chatId' => $id,
            'members' => $members
        ];

        return view('chat/dialog', $data);
    }

    public function addMembers(Request $request){
        foreach ($request->to_user_id as $user_to_id) {
            if($user_to_id){
                $chatMember = ChatMember::where('chat_id', $request->chat_id)
                ->where('user_id', $user_to_id)->first();
                if(!$chatMember){
                    ChatMember::create([
                        'chat_id' => $request->chat_id,
                        'user_id' => $user_to_id
                    ]);
                }                
            }            
        }

        return redirect()
            ->route('chat.dialog', ['id' => $request->chat_id]);
    }

    public function changeName(Request $request){
        $chat = Chat::find($request->chat_id);
        $chat->update([
            'title' => $request->name
        ]);

        return json_encode(['state' => 'success']);
    }

    public function updateMessage($id){
        $message = ChatMessage::findOrFail($id);        
        $data = [
            'menu_item' => 'chat', 
            'message' => $message
        ];                
        
        return view('chat/message-edit', $data);
    }

    public function updateMessagePost($id, StoreChatMessageRequest $request){
        $message = ChatMessage::findOrFail($id);        
        $messageDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at);
        $mesTime = $messageDateTime->getTimestamp();
        $curTime = time();                    
        $diff = $curTime - $mesTime;        
        if($diff>600){            
            return view('chat/message-no-edit', [
                'menu_item' => 'chat',             
            ]);
        }
        $mesData = [            
            'text' => $request->text,
        ];

        $message->update($mesData);
        
        return redirect()
            ->route('chat.dialog', ['id' => $message->chat_id]);
    }

    public function deleteMessage($id){
        $message = ChatMessage::findOrFail($id);
        $messageDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at);
        $mesTime = $messageDateTime->getTimestamp();
        $curTime = time();                    
        $diff = $curTime - $mesTime;        
        if($diff>600){
            return view('chat/message-no-edit', [
                'menu_item' => 'chat',             
            ]);
        }
                      
        $message->delete();

        return back();
    }

    public function settings(){
        $privateSettings = ChatNotificationSettings::where('user_id', Auth::user()->id)
            ->where('chat_type', 'private')->first();

        $groupSettings = ChatNotificationSettings::where('user_id', Auth::user()->id)
            ->where('chat_type', 'group')->first();

        $data = [
            'private' => $privateSettings, 
            'group' => $groupSettings,
            'menu_item' => 'settings'
        ]; 

        return view('chat/settings', $data);
    }

    public function storeSettings(Request $request){
        $privateSettings = ChatNotificationSettings::where('user_id', Auth::user()->id)
            ->where('chat_type', 'private')->first();

        if($privateSettings){
            $privateSettings->update([
                'frequency' => $request->private_frequency
            ]);
        } else {
            ChatNotificationSettings::create([
                'user_id' => Auth::user()->id,
                'chat_type' => 'private',
                'frequency' => $request->private_frequency
            ]);
        }

        $groupSettings = ChatNotificationSettings::where('user_id', Auth::user()->id)
            ->where('chat_type', 'group')->first();

        if($groupSettings){
            $groupSettings->update([
                'frequency' => $request->group_frequency
            ]);
        } else {
            ChatNotificationSettings::create([
                'user_id' => Auth::user()->id,
                'chat_type' => 'group',
                'frequency' => $request->group_frequency
            ]);
        }

        return redirect()
            ->route('chat.settings');
    }
}

