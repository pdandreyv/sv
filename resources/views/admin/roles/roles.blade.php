@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Роли пользователей</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.roles.create') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>Код роли</th>
                <th>Название роли</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr class="client_info">
                        <td>{{$role->name}}</td>
                        <td>{{$role->title}}</td>

                        <td class="text-right">
                            <a href="{{ route('admin.roles.update', ['id' => $role->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.roles.delete', ['id' => $role->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить роль?'); if(!result) return false;">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$roles->links()}}

    </div>

@endsection