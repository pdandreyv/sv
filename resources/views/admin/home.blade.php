@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="alert alert-success" role="alert">{{$userName}}, Приветствуем вас в панели администрирования</div>
    </div>

@endsection