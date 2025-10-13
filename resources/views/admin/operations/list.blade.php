@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Финансовые операции</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.operations.choose-type') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>ПОЛЬЗОВАТЕЛЬ</th>
                <th>КОМУ</th>
                <th>СУММА</th>
                <th>ТИП</th>
                <th>ОПЛАЧЕНО</th>
                <th>СОЗДАНА</th>
                <th>ОБНОВЛЕНА</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($operations as $operation)
                    <tr class="client_info">
                        <td>{{$operation->user ? $operation->user->name : ''}}</td>
                        <td>{{!empty($operation->to_user)?$operation->to_user->name:'Кооператив'}}</td>
                        <td>{{number_format($operation->sum,2,","," ")}}</td>
                        <td>{{$operation->operation_type->name}}</td>
                        <td>{{($operation->paid)?'Да':''}}</td>
                        <td>{{$operation->created_at}}</td>
                        <td>{{$operation->updated_at}}</td>

                        <td class="text-right">
                            <a href="{{ route('admin.operations.delete', ['id' => $operation->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить операцию?'); if(!result) return false;">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$operations->links()}}

    </div>

@endsection