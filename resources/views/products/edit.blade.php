@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <link href="{{ asset('css/uploader/jquery.dm-uploader.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/uploader/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/uploader/my-styles.css') }}" rel="stylesheet">

    <script src="{{ asset('js/uploader/config.js') }}"></script>
    <script src="{{ asset('js/uploader/jquery.dm-uploader.min.js') }}"></script>
    <script src="{{ asset('js/uploader/ui.js') }}"></script>
   
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
        <form action="{{ route($form_route, ['id' => isset($product->id)?$product->id:0]) }}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div id="categories-area" class="form-group">
                @include('products.categories-dropdown', [
                    'categories' => $categories, 
                    'current_main' => isset($product) ? ($product->category->parent_id ? $product->category->parent_id : $product->category_id) : false,
                    'current_sub' => isset($product) ? ($product->category->parent_id ? $product->category_id : false) : false
                ])
                @if ($errors->has('category_id'))
                    <div class="col-md-12 form-group alert alert-danger">
                        {{ $errors->first('category_id') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="title" class="required">Название</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ isset($product) ? $product->title : old('title') }}">
                @if ($errors->has('title'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
            <div class="form-group required">
                <label for="description" class="required">Описание</label>
                <textarea  type="textarea" id="description" name="description" class="form-control" rows="5">{{ isset($product) ? $product->description : old('description') }}</textarea>
                @if ($errors->has('description'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-sm-12 col-md-6 right">
                <label for="cooperative_price" class="required">Цена для кооператива</label>
                <input type="number" id="cooperative_price" name="cooperative_price" class="form-control" min="0" step="0.01" value="{{ isset($product) ? $product->cooperative_price : old('cooperative_price') }}">
                @if ($errors->has('cooperative_price'))
                    <div class="form-group alert alert-danger ">
                        {{ $errors->first('cooperative_price') }}
                    </div>
                @endif
            </div>
            <div class="form-group col-sm-12 col-md-6 left">
                <label for="price" class="required">Цена</label>
                <input type="number" id="price" name="price" class="form-control" min="0" step="0.01" value="{{ isset($product) ? $product->price : old('price') }}">
                @if ($errors->has('price'))
                    <div class="form-group alert alert-danger">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>
            @if (!$is_service)
                <div class="form-group">
                    <label for="production_place" class="required">Место производства</label>
                    <input type="text" id="production_place" name="production_place" class="form-control" value="{{ isset($product) ? $product->production_place: old('production_place' )}}">
                    @if ($errors->has('production_place'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('production_place') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-sm-12 col-md-6 right">
                    <label for="quantity">Количество</label>
                    <input type="text" id="quantity" name="quantity" class="form-control" value="{{ isset($product) ? $product->quantity : old('quantity') }}">
                    @if ($errors->has('quantity'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('quantity') }}
                        </div>
                    @endif
                </div>
                <div class="form-group col-sm-12 col-md-6 left">
                    <label for="weight">Вес</label>
                    <input type="text" id="weight" name="weight" class="form-control" value="{{ isset($product) ? $product->weight : old('weight')}}" >
                    @if ($errors->has('weight'))
                        <div class="form-group alert alert-danger">
                            {{ $errors->first('weight') }}
                        </div>
                    @endif
                </div>
            @endif
            @include('parts.uploader')
            <input type="hidden" name="is_service" value="{{$is_service}}">
            <div class="form-group">
                <button type="submit" class="btn btn-success">{{$submit_title}}</button>
            </div>
        </form>
    </div>
@endsection