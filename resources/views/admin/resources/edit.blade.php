@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>{{$page_title}}</h3>
        </div>
        <hr />
        <div class="btn-container form-group">
            <a href="{{ route($back_route) }}" class="btn btn-info btn-back"><i class="fas fa-arrow-left"></i>Назад</a>
        </div>
        <hr />
        <div class="alert alert-info">
            <span>Поля помеченные <span class="text-danger">*</span> обязательны к заполнению.</span>
        </div>
        <form action="{{ route($form_route, ['id' => isset($resource)?$resource->id:0]) }}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="required">Название</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ isset($resource) ? $resource->name : old('name') }}">
                @if ($errors->has('name'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="unit_id" class="required">Единица измерения</label>
                <select name="unit_id" id="unit_id" required>
                    <option selected value> -- выбрать -- </option>
                    @foreach ($units as $unit) >
                        <option value="{{$unit->id}}" {{isset($resource) ? ($unit->id == $resource->unit_id ? 'selected' : '') : false}}>{{$unit->description}}</option>
                    @endforeach
                </select>
                @if ($errors->has('unit_id'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('unit_id') }}
                    </div>
                @endif
            </div>
            <div id="categories-area" class="form-group">
                <label class="col-md-12 required">Категория</label>
                @include('admin.resources.categories', ['categories' => $categories, 'current' => isset($resource) ? $resource->category_id : false])
                @if ($errors->has('category_id'))
                    <div class="col-md-12 form-group alert alert-danger">
                        {{ $errors->first('category_id') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">{{$submit_title}}</button>
            </div>
        </form>
    </div>

@endsection