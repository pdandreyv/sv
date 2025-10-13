@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">

<form action="{{route('admin.user-types.store')}}" class="form-horizontal" method="post">
    {{ csrf_field() }}
    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a>
    <h4>Добавить тип</h4><hr>  
    </div>  
    <div class="form-group">
        <label for="code">КОД</label>
        <input type="text" name="code" class="form-control" value="{{old('code')}}" >
    </div>
    @if($errors->has('code'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('code') }}
        </div>
    @endif
    <div class="form-group">
        <label for="name">ИМЯ</label>
        <input type="text" name="name" class="form-control" value="{{old('name')}}">
    </div>  
    @if($errors->has('name'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('name') }}
        </div>
    @endif              

    <div class="form-group">        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

</div>

@endsection

