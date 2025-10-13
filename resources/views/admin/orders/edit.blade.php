@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">

<div class="products-block-up">
    <div class="row">
        <div class="col-md-8">
            <span class="product-block-bread">Редактирование заказа №{{$order->id}} от {{$order->user->fullName()}}</span>
        </div>
    </div>
</div>
<hr>

<form method="post">
{{ csrf_field() }}
<div class="form-group">
    <label>Статус заказа:</label>
    <select class="form-control" name="status_id">
    @foreach ($statuses as $status)
        @php
        $selected = ($status->id == $order->status_id)?'selected="selected"':'';
        @endphp
        <option {{$selected}} value="{{$status->id}}">{{$status->name}}</option>
    @endforeach
    </select>
</div>
<div class="form-group">
    <div class="form-group">
        <label>Адрес доставки:</label>
        <select {{$not_editable?'disabled="disabled"':''}} class="form-control" name="address_id">            
        @foreach ($addresses as $address)
            @php
            $selected = ($address->id == $order->address_id)?'selected="selected"':'';
            @endphp
            <option {{$selected}} value="{{$address->id}}">{{$address->address}}</option>
        @endforeach
        </select>
    </div>
    @if(!$not_editable)
    <div class="form-group">
        <label>Доставить по новому адресу:</label>
        <input type="text" class="form-control" name="shipping_adress"/>
    </div>
    @endif
</div>
<input type="submit" value="Сохранить" class="btn btn-primary">
</form>

<hr>
@if(!$not_editable)
<div class="form-group">
    <label>Добавление товара:</label>
</div>

<div class="form-group"> 
    <div style="padding-left: 0px" class="col-md-6">       
        <div class="product-block">
            <div class="wrapper-dropdown">            
                <input type="text" id="product-name" class="form-control" value="" autocomplete="off">
                <input type="hidden" id="product_id">                   
                <ul class="products-dropdown"></ul>
            </div> 
        </div>        
    </div>
    <div class="col-md-4">       
        <input type="button" class="btn btn-primary" value="Добавить" id="add-product">
    </div>
</div> 
@endif
<table class="table order-items-table">
    <thead>
    <tr class="product-table-thead">
        <th>Товар</th>
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
        @foreach ($order->items as $item)
            <tr class="client_info">
                <td>
                    <a href="{{route('products.product', ['id'=>$item->product->id])}}">
                    {{$item->product->title}}
                    </a>
                </td>
                <td>                    
                    <a href="{{route('products.product', ['id'=>$item->product->id])}}">
                    @php
                    if($item->product->image()->where('main', 1)->first()){
                        $src = '/images/products/'.$item->product->image()->where('main', 1)->first()->new_name;
                    } else {
                        $src = config('app.placeholder_url').'100x100/00d2ff/ffffff';
                    }
                    @endphp
                    <img width=100 class="product-thumb" src="{{$src}}">
                    </a>
                </td>
                <td>
                    <input {{$not_editable?'disabled="disabled"':''}} item-id="{{$item->id}}" type="number" class="form-control cart-item-quantity" value="{{$item->quantity}}"/>
                </td>                
                <td>                    
                    {{number_format($item->price, 2, ',', ' ')}}                    
                </td>
                <td>  
                    @php
                    $rowTotal = $item->price*$item->quantity;
                    $total += $rowTotal;
                    @endphp                  
                    <span class="cart-item-total">{{number_format($rowTotal, 2, ',', ' ')}}</span>
                </td>                
                <td>
                    @if(!$not_editable)
                    <span item-id="{{$item->id}}" class="cart-item-remove"><i class="fa fa-trash-alt"></i></span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="client_info">
            <td>
                
            </td>
            <td>
                
            </td>
            <td>
                
            </td>                
            <td>                    
                                    
            </td>
            <td>                    
                <span id="page-cart-total">{{number_format($total, 2, ',', ' ')}}</span>
            </td>                
            <td>
                
            </td>
        </tr>
    </tfoot>
</table>
</div>
<input type="hidden" id="order_id" value="{{$order->id}}">

<!-- File item template -->
<script type="text/html" id="product-row-template">
    <tr class="client_info">
        <td>
            <a href="/product/%%product_id%%">
            %%product_title%%
            </a>
        </td>
        <td>            
            <a href="/product/%%product_id%%">
            <img class="product-thumb" width=100 src="%%product_image_src%%">
            </a>
        </td>
        <td>
            <input item-id="%%product_id%%" type="number" class="form-control cart-item-quantity" value="1"/>
        </td>                
        <td>                    
            %%product_price%%                    
        </td>
        <td>                   
            <span class="cart-item-total">%%product_row_total%%</span>
        </td>                
        <td>
            <span item-id="%%product_id%%" class="cart-item-remove"><i class="fa fa-trash-alt"></i></span>
        </td>
    </tr>
