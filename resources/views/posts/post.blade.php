@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9 post-item">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="post-title">{{ $post_item->post_title }}</h3>
                @include('parts.post-control', ['post' => $post_item])
            </div>
            <div class="panel-body">
                {!! $post_item->post_content !!}
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="post-author col-12 col-sm-12 col-md-6">
                        <h5>Автор:</h5>
                        <span>{{$post_item->last_name}} {{$post_item->first_name}}</span>
                    </div>
                    <div class="post-date col-12 col-sm-12 col-md-6">
                        <h5>Обновлено:</h5>
                        {{ \Carbon\Carbon::parse($post_item->updated_at)->format('H:i d F Y')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection