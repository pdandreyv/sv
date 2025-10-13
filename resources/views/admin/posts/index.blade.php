@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9 admin-table">
        <div class="title">
            <h3>Записи</h3>
        </div>
        @if (session()->has('sucсess'))
            <hr />
            <div class="form-group alert alert-success">
                <span>{{session()->pull("sucсess")}}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <hr />
            <div class="form-group alert alert-error">
                <span>{{session()->pull("error")}}</span>
            </div>
        @endif
        <hr />
        <div class="admin-table-title row">
            <div class="title col-3">
                Название
            </div>
            <div class="author col-3">
                Автор
            </div>
            <div class="date col-2">
                Опубликовано
            </div>
            <div class="approved col-2">
                Одобрено
            </div>
            <div class="tools col-2">
                {{-- Инструменты --}}
            </div>
        </div>
        <hr style="margin-bottom: 0px;">
        <div class="admin-table-list">
            @foreach($posts as $post)
                <div class="row admin-table-item">
                    <div class="title col-3">
                        <a href="{{ route('admin.post.edit', ['post_id' => $post->post_id]) }}" title="{{ $post->post_title }}">{{ $post->post_title }}</a>
                    </div>
                    <div class="author col-3">
                        <span>{{$post->name}}</span>
                    </div>
                    <div class="date col-2">
                        {{ \Carbon\Carbon::parse($post->updated_at)->format('d.m.Y')}}
                    </div>
                    <div class="approved col-2">
                        @if ( (isset($post->approved)) && ($post->approved =='1'))
                            <span class="approve text-success" title="Одобрено"><i class="fas fa-check"></i></span>
                        @else
                            <span class="not-approve text-danger" title="Не одобрено"><i class="fas fa-times"></i></span>
                        @endif
                    </div>
                    <div class="tools col-2">
                        <div class="post-control pull-right row">
                            <a href="{{ route('admin.post.edit', ['post_id' => $post->post_id]) }}" title="Редактировать Запись" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.posts.delete', ['post_id' => $post->post_id]) }}" onclick='return confirm("Вы действительно хотите удалить запись?")' title="Удалить запись" class="btn btn-danger btn-sm">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="pagination-container">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

@endsection