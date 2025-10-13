@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Шаблоны писем</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.mail-templates.create') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                <th>Алиас</th>
                <th>Тема</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($mailTemplates as $template)
                    <tr>
                        <td>{{$template->alias}}</td>
                        <td>{{$template->subject}}</td>

                        <td class="text-right" style="text-align: left;">
                            <a href="{{ route('admin.mail-templates.update', ['id' => $template->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            @if(!$template->is_standart)
                                <a href="{{ route('admin.mail-templates.delete', ['id' => $template->id]) }}"onclick="var result = confirm('Вы действительно хотите удалить шаблон?'); if(!result) return false;" class="btn btn-danger btn-sm">
                                    <span><i class="fas fa-trash-alt"></i></span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$mailTemplates->links()}}

    </div>
@endsection