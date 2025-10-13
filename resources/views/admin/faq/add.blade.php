@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')
    <div class="col-md-9 admin-table">
        <div class="title">
            <h3>Новый вопрос</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.faq') }}" class="btn btn-default btn-back">Отмена</a>
        </div>
        <hr />
        <div class="col-md-12 post-item edit">
            <div class="form-group">
                <h4>Добавить новый вопрос</h4>
            </div>
            @include('parts.summernote_1', ['title_label' => 'Вопрос', 'content_label' => 'Ответ'])
        </div>
    </div>
@endsection