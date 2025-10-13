<?php

namespace DocumentCategoryController\Http\Controllers\admin;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use App\DocumentCategory;
use App\Document;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        $data = [
//            'documents' => DocumentCategory::paginate(20),
//        ];
//        return view('admin.documents_cat.documents.index', $data);
//    }

    public function documents($id)

    {
        $doc_category_id = DocumentCategory::findOrFail($id);
        $data = [
            'documents' => Document::where("doc_category_id", $id)->get(),
            'doc_category_id' => $doc_category_id,
        ];
        return view('admin.documents_cat.documents.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $doc_category_id = DocumentCategory::findOrFail($id);
        $data = [
            'name' => '',
            'doc_category_id' => $id,

        ];
        return view('admin.documents_cat.documents.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $doc_category_id = DocumentCategory::findOrFail($id);
        $doc_category_id1 = new Document;
        $documentData = [
            'name' => $request->name,
            'doc_category_id'=> $id,
            ];
//        $documents_cat = $request->doc_category_id;
        if ($request->file) {
            $file = $request->file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('storage/images/documents'), $new_name);
            $documentData['file'] = $new_name;
        }
        $doc_category_id1->create($documentData);

        return redirect()
            ->route('admin.documents_cat.documents.index', $doc_category_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documents = Document::findOrFail($id);

        $data = [
            'name' => $documents->name,
            'doc_category_id' => $documents->doc_category_id,
            'documents' => $documents
            ];
        return view('admin.documents_cat.documents.edit', $data);
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
        $documents = Document::findOrFail($id);
        $doc_category_id = $documents->doc_category_id;

        $documentData = [
            'name' => $request->name,
        ];
        //IMAGE
        if ($request->file) {
            $file = $request->file;
            $ext = $file->getClientOriginalExtension();
            $new_name = uniqid() . '.' . $ext;
            $file->move(public_path('storage/images/documents'), $new_name);
            $documentData['file'] = $new_name;
        }
        $documents->update($documentData);
        return redirect()
            ->route('admin.documents_cat.documents.index',$doc_category_id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $document = Document::find($id);
//        $d = new Filesystem;
//        $d->delete(public_path('storage/images/documents'.$document->photo));
        $filename = public_path().'/storage/images/documents/'.$document->file;

        if (File::exists($filename)) {
            File::delete($filename);
        };
        $document->delete();

        return back();
    }
}
