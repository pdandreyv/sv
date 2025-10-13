@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">
    
<div class="title">
    <h3>Добавление связи</h3>
</div>
<hr>
<div class="btn-container">
    <a href="{{ url()->previous() }}" class="btn btn-info btn-add">Назад</a>
</div>
<hr>
    
<form action="{{route('admin.network.node.store')}}" class="form-horizontal" method="post">
    {{ csrf_field() }}    
    
    <div class="form-group">
        <label>Пользователь</label>
        <div class="user-block">
            <div class="wrapper-dropdown">
                <input type="text" name="user_name" class="name-control user-name form-control" value="{{old('user_id')?old('user_name'):''}}" autocomplete="off">
                <input type="hidden" name="user_id"  id="user_id" class="id-hidden" value="{{old('user_id')?old('user_id'):''}}">
                <ul class="users-dropdown"></ul>
            </div> 
        </div>
    </div>    
    @if($errors->has('user_id'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('user_id') }}
        </div>
    @endif
    
    <div class="form-group">
        <label>УПС-1</label>
        <div class="user-block">
            <div class="wrapper-dropdown">
                <input type="text" name="ups1_name" class="name-control ups1-name form-control" value="{{old('ups1_id')?old('ups1_name'):''}}" autocomplete="off">
                <input type="hidden" name="ups1_id" id="ups1_id" class="id-hidden" value="{{old('ups1_id')?old('ups1_id'):''}}">
                <ul class="users-dropdown"></ul>
            </div> 
        </div>
    </div>
    @if($errors->has('ups1_id'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('ups1_id') }}
        </div>
    @endif
    
    <div class="form-group">
        <label>УПС-2</label>
        <div class="user-block">
            <div class="wrapper-dropdown">
                <input type="text"  name="ups2_name" class="name-control ups2-name form-control" value="{{old('ups2_name')}}" autocomplete="off" readonly="true">
                <input type="hidden" name="ups2_id" id="ups2_id" class="id-hidden" value="{{old('ups2_id')}}">
                <ul class="users-dropdown"></ul>
            </div> 
        </div>
    </div>
    
    <div class="form-group">
        <label>УПС-3</label>
        <div class="user-block">
            <div class="wrapper-dropdown">
                <input type="text" name="ups3_name"  class="name-control ups3-name form-control" value="{{old('ups3_name')}}" autocomplete="off" readonly="true">
                <input type="hidden" name="ups3_id" id="ups3_id" class="id-hidden" value="{{old('ups3_id')}}">
                <ul class="users-dropdown"></ul>
            </div> 
        </div>
    </div>
    
    <div class="form-group">        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

<script src="{{ asset('js/users/ups-users.js') }}"></script>
    
</div>

@endsection