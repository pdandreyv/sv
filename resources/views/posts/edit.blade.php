@extends('layouts.app')

@section('content')

    @include('parts.sidebar')
    <div class="col-md-9 post-item edit">
        @if (session()->has('sucсess'))
            <hr />
            <div class="form-group alert alert-success">
                <span>{{session()->pull("sucсess")}}</span>
            </div>
        @endif
        @if (session()->has('erorr'))
            <hr />
            <div class="form-group alert alert-erorr">
                <span>{{session()->pull("error")}}</span>
            </div>
        @endif
        <div class="form-group">
            <h4>Редактирование записи</h4>
            <hr>
            @include('parts.user-info')
        </div>

        @include('parts.summernote', ['post_title' => $post_title, 'post_content' => $post_content, 'post_id' => $post_id, 'author_id' => $user_id])
    </div>
@endsection
