@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9 post-item edit">
        <div class="form-group">
            <h3>Редактирование вопроса</h3>
        </div>
        @if (session()->has('sucсess'))
            <hr />
            <div class="form-group alert alert-success">
                <span>{{session()->pull("sucсess")}}</span>
            </div>
        @endif
        @if (session()->has('erorr'))
            <hr />
            <div class="form-group alert alert-erorr">
                <span>{{session()->pull("erorr")}}</span>
            </div>
        @endif
        @include('parts.summernote_1', ['title' => $title, 'content' => $content, 'title_label' => 'Вопрос', 'content_label' => 'Ответ', 'id' => $id, 'order' => $order, 'active' => $active])
    </div>
@endsection