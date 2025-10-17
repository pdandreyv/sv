@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Редактировать вопрос</h3>
        </div>
        <hr />

        <form method="POST" action="{{ route('admin.questionnaire.update', ['id' => $question->id]) }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Вопрос</label>
                <input type="text" class="form-control" name="question" value="{{ $question->question }}" required>
            </div>
            <div class="form-group">
                <label>Тип поля</label>
                <select name="type" class="form-control" required>
                    <option value="short" {{ $question->type=='short' ? 'selected' : '' }}>Короткий текст</option>
                    <option value="long" {{ $question->type=='long' ? 'selected' : '' }}>Длинный текст</option>
                </select>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea class="form-control" name="description" rows="3">{{ $question->description }}</textarea>
            </div>
            <div class="form-group">
                <label>Сортировка</label>
                <input type="number" min="0" step="1" class="form-control" name="sort" value="{{ $question->sort ?? 0 }}">
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>

@endsection


