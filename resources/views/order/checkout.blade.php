@extends('layouts.app')

@section('content')

@include('parts.sidebar')

<div class="col-md-9">
    <form action="{{route('order.place')}}" method="POST">
        {{ csrf_field() }}
        @if($noAddressFound)
            <div class="form-group">
                <label>Адрес доставки:</label>
                <input type="text" required="required" class="form-control" name="shipping_adress"/>
            </div>
        @else
            <div class="form-group">
                <label>Раннее используемые адреса доставки:</label>
                <select class="form-control" name="address_id">
                @foreach ($addresses as $address)
                    <option value="{{$address->id}}">{{$address->address}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Доставить по новому адресу:</label>
                <input type="text" class="form-control" name="shipping_adress"/>
            </div>
        @endif        
        <input type="submit" class="btn btn-primary" value="Оплатить"/>    
    </form>
</div>

@endsection
