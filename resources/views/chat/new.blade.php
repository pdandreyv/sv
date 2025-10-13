@extends('layouts.app')

@section('content')

@include('parts.sidebar')

    <div class="col-md-9">
        <div class="title">
            <h3>Написать новое сообщение</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('chat.chats.list') }}" class="btn btn-warning btn-back">
                <span>Отмена</span>
            </a>
        </div>
        <hr />
        <form action="{{route('chat.message.store')}}" method="post" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="chat_title">Название Чата</label>
                <input type="text" class="form-control" value="{{old('chat_title')}}" name="chat_title">
            </div>

            <div class="users-block">
                <div class="form-group">
                    <label for="email">Кому</label>
                    <div class="user-block">
                        <div class="wrapper-dropdown">
                            <input type="text" class="user-name form-control" value="{{old('user_name')?old('user_name'):(isset($userTo)?$userTo->name:'')}}" autocomplete="off"  required="required" >
                            <input type="hidden" name="to_user_id[]" class="user_to_id" value="{{old('user_name')?old('user_to_id'):(isset($userTo)?$userTo->id:'') }}">
                            <ul class="users-dropdown"></ul>
                        </div> 
                    </div>
                </div> 
            </div>
            @if($errors->has('to_user_id'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('to_user_id') }}
                </div>
            @endif

            <div class="form-group">
                <input type="button" id="add-chat-member" class="btn btn-primary" value="Добавить  ещё одного пользователя в чат">
            </div>

            <div class="form-group">
                <label for="name">Текст сообщения</label>
                <input type="text" name="text" required="required" class="form-control" value="{{old('text')}}" >
            </div>
            @if($errors->has('message_text'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('message_text') }}
                </div>
            @endif
            
            <div class="form-group">
                <button type="submit" class="btn btn-success">Отправить</button>
            </div>
        </form>
        <script src="{{ asset('js/users/group-user-dropdown.js') }}"></script>

        <script>
            $('#add-chat-member').on('click', function(event) {
                addNewUserInput();
            });
        </script>
    </div>

@endsection