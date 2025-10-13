@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Редактирование файла</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.documents_cat.documents.index', $doc_category_id) }}" class="btn btn-info btn-add">Назад</a>
        </div>
        <hr />
        <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{route('admin.documents_cat.documents.update', $documents->id)}}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" name="name" class="form-control" value="{{$documents->name}}" >
            </div>
            @if($errors->has('name'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
            <div class="form-group">
                <label for="name">ФОТО</label>
                <input name="file" type="file" value="{{$documents->file}}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </div>
        </form>


        <hr />
    </div>
@endsection