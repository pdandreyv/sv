@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">

        <form action="{{route('admin.documents_cat.documents.store', $doc_category_id)}}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a>
                <h4>Добавить пользователя</h4><hr>
            </div>
            <div class="form-group">
                <label for="name">ИМЯ</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
            </div>
            @if($errors->has('name'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif

            <div class="form-group">
                <label for="name">ДОКУМЕНТ</label>
                <input name="file" type="file">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>

    </div>


@endsection

