@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<div class="col-md-9">

<div class="products-block-up">
    <div class="row">
        <div class="col-md-8">
            <span class="product-block-bread">Создание заказа</span>
        </div>
    </div>
</div>
<hr>

<form method="post" action="{{route('admin.orders.store')}}">
{{ csrf_field() }}

<div class="form-group">
    <label for="user_name">Получатель</label>
    <div class="wrapper-dropdown">
    <div class="users-block">
        <input type="text" id="user-name" name='user_name' class="form-control" value="{{old('user_name')?old('user_name'):(isset($userTo)?$userTo->name:'')}}" autocomplete="off">
        <input type="hidden" name="to_user_id" id="user_to_id" value="{{old('to_user_id')}}">
        <input type="hidden" id="additionalMode" value="addOrder">
    </div>
    <ul class="users-dropdown"></ul>
    </div>
</div>
@if($errors->has('to_user_id'))
    <div class="form-group alert alert-danger">
        {{ $errors->first('to_user_id') }}
    </div>
@endif

<div class="form-group">
    <label>Статус заказа:</label>
    <select class="form-control" name="status_id">
    @foreach ($statuses as $status)        
        <option value="{{$status->id}}">{{$status->name}}</option>
    @endforeach
    </select>
</div>
<div class="form-group">
    <div class="form-group">
        <label>Адрес доставки:</label>
        <select id="selectAddresses" class="form-control" name="address_id">            
        </select>
    </div> 
    @if($errors->has('address_id'))
	    <div class="form-group alert alert-danger">
	        {{ $errors->first('address_id') }}
	    </div>
	@endif   
    <div class="form-group">
        <label>Доставить по новому адресу:</label>
        <input type="text" class="form-control" name="shipping_adress"/>
    </div> 
    @if($errors->has('shipping_adress'))
	    <div class="form-group alert alert-danger">
	        {{ $errors->first('shipping_adress') }}
	    </div>
	@endif   
</div>
<hr>

<div class="form-group">       
    <input type="button" class="btn btn-primary" value="Добавить" id="add-product">
</div> 

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
                <span id="orderTotalView">0,00</span>
                <input type="hidden" name="orderTotal" id="orderTotal" value="0">
            </td>                
            <td>
                
            </td>
        </tr>
    </tfoot>
</table>

<div class="form-group">
<input type="submit" value="Сохранить" class="btn btn-primary">
</div>
</form>

</div>

<script src="{{ asset('js/users/user-dropdown.js') }}"></script>

<!-- File item template -->
<script type="text/html" id="product-row-template">
    <tr class="client_info">
        <td>
        	<div class="wrapper-dropdown"> 
	            <input type="text" name="product[]" required class="product-name form-control"/>
	            <input type="hidden" name="productId[]" class="product-id"/>
	            <ul class="products-dropdown"></ul>
            </div> 
        </td>
        <td class="img-cell">            
            
        </td>
        <td>
            <input type="number" required name="itemQuantity[]" class="form-control item-quantity" value="1"/>
        </td>                
        <td>
        	<span class="price-cell"></span>
            <input type="hidden" class="price" name="price[]"/>
            <input type="hidden" class="cooperative_price" name="cooperative_price[]"/>
        </td>
        <td>  
        	<span class="row-amount-cell"></span>
            <input type="hidden" class="item-total"/>
        </td>                
        <td>
            <span class="item-remove"><i class="fa fa-trash-alt"></i></span>
        </td>
    </tr>
</script>

