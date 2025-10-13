@extends('layouts.app')

@section('content')

@include('parts.sidebar')

    <div class="col-md-9">
        <div class="title">
            <h3>Перевод денежных средств</h3>
        </div>
        @if (session()->has('sucсess'))
            <hr />
            <div class="form-group alert alert-success">
                <span>{{session()->pull("sucсess")}}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <hr />
            <div class="form-group alert alert-erorr">
                <span>{{session()->pull("erorr")}}</span>
            </div>
        @endif
        <hr />
        <form method="post" class="form-horizontal" action="{{ route('money.transfer.post') }}">
            {{ csrf_field() }}

            <div class="form-group col-sm-12 col-md-6">
                <label for="user_name">Получатель перевода</label>
                <div class="wrapper-dropdown">
                <div class="users-block">
                    <input type="text" id="user-name" name='user_name' class="form-control" value="{{old('user_name')?old('user_name'):(isset($userTo)?$userTo->name:'')}}" autocomplete="off">
                    <input type="hidden" name="to_user_id" id="user_to_id" value="{{old('to_user_id')}}">
                </div>
                <ul class="users-dropdown"></ul>
                </div>
            </div>
            @if($errors->has('to_user_id'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('to_user_id') }}
                </div>
            @endif

            <div class="form-group col-sm-12 col-md-6">
                <label for="sum">Сумма перевода</label>
                <input type="text" name="sum" id="insert_sum" class="form-control" value="{{old('sum')}}" required>
            </div>
            @if($errors->has('sum'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('sum') }}
                </div>
            @endif

            <div class="form-group col-sm-12">
                <button type="submit" class="btn btn-success">Перевести</button>
            </div>

        </form>

    </div>

    <script src="{{ asset('js/users/user-dropdown.js') }}"></script>

@endsection

