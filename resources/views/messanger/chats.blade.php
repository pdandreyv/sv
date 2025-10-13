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
        <hr class="col-md-12" />
        <div class="col-md-12">
            <a href="{{route('messanger.message')}}" class="btn btn-primary add_product_button">
                <span>Написать сообщение</span>
            </a>
        </div>
        <hr class="col-md-12" />
        <table class="table table-messages">
            <tbody>
                @foreach ($chats as $chat)
                    @php
                    $user = User::find($chat->contact_id);
                    $style = ($chat->all_message_read)?'':"font-weight:bold";
                    @endphp
                    <tr style="{{$style}}">
                        <td>
                            <a href="{{route('messanger.dialog', ['id'=>$user->id])}}">
                            @if($user->photo)
                		<img width="100px" src="/images/users_photos/{{$user->photo}}">
        		    @else
        		    	<img width="100px" src="{{config('app.placeholder_url')}}100x100/00d2ff/ffffff">
        		    @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{route('messanger.dialog', ['id'=>$user->id])}}">
                            {{$user->last_name}} {{$user->first_name}} {{$user->middle_name}}
                            </a>
                        </td>
                        <td>                    
                            <a href="{{route('messanger.dialog', ['id'=>$user->id])}}">
                            {{$chat->last_message_date}}
                            </a>                    
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
