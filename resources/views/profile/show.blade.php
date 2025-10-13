@extends('layouts.app')

@section('content')
    <div class="title">
        <h3>Просмотр профиля</h3>
    </div>
    <hr />
    <div class="btn-container form-group">
        <a href="{{ url()->previous() }}" class="btn btn-info btn-back"><i class="fas fa-arrow-left"></i>Назад</a>
    </div>
    <div class="col-md-3">
        <ul class="nav navbar navbar-default" id="admin-side-menu">
            <li>
                @if($user->photo)
                    <img width="253px" src="/images/users_photos/{{$user->photo}}">
                @else
                    <img width="253px" src="{{config('app.placeholder_url')}}253x253/00d2ff/ffffff">
                @endif
            </li>
            @if(app('request')->attributes->get('isCooperative'))
                @if($subscribe)
                    <li class="form-group">
                        <a href="{{ route('unsubscribe', ['id' => $user->id]) }}" class="btn btn-info btn-block">
                            <span>Отписаться</span>
                        </a>
                    </li>
                @else
                    <li class="form-group">
                        <a href="{{ route('subscribe', ['id' => $user->id]) }}" class="btn btn-info btn-block">
                            <span>Подписаться</span>
                        </a>
                    </li>
                @endif
                <li class="form-group">
                    <a href="{{ route('messanger.message', ['id' => $user->id]) }}" class="btn btn-info btn-block">
                        <span>Написать сообщение</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <div class="col-md-9">
        <p><strong>ФИО:</strong> {{$user->last_name}} {{$user->first_name}} {{$user->middle_name}}</p>
        @if($user->birth_date_view == 1)
        <p><strong>Дата рождения:</strong> {{ \Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') }}</p>
        @endif
        @if($user->city_view == 1)
        <p><strong>Город:</strong> {{$user->city or '-'}}</p>
        @endif
        @if($user->phone_number_view == 1)
        <p><strong>Телефон:</strong> {{$user->phone_number or '-'}}</p>
        @endif
        @if($user->email_view == 1)
        <p><strong>E-mail:</strong>{{$user->email or '-'}}</p>
        @endif

        @if(isset($questionnaireAnswers) && count($questionnaireAnswers))
        <hr />
        <div class="title">
            <h4>Анкета</h4>
        </div>
        <div class="form-group">
            @foreach($questionnaireAnswers as $answer)
                @if($answer->question)
                    <p>
                        <strong>{{ $answer->question->question }}:</strong><br />
                        {{ $answer->answer }}<br /><br />
                    </p>
                @endif
            @endforeach
        </div>
        @endif
    </div>

@endsection