@extends('layouts.app')

@section('content')
    <div class="container">
        @include('parts.sidebar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Панель управления</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row dashboard">
                        <div class="col-12 col-sm-6 col-md-3 first">
                            <div class="row">
                                <a href="" title="">Моя страница</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row">
                                <a href="" title="">Редактирование профиля</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row">
                                <a href="" title="">Пополнение баланса</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row">
                                <a href="" title="">Перевод денег</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row">
                                <a href="" title="">Мои сообщения</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row">
                                <a href="" title="">Моя сеть</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row">
                                <a href="" title="">Мои товары</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row">
                                <a href="" title="">Мои услуги</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection