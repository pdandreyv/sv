@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9">

        <div class="title">
            <h3>Список участников</h3>
        </div>
        <hr />
        <table class="table">
            <thead>
            <tr class="product-table-thead">
                <th>Фото</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Город</th>
                <th>Статус</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="client_info">
                        <td class="item-photo-container item-photo-75"> 
                            <a class="item-photo-75" href="{{route('profile.show', ['id'=>$user->getLink()])}}">

                                @if( $user->photo && file_exists(public_path().'/images/users_photos/'.$user->photo) )
                                    <img width="75px" src="/images/users_photos/{{$user->photo}}">
                                @else
                                    <img width="75px" src="{{config('app.placeholder_url')}}75x75/00d2ff/ffffff">
                                @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{route('profile.show', ['id'=>$user->getLink()])}}">
                                <span>{{$user->last_name}}</span>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('profile.show', ['id'=>$user->getLink()])}}">
                                <span>{{$user->first_name}}</span>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('profile.show', ['id'=>$user->getLink()])}}">
                                <span>{{$user->middle_name}}</span>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('profile.show', ['id'=>$user->getLink()])}}">
                                <span>{{$user->city}}</span>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('profile.show', ['id'=>$user->getLink()])}}">
                                <span>{{($user->type)?$user->type->name:''}}</span>
                            </a>
                        </td>
                        <td class="text-right buttons">
                            @if($user->isSubscribe(Auth::user()->id))
                            <a href="{{ route('unsubscribe', ['id' => $user->id]) }}" class="btn btn-warning btn-sm">
                                <span>Отписаться</span>
                            </a>
                            @else
                            <a href="{{ route('subscribe', ['id' => $user->id]) }}" class="btn btn-success btn-sm">
                                <span>Подписаться</span>
                            </a>
                            @endif
                            <a href="{{ route('chat.message', ['user_to_id' => $user->id]) }}" class="btn btn-primary btn-sm">
                                <span>Написать сообщение</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$users->links()}}

    </div>

@endsection
