@extends('layouts.app')

@section('content')
    <div class="title">
        <h2>{{$product->title}}</h2>
    </div>
    {{-- Хлебные крошки --}}
    @if(!empty($breadcrumb) && count($breadcrumb))
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.goods') }}">Категории</a></li>
                @foreach($breadcrumb as $bc)
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.category', ['category_id' => $bc->id]) }}">{{$bc->title}}</a>
                    </li>
                @endforeach
                <li class="breadcrumb-item active" aria-current="page">{{$product->title}}</li>
            </ol>
        </nav>
    @endif
    <hr style="border-top: 3px solid #eeeeee;">
    <div class="row product">
        <?php $images = $product->image()->where('main', 1)->first(); ?>
        <div class="product row">
            <div class="media col-4">
                <div class="photo row">
                    @if ($images && file_exists(public_path().'/images/products/'.$images->new_name))
                        <img src="/images/products/{{$images->new_name}}" alt="{{$product->title}}">
                    @else
                        <img src="/images/placeholder.png" alt="temporary_no_photo">
                    @endif
                </div>
            </div>
            <div class="info col-6">
                <div class="title">
                    <h4>Информация</h4>
                </div>
                <div class="price">
                    <strong>Цена: </strong><span>{{$product->price}}</span><span> грн</span>
                </div>
                @if(!$product->is_service)
                <div class="production_place">
                    <strong>Место производства: </strong><span>{{$product->production_place}}</span><span></span>
                </div>
                @endif

                <div class="description">
                    <strong>Описание: </strong>{{$product->description}}
                </div>                
                <div class="col-12 add_cart">
                    <input type="number" class="form-control quantity" name="" value="1"/>
                    <input type="button" class="add_cart_btn btn" class="btn" value="В корзину"/>
                    <input type="hidden" class="product_id" value="{{$product->id}}"/>
                </div>
            </div>
            <div class="author col-2">
                <h4>Автор</h4>
                <a href="{{ route('profile.show', ['id' => $product->user_id]) }}">
                    <div class="photo">
                        @if ($product->user_photo)
                            <img src="/images/users_photos/{{$product->user_photo}}" alt="{{$product->title}}">
                        @else
                            <img src="/images/placeholder.png" alt="temporary_no_photo">
                        @endif
                    </div>
                    <div class="title">
                        {{$product->last_name.' '.\Illuminate\Support\Str::limit($product->first_name, 1,'.').\Illuminate\Support\Str::limit($product->middle_name, 1, '.')}}
                    </div>
                </a>
            </div>
        </div>
    </div>
    <hr style="border-top: 3px solid #eeeeee;">
@endsection