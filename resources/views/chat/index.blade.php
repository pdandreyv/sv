@extends('layouts.app')

@section('content')

@include('parts.sidebar')
    @php
        use App\User;
    @endphp
    <div class="col-md-9">
        <div class="title">
            <h3>Мои сообщения</h3>
        </div>
        <hr class="col-md-12"/>
        <div class="col-md-12">
            <a href="{{route('chat.message')}}" class="btn btn-primary">
                <span>Написать сообщение</span>
            </a>
        </div>
        <hr class="col-md-12" />

        <table class="table table-messages">
            <tbody>
                @foreach ($chats as $chat)
                    @php
                        $style = ($chat->not_all_message_read)?"font-weight:bold":'';
                    @endphp
                    <tr style="{{$style}}">
                        <td>
                            <a href="{{route('chat.dialog', ['id'=>$chat->chat_id])}}">
                                <img width="100px" src="{{$chat->chat_display_photo}}">
                            </a>
                        </td>
                        <td>
                            <a href="{{route('chat.dialog', ['id'=>$chat->chat_id])}}">
                            {{$chat->chat_display_name}}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('chat.dialog', ['id'=>$chat->chat_id])}}">
                                {{$chat->last_message_date}}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
