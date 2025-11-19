@extends('layouts.app')

@section('content')
    <div class="title">
        <h2>{{$currentCategory->title}}</h2>
    </div>

    {{-- Хлебные крошки --}}
    @if(!empty($breadcrumb) && count($breadcrumb))
        <nav aria-label="breadcrumb" class="mb-3">
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
        <div class="col-12 row description">
            <br><br>
            <div class="alert alert-info col-12">
                {!! $currentCategory->description !!}
            </div>
        </div>
    @endif

    {{-- Если есть подкатегории, рисуем их как на главной странице категорий и НЕ показываем список товаров --}}
    @if(isset($childCategories) && $childCategories->count() > 0)
        <div class="panel-categories">
            <br>
            <div class="row">
                @foreach ($childCategories as $category)
                    <div class="col-md-2 category-item">
                        <a href="{{ route('products.category', ['category_id' => $category->id]) }}" title="{{$category->description}}">
                            <div class="photo">
                                @if ($category->photo && file_exists(public_path().'/images/product_category_photos/'.$category->photo))
                                    <img class="cat-img" src="/images/product_category_photos/{{$category->photo}}" alt="{{$category->title}}">
                                @else
                                    <img src="/images/placeholder.png" alt="temporary_no_photo">
                                @endif
                            </div>
                            <div class="title">
                                <h3>{{$category->title}}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <br><br>
        </div>
    @else

        <table class="table table-bordered table-categories">
          <tr>
            <td class="col-md-2"><div class="title-item link">
                        <h4>Название</h4>
                </div></td>
            <td class="col-md-8"><div class="title-item">
                        <h4>Описание</h4>
                    </div></td>
            <td class="col-md-2"><div class="title-item author">
                        <h4>Автор</h4>
                    </div></td>
               
          </tr>
           @foreach ($products as $product)
            <?php $images = $product->image()->where('main', 1)->first(); ?>
          <tr>
            <td class="col-md-2">
                <a href="{{ route('products.product', ['product_id' => $product->id]) }}" title="{{$product->title}}">
                    <div class="photo">
                        @if ($images && file_exists(public_path().'/images/products/'.$images->new_name))
                            <img src="/images/products/{{$images->new_name}}" alt="{{$product->title}}">
                        @else
                            <img src="/images/placeholder.png" alt="temporary_no_photo">
                        @endif
                    </div>
                 </a>
            </td>
            <td class="col-md-8">
               <a href="{{ route('products.product', ['product_id' => $product->id]) }}" title="{{$product->title}}" class="col-12">
                        <div class="title">
                            <h4>{{$product->title}}</h4>
                        </div>
                    </a>
                    <div class="col-12 description">
                        {{$product->description}}
                    </div>
                    <div class="col-12 production_place">
                        <p><strong>Место производства:</strong> {{$product->production_place}}</p>
                    </div>
                    <div class="col-12 price">
                        <p><strong>Цена:</strong> {{$product->price}} грн</p>
                    </div>
                    @if(!$product->is_service)
                    <div class="col-12 add_cart">
                        <input type="number" class="form-control quantity" name="" value="1"/>
                        <input type="button" class="add_cart_btn btn" class="btn" value="В корзину"/>
                        <input type="hidden" class="product_id" value="{{$product->id}}"/>
                    </div>
                    @endif
            </td>
            <td class="col-md-2">
               <a href="{{ route('profile.show', ['id' => $product->user_id]) }}">
                        <div class="title">
                            <h4>{{$product->last_name.' '.str_limit($product->first_name, 1,'.').str_limit($product->middle_name, 1, '.')}}</h4>
                        </div>
                        <div class="photo">
                            @if ($product->user_photo)
                                <img src="/images/users_photos/{{$product->user_photo}}" alt="{{$product->title}}">
                            @else
                                <img src="/images/placeholder.png" alt="temporary_no_photo">
                            @endif
                        </div>
                    </a>
            </td>     
          </tr>
          @endforeach
        </table>
    @endif
    </div>
    
@endsection