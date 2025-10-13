@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9 post-item edit">
        @if (Session::has('success'))
            <div class="form-group alert alert-success">
                <span>{{ Session::get('success') }}</span>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="form-group alert alert-danger">
                <span>{{ Session::get('error') }}</span>
            </div>
        @endif
        <div class="form-group">
            <h4>Редактирование записи</h4>
        </div>
        @include('parts.summernote', ['post_title' => $post_item->post_title, 'post_content' => $post_item->post_content, 'post_id' => $post_item->post_id, 'stick_on_top' => ($post_item->stick_on_top ?? 0), 'author_id' => $post_item->user_id, 'title_label' => 'Заголовок записи','content_label' => 'Содержимое записи', 'approved' => ($post_item->approved ?? 0)])
    </div>
@endsection