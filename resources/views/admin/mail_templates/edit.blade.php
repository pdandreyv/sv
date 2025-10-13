@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">

<form class="form-horizontal" method="post">
    {{ csrf_field() }}
    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><-Назад</a>
    <h4>Редактировать шаблон</h4><hr>  
    </div> 

    @php
    $readonly = '';
    if($template->is_standart){
        $readonly = 'readonly="readonly"';
    }
    @endphp

    <div class="form-group">
        <label for="name">АЛИАС</label>
        <input type="text" name="alias" class="form-control" value="{{$template->alias}}" {{$readonly}}>
    </div>
    @if($errors->has('alias'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('alias') }}
        </div>
    @endif

    <div class="form-group">
        <label for="title">ТЕМА</label>
        <input type="text" name="subject" class="form-control" value="{{$template->subject}}">
    </div>  
    @if($errors->has('subject'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('subject') }}
        </div>
    @endif         

    <div class="alert alert-info" role="alert">
        Вставляемые переменные: <strong>
        @php
        echo $template->used_vars;
        @endphp    
        </strong>
    </div>

    @if($errors->has('body'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('body') }}
        </div>
    @endif

    <div class="form-group">
        <label for="title">КОНТЕНТ</label>
        <textarea id="message_template_content" name="body" class="form-control">{{$template->body}}</textarea>
    </div>  
    
    <script>
        $(document).ready(function() {
            $('#message_template_content').summernote();
        });
    </script>

    <div class="form-group">        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

</div>

@endsection