@extends('layouts.app')

@section('content')

@include('parts.sidebar')

<div class="col-md-9">

@if(!count($products))

<div class="products-block-up">
    <div class="row">
        <div class="col-md-8">
            <span class="product-block-bread">По запросу <strong>{{$searchText}}</strong> не найдено ни одного товара</span>
        </div>
    </div>
</div>
<hr>
    
@else    

<div class="products-block-up">
    <div class="row">
        <div class="col-md-8">
            <span class="product-block-bread">РЕЗУЛЬТАТЫ ПОИСКА ПО <strong>{{$searchText}}</strong></span>
        </div>
    </div>
</div>
<hr>
<table class="table tproduct-table">
    <thead>
    <tr class="product-table-thead">        
        <th>ФОТО</th>        
        <th>НАИМЕНОВАНИЕ</th>
        <th>ЦЕНА</th>        
    </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            <tr class="client_info">
                <td>
                    @if($product->image()->where('main', 1)->first())
                    <a href="{{route('products.product', ['product_id'=>$product->id])}}">
                    <img width=100 src="images/products/{{ $product->image()->where('main', 1)->first()->new_name }}">
                    </a>
                    @endif
                </td>  
                <td>
                    <a href="{{route('products.product', ['product_id'=>$product->id])}}">
                    {{$product->title}}
                    </a>
                </td>               
                <td>{{$product->price}}</td>                
            </tr>
        @endforeach
    </tbody>
</table>

{{$products->appends($_GET)->links()}}

@endif

</div>

@endsection