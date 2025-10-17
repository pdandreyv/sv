@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9 admin-table">
        <div class="title">
            <h3>Анкета — вопросы</h3>
        </div>
        <div class="btn-container form-group">
            <a href="{{ route('admin.questionnaire.create') }}" class="btn btn-info">
                <span>Добавить вопрос</span>
            </a>
        </div>
        <hr />
            <div class="admin-table-title row">
            	<div class="title col-6">Вопрос</div>
                <div class="date col-2">Тип</div>
                <div class="tools col-4">Сортировка</div>
            </div>
        <hr style="margin-bottom: 0px;">
        <div class="admin-table-list">
            @foreach($questions as $q)
                <div class="row admin-table-item">
                    <div class="title col-6">{{ $q->question }}</div>
                    <div class="date col-2">{{ $q->type == 'short' ? 'Короткий текст' : 'Длинный текст' }}</div>
                    <div class="tools col-4">
                        <span class="mr-2">{{ $q->sort }}</span>
                        <div class="post-control pull-right row">
                            <a href="{{ route('admin.questionnaire.edit', ['id' => $q->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.questionnaire.delete', ['id' => $q->id]) }}" onclick="return confirm('Удалить вопрос?')" class="btn btn-danger btn-sm">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="pagination-container">
                {{ $questions->links() }}
            </div>
        </div>
    </div>

@endsection


