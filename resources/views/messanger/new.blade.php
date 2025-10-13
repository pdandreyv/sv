@extends('layouts.app')

@section('content')

@include('parts.sidebar')

<div class="col-md-9">

<form action="{{route('messanger.message.store')}}" method="post" class="form-horizontal">
    {{ csrf_field() }}    

    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a></br>
    </div>
    
    <div class="form-group">    
    <div class="products-block-up">
        <div class="row">
            <div class="col-md-8">
                <span class="product-block-bread">НОВОЕ СООБЩЕНИЕ</span>
            </div>
        </div>
    </div>
    <hr>
    </div>
    <div class="form-group">
        <label for="email">КОМУ</label>
        <div class="wrapper-dropdown">
        <div class="users-block">
            <input type="text" id="user-name" name='user_name' class="form-control" value="{{old('user_name')?old('user_name'):(isset($userTo)?$userTo->name:'')}}" autocomplete="off">
            <input type="hidden" name="to_user_id" id="user_to_id" value="{{old('user_name')?old('user_to_id'):(isset($userTo)?$userTo->id:'') }}">
        </div>        
        <ul class="users-dropdown"></ul>
        </div>
    </div>           
    @if($errors->has('to_user_id'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('to_user_id') }}
        </div>
    @endif

    <div class="form-group">        
        <label for="name">ТЕКСТ СООБЩЕНИЯ</label>
        <input type="text" name="message_text" class="form-control" value="{{old('message_text')}}" >        
    </div>
    @if($errors->has('message_text'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('message_text') }}
        </div>
    @endif
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
</form>

</div>
    
<script src="{{ asset('js/users/user-dropdown.js') }}"></script>

@endsection
