<?php

namespace App\Http\Controllers\admin;
use App\UserRole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\DocumentCategory;
use Illuminate\Support\Facades\Validator;


class DocumentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'menu_item' => 'documents_cat',
            'documents_cat' => DocumentCategory::paginate(20),
            'roles' => UserRole::All(),

        ];
        return view('admin.documents_cat.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [
            'menu_item' => 'documents_cat',
            'roles' => UserRole::All(),
        ];
        return view('admin.documents_cat.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $dataCat = $this->validate($request,[
                'code' => 'regex:/(^([a-zA-Z0-9_]+)?$)/u',
                'name' => 'required'
            ]);

        $category = DocumentCategory::create($dataCat);

        if (!empty($request->role)) {
            foreach ($request->role as $role_id) {
                DB::table('doc_access')
                    ->insert([
                        'doc_category_id' => $category->id,
                        'role_id' => $role_id,
                    ]);
            }
        } else {

            $role = UserRole::where('name', 'member')->first();

            DB::table('doc_access')
                ->insert([
                    'doc_category_id' => $category->id,
                    'role_id' => $role->id,
                ]);
        }
        return redirect()
            ->route('admin.documents_cat.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


//    public function documents($id) {
//
//    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documents_cat = DocumentCategory::findOrFail($id);
        $data = [
            'menu_item' => 'documents_cat',
            'documents_cat' => $documents_cat,
            'roles' => UserRole::All(),
            'name' => $documents_cat->name,
        ];

        return view('admin.documents_cat.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = DocumentCategory::findOrFail($id);
        $category->update([
            'name' => $request['name'],
        ]);

        /* roles start */
        $rolesOld = $category->roles()->get()->pluck('id')->toArray();

        if (isset($request->role) && count($request->role)) {
            $rolesToAdd = array_diff($request->role, $rolesOld);

            foreach($rolesToAdd as $one) {
                DB::table('doc_access')->insert([
                    ['doc_category_id' => $category->id, 'role_id' => $one],
                ]);
            }

            $rolesToDelete = array_diff($rolesOld, $request->role);
        }
        else {
            $rolesToDelete = $rolesOld;
        }

        foreach($rolesToDelete as $one) {
            DB::table('doc_access')
                ->where(['doc_category_id' => $category->id, 'role_id' => $one])
                ->delete();
        }
        return redirect()
            ->route('admin.documents_cat.index');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $category = DocumentCategory::find($id);

        DB::table('doc_access')
            ->where(['doc_category_id' => $category->id])
            ->delete();
        DB::table('doc_document')
            ->where(['doc_category_id' => $category->id])
            ->delete();

        $category->delete();

        return back();
    }
}
