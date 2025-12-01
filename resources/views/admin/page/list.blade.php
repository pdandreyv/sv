@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')
    <div class="col-md-9 admin-table">
        <div class="title">
            <h3>Страницы</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.page.add') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <div class="admin-table-title row">
            <div class="title col-md-6">
                Страница
            </div>
            <div class="order col-md-2">
                updated_at
            </div>
            <div class="order col-md-2">
                открыть
            </div>
            <div class="date col-md-2">
                Действия
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
            @foreach($pages as $page)
                <div class="row admin-table-item">
                    <div class="title col-md-6">
                        <a href="{{ route('admin.page.edit', ['page_id' => $page->id]) }}" title="Редактировать страницу">{{ $page->h1 }}</a>
                    </div>
                    <div class="date col-md-2">
                        {{ \Carbon\Carbon::parse($page->updated_at)->format('d.m.y')}}
                    </div>
                    <div class="date col-md-2">
                        <a href="/{{$page->alias}}" target="_blank">{{$page->alias}}</a>
                    </div>
                    <div class="tools col-md-2">
                        <div class="post-control pull-right row">
                            <a href="{{ route('admin.page.edit', ['page_id' => $page->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.page.delete', ['page_id' => $page->id]) }}" onclick='return confirm("Вы действительно хотите удалить страницу?")' title="Удалить страницу" class="btn btn-danger btn-sm">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="pagination-container">
                {{ $pages->links() }}
            </div>
        </div>
    </div>

@endsection
