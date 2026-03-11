@extends('layouts.app')

@section('content')
<section class="goods-catalog-page category-catalog-page">
    <div class="title goods-page-title">
        <h2>{{$currentCategory->title}}</h2>
    </div>

    @if(!empty($breadcrumb) && count($breadcrumb))
        <nav aria-label="breadcrumb" class="mb-3 category-breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.goods') }}">Категории</a></li>
                @foreach($breadcrumb as $idx => $bc)
                    @if($idx < count($breadcrumb) - 1)
                        <li class="breadcrumb-item">
                            <a href="{{ route('products.category', ['category_id' => $bc->id]) }}">{{$bc->title}}</a>
                        </li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{$bc->title}}</li>
                    @endif
                @endforeach
            </ol>
        </nav>
    @endif

    @if ($currentCategory->description)
        <div class="alert alert-info category-description">
            {!! $currentCategory->description !!}
        </div>
    @endif

    @if(isset($childCategories) && $childCategories->count() > 0)
        <div class="panel-categories goods-catalog-grid-wrap">
            <div class="row goods-catalog-grid">
                @foreach ($childCategories as $category)
                    <div class="col-12 category-item goods-card-col">
                        <a href="{{ route('products.category', ['category_id' => $category->id]) }}" title="{{$category->description}}">
                            <div class="photo">
                                @if ($category->photo && file_exists(public_path().'/images/product_category_photos/'.$category->photo))
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
    @else
        <div class="row category-products-grid">
            @foreach ($products as $product)
                @php $images = $product->image()->where('main', 1)->first(); @endphp
                <div class="col-lg-4 col-md-6 col-12 product-card-col">
                    <a href="{{ route('products.product', ['product_id' => $product->id]) }}" class="product-card-link" title="{{$product->title}}">
                        <div class="product-card">
                            <div class="product-card-photo">
                                @if ($images && file_exists(public_path().'/images/products/'.$images->new_name))
                                    <img src="/images/products/{{$images->new_name}}" alt="{{$product->title}}">
                                @else
                                    <img src="/images/placeholder.png" alt="temporary_no_photo">
                                @endif
                            </div>
                            <h4 class="product-card-title">{{$product->title}}</h4>
                            <div class="product-card-price">{{$product->price}} грн</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection