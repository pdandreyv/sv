@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Управление категориями</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.product-categories.create') }}" class="btn btn-info btn-add">Добавить корневую категорию</a>
        </div>
        <hr />
        @if (session()->has('sucсess'))
            <div class="form-group alert alert-success">
                <span>{{session()->pull("sucсess")}}</span>
            </div>
            <hr />
        @endif
        @if (session()->has('erorr'))
            <hr />
            <div class="form-group alert alert-erorr">
                <span>{{session()->pull("erorr")}}</span>
            </div>
        @endif
        <ul class="nav nav-tabs d-flex flex-row" id="categoryTab" role="tablist">
            <li class="nav-item goods active">
                <a class="nav-link active" id="goods-tab" data-toggle="tab" href="#goods" role="tab" aria-controls="goods" aria-selected="true">Категории товаров</a>
            </li>
            <li class="nav-item services">
                <a class="nav-link" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="false">Категории услуг</a>
            </li>
        </ul>
        <div class="tab-content clearfix" id="categoryTabContent">
            <div class="tab-pane fade active in" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                @include('admin.product_categories.category', ['categories' => $categories, 'service'=> 0])
            </div>
            <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                @include('admin.product_categories.category', ['categories' => $categories, 'service'=> 1])
            </div>
        </div>
    </div>

@endsection