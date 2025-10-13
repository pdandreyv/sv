<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Session;
use Route;
use Auth;
use App\Posts;
use App\Subscribers;
use \DomDocument;
use Intervention\Image\ImageManagerStatic as Image;

class PostsController extends Controller

{

    public function index(View $view)
    {
        $user = Auth::user();
        if (Route::current()->parameter('id')) {
            $user_id = Route::current()->parameter('id');
        } else {
            $user_id = Auth::user()->id;
        }
        $posts = (new Posts)->getUserPosts($user_id);
        return $view->with(['posts' => $posts , 'user' => $user]);
    }

    public function create(CreatePostRequest $request)
    {
        $user_id = intval(auth()->user()->id);
        $post_title = $request['post_title'];
        $post_content = Posts::postimageUpload($request['post_content']);
        $stick_on_top = $request['stick_on_top'];
        try {
            Posts::insert(['user_id' => $user_id ,'post_title' => $post_title, 'post_content' => $post_content , 'stick_on_top' => $stick_on_top]);
            Session::flash('sucсess', 'Запись успешно добавлена');
            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('error', 'Запись не была добавлена');
            return redirect()->back();
        }
    }


    public function edit(ViewFactory $view, $post_id)
    {
        $user_id = intval(auth()->user()->id);
        $user = User::findOrFail($user_id);
        $post_item = Posts::getSinglePost($post_id);
        $post_title = DB::table('users_posts')->pluck('post_title');
        $post_content = DB::table('users_posts')->pluck('post_content');

        return view('posts/edit')->with(['post_item' => $post_item, 'user' => $user, 'post_title' => $post_title, 'post_content' => $post_content, 'post_id' => $post_id, 'user_id' => $user_id]);
    }

    public function view(ViewFactory $view, $post_id)
    {
        $post_item = Posts::getSinglePost($post_id);
        return view('posts/post')->with(['post_item' => $post_item]);
    }

    public function update(UpdatePostRequest $request, $post_id)
    {
        $user_id = intval(auth()->user()->id);
        $author_id = intval($request['author_id']);
        $post_title = $request['post_title'];
        $post_content = $request['post_content'];
        $stick_on_top = ($request['stick_on_top'] == 'on') ? 1 : 0;
        if ( isset($user_id) ) {
            Posts::where('post_id', $post_id) ->update(['post_title' => $post_title, 'post_content' => $post_content,'stick_on_top' => $stick_on_top]);
            Session::flash('sucсess', 'Запись успешно обновлена');
        } else {
            Session::flash('error', 'У Вас нет прав на редактирование этой записи');
        }
        return redirect()->route('profile.my-page', ['id' => Auth::user()->id]);
    }

    public function delete(Request $request, $post_id)
    {
        $user_id = intval(auth()->user()->id);
        $user = User::findOrFail($user_id);
        $author_id = intval($request['author_id']);
        $post_item = Posts::getSinglePost($post_id);
        $post_title = DB::table('users_posts')->pluck('post_title');
        $post_content = DB::table('users_posts')->pluck('post_content');
        $user_id = DB::table('users_posts')->pluck('user_id');
        DB::table('users_posts')->where('post_id', intval($post_id))->delete();
        if ( $user_id->count()) {
            Session::flash('sucсess', 'Запись была удалена');
            return view('profile/my-page')->with(['user' => $user, 'post_item' => $post_item, 'post_title' => $post_title, 'post_content' => $post_content, 'post_id' => $post_id, 'user_id' => $user_id, 'author_id' => $author_id]);
        } else {
            Session::flash('error', 'Запись была удалена');
            return view('profile/my-page')->with(['user' => $user, 'post_item' => $post_item, 'post_title' => $post_title, 'post_content' => $post_content, 'post_id' => $post_id, 'user_id' => $user_id, 'author_id' => $author_id]);
        }
    }

    public function news(){
         $usersIdsArr = Subscribers::where('subscriber_id', Auth::user()->id)->pluck('id')->toArray();
         $adminsIdsArr = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->pluck('id')->toArray();
         
         $targetUsersIds = array_merge($adminsIdsArr, $usersIdsArr);
         $posts = Posts::whereIn('user_id', $targetUsersIds)->orderBy('created_at')->limit(10)->get();
         $data = [
             'posts' => $posts,
             'menu_item' => 'news',
         ];
         return view('posts/news', $data);
    }

    public function newsAjax(Request $request){
         $usersIdsArr = Subscribers::where('subscriber_id', Auth::user()->id)->pluck('id')->toArray();
         $adminsIdsArr = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->pluck('id')->toArray();
         $targetUsersIds = array_merge($adminsIdsArr, $usersIdsArr);
         $posts = Posts::whereIn('user_id', $targetUsersIds)->orderBy('created_at')->offset($request->offset)->limit(10)->get();
         $data = [
             'posts' => $posts,
         ];
         return view('posts/ajax-items', $data);
    }

}