@extends('layouts.app')

@section('content')

    @include('parts.sidebar')
    <div class="col-md-9">
        <div class="title">
            <h3>Моя Страница</h3>
            @if(app('request')->attributes->get('canSendCooperativeRequest') && app('request')->attributes->get('emptyForm'))
                <div class="alert alert-danger">Чтобы продолжить работу с сайтом, вам необходимо нажать кнопку "Подать заявку на участие в кооперативе" и заполнить там все поля</div>
            @endif
            @if($user->isCooperationRequest())
                <div class="alert alert-danger">Ваша заявка на рассмотрении. После одобрения Вам будет доступен полный функционал. Для ускорения рассмотрения заявки можете позвонить по телефону (097)980-32-94.</div>
            @endif
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
        <div class="form-group">
            @include('parts.user-info')
        </div>
        <hr>
        <div>
            <button type="submit" class="btn btn-primary" id="add_post_toggle">Добавить информацию</button>
            @include('parts.summernote')
        </div>
        @include('posts.list')
    </div>
@endsection
