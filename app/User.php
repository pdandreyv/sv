<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use App\ChatNotificationSettings;
use App\ChatMember;
use App\ChatMessage;
use App\ChatMessageReading;
use App\Mail\ShedulerMessageMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Subscribers;
use App\UserType;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'email_view', 
        'password', 
        'first_name',
        'middle_name',
        'last_name', 
        'birth_date', 
        'birth_date_view', 
        'gender',
        'registration_address',
        'accomodation_address',
        'phone_number', 
        'phone_number_view', 
        'photo',
        'user_type_id',
        'passport_series',
        'passport_number',
        'passport_give',
        'passport_give_date',
        'identification_code',
        'city', 
        'city_view', 
        'alias',
        'referrer_id',
        'token',
        'verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];    

    public function roles()
    {
        return $this->belongsToMany('App\UserRole', 'users__roles',  'user_id', 'role_id');
    }

    public function type()
    {
        return $this->belongsTo('App\UserType', 'user_type_id');
    }
    
    public function getRolesDisplay()
    {
        $rolesList = $this->belongsToMany('App\UserRole', 'users__roles',  'user_id', 'role_id')->get()->pluck('name')->toArray();
        return implode(', ', $rolesList);        
    }

    public function appliedFinanceOperation()
    {
        return $this->hasMany('App\FinanceOperations\AppliedFinanceOperation');
    }

    public function balance()
    {
        return $this->hasOne('App\UserBalance');
    }

    public function getBalanceDisplay()
    {
        $balance = $this->balance()->first();
        return ($balance)?(number_format($balance->sum,2,","," ")):'0,00';
    }
    
    public function getBirthDay()
    {
        $dateArr = explode('-', $this->birth_date);
        if(empty($this->birth_date)) return false;
        return $dateArr[2];
    }

    public function getBirthMonth()
    {
        $dateArr = explode('-', $this->birth_date);
        if(empty($this->birth_date)) return false;
        return $dateArr[1];
    }

    public function getBirthYear()
    {
        $dateArr = explode('-', $this->birth_date);
        if(empty($this->birth_date)) return false;
        return $dateArr[0];
    }

    public function scans()
    {
        return $this->hasMany('App\UserScan');
    }

    public function shippingAddresses()
    {
        return $this->hasMany('App\ShippingAddress');
    }

    public function getLink()
    {
        return ($this->alias)?$this->alias:$this->id;
    }


    public function sendPasswordResetNotification($token)
    {       
        //@Mail::to($this->email)->send(new ResetPasswordMail($this, $token)); 
    }


    
    public function fullName() {

        User::select(DB::raw("CONCAT('last_name','first_name','middle_name') AS name"))->get();
//        if(!empty(trim($this->last_name.' '.$this->first_name.' '.$this->middle_name))){
//            return $this->last_name.' '.$this->first_name.' '.$this->middle_name;
//        } else {
//            return $this->name;
//        }
    }

    public static function ChatMessagesSheduleNotify($frequency){        

        $startDateObj = new \DateTime('-1 days');
        $startDateStr = $startDateObj->format('Y-m-d H:i:s');
        
        $endDateObj = new \DateTime();
        $endDateStr = $endDateObj->format('Y-m-d H:i:s');

        $privateSettingsIds = ChatNotificationSettings::where('chat_type', 'private')
            ->where('frequency', $frequency)
            ->pluck('user_id')->toArray();

        $groupSettingsIds = ChatNotificationSettings::where('chat_type', 'group')
            ->where('frequency', $frequency)
            ->pluck('user_id')->toArray();

        $allUsersIds = array_merge($privateSettingsIds, $groupSettingsIds);
        $allUsersIds = array_unique($allUsersIds);
        foreach ($allUsersIds as $userId) {
            $userChats = ChatMember::where('user_id', $userId)->get();
            $privateCount = 0;
            $groupCount = 0;

            foreach ($userChats as $userChat) {
                $chatMembersCount = ChatMember::where('chat_id', $userChat->chat_id)->count();
                if($chatMembersCount > 2) {
                    $chatType = 'group';
                } else {
                    $chatType = 'private';
                }

                if(!(($chatType == 'group' && in_array($userId, $groupSettingsIds))
                    || ($chatType == 'private' && in_array($userId, $privateSettingsIds)))){
                    continue;
                }

                $messagesColl = ChatMessage::where('chat_id', $userChat->chat_id)
                ->where('user_id', '!=', $userId)
                ->where(function($query) use ($startDateStr, $endDateStr) {
                    $query->where('created_at', '>', $startDateStr);
                    $query->orWhere('created_at', '<', $endDateStr);
                });
               
                $messagesCount = $messagesColl->count();
                $messagesIds = $messagesColl->pluck('id');

                $readedMessagesCount = ChatMessageReading::whereIn('message_id', $messagesIds)
                ->where('user_id', $userId)->count();

                $notReadedCount = $messagesCount - $readedMessagesCount;
                if($chatType == 'group'){
                    $groupCount+=$notReadedCount;
                } else {
                    $privateCount+=$notReadedCount;
                }
            }

            $user = self::find($userId);

            if($privateCount){
                //@Mail::to($user->email)->send(new ShedulerMessageMail($user, $privateCount, true));
            }
            
            if($groupCount){
                //@Mail::to($user->email)->send(new ShedulerMessageMail($user, $groupCount, false));
            }

        }
    }
    
    public function isSubscribe($subscrber_id){
        $subscribe = (Subscribers::where('user_id', $this->id)
                ->where('subscriber_id', $subscrber_id)->first())?true:false;
        return $subscribe;
    }
    
    public function invitor()
    {
        return $this->belongsTo('App\User', 'referrer_id');
    }
    
    public function isAdmin(){
        if(auth()->user()){
            $hasAdmin = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->where('id', auth()->user()->id)->get();                
            if(count($hasAdmin))
            {
            return true;
            }
        }
        return false;
    }
    
    public static function isMember(){
        if(auth()->user()){
            $hasMember = User::whereHas('roles', function ($query) {
                $query->where('name', 'member')
                     ->orWhere('name', 'admin');
            })->where('id', auth()->user()->id)->get();                
            if(count($hasMember))
            {
                return true;
            }
        }
        return false;
    }
    public static function getMembers(){
        return self::whereHas('roles', function ($query) {
            $query->where('name', 'member');
        })->get();
    }
    public static function isCooperationRequest(){
        if(auth()->user()){
            $isCooperationRequest = self::where('user_type_id',UserType::where('code', 'сooperation_request')->pluck('id')->first())
                ->where('id', auth()->user()->id)
                ->get();
            if(count($isCooperationRequest)){
                return true;
            }
        }
        return false;
    }
}
