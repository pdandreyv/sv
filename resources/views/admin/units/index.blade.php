@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')
    <div class="col-md-9 admin-table">
        <div class="title">
            <h3>Список единиц измерения</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.units.add') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <div class="admin-table-title row">
            <div class="title col-md-1">
                ИД
            </div>
            <div class="title col-md-6">
                Название
            </div>
            <div class="tools col-md-2">
                {{-- Инструменты --}}
            </div>
        </div>
        @if (session()->has('sucсess'))
            <hr />
            <div class="form-group alert alert-success">
                <span>{{session()->pull("sucсess")}}</span>
            </div>
        @endif
        @if (session()->has('erorr'))
            <hr />
            <div class="form-group alert alert-erorr">
                <span>{{session()->pull("erorr")}}</span>
            </div>
        @endif
        <hr style="margin-bottom: 0px;" />
        <div class="admin-table-list">
            @foreach($units as $unit)
                <div class="row admin-table-item">
                    <div class="title col-md-2">
                        <a href="{{ route('admin.units.edit', ['id' => $unit->id]) }}" title="Редактировать Пожелание">{{ $unit->id }}</a>
                    </div>
                    <div class="title col-md-3">
                        <a href="{{ route('admin.units.edit', ['id' => $unit->id]) }}" title="Редактировать Пожелание">{{ $unit->name }}</a>
                    </div>
                    <div class="title col-md-5">
                        {{ $unit->description }}
                    </div>
                    <div class="tools col-md-2">
                        <div class="post-control pull-right row">
                            <a href="{{ route('admin.units.edit', ['id' => $unit->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.units.delete', ['id' => $unit->id]) }}" onclick='return confirm("Вы действительно хотите удалить единицу измерения?")' title="Удалить вопрос" class="btn btn-danger btn-sm">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="pagination-container">
                {{ $units->links() }}
            </div>
        </div>
    </div>

@endsection