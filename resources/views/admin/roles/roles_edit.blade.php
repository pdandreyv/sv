@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">

<form class="form-horizontal" method="post">
    {{ csrf_field() }}
    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><-Назад</a>
    <h4>Редактировать роль</h4><hr>  
    </div>  
    <div class="form-group">
        <label for="name">КОД</label>
        <input type="text" readonly=true name="name" class="form-control" value="{{$role->name}}" >
    </div>
    @if($errors->has('name'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('name') }}
        </div>
    @endif
    <div class="form-group">
        <label for="title">ИМЯ</label>
        <input type="text" name="title" class="form-control" value="{{$role->title}}">
    </div>  
    @if($errors->has('title'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('title') }}
        </div>
    @endif              

    <div class="form-group">        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

</div>

@endsection