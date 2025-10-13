@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Редактирование пользователя</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.documents_cat.index') }}" class="btn btn-info btn-add">Назад</a>
        </div>
        <hr />
        <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{route('admin.documents_cat.update', $documents_cat->id)}}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" name="name" class="form-control" value="{{$documents_cat->name}}" >
            </div>
            @if($errors->has('name'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
            <div class="form-group">
                <label for="name">Код</label>
                <input disabled type="text" name="code" class="form-control" value="{{$documents_cat->code}}" >
            </div>
            <div class="form-group">
                <label for="access">Роль</label>
                <select multiple="multiple" name="role[]" placeholder="Select roles..." class="SlectBox">
                    @foreach ($roles as $role)
                        @php
                            $selected = in_array($role->id, $documents_cat->roles()->get()->pluck('id')->toArray())?'selected="selected"':'';
                        @endphp
                        <option value="{{$role->id}}" {{$selected}}>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </div>
        </form>


        <hr />
        <script type="text/javascript">
            $(document).ready(function () {
                $('.SlectBox').SumoSelect({
                    csvDispCount: 3,
                    selectAll:true,
                    captionFormatAllSelected: "Yeah, OK, so everything."
                });
                $('.SlectBox').on('sumo:opened', function(o) {
                    console.log("dropdown opened", o)
                });
                var scanItemWidth = $('.scan-item').width();
                $('.scan-item').height(scanItemWidth);
            });

            $('.date').datepicker({
                timePicker: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
                language: 'ru',
                startDate: new Date(<?php echo date('Y-m-d') ?>)
            });

        </script>

    </div>
@endsection