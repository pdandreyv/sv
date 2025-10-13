@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')
    <div class="col-md-9 admin-table">
        <div class="title">
            <h3>Часто задаваемые вопросы</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.faq.add') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />
        <div class="admin-table-title row">
            <div class="title col-md-6">
                Вопрос
            </div>
            <div class="order col-md-2">
                Порядок
            </div>
            <div class="date col-md-2">
                Создано
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
            @foreach($faq as $question)
                <div class="row admin-table-item">
                    <div class="title col-md-6">
                        <a href="{{ route('admin.faq.edit', ['faq_id' => $question->id]) }}" title="Редактировать Вопрос">{{ $question->title }}</a>
                    </div>
                    <div class="order col-md-2">
                        <span>{{$question->order}}</span>
                    </div>
                    <div class="date col-md-2">
                        {{ \Carbon\Carbon::parse($question->updated_at)->format('d.m.y')}}
                    </div>
                    <div class="tools col-md-2">
                        <div class="post-control pull-right row">
                            <a href="{{ route('admin.faq.edit', ['faq_id' => $question->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.faq.delete', ['faq_id' => $question->id]) }}" onclick='return confirm("Вы действительно хотите удалить вопрос?")' title="Удалить вопрос" class="btn btn-danger btn-sm">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="pagination-container">
                {{ $faq->links() }}
            </div>
        </div>
    </div>

@endsection