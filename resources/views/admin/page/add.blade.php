@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')
    <div class="col-md-9 admin-table">
        <div class="title">
            <h3>Новая страница</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.page') }}" class="btn btn-default btn-back">Отмена</a>
        </div>
        <hr />
        <div class="col-md-12 post-item edit">
            <div class="form-group">
                <h4>Добавить новую страницу</h4>
            </div>
            @include('parts.summernote_2', [             'title_label' => 'Заголовок',
             'content_label' => 'Текст',])
        </div>
    </div>
@endsection
