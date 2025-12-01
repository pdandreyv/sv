@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9 post-item">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="post-title">{{ $page->h1 }}</h3>
            </div>
            <div class="panel-body">
                {!! $page->body !!}
            </div>

        </div>
    </div>
@endsection
