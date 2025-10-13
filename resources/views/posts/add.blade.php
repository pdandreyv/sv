@extends('layouts.app')

@section('content')

    @include('parts.sidebar')
    <div class="col-md-9">
        <div class="title">
            <h3>Новая запись</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('profile.my-page', auth()->user()->id) }}" class="btn btn-default btn-back">Отмена</a>
        </div>
        <hr />
        <div class="col-md-12 post-item add">
            <div class="form-group">
                <h4>Добавить новую запись</h4>
            </div>
            @include('parts.summernote_2')
        </div>
    </div>
@endsection