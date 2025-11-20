@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Редактирование пользователя</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.users') }}" class="btn btn-info btn-add">Назад</a>
        </div>
        <hr />
        <form method="post" action="{{route('admin.users.update.post', $user->id)}}" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group col-sm-12 col-md-6 right">
                <label for="email">Адрес электронной почтыl (Логин)</label>
                <input type="text" name="email" class="form-control" value="{{$user->email}}">
            </div>
            @if($errors->has('email'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif
            <div class="form-group col-sm-12 col-md-6 left">
                <label for="name">Номер телефона</label>
                <input type="text" name="phone_number" class="form-control" value="{{$user->phone_number}}" >
            </div>
            <div class="form-group col-sm-12 col-md-4 right">
                <label for="access" class="col-sm-12 no-side-padding">Роль</label>
                <select multiple="multiple" name="role[]" placeholder="Select roles..." class="SlectBox">
                    @foreach ($roles as $role)
                        @php
                            $selected = in_array($role->id, $user->roles()->get()->pluck('id')->toArray())?'selected="selected"':'';
                        @endphp
                        <option value="{{$role->id}}" {{$selected}}>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-12 col-md-4">
                <label for="access">Тип</label>
                <select class="form-control" name="user_type_id">
                    <option value=""></option>
                    @foreach ($types as $type)
                        @php
                            $selected = ($type->id == $user->user_type_id)?'selected="selected"':'';
                        @endphp
                        <option value="{{$type->id}}" {{$selected}}>{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-12 col-md-4 left">
                <label for="alias">Псевдоним реферальной ссылки</label>
                <input type="text" name="alias" class="form-control" value="{{$user->alias}}">
            </div>
            @if($errors->has('alias'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('alias') }}
                </div>
            @endif

            <hr>

            <div class="form-group col-sm-12 col-md-4 right">
                <label for="name">Город</label>
                <input type="text" name="city" class="form-control" value="{{$user->city}}" >
            </div>

            <div class="form-group col-sm-12 col-md-8 left">
                <label for="name">Адрес проживания</label>
                <input type="text" name="accomodation_address" class="form-control" value="{{$user->accomodation_address}}" >
            </div>

            <div class="form-group">
                <label for="name">Фото</label>
                <input name="photo_file" type="file">
            </div>

            @if(!empty($user->photo))
            <div class="form-group image-container">
                <img src="/images/users_photos/{{$user->photo}}">
            </div>
            @endif
            <hr />
            <h4>Паспортные данные</h4>
            <hr />
            <div class="form-group">
                <div class="col-sm-12 col-md-4" style="padding-left: 0;">
                    <label for="name">Фамилия</label>
                    <input type="text" name="last_name" class="form-control" value="{{$user->last_name}}" >
                </div>

                <div class="col-sm-12 col-md-4" style="padding-left: 0;">
                    <label for="name">Имя</label>
                    <input type="text" name="first_name" class="form-control" value="{{$user->first_name}}" >
                </div>

                <div class="col-sm-12 col-md-4" style="padding-left: 0;">
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
            <div class="row">
                <div class="col-sm-12 col-md-3"  style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">День рождения</label>
                        <select name="birth_day" class="form-control">
                            <option value=""></option>
                            @for ($i = 1; $i < 32; $i++)
                                @php 
                                    $day = (string)sprintf('%02d', $i);
                                @endphp
                                <option value="{{ $day }}" {{($user->getBirthDay()==$day)?'selected="selected"':''}}>{{$day}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3" style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">Месяц рождения</label>
                        @php
                            $monthNames = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
                        @endphp
                        <select class="form-control" name="birth_mounth">
                            <option value=""></option>
                            @for ($i = 1; $i < 13; $i++)
                                @php 
                                    $month = (string)sprintf('%02d', $i);
                                @endphp
                                <option value="{{ $month }}" {{($user->getBirthMonth()==$month)?'selected="selected"':''}}>{{$monthNames[$i-1]}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3" style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">Год рождения</label>
                        <select class="form-control" name="birth_year">
                            <option value=""></option>
                            @for ($i = 1940; $i < (now()->year - 17); $i++)
                                @php 
                                    $year = (string)sprintf('%04d', $i);
                                @endphp
                                <option value="{{ $year }}" {{($user->getBirthYear()==$year)?'selected="selected"':''}}>{{$year}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3" style="padding-left: 0;">
                    <div class="form-group" style="padding-left: 0;">
                        <label for="name">Пол</label>
                        <select name="gender" class="form-control" placeholder="Выберите пол...">
                            <option value=""></option>
                            <option value="male" {{$selected = ($user->gender=='male')?'selected="selected"':''}}>Мужской</option>
                            <option value="female" {{$selected = ($user->gender=='female')?'selected="selected"':''}}>Женский</option>
                        </select>
                    </div>
                    @if($errors->has('gender'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('gender') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-2" style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">Серия паспорта</label>
                        <input type="text" name="passport_series" class="form-control" value="{{$user->passport_series}}" >
                    </div>
                    @if($errors->has('passport_series'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('passport_series') }}
                        </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-2" style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">Номер паспорта</label>
                        <input type="text" name="passport_number" class="form-control" value="{{$user->passport_number}}" >
                    </div>
                    @if($errors->has('passport_number'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('passport_number') }}
                        </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-2" style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">Дата выдачи</label>
                        <input type="text" name="passport_give_date" class="form-control date" value="{{$user->passport_give_date}}" >
                    </div>
                    @if($errors->has('passport_give_date'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('passport_give_date') }}
                        </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-6" style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">Кем выдан</label>
                        <input type="text" name="passport_give" class="form-control" value="{{$user->passport_give}}" >
                    </div>
                    @if($errors->has('passport_give'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('passport_give') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4" style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">Идентификационный код</label>
                        <input type="text" name="identification_code" class="form-control" value="{{$user->identification_code}}" >
                    </div>
                    @if($errors->has('identification_code'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('identification_code') }}
                        </div>
                    @endif
                </div>
                <div class="col-sm-6 col-md-8" style="padding-left: 0;">
                    <div class="form-group">
                        <label for="name">Адрес регистрации</label>
                        <input type="text" name="registration_address" class="form-control" value="{{$user->registration_address}}" >
                    </div>
                    @if($errors->has('registration_address'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('registration_address') }}
                        </div>
                    @endif
                </div>
            </div>
            <hr />
            <h4>Сканы документов</h4>
            <hr />
            <div class="scans">
                <div class="col-sm-6 col-md-3 scan-container" style="padding-left: 0;">
                    <label>Первая страница паспорта</label> 
                    @if($passport1!=null)
                        <a class="scan-item" target="_blank" href="/images/users_documents/{{$passport1->file_name}}">
                            <img src="/images/users_documents/{{$passport1->file_name}}">
                        </a>
                    @else
                        <div class="scan-item">
                            <img src="{{config('app.placeholder_url')}}400x400/00d2ff/ffffff">
                        </div>
                    @endif
                    <div class="input-group input-file scan-choose" name="page1_file">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-choose" type="button">
                                <span><i class="far fa-image"></i></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" placeholder='Выбрать...' />
                        <span class="input-group-btn">
                             <button class="btn btn-warning btn-reset" type="button">
                                <span><i class="fas fa-sync-alt"></i></span>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 scan-container" style="padding-left: 0;">
                    <label>Вторая страница паспорта</label> 
                    @if($passport2!=null)
                        <a class="scan-item" target="_blank" href="/images/users_documents/{{$passport2->file_name}}">
                            <img src="/images/users_documents/{{$passport2->file_name}}">
                        </a>
                    @else
                        <div class="scan-item">
                            <img src="{{config('app.placeholder_url')}}400x400/00d2ff/ffffff">
                        </div>
                    @endif
                    <div class="input-group input-file scan-choose" name="page2_file">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-choose" type="button">
                                <span><i class="far fa-image"></i></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" placeholder='Выбрать...' />
                        <span class="input-group-btn">
                             <button class="btn btn-warning btn-reset" type="button">
                                <span><i class="fas fa-sync-alt"></i></span>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 scan-container" style="padding-left: 0;">
                    <label>Третья страница паспорта</label>
                    @if($passport3!=null)
                        <a class="scan-item" target="_blank" href="/images/users_documents/{{$passport3->file_name}}">
                            <img src="/images/users_documents/{{$passport3->file_name}}">
                        </a>
                    @else
                        <div class="scan-item">
                            <img src="{{config('app.placeholder_url')}}400x400/00d2ff/ffffff">
                        </div>
                    @endif
                    <div class="input-group input-file scan-choose" name="page3_file">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-choose" type="button">
                                <span><i class="far fa-image"></i></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" placeholder='Выбрать...' />
                        <span class="input-group-btn">
                             <button class="btn btn-warning btn-reset" type="button">
                                <span><i class="fas fa-sync-alt"></i></span>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 scan-container" style="padding-left: 0;">
                    <label>Идентификационный код</label>
                    @if ($identification_code!=null)
                        <a class="scan-item" target="_blank" href="/images/users_documents/{{$identification_code->file_name}}">
                            <img src="/images/users_documents/{{$identification_code->file_name}}">
                        </a>
                    @else
                        <div class="scan-item">
                            <img src="{{config('app.placeholder_url')}}400x400/00d2ff/ffffff">
                        </div>
                    @endif
                    <div class="input-group input-file scan-choose" name="ic_file">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-choose" type="button">
                                <span><i class="far fa-image"></i></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" placeholder='Выбрать...' />
                        <span class="input-group-btn">
                             <button class="btn btn-warning btn-reset" type="button">
                                <span><i class="fas fa-sync-alt"></i></span>
                            </button>
                        </span>
                    </div>
                </div>

            </div>
            @if($errors->has('page1_file'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('page1_file') }}
                </div>
            @endif
            
            @if($errors->has('page2_file'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('page2_file') }}
                </div>
            @endif

            @if($errors->has('page3_file'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('page3_file') }}
                </div>
            @endif

            @if($errors->has('ic_file'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('ic_file') }}
                </div>
            @endif
            <hr />
            <div class="form-group">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </div>
            <hr />
            <h4>Изменить пароль</h4>
            <hr />
            <div class="form-group col-sm-12 col-md-8" style="padding-left: 0;">
                <label for="new_password">Новый пароль</label>
                <input type="text" name="password" id="new_password" class="form-control" autocomplete="new-password" style="max-width: 300px; display: inline-block; margin-right: 10px;"><br><br>
                <button type="button" class="btn btn-success" id="btn-generate-password" style="margin-right: 10px;">Сгенерировать пароль</button>
                <button type="submit" class="btn btn-success" id="btn-save-password" disabled>Сохранить пароль</button>
            </div>
        </form>

        <hr />
        <script type="text/javascript">
            $(document).ready(function () {
                $('.SlectBox').SumoSelect({
                    csvDispCount: 3,
                    selectAll:true,
                    captionFormatAllSelected: "Yeah, OK, so everything."
                });
                $('.SlectBox').on('sumo:opened', function(o) {
                    console.log("dropdown opened", o)
                });
                var scanItemWidth = $('.scan-item').width();
                $('.scan-item').height(scanItemWidth);

                function toggleSavePwd() {
                    var enabled = $('#new_password').val().trim() !== '';
                    $('#btn-save-password').prop('disabled', !enabled);
                }

                $('#btn-generate-password').on('click', function() {
                    var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%^&*';
                    var pass = '';
                    for (var i = 0; i < 12; i++) {
                        pass += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    $('#new_password').val(pass);
                    toggleSavePwd();
                });

                $('#new_password').on('input change', toggleSavePwd);
                toggleSavePwd();
            });

            $('.date').datepicker({
                timePicker: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
                language: 'ru',
                startDate: new Date(<?php echo date('Y-m-d') ?>)
            });

            function bs_input_file() {
                $(".input-file").before(
                    function() {
                        if ( ! $(this).prev().hasClass('input-ghost') ) {
                            var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0' accept='.jpg,.jpeg,.png'>");
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