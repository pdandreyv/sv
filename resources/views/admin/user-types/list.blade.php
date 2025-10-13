@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Типы пользователей</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.user-types.create') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>Код</th>
                <th>Навазание</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($types as $type)
                    <tr class="client_info">
                        <td>{{$type->code}}</td>
                        <td>{{$type->name}}</td>

                        <td class="text-right">
                            <a href="{{ route('admin.user-types.update', ['id' => $type->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.user-types.delete', ['id' => $type->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить тип?'); if(!result) return false;">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$types->links()}}

    </div>

@endsection