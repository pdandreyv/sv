<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts;
use Auth;
use App\Http\Requests\UpdatePostRequest;
use File;
use Illuminate\Support\Facades\DB;
use Session;
use \DomDocument;
use Intervention\Image\ImageManagerStatic as Image;

class PostsController extends Controller
{   

    public function index()
    {   
        $data = [
            'menu_item' => 'posts',
            'posts' => Posts::getAllPosts(),
        ];
        return view('admin.posts.index', $data);
    }

    public function edit($post_id)
    {
        $post_item = DB::table('users_posts')->where('post_id', '=', intval($post_id))->first();

        return view('admin.posts.edit')->with(['post_item' => $post_item]);
    }

    public function update(UpdatePostRequest $request, $post_id)
    {
        $post_title = $request['post_title'];
        $post_content = Posts::postimageUpload($request['post_content']);
        $stick_on_top = $request['stick_on_top'];
        $approved = $request['approved'];
        Posts::where('post_id', $post_id)
            ->update(['post_title' => $post_title, 'post_content' => $post_content,'stick_on_top' => $stick_on_top, 'approved' => $approved]);
        Session::flash('sucсess', 'Запись успешно обновлена');
        return redirect()->route('admin.posts');
    }

    public function delete(Request $request, $post_id)
    {
        try {
            DB::table('users_posts')->where('post_id', '=', intval($post_id))->delete();
            Session::flash('sucсess', 'Запись удалена успешно');
            return redirect('admin/posts');
        } catch (Exception $e) {
            Session::flash('error', 'Не удалось удалить запись');
            return redirect()->back();
        }
    }
}