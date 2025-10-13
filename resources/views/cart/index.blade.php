@extends('layouts.app')

@section('content')

@include('parts.sidebar')

<div class="col-md-9">
    <div class="title">
        <h3>
            @if(count($cartItems))
                <span>Корзина</span>
            @else
                <span>Корзина пуста</span>
            @endif
        </h3>
    </div>
    <hr>
    @if(count($cartItems))
        <table class="table cart-items">
            <thead>
            <tr class="product-table-thead">
                <th></th>
                <th></th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Итого</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($cartItems as $cartItem)
                    <tr class="client_info">
                        <td>
                            <a href="{{route('products.product', ['product_id'=>$cartItem->product->id])}}">
                            {{$cartItem->product->title}}
                            </a>
                        </td>
                        <td>
                            @if($cartItem->product->image()->where('main', 1)->first())
                            <a href="{{route('products.product', ['product_id'=>$cartItem->product->id])}}">
                            <img width=100 src="images/products/{{ $cartItem->product->image()->where('main', 1)->first()->new_name }}">
                            </a>
                            @endif
                        </td>
                        <td>
                            <input product-id="{{$cartItem->product_id}}" product-price="{{$cartItem->price}}"type="number" class="form-control cart-item-quantity" value="{{$cartItem->quantity}}"/>
                        </td>
                        <td>
                            {{number_format($cartItem->price, 2, ',', ' ')}}
                        </td>
                        <td>  
                            @php
                                $rowTotal = $cartItem->price*$cartItem->quantity;
                                $total += $rowTotal;
                            @endphp
                            <span class="cart-item-total">{{number_format($rowTotal, 2, ',', ' ')}}</span>
                        </td>
                        <td>
                            <span product-id="{{$cartItem->product_id}}" product-price="{{$cartItem->price}}" class="cart-item-remove"><i class="fa fa-trash-alt"></i></span>
                        </td>
                    </tr>
                @endforeach
                <tr class="client_info cart-total">
                    <td colspan="4">
                        <span>Общая сумма заказа</span>
                    </td>
                    <td>
                        <span id="page-cart-total">{{number_format($total, 2, ',', ' ')}}</span>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <a class="btn btn-primary" id="makeOrderBtn">Оформить Заказ</a>
    @else
        <div class="empty-cart">
            <div class="header">
                <span>Ой! В корзине ничего нет.</span>
            </div>
            <div>
                <span>Добавьте <a href="{{route('products.goods')}}" title="Товары">товары</a> и/или <a href="{{route('products.services')}}" title="Товары">услуги</a> в корзину</span>
            </div>
        </div>
    @endif
</div>
<!-- Modal -->
<div class="modal fade" id="noMoneyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">      
      <div class="modal-body">
        <p>На вашем балансе недостаточно средств. Пожалуйста, пополните счет для завершения покупки!</p>
      </div>
      <div class="modal-footer">            
        <a class="btn btn-primary" href="{{route('replenish.balance.back-page', ['page'=>'cart'])}}">Пополнить баланс</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>        
      </div>
    </div>
  </div>
</div>

<script>
    $('.cart-item-remove').on('click', function(e) { 
        var actionConfirm = confirm("Вы действительно желаете удалить товар из корзины?");       
        
        if(!actionConfirm) return;

        var product_id = $(this).attr('product-id');
        var product_price = $(this).attr('product-price');
        var iconElement = $(this);
        $.ajax({
            url: 'cart/remove',
            type: 'post',
            data: {
                'product_id': product_id,
                'product_price': product_price
            },
            dataType: 'json',
            async: false,
            success: function(data) {
                if (data.cartInfo.totalQuantity == 0) {
                    location.href = 'cart';
                }
                $('#cart-quantity').text(data.cartInfo.totalQuantity);
                $('#cart-total').text(data.cartInfo.totalAmount);
                $('#page-cart-total').text(data.cartInfo.totalAmount);
                iconElement.parent().parent().remove();
            }
        });
    });

    $('.cart-item-quantity').on('change', function(e) { 

        var product_id = $(this).attr('product-id');
        var product_price = $(this).attr('product-price');
        var newQuantity = $(this).val();
        var quantityInput = $(this);
        $.ajax({
            url: 'cart/quantity/update',
            type: 'post',
            data: {
                'product_id': product_id,
                'product_price': product_price,
                'newQuantity': newQuantity 
            },
            dataType: 'json',
            async: false,
            success: function(data) {
                $('#cart-quantity').text(data.cartInfo.totalQuantity);
                $('#cart-total').text(data.cartInfo.totalAmount);
                $('#page-cart-total').text(data.cartInfo.totalAmount);
                quantityInput.parent().parent().find('td .cart-item-total').text(data.itemTotal);
            }
        });
    });

    $('#makeOrderBtn').on('click', function(e) { 
        
        $.ajax({
            url: '{{route("cart.check.balance.sum")}}',
            type: 'get',
            dataType: 'json',
            success: function(data) {
                if(data.hasMoney){
                    window.location.href = "{{route('order.checkout')}}";
                } else {
                    $("#noMoneyModal").modal('show');
                }
            }
        });
    });

</script>

@endsection
