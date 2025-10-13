@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9 profile-edit">
        <div class="title">
            <h3>Редактирование профиля</h3>
        </div>
        @if (session()->has('sucсess'))
            <hr />
            <div class="form-group alert alert-success">
                <span>{{session()->pull("sucсess")}}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <hr />
            <div class="form-group alert alert-erorr">
                <span>{{session()->pull("error")}}</span>
            </div>
        @endif
        <hr />
        @include('parts.user-info')
        <hr />
        <div class="title">
            <h4>Изменение контактных данных</h4>
        </div>
        <hr />
        <form method="post" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
                <div class="col-sm-12 col-md-4 right">
                    <label for="name">Фамилия</label>
                    <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}" >
                </div>

                <div class="col-sm-12 col-md-4" style="padding-left: 0;">
                    <label for="name">Имя</label>
                    <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}" >
                </div>

                <div class="col-sm-12 col-md-4 left" style="padding-left: 0;">
                    <label for="name">Отчество</label>
                    <input type="text" name="middle_name" class="form-control" value="{{$user->middle_name}}" >
                </div>
            </div>
                @if($errors->has('last_name'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('last_name') }}
                    </div>
                @endif

                @if($errors->has('first_name'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('first_name') }}
                    </div>
                @endif

                @if($errors->has('middle_name'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('middle_name') }}
                    </div>
                @endif

            <div class="form-group col-md-6 col-sm-12 right">
                <label for="email">Адрес электронной почтыl (Логин)</label>
                <input type="text" name="email" class="form-control" value="{{$user->email}}">
            </div>  
            @if($errors->has('email'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif

            <div class="form-group col-md-6 col-sm-12 left">
                <label for="alias">Псевдоним реферальной ссылки</label>
                <input type="text" name="alias" class="form-control" value="{{$user->alias}}">
            </div>
            @if($errors->has('alias'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('alias') }}
                </div>
            @endif

            <div class="form-group col-sm-12 col-md-3 right">
                <label for="name">Город</label>
                <input type="text" name="city" class="form-control" value="{{$user->city}}" >        
            </div>
            
            <div class="form-group col-sm-12 col-md-9 left">
                <label for="name">Адрес проживания</label>
                <input type="text" name="accomodation_address" class="form-control" value="{{$user->accomodation_address}}" >
            </div>

            <div class="form-group col-md-6 col-sm-12 right">
                <label for="name">Телефон</label>
                <input type="text" name="phone_number" class="form-control" value="{{$user->phone_number}}" >
            </div>

            <div class="form-group col-md-6 col-sm-12 left">
                <label for="photo_file">Фото</label>
                <div class="input-group input-file" name="photo_file">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-choose" type="button">Выбрать файл</button>
                    </span>
                    <input type="text" class="form-control" placeholder='Выбрать файл...' />
                    <span class="input-group-btn">
                    <button class="btn btn-warning btn-reset" type="button">
                        <span><i class="fas fa-sync-alt"></i></span>
                    </button>
                    </span>
                </div>
            </div>
            <div class="form-group col-sm-12 no-side-padding">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </div>
        </form>
        <hr />
        <div class="title">
            <h4>Изменение пароля</h4>
        </div>
        <hr />

        <form action="{{route('users.change.password', ['id'=>$user->id])}}" class="form-horizontal" method="post">
            {{ csrf_field() }}

            <div class="form-group col-sm-12 col-md-4 right">
                <label for="password">Введите старый пароль</label>
                <input type="password" name="my_password" class="form-control">
            </div>
            @if($errors->has('my_password'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('my_password') }}
                </div>
            @endif

            <div class="form-group col-sm-12 col-md-4">
                <label for="name">Введите новый пароль</label>
                <input type="password" name="password" class="form-control">
            </div>
            @if($errors->has('password'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <div class="form-group col-sm-12 col-md-4 left">
                <label for="name">Подтверждение нового пароля</label>
                <input type="password" name="password_confirm" class="form-control">
            </div>
            @if($errors->has('password_confirm'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('password_confirm') }}
                </div>
            @endif

            <div class="form-group col-sm-12 no-side-padding">
                <button type="submit" class="btn btn-success">Изменить пароль</button>
            </div>
        </form>
        <script type="text/javascript">
            function bs_input_file() {
                $(".input-file").before(
                    function() {
                        if ( ! $(this).prev().hasClass('input-ghost') ) {
                            var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                            element.attr("name",$(this).attr("name"));
                            element.change(function(){
                                element.next(element).find('input').val((element.val()).split('\\').pop());
                            });
                            $(this).find("button.btn-choose").click(function(){
                                element.click();
                            });
                            $(this).find("button.btn-reset").click(function(){
                                element.val(null);
                                $(this).parents(".input-file").find('input').val('');
                            });
                            $(this).find('input').css("cursor","pointer");
                            $(this).find('input').mousedown(function() {
                                $(this).parents('.input-file').prev().click();
                                return false;
                            });
                            return element;
                        }
                    }
                );
            }
            $(function() {
                bs_input_file();
            });
        </script>
    </div>

@endsection