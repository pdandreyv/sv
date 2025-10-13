@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Добавить вопрос</h3>
        </div>
        <hr />

        <form method="POST" action="{{ route('admin.questionnaire.store') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Вопрос</label>
                <input type="text" class="form-control" name="question" required>
            </div>
            <div class="form-group">
                <label>Тип поля</label>
                <select name="type" class="form-control" required>
                    <option value="short">Короткий текст</option>
                    <option value="long">Длинный текст</option>
                </select>
            </div>
            <div class="form-group">
                <label>Описание</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>

@endsection


