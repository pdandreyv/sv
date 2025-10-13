@extends('layouts.app')

@section('content')

@include('parts.sidebar')

<div class="col-md-9">

@if(!count($posts))

<div class="products-block-up">
    <div class="row">
        <div class="col-md-8">
            <span class="product-block-bread">По запросу <strong>{{$searchText}}</strong> не найдено ни одной записи</span>
        </div>
    </div>
</div>
<hr>
    
@else 

<div class="products-block-up">
    <div class="row">
        <div class="col-md-8">
            <span class="product-block-bread">РЕЗУЛЬТАТЫ ПОИСКА ПО <strong>{{$searchText}}</strong></span>
        </div>
    </div>
</div>
<hr>
<div class="content posts-list">
    @foreach($posts as $post)
        <div class="panel panel-info post-item">
            <div class="panel-heading">
                <a href="{{ route('posts.post', ['post_id' => $post->post_id]) }}" title="{{ $post->post_title }}">
                    <h3 class="post-title">{{ $post->post_title }}</h3>
                </a>
                @include('parts.post-control', ['post_id' => $post->post_id])
            </div>
            <div class="panel-body">
                {!! $post->post_content !!}
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="post-author col-12 col-sm-12 col-md-6">
                        <h5>Автор:</h5>
                        <span>{{$post->last_name}} {{$post->first_name}}</span>
                    </div>
                    <div class="post-date col-12 col-sm-12 col-md-6">
                        <h5>Обновлено:</h5>
                        {{ \Carbon\Carbon::parse($post->updated_at)->format('H:i d F Y')}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{$posts->appends($_GET)->links()}}

@endif

</div>

@endsection