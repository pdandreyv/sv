@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">

<form action="{{route('admin.operations.create')}}" class="form-horizontal" method="get">
    {{ csrf_field() }}
    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><-Назад</a>
    <h4>Добавить финансовую операцию</h4><hr>  
    </div>      
    <div class="form-group">
        <label for="name">ТИП ОПЕРАЦИИ</label>
        <select name="operation_type_id" class="form-control">
            <option value=""></option>            
            @foreach ($types as $type)
                @php
                    $selected = (old('operation_type_id')!==null && $type->id == old('operation_type_id'))?'selected="selected"':'';
                @endphp
                <option value="{{$type->id}}" {{$selected}}>{{$type->name}}</option>
            @endforeach
        </select>        
    </div>  
    @if($errors->has('operation_type_id'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('operation_type_id') }}
        </div>
    @endif                   
    <div class="form-group">        
        <button type="submit" class="btn btn-primary">Продолжить</button>
    </div>
</form>

</div>

@endsection