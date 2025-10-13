@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9">
        <div class="title">
            <h3>Настройки</h3>
        </div>
        <hr />
        <div class="title">
            <h4>Настройки уведомлений чата</h4>
        </div>
        <hr />
        <form action="{{route('chat.store.settings')}}" method="post" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group col-sm-12 col-md-6">
                <label>Получать уведомление о личных сообщениях</label>
                <select name="private_frequency" class="form-control">
                    <option value="never" {{($private && $private->frequency == 'never')?'selected="selectd"':''}}>Не получать</option>
                    <option value="every" {{($private && $private->frequency == 'every')?'selected="selectd"':''}}>О каждом сообщении</option>
                    <option value="daily" {{($private && $private->frequency == 'daily')?'selected="selectd"':''}}>Ежедневно</option>
                    <option value="weekly" {{($private && $private->frequency == 'weekly')?'selected="selectd"':''}}>1 раз в неделю</option>
                    <option value="mounthly" {{($private && $private->frequency == 'mounthly')?'selected="selectd"':''}}>1 раз в месяц</option>
                </select>
            </div>
            <div class="form-group col-sm-12 col-md-6">
                <label>Получать уведомление о сообщениях в чатах</label>
                <select name="group_frequency" class="form-control">
                    <option value="never" {{($group && $group->frequency == 'never')?'selected="selectd"':''}}>Не получать</option>
                    <option value="every" {{($group && $group->frequency == 'every')?'selected="selectd"':''}}>О каждом сообщении</option>
                    <option value="daily" {{($group && $group->frequency == 'daily')?'selected="selectd"':''}}>Ежедневно</option>
                    <option value="weekly" {{($group && $group->frequency == 'weekly')?'selected="selectd"':''}}>1 раз в неделю</option>
                    <option value="mounthly" {{($group && $group->frequency == 'mounthly')?'selected="selectd"':''}}>1 раз в месяц</option>
                </select>
            </div>
            <div class="col-sm-12 col-md-6">
                <button type="submit" class="btn btn-success">Добавить</button>
            </div>
            <hr class="col-md-12" />
        </form>
    </div>
@endsection