@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Список пользователей</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.users.create') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>Логин</th>
                <th>Отображаемое имя</th>
                <th>Роли</th>
                <th>Тип</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="client_info">
                        <td>
                            <span>{{$user->email}}</span>
                        </td>
                        <td>
                            <span>{{$user->name}}</span>
                        </td>
                        <td>
                            <span>{{$user->getRolesDisplay()}}</span>
                        </td>
                        <td>
                            <span>{{($user->type)?$user->type->name:''}}</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.users.update', ['id' => $user->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.users.delete', ['id' => $user->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить пользователя?'); if(!result) return false;">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$users->links()}}

    </div>

@endsection