</script>

<script>

    $('#add-product').click(function(event) {                                
        var product_id = $('#product_id').val();
        var order_id = $('#order_id').val();
        if(product_id){
            $.ajax({
                url: '/admin/order-items/'+order_id+'/add-item/'+product_id,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if(data.success == true){
                        if(data.existed == false){
                            var template = $('#product-row-template').text();
                            template = template.split("%%product_id%%").join(data.product.id);
                            template = template.replace('%%product_title%%', data.product.title);
                            template = template.replace('%%product_price%%', data.product.price);
                            template = template.replace('%%product_row_total%%', data.product.price);

                            if(data.product.image != undefined){
                                var src = '/images/products/'+data.product.image;
                            } else {
                                var src = '{{config('app.placeholder_url')}}100x100/00d2ff/ffffff';
                            }

                            template = template.replace('%%product_image_src%%', src);                        

                            template = $(template);
                            
                            $('.order-items-table').append(template);
                            $('#page-cart-total').text(data.amount);                        
                        } else {
                            var quantityInput = $('[item-id="'+data.existed+'"]');
                            quantityInput.val(data.quantity);
                            quantityInput.parent().parent().find('td .cart-item-total').text(data.itemTotal);
                            $('#page-cart-total').text(data.amount);
                        }                    
                    }
                    $('#product_id').val('');
                    $('#product-name').val('');
                }                
            });
        }        
    });

    $('#product-name').keyup(function(event) {                
        if(event.keyCode!=13){
            $('.products-dropdown').empty();
            $('#product_id').val('');
            var productName = $('#product-name').val();
            if(productName.length < 1){                    
                return false;
            }
            $.ajax({
                url: '/admin/orders/product-drop-down/'+productName,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    for(var i in data){
                        if(data[i].image){
                            var src = '/images/products/'+data[i].image;
                        } else {
                            var src = '{{config('app.placeholder_url')}}100x100/00d2ff/ffffff';
                        }

                        var res_item = '<li class="product-tip-item">'
                            +'<div class="img-container">'
                                +'<img class="product-thumb" width="100" src="'+src+'" alt="Generic placeholder image">'
                            +'</div>'
                            +'<ul class="info-container">'                   
                                +'<li class="product-name">'+data[i].title+'</li>'
                                +'<li>'+data[i].user_name+'</li>'
                                +'<li>'+data[i].price+'</li>'                                
                            +'</ul>'
                            +'<input type="hidden" class="product_id" value="'+data[i].id+'">'
                        +'</li>';
                        $('.products-dropdown').append(res_item);                    
                    } 
                }
            });
        }
    });

    $('.products-dropdown').on('click', '.product-tip-item', function(event) {        
        $('#product-name').val($(this).find('.product-name').text());
        $('#product_id').val($(this).find('.product_id').val());        
        $('.products-dropdown').empty();        
    });

    $('.order-items-table').on('click', '.cart-item-remove', function(e) { 
        var actionConfirm = confirm("Вы действительно желаете удалить товар из заказа?");       
        
        if(!actionConfirm) return;

        var item_id = $(this).attr('item-id');

        var iconElement = $(this);
        $.ajax({
            url: '/order-items/remove',
            type: 'post',
            data: {
                'item_id': item_id
            },
            dataType: 'json',
            async: false,
            success: function(data) {                
                $('#page-cart-total').text(data.amount);
                iconElement.parent().parent().remove();
            }
        });
    });

    $('.order-items-table').on('change', '.cart-item-quantity', function(e) { 

        var item_id = $(this).attr('item-id');        
        var newQuantity = $(this).val();
        var quantityInput = $(this);
        $.ajax({
            url: '/order-items/quantity/update',
            type: 'post',
            data: {
                'item_id': item_id,
                'newQuantity': newQuantity 
            },
            dataType: 'json',
            async: false,
            success: function(data) {                
                $('#page-cart-total').text(data.amount);
                quantityInput.parent().parent().find('td .cart-item-total').text(data.itemTotal);
            }
        });
    });    

    $('#address_id').on('change', function(e) {
        window.location.href = "";
    });

</script>

@endsection
