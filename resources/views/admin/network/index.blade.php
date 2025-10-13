@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Сеть</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.network.node.create') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>Пользователь</th>
                <th>УПС1</th>
                <th>УПС2</th>
                <th>УПС3</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($nodes as $node)
                    <tr class="client_info">
                        <td>{{$node->user ? $node->user->fullName() : ''}}</td>
                        <td>{{$node->ups1User ? $node->ups1User->fullName() : ''}}</td>
                        <td>{{$node->ups2User?$node->ups2User->fullName():''}}</td>
                        <td>{{$node->ups3User?$node->ups3User->fullName():''}}</td>

                        <td class="text-right">                            
                            <a href="{{ route('admin.network.node.delete', ['id' => $node->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить запись?'); if(!result) return false;">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$nodes->links()}}
        
    </div>    

@endsection