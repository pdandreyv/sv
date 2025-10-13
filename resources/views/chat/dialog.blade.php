@extends('layouts.app')

@section('content')

@include('parts.sidebar')
<div class="col-md-9">
<div class="row form-group">
    <a href="{{ url()->previous() }}" class="btn btn-info"><i class="fas fa-arrow-left"></i>
    Назад</a>
</div>
<br>
<div class="products-block-up">
    <div class="row">        
        <span class="product-block-bread">ДИАЛОГ С <span id="name-edit-wrapper"><a href="#">{{$chatName}}</a></span></span>        
    </div>
</div>
<hr>

<div class="row">
<p>Список участников: </p>&nbsp;&nbsp;
@foreach($members as $idx=>$member)
    @php
    if(!empty($member->user->last_name.' '.$member->user->first_name.' '.$member->user->middle_name)){
        $memberName = $member->user->last_name.' '.$member->user->first_name.' '.$member->user->middle_name;
    } else {
        $memberName = $member->name;
    }
    @endphp
    <a href="{{route('profile.show', ['id'=>$member->id])}}"><span>{{$member->user->last_name}} {{$member->user->first_name}} {{$member->user->middle_name}}</span></a>
    @if($idx!=count($members)-1)
    ,&nbsp;
    @endif
@endforeach
</div>
<hr>

<div class="row">   
    <div class="form-group"> 
        <button id="add-member" class="btn btn-primary">Добавить участника</button>    
    </div>
</div>

<form action="{{route('chat.add-members')}}" id="add-member-form" method="post" class="form-horizontal" style="display:none">
    {{ csrf_field() }}    

    <input type="hidden" name="chat_id" id="chat_id" value="{{$chatId}}">

    <div class="users-block">
        <div class="form-group">                   
            <div class="user-block">
                <div class="wrapper-dropdown">            
                    <input type="text" class="user-name form-control" value="" autocomplete="off"  required="required" >
                    <input type="hidden" name="to_user_id[]" class="user_to_id" value="">                   
                    <ul class="users-dropdown"></ul>
                </div> 
            </div>        
        </div> 
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
</form>

<table class="table tproduct-table">    
    <tbody>
        @foreach ($dialog as $message)            
            <tr>
                <td>
                    <p><b>                    
                    {{$message->user->name}}                    
                    </b></p>
                    <p><i>
                    {{$message->created_at}}
                    </i></p>
                    <p>
                    {{$message->text}}
                    </p>
                </td>
                <td class="table-control">
                    @php                    
                    $messageDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at);
                    $mesTime = $messageDateTime->getTimestamp();
                    $curTime = time();                    
                    $diff = $curTime - $mesTime;                                        
                    @endphp
                    @if($diff<=600 && $message->user->id == Auth::user()->id)
                    <a href="{{ route('chat.message.update', ['id' => $message->id]) }}"><span><i class="fas fa-edit"></i></span></a>
                    <a href="{{ route('chat.message.delete', ['id' => $message->id]) }}" onclick="var result = confirm('Вы действительно хотите удалить сообщение?'); if(!result) return false;"><span><i class="fas fa-trash-alt"></i></span></a>
                    @endif
                </td>               
            </tr>
        @endforeach
    </tbody>
</table>

<form action="{{route('chat.message.store-answer')}}" method="post" class="form-horizontal">
    {{ csrf_field() }}        
    
    <div class="form-group">    
    <div class="products-block-up">
        <div class="row">
            <div class="col-md-8">
                <span class="product-block-bread">ОТВЕТ</span>
            </div>
        </div>
    </div>
    <hr>
    </div>
             
    <input type="hidden" name="chat_id" value="{{ $chatId }}">                 

    <div class="form-group">        
        <label for="name">ТЕКСТ СООБЩЕНИЯ</label>
        <input type="text" name="text" class="form-control" required="required">        
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
</form>

</div>

<script src="{{ asset('js/users/group-user-dropdown.js') }}"></script>

<script type="text/javascript">
    $('#add-member').on('click', function(event) {        
        var formVisible = $('#add-member-form').is(":visible");
        if(formVisible){
            addNewUserInput();
        } else {
            $('#add-member-form').show();
        }

    });

    $('#name-edit-wrapper').on('click', function(event) {
        var aElem = $(this).find('a');        
        if(aElem.length){
            var oldName = $(this).find('a').text();
            aElem.remove();
            var inputHTML = '<input type="text" class="form-control" id="change-nane-input" value="'+ oldName +'">';
            $(this).append(inputHTML);
        }        
    });

    $('#name-edit-wrapper').on('keyup', '#change-nane-input', function(event) {
        var inputElem = $(this);
        if(event.keyCode==13){  
            var name = $(this).val();
            var chat_id = $('#chat_id').val();
            $.ajax({
                url: '/chat/change-name',
                type: 'post',
                dataType: 'json',
                data: {
                    name: name,
                    chat_id: chat_id
                },
                async: false,
                success: function(data) {
                    if(data.state == 'success'){                           
                        inputElem.remove();
                        var aHTML = '<a href="#">'+name+'</a>';
                        $('#name-edit-wrapper').append(aHTML);
                    }                              
                }
            });
        };
    });

</script>

<style type="text/css">
    #change-nane-input{
        width: 600px;
        display: inline-block;
    }
</style>

@endsection