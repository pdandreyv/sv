@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>{{$page_title}}</h3>
        </div>
        <hr />
        <div class="btn-container form-group">
            <a href="{{ route($back_route) }}" class="btn btn-info btn-back"><i class="fas fa-arrow-left"></i>Назад</a>
        </div>
        <hr />
        <div class="alert alert-info">
            <span>Поля помеченные <span class="text-danger">*</span> обязательны к заполнению.</span>
        </div>
        <form action="{{ route($form_route, ['id' => isset($unit) ? $unit->id : 0]) }}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="required">Сокращение</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ isset($unit) ? $unit->name : old('name') }}">
                @if ($errors->has('name'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="description" class="required">Полное названия</label>
                <input type="text" id="description" name="description" class="form-control" value="{{ isset($unit) ? $unit->description : old('description') }}">
                @if ($errors->has('description'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">{{$submit_title}}</button>
            </div>
        </form>
    </div>

@endsection