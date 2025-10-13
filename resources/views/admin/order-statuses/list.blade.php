@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Статусы заказа</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.order-statuses.create') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>Код</th>
                <th>Название</th>
                <th>Не редактируемый</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($statuses as $status)
                    <tr class="client_info">
                        <td>{{$status->code}}</td>
                        <td>{{$status->name}}</td>
                        <td>{{$status->not_editable?'Да':'Нет'}}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.order-statuses.update', ['id' => $status->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            @if(!$status->is_standart)
                            <a href="{{ route('admin.order-statuses.delete', ['id' => $status->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить статус?'); if(!result) return false;">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$statuses->links()}}

    </div>

@endsection