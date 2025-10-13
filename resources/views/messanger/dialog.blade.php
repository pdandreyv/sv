@extends('layouts.app')

@section('content')

@include('parts.sidebar')

<div class="col-md-9">

<div class="form-group row btn-container">
<a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a>
</div>
<br>
<div class="products-block-up">
    <div class="row">
        <div class="col-md-8">
            <span class="product-block-bread">ДИАЛОГ С {{$contact->name}}</span>
        </div>
    </div>
</div>
<hr>

<table class="table drv-table">    
    <tbody>
        @foreach ($dialog as $message)            
            <tr>
                <td>
                    <p><b>
                    @if($message->from_user_id == Auth::user()->id)
                    {{Auth::user()->name}}
                    @else
                    {{$contact->name}}
                    @endif
                    </b></p>
                    <p><i>
                    {{$message->created_at}}
                    </i></p>
                    <p>
                    {{$message->message_text}}
                    </p>
                </td>
                <td class="table-control">
                    @php                    
                    $messageDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $message->created_at);
                    $mesTime = $messageDateTime->getTimestamp();
                    $curTime = time();                    
                    $diff = $curTime - $mesTime;                                        
                    @endphp
                    @if($diff<=600 && $message->from_user_id == Auth::user()->id)
                    <a href="{{ route('messanger.message.store', ['id' => $message->id]) }}"><span><i class="fas fa-edit"></i></span></a>
                    <a href="{{ route('messanger.delete', ['id' => $message->id]) }}" onclick="var result = confirm('Вы действительно хотите удалить сообщение?'); if(!result) return false;"><span><i class="fas fa-trash-alt"></i></span></a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<form action="{{route('messanger.message.store')}}" method="post" class="form-horizontal">
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
             
    <input type="hidden" name="to_user_id" id="user_to_id" value="{{ $contact->id }}">                 

    <div class="form-group">        
        <label for="name">ТЕКСТ СООБЩЕНИЯ</label>
        <input type="text" name="message_text" class="form-control" value="{{old('message_text')}}" >        
    </div>
    @if($errors->has('message_text'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('message_text') }}
        </div>
    @endif
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
</form>

</div>

@endsection