@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Список документов</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.documents_cat.index') }}" class="btn btn-info btn-add"><i class="fas fa-arrow-left"></i>Назад</a>
            <a href="{{ route('admin.documents_cat.documents.create', $doc_category_id) }}" class="btn btn-info btn-add">Добавить Документ</a>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>Имя</th>
                <th>Файл</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($documents as $document)
                <tr class="client_info">
                    <td>
                        <span>{{$document->name}}</span>
                    </td>
                    <td>
                        <a download="" href="http://{{$_SERVER['SERVER_NAME']}}/storage/images/documents/{{$document->file}}"><span>{{$document->file}}</span></a>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.documents_cat.documents.edit', ['id' => $document->id]) }}" class="btn btn-info btn-sm">
                            <span><i class="fas fa-edit"></i></span>
                        </a>
                        <a href="{{ route('admin.documents_cat.documents.delete', ['id' => $document->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить файл?'); if(!result) return false;">
                            <span><i class="fas fa-trash-alt"></i></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{--{{$documents->links()}}--}}

    </div>

@endsection