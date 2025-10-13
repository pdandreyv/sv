@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')
    <div class="col-md-9 admin-table">
        <div class="title">
            <h3>Список пожеланий</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.resources.add') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <div class="btn-container user-select-field">
            @include('admin.resources-user.form-user-resources', ['users' => $users ])
        </div>
        <hr />

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

        <div class="items-list admin">
            @include('admin.resources.categories', ['categories' => $categories ])
        </div>

    </div>

@endsection