<script>

    $('#add-product').click(function(event) {                                
        var template = $('#product-row-template').text();                
        $('.order-items-table tbody').append(template);                
    });
    
    $('.order-items-table').on('keyup', '.product-name', function(event) {                 
        if(event.keyCode!=13){
            $('.products-dropdown').empty();            
            var productName = $(this).val();
            if(productName.length < 1){                    
                return false;
            }
            var dropDownContainer = $(this).parent().find('.products-dropdown');
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
                            +'<input type="hidden" class="tip_product_id" value="'+data[i].id+'">'
                            +'<input type="hidden" class="tip_product_title" value="'+data[i].title+'">'
                            +'<input type="hidden" class="tip_product_image" value="'+data[i].image+'">'
                            +'<input type="hidden" class="tip_product_price" value="'+data[i].price+'">'
                            +'<input type="hidden" class="tip_product_cooperative_price" value="'+data[i].cooperative_price+'">'
                        +'</li>';
                        dropDownContainer.append(res_item);                    
                    } 
                }
            });
        }
    });

    $('.order-items-table').on('click', '.product-tip-item', function(event) {        
        var rowElem = $(this).parent().parent().parent().parent();
        rowElem.find('.product-name').val($(this).find('.tip_product_title').val());
        var productId = $(this).find('.tip_product_id').val();
        rowElem.find('.product-id').val($(this).find('.tip_product_id').val());

        var image = $(this).find('.tip_product_image').val();

        if(image!=='null'){
            var productImageSrc = '/images/products/' + image;
        } else {
            var productImageSrc = '{{config('app.placeholder_url')}}100x100/00d2ff/ffffff';
        }

        var imgContent = '<a href="/product/'+productId+'">'
            +'<img class="product-thumb" width=100 src="'+productImageSrc+'">'
        +'</a>';

        rowElem.find('.img-cell').empty();
        rowElem.find('.img-cell').append(imgContent);
        
        var unformatPrice = $(this).find('.tip_product_price').val();
        var formatPrice = number_format(unformatPrice, 2, ',', ' ');
        
        var unformatCoopPrice = $(this).find('.tip_product_cooperative_price').val();
        
        rowElem.find('.price-cell').html(formatPrice);
        rowElem.find('.price').val(unformatPrice);
        rowElem.find('.cooperative_price').val(unformatCoopPrice);
        
        rowElem.find('.row-amount-cell').empty();
        rowElem.find('.row-amount-cell').append(formatPrice);

        rowElem.find('.item-total').val(unformatPrice);

        var newUnformatAmount = parseFloat($('#orderTotal').val()) + parseFloat(unformatPrice);
        var newFormatAmount = number_format(newUnformatAmount, 2, ',', ' ');
        $('#orderTotal').val(newUnformatAmount);
        $('#orderTotalView').html(newFormatAmount);

        $(this).parent().empty();        
    });

    $('.order-items-table').on('click', '.item-remove', function(e) { 
        var actionConfirm = confirm("Вы действительно желаете удалить товар из заказа?");               
        if(!actionConfirm) return;        

        var iconElement = $(this);
        iconElement.parent().parent().remove();  

        var newUnformatAmount = 0;
        $('.item-total').each(function( index ) {
        	newUnformatAmount += parseFloat($(this).val());			
		});

        var newFormatAmount = number_format(newUnformatAmount, 2, ',', ' ');
        $('#orderTotal').val(newUnformatAmount);
        $('#orderTotalView').html(newFormatAmount);

    });

    $('.order-items-table').on('change', '.item-quantity', function(e) { 
                
        var newQuantity = $(this).val();
        
        var rowElem = $(this).parent().parent();
        var unformatPrice = rowElem.find('.price').val();
        var newUnformatAmount = parseFloat(newQuantity)*parseFloat(unformatPrice);
        
        var newFormatAmount = number_format(newUnformatAmount, 2, ',', ' ');                

        rowElem.find('.row-amount-cell').empty();
        rowElem.find('.row-amount-cell').html(newFormatAmount);

        rowElem.find('.item-total').val(newUnformatAmount);

        var newUnformatAmount = 0;
        $('.item-total').each(function( index ) {
        	newUnformatAmount += parseFloat($(this).val());			
		});

        var newFormatAmount = number_format(newUnformatAmount, 2, ',', ' ');
        $('#orderTotal').val(newUnformatAmount);
        $('#orderTotalView').html(newFormatAmount);

    });

</script>

@endsection
