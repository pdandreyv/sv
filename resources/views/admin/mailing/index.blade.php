@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9 mailing">

        <div class="title">
            <h3>Рассылка сообщений</h3>
        </div>
        <hr />
        <form action="{{route('admin.mailing.send')}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="template">Шаблон</label>
                <select name="template_id" class="form-control">
                    @foreach($templates as $template)
                        <option value="{{$template->id}}">{{$template->subject}}</option>
                    @endforeach
                </select>
            </div>
            @if($errors->has('template_id'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('template_id') }}
                </div>
            @endif
            <div class="form-group">
                <label>
                    <input type="radio" name="send_type" value="all">
                    <span>Всем</span>
                </label>
                <label>
                    <input type="radio" name="send_type" value="group">
                    <span>Группе людей</span>
                </label>
                <label>
                    <input type="radio" name="send_type" value="some_users">
                    <span>Выбранным пользователям</span>
                </label>
            </div>
            <div class="form-group" id="group_option" style="display: none;">
                <label>Группы пользователей</label></br>
                <select name="user_type_id" class="form-control">  
                    @foreach($userTypes as $userType)
                        <option value="{{$userType->id}}">{{$userType->name}}</option>
                    @endforeach
                </select>
            </div>
            <div id="some_users_option" style="display: none;">
                <div class="users-block">
                    <div class="form-group">
                        <label for="email">Кому</label>
                        <div class="user-block">
                            <div class="wrapper-dropdown">
                                <input type="text" class="user-name form-control" value="{{old('user_name')?old('user_name'):(isset($userTo)?$userTo->name:'')}}" autocomplete="off" name="to_user_name[]">
                                <input type="hidden" name="to_user_id[]" class="user_to_id" value="{{old('user_name')?old('user_to_id'):(isset($userTo)?$userTo->id:'') }}">
                                <ul class="users-dropdown"></ul>
                            </div> 
                        </div>
                    </div> 
                </div>
                <div class="form-group">
                    <input type="button" id="add-chat-member" class="btn btn-primary" value="Добавить пользователя">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Отправить</button>
            </div>
        </form>
    </div>
    <script>
        $('#add-chat-member').on('click', function(event) {
            addNewUserInput();
        });
        $('input[type=radio][name="send_type"]').change(function() {        
            if (this.value == 'all') {
                 $('#some_users_option').hide();
                 $('#group_option').hide();
                 $('.user-name').removeAttr('required');
            }
            else if (this.value == 'group') {
                $('#some_users_option').hide();
                $('#group_option').show();
                $('.user-name').removeAttr('required');
            } else if (this.value == 'some_users') {
                $('#some_users_option').show();
                $('#group_option').hide(); 
                $('.user-name').attr('required', 'required');
            }
        });
    </script>
    <script src="{{ asset('js/users/group-user-dropdown.js') }}"></script>
@endsection