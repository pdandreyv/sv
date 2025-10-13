@extends('layouts.app')

@section('content')

@include('parts.sidebar')

<div class="col-md-9">

    <form action="{{route('chat.message.update.post', ['id' => $message->id])}}" method="post" class="form-horizontal">
    {{ csrf_field() }}    

    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a></br>
    </div>
    
    <div class="form-group">    
    <div class="products-block-up">
        <div class="row">
            <div class="col-md-8">
                <span class="product-block-bread">РЕДАКТИРОВАНИЕ СООБЩЕНИЯ</span>
            </div>
        </div>
    </div>
    <hr>
    </div>

    <div class="form-group">        
        <label for="name">ТЕКСТ СООБЩЕНИЯ</label>
        <input type="text" name="text" class="form-control" value="{{$message->text}}" >        
    </div>
    @if($errors->has('text'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('text') }}
        </div>
    @endif
    
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Отправить</button>
    </div>
</form>

</div>

@endsection