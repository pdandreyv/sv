@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9">
        <div class="title">
            <h3>{{$page_title}}</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{route($create_route)}}" class="btn btn-info add_product_button">
                <span>{{$add_title}}</span>
            </a>
        </div>
        <hr />
        @if(count($products))
            <table class="table drv-table">
                <thead>
                    <tr class="product-table-thead">
                        <th>Фото</th>
                        <th>Название</th>
                        @if(!$is_service)
                            <th>Кол-во</th>
                        @endif
                        <th>Цена</th>
                        <th>Цена для кооператива</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="client_info">
                            <td class="item-photo-container">
                                <a class="item-photo-75" href="{{ route($update_route, ['id' => $product->id]) }}">
                                    @if($product->image()->where('main', 1)->first())
                                        <img width="75px" src="images/products/{{ $product->image()->where('main', 1)->first()->new_name }}">
                                    @else
                                        <img width="75px" src="{{config('app.placeholder_url')}}75x75/00d2ff/ffffff">
                                    @endif
                                </a>
                            </td>
                            <td>
                                <a href="{{ route($update_route, ['id' => $product->id]) }}">
                                    <span>{{$product->title}}</span>
                                </a>
                            </td>
                            @if(!$is_service)
                                <td>
                                    <span>{{$product->quantity}}</span>
                                </td>
                            @endif
                            <td>
                                <span>{{$product->price}}</span>
                            </td>
                            <td>
                                <span>{{$product->cooperative_price}}</span>
                            </td>
                            <td>
                                @if ( (isset($product->is_confirmed)) && ($product->is_confirmed =='1'))
                                    <span class="approve text-success" title="Подтвержден"><i class="fas fa-check"></i></span>
                                @else
                                    <span class="not-approve text-danger" title="Не подтвержден"><i class="fas fa-times"></i></span>
                                @endif
                            </td>
                            <td class="table-control">
                                <a href="{{ route($update_route, ['id' => $product->id]) }}">
                                    <span><i class="fas fa-edit"></i></span>
                                </a>
                                <a href="{{ route($delete_route, ['id' => $product->id]) }}" onclick="var result = confirm('Вы действительно хотите удалить товар?'); if(!result) return false;">
                                    <span><i class="fas fa-trash-alt"></i></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$products->links()}}
        @else
            <h4>Вы ещё не добавляли товары</h4>
        @endif
    </div>

@endsection