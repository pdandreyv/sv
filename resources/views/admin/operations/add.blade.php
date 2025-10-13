@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">

<form action="{{route('admin.operations.store')}}" class="form-horizontal" method="post">
    {{ csrf_field() }}
    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a>
    <h4>Добавить финансовую операцию</h4><hr>  
    </div>  
    <div class="form-group">
        <label for="name">ПОЛЬЗОВАТЕЛЬ</label>
        <select name="user_id" class="form-control">
            <option value=""></option>           
            @foreach ($users as $user)
                @php
                    $selected = (old('user_id')!==null && $user->id == old('user_id'))?'selected="selected"':'';
                @endphp
                <option value="{{$user->id}}" {{$selected}}>{{$user->name}}</option>
            @endforeach
        </select>        
    </div>
    @if($errors->has('user_id'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('user_id') }}
        </div>
    @endif
    <div class="form-group">
        <label for="sum">СУММА</label>
        <input type="text" name="sum" class="form-control" value={{old('sum')}}>
    </div>  
    @if($errors->has('sum'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('sum') }}
        </div>
    @endif 
    <input type="hidden" name="operation_type_id" value="{{old('operation_type_id')?old('operation_type_id'):$operationType->id}}"/>                  

    <div class="form-group">        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

</div>

@endsection

