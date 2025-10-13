<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\User;
use App\Resources;
use App\ProductCategory;
use App\ResourcesUsers;
use Auth;
use Illuminate\Http\Request;

class ResourcesUsersController extends Controller
{

    public function index(Request $request)
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->orderBy('title', 'asc')
            ->with('children')
            ->with('resources')
            ->where('for_service', 0)
            ->get();

        $user_id = $request->user_id;
        $user_resources = ResourcesUsers::where('user_id', $user_id)->get();

        $resources_checked = [];
        foreach ($user_resources as $user_resource) {
            $resources_checked[$user_resource->category_id][$user_resource->resource_id] = $user_resource->volume;
        }
        $data = [
            'menu_item' => 'resources',
            'resources' => Resources::with('category'),
            'categories' => $categories,
            'resources_checked' => $resources_checked,
            'users' => User::get(),
            'selected_user_id' => $user_id
        ];
        return view('admin.resources-user.index', $data);

    }

    public function save(Request $request)
    {
        $checked = $request->checked;
        $resource_id = $request->resource_id;
        $category_id = $request->category_id;
        $user_id = $request->user_id;
        $volume = (float)str_replace(',', '.',$request->volume);
        $recordFindCount = ResourcesUsers::
            where('user_id',$user_id)
            ->where('resource_id',$resource_id)
            ->get()
            ->count();
        $data = [
            'resource_id' => $resource_id,
            'category_id' => $category_id,
            'user_id' => $user_id,
            'volume' => $volume
        ];
        if ( $recordFindCount > 0 ):
            if ($checked == 'true'):
                ResourcesUsers::
                  where('user_id',$user_id)
                  ->where('resource_id',$resource_id)
                  ->update(['volume' => $volume]);
                $message = 'Created/Updated';
            elseif ( $checked == 'false' ):
                ResourcesUsers::
                    where('user_id',$user_id)
                    ->where('resource_id',$resource_id)
                    ->delete();
                $message = 'Deleted';
            endif;
        else:
            if ( $checked == 'true' ):
                if( $volume == 0 ):
                    $data['volume'] = 1;
                endif;
                ResourcesUsers::create($data);
                $message = 'Created/Updated';
            elseif ( $checked == 'false' ):
                ResourcesUsers::
                    where('user_id',$user_id)
                    ->where('resource_id',$resource_id)
                    ->delete();
                $message = 'Deleted';
            endif;
        endif;
    }
}
