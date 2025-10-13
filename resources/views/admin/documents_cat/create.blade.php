@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">

        <form action="{{route('admin.documents_cat.store')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a>
                <h4>Добавить Категорию</h4><hr>
            </div>
            <div class="form-group">
                <label for="name">ИМЯ КАТЕГОРИИ</label>
                <input required type="text" name="name" class="form-control" value="{{old('name')}}">
            </div>
            @if($errors->has('name'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
            <div class="form-group">
                <label for="name">Код</label>
                <input type="text" name="code" class="form-control" value="{{old('code')}}" >
            </div>
            @if($errors->has('code'))
                <div class="form-group alert alert-danger">
                    Поле "Код" может принимать Только латинские символы
                </div>
            @endif

            <div class="form-group">
                <label for="access">РОЛЬ</label>
                <select multiple="multiple" name="role[]" placeholder="Select roles..." class="SlectBox">
                    @foreach ($roles as $role)
                        @php
                            $selected = (old('role')!==null && in_array($role->id, old('role')))?'selected="selected"':'';
                        @endphp
                        <option value="{{$role->id}}" {{$selected}}>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.SlectBox').SumoSelect({ csvDispCount: 3, selectAll:true, captionFormatAllSelected: "Yeah, OK, so everything." });

            $('.SlectBox').on('sumo:opened', function(o) {
                console.log("dropdown opened", o)
            });

            $('.date').datepicker({
                timePicker: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
                language: 'ru',
                startDate: new Date(<?php echo date('Y-m-d') ?>)
            });
        });
    </script>

@endsection

