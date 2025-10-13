<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Posts extends Model
{

    protected $fillable = ['user_id','post_title', 'post_content'];
    public $sortable = ['post_title', 'post_content', 'details', 'created_at', 'updated_at'];

    protected $table = 'users_posts';

    public function autor()
    {
        return $this->belongsTo('App\User');
    }

    static function getSinglePost($post_id)
    {
        return Posts::leftJoin('users', 'users.id', '=', 'users_posts.user_id')->select('users_posts.*','users.name', 'users.first_name', 'users.middle_name', 'users.last_name')->where('post_id', $post_id)->first();
    }

    static function getUserPosts($user_id)
    {
        return Posts::leftJoin('users', 'users.id', '=', 'users_posts.user_id')->select('users_posts.*', 'users.first_name', 'users.middle_name', 'users.last_name')->where('user_id', $user_id)->orderBy('stick_on_top', 'DESC')->orderBy('created_at', 'DESC')->paginate(10);
    }

    static function getAllPosts()
    {
        return Posts::leftJoin('users', 'users.id', '=', 'users_posts.user_id')->select('users_posts.*','users.name', 'users.first_name', 'users.middle_name', 'users.last_name')->paginate(10);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    static function postimageUpload($post_content)
    {
        $dom = new \DomDocument();
        $dom->loadHtml($post_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach($images as $k => $img){
            $data = $img->getAttribute('src');
            if (!preg_match('/data:image/', $data)) {
                continue;
            }
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name= "/images/uploads/" . time().$k.'.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }
        $post_content = $dom->saveHTML();
        return $post_content;
    }
}
