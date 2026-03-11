@extends('layouts.app')

@section('content')
<section class="goods-catalog-page">
    <div class="title goods-page-title">
        <h2>{{$pageTitle}}</h2>
    </div>
    <div class="panel-categories goods-catalog-grid-wrap">
        <div class="row goods-catalog-grid">
            @foreach ($categories as $category)
                <div class="col-12 category-item goods-card-col">
                    <a href="{{ route('products.category', ['category_id' => $category->id]) }}" title="{{$category->description}}">
                        <div class="photo">
                            @if (!empty($category->photo))
                                <img class="cat-img" src="/images/product_category_photos/{{$category->photo}}" alt="{{$category->title}}">
                            @else
                                <img class="cat-img" src="/images/placeholder.png" alt="temporary_no_photo">
                            @endif
                        </div>
                        <div class="title">
                            <h3>{{$category->title}}</h3>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection