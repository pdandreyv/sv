@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9">
        <div class="title">
            <h3>Анкета</h3>
        </div>
        <p>Участие в сообществе добровольное, информация которую вы предоставляете будет доступна всем участникам, которые предоставили такую же информацию о себе, вам тоже будет доступна вся информация о всех участниках. Телефон и адрес скрыты по умолчанию. Все участники сообщества присоединяются только по рекомендации.</p>
        <hr />

        <form method="POST" action="{{ route('questionnaire.store') }}">
            {{ csrf_field() }}
            @foreach($questions as $q)
                <div class="form-group">
                    <label>{{ $q->question }}</label>
                    @if($q->type == 'long')
                        <textarea class="form-control" name="answers[{{ $q->id }}]" rows="4">{{ isset($answers[$q->id]) ? $answers[$q->id]->answer : '' }}</textarea>
                    @else
                        <input type="text" class="form-control" name="answers[{{ $q->id }}]" value="{{ isset($answers[$q->id]) ? $answers[$q->id]->answer : '' }}">
                    @endif
                    @if($q->description)
                        <small class="form-text text-muted">{{ $q->description }}</small>
                    @endif
                </div>
            @endforeach
            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>

@endsection


