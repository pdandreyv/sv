@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9">
        <div class="title">
            <h3>Моя сеть</h3>
        </div>
        <hr />

        @if(!empty($myReferrer))
            <div class="subtitle">
                <h4>Меня пригласил</h4>
            </div>
            <hr />
            <div class="referrer">
                <a class="item-photo" href="{{route('profile.show', ['id'=>$myReferrer->getLink()])}}">
                    @if($myReferrer->photo)
                        <img width="90px" src="/images/users_photos/{{$myReferrer->photo}}">
                    @else
                        <img width="90px" src="{{config('app.placeholder_url')}}90x90/00d2ff/ffffff">
                    @endif
                </a>
                <a href="{{route('profile.show', ['id'=>$myReferrer->getLink()])}}">
                    <span>{{$myReferrer->last_name}} {{$myReferrer->first_name}} {{$myReferrer->middle_name}}</span>
                </a>
            </div>
            <hr />
        @endif

        @if(count($myInvitees))
            <div class="subtitle">
                <h4>Я пригласил</h4>
            </div>
            <hr />
            @foreach ($myInvitees as $user)
                <div class="col-sm-12 col-md-4 referrer">
                    <a class="item-photo" href="{{route('profile.show', ['id'=>$user->getLink()])}}">
                        @if($user->photo)
                            <img width="90px" src="/images/users_photos/{{$user->photo}}">
                        @else
                            <img width="90px" src="{{config('app.placeholder_url')}}90x90/00d2ff/ffffff">
                        @endif
                    </a>
                    <a href="{{route('profile.show', ['id'=>$user->getLink()])}}">
                        <span>{{$user->last_name}} {{$user->first_name}} {{$user->middle_name}}</span>
                    </a>
                </div>
            @endforeach
            {{$myInvitees->links()}}
        @else
            <div class="subtitle">
                <h4>Вы еще ни кого не пригласили</h4>
            </div>
        @endif
    </div>
@endsection