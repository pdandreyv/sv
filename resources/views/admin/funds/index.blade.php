@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Фонды</h3>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>Код</th>
                <th>Название</th>
                <th>Сумма</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($funds as $fund)
                    <tr class="client_info">
                        <td>{{$fund->code}}</td>
                        <td>{{$fund->name}}</td>
                        <td>{{number_format($fund->balance, 2, ",", " ")}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$funds->links()}}

    </div>

@endsection
