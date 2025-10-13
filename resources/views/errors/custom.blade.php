@extends('layouts.app')

@section('content')

    @include('parts.sidebar')
    <div class="col-md-9 unknown-error">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3>Произошла неизвестная ошибка, свяжитесь с администратором</h3>
            </div>
        </div>
        <form id="contact_form" enctype="multipart-formdata" method="post">
            {{ csrf_field() }}
            <div class="form-group col-sm-12 col-md-4 right">
                <label for="name" class="col-sm-12 no-side-padding">Имя</label> 
                <input type="text" class="form-control col-sm-12" id="name" name="name" value ="{{Auth::user()->last_name}} {{Auth::user()->first_name}} {{Auth::user()->middle_name}}" />
                <div class="col-sm-12 no-side-padding name-error">
                    <!---->
                </div>
            </div>
            <div class="form-group col-sm-12 col-md-4 no-side-padding">
                <label for="email" class="col-sm-12 no-side-padding">E-mail</label> 
                <input type="email" class="form-control col-sm-12" id="email" name="email" value ="{{Auth::user()->email}}" />
                <div class="col-sm-12 no-side-padding email-error">
                    <!---->
                </div>
            </div>
            <div class="form-group col-sm-12 col-md-4 left">
                <label for="phone" class="col-sm-12 no-side-padding">Телефон</label> 
                <input type="text" class="form-control col-sm-12" id="phone" name="phone" value="{{Auth::user()->phone_number}}"/>
                <div class="col-sm-12 no-side-padding phone-error">
                    <!---->
                </div>
            </div>
            <div class="form-group col-sm-12 no-side-padding">
                <label for="subject" class="col-sm-12 no-side-padding">Тема</label> 
                <input type="text" class="form-control col-sm-12 no-side-padding" id="subject" name="subject" />
                <div class="col-sm-12 no-side-padding subject-error">
                    <!---->
                </div>
            </div>
            <div class="form-group col-sm-12 no-side-padding">
                <label for="message" class="col-sm-12 no-side-padding">Сообщение</label> 
                <textarea class="form-control col-sm-12 no-side-padding" id="message" name="message" rows="6" ></textarea>
                <div class="col-sm-12 no-side-padding message-error">
                    <!---->
                </div>
            </div>

            <div class="form-group col-sm-12 no-side-padding">
                <label for="file" class="col-sm-12 no-side-padding">Файл</label> 
                <input type="file" class="form-control col-sm-6 no-side-padding id="file" name="file" />
            </div>

            <div class="form-group col-sm-12 no-side-padding">
                <input type="submit" class="btn btn-primary"  value="Отправить" />
                <div class="col-sm-12 no-side-padding send-success">
                    <!---->
                </div>
            </div>
        </form>
    </div>
@endsection