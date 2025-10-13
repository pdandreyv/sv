@extends('layouts.app')

@section('content')

@include('parts.sidebar')


<h4>Период изменения/удаления данного сообщения истек</h4>
<a href="{{route('chat.chats.list')}}">Перейти в мои сообщения</a>
@endsection