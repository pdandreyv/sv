@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Заказы</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.orders.create') }}" class="btn btn-info btn-add">Добавить заказ</a>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>ID</th>
                <th>Пользователь</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->user->fullName()}}</td>
                        <td>{{number_format($order->sum, 2, ',', ' ')}}</td>
                        <td>{{$order->status->name}}</td>
                        <td class="text-right">
                            <a href="{{route('admin.orders.update', $order->id)}}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{route('admin.orders.delete', $order->id)}}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить заказ?'); if(!result) return false;">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                                                                                   
                            <a {{$order->applied?'':'style=display:none'}} title="Отменить проведение" data-id={{$order->id}} class="btn btn-danger btn-sm unapply-btn">
                                <span><i class="fas fa-times-circle"></i></span>
                            </a>                            
                            <a {{(!$order->applied)?'':'style=display:none'}} title="Проведение" data-id={{$order->id}} class="btn btn-success btn-sm apply-btn">
                                <span><i class="fas fa-arrow-circle-down"></i></span>
                            </a>                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$orders->links()}}

    </div>

    
    <script>

    $('.unapply-btn').click(function(event) {        
        var unapplyBtn = $(this);
        var result = confirm('Вы действительно хотите отменить проведение?'); if(!result) return false;
        
        var order_id = $(this).attr('data-id');
        if(order_id){
            $.ajax({
                url: '/admin/orders/unapply/'+order_id,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {                    
                    if(data.success == 0){                        
                    } else {
                        unapplyBtn.hide();
                        unapplyBtn.parent().find('.apply-btn').show();
                    }
                }                
            });
        }        
    });

    $('.apply-btn').click(function(event) {        
        var applyBtn = $(this);
        var result = confirm('Вы действительно хотите провести заказ?'); if(!result) return false;
    
        var order_id = $(this).attr('data-id');
        if(order_id){
            $.ajax({
                url: '/admin/orders/apply/'+order_id,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {                    
                    if(data.success == 0){
                        alert('У потребителя не достаточно средств на счету');
                    } else {
                        applyBtn.hide();
                        applyBtn.parent().find('.unapply-btn').show();
                    }
                }                
            });
        }        
    });
    
</script>
    
@endsection