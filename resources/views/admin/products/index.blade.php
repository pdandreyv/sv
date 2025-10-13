@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Товары и Услуги</h3>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-8">
                <a href="{{route('admin.products.create')}}" class="btn btn-info add_product_button"> Добваить товар/услугу</a>
            </div>
        </div>
        <hr>
        <ul class="nav nav-tabs d-flex flex-row" id="productTabs" role="tablist">
            <li class="nav-item goods active">
                <a class="nav-link active" id="goods-tab" data-toggle="tab" href="#goods" role="tab" aria-controls="goods" aria-selected="true">Товары</a>
            </li>
            <li class="nav-item services">
                <a class="nav-link" id="services-tab" data-toggle="tab" href="#services" role="tab" aria-controls="services" aria-selected="false">Услуги</a>
            </li>
        </ul>
        <div class="tab-content clearfix" id="categoryTabContent">
            <div class="tab-pane fade active in" id="goods" role="tabpanel" aria-labelledby="goods-tab">
                @include('admin.products.items', ['products' => $products, 'service'=> 0])
            </div>
            <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                @include('admin.products.items', ['products' => $products, 'service'=> 1])
            </div>
        </div>
        {{$products->links()}}

    </div>

@endsection