@extends('layouts.app')

@section('content')
<section class="goods-catalog-page product-view-page">
    @if(!empty($breadcrumb) && count($breadcrumb))
        <nav aria-label="breadcrumb" class="mb-3 category-breadcrumbs">
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

    @php
        $mainImage = $productImages->firstWhere('main', 1) ?: $productImages->first();
        $mainImageSrc = ($mainImage && file_exists(public_path().'/images/products/'.$mainImage->new_name))
            ? '/images/products/'.$mainImage->new_name
            : '/images/placeholder.png';
        $authorName = trim(($product->last_name ?? '').' '.\Illuminate\Support\Str::limit($product->first_name ?? '', 1,'.').\Illuminate\Support\Str::limit($product->middle_name ?? '', 1, '.'));
    @endphp

    <div class="row product-main-grid">
        <div class="col-lg-7 col-md-12">
            <div class="product-main-media">
                <div class="product-main-photo">
                    <img id="product-main-image" src="{{$mainImageSrc}}" alt="{{$product->title}}">
                </div>

                @if($productImages->count() > 1)
                    <div class="product-gallery-under">
                        @foreach($productImages as $image)
                            @php
                                $thumbSrc = file_exists(public_path().'/images/products/'.$image->new_name)
                                    ? '/images/products/'.$image->new_name
                                    : '/images/placeholder.png';
                            @endphp
                            <button type="button" class="product-thumb-btn {{$thumbSrc === $mainImageSrc ? 'active' : ''}}" data-src="{{$thumbSrc}}">
                                <img src="{{$thumbSrc}}" alt="{{$product->title}}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-5 col-md-12">
            <div class="product-info-card">
                <div class="title goods-page-title">
                    <h2>{{$product->title}}</h2>
                </div>
                @if(!$product->is_service)
                    <div class="product-info-meta">Вес: {{$product->weight ?: '—'}}</div>
                    <div class="product-info-meta">В наличии: {{$product->quantity ?: '0'}} шт.</div>
                    @if($product->production_place)
                        <div class="product-info-meta">Место производства: {{$product->production_place}}</div>
                    @endif
                @endif

                <div class="add_cart product-purchase-box">
                    <div class="product-add-cart-row">
                        <div class="product-price-box">
                            <span>Цена:</span> {{$product->price}} грн
                        </div>
                        <div class="product-qty-box">
                            <button type="button" class="qty-btn qty-minus" aria-label="Уменьшить количество">−</button>
                            <input type="number" class="form-control quantity" value="1" min="1"/>
                            <button type="button" class="qty-btn qty-plus" aria-label="Увеличить количество">+</button>
                        </div>
                    </div>
                    <input type="hidden" class="product_id" value="{{$product->id}}"/>
                    <input type="button" class="add_cart_btn btn" value="Добавить в корзину"/>
                </div>

                <a href="{{ route('profile.show', ['id' => $product->user_id]) }}" class="product-author-link">
                    <span>Автор: {{$authorName}}</span>
                </a>
            </div>
        </div>
    </div>

    @if($product->description)
        <div class="product-description-card">
            <h4>Описание</h4>
            <p>{!! nl2br(e($product->description)) !!}</p>
        </div>
    @endif

    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="product-related">
            <h3>С этим товаром покупают</h3>
            <div class="row category-products-grid product-related-grid">
                @foreach($relatedProducts as $relatedProduct)
                    @php
                        $relatedMainImage = $relatedProduct->image()->where('main', 1)->first() ?: $relatedProduct->image()->first();
                        $relatedImageSrc = ($relatedMainImage && file_exists(public_path().'/images/products/'.$relatedMainImage->new_name))
                            ? '/images/products/'.$relatedMainImage->new_name
                            : '/images/placeholder.png';
                    @endphp
                    <div class="col-lg-3 col-md-6 col-12 product-card-col">
                        <a href="{{ route('products.product', ['product_id' => $relatedProduct->id]) }}" class="product-card-link" title="{{$relatedProduct->title}}">
                            <div class="product-card">
                                <div class="product-card-photo">
                                    <img src="{{$relatedImageSrc}}" alt="{{$relatedProduct->title}}">
                                </div>
                                <h4 class="product-card-title">{{$relatedProduct->title}}</h4>
                                <div class="product-card-price">{{$relatedProduct->price}} грн</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>

<script>
    $(document).ready(function () {
        $('.product-gallery-under').on('click', '.product-thumb-btn', function () {
            var src = $(this).data('src');
            if (!src) return;
            $('#product-main-image').attr('src', src);
            $('.product-thumb-btn').removeClass('active');
            $(this).addClass('active');
        });

        $('.product-add-cart-row').on('click', '.qty-minus, .qty-plus', function () {
            var $qty = $(this).closest('.product-qty-box').find('.quantity');
            var current = parseInt($qty.val(), 10);
            if (isNaN(current) || current < 1) current = 1;
            if ($(this).hasClass('qty-minus')) {
                current = Math.max(1, current - 1);
            } else {
                current += 1;
            }
            $qty.val(current);
        });
    });
</script>
@endsection