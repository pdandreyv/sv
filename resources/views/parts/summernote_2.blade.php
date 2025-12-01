<div class="add_item" id="add_item">
    <hr>
    <form method="post"
          @if (\Request::is('admin/page/edit/*'))
          action="{{ route('admin.page.update', $id) }}"
          @elseif (\Request::is('admin/page/add'))
          action="{{ route('admin.page.create') }}"
          @endif
          class="form-horizontal" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">
                {{$title_label}}
            </label>
            <input id="h1" name="h1" class="form-control" type="text"
                   value="{{ old('h1', $h1) }}" required/>
        </div>

        @if($errors->has('h1'))
            <div class="form-group alert alert-danger errors">
                {{ $errors->first('h1') }}
            </div>
        @endif


        <div class="form-group">
            <label for="title">
                Псевдоним
            </label>
            <input id="alias" name="alias" class="form-control" type="text"
                   value="{{ old('alias', $alias) }}" required/>
        </div>

        @if($errors->has('alias'))
            <div class="form-group alert alert-danger errors">
                {{ $errors->first('alias') }}
            </div>
        @endif

        <div class="form-group">
            <label for="body">{{$content_label}}</label>
            <textarea id="body" name="body" class="form-control tiny"
                      required>{{ old('body', $body) }}</textarea>
        </div>

        @if($errors->has('body'))
            <div class="form-group alert alert-danger errors">
                {{ $errors->first('body') }}
            </div>
        @endif

        <div class="form-group">
            @if (\Request::is('admin/page/add'))
                Обновите стр чтобы создание сработало
            @endif
            @if (\Request::is('admin/page/add'))
                <button class="btn btn-success" type="submit">Создать</button>
            @else
                <button class="btn btn-success" type="submit">Сохранить</button>
            @endif
            <a href="{{ route('admin.page') }}" class="btn btn-default" title="Назад">
                <span>Назад</span>
            </a>
        </div>
    </form>
    <hr>
</div>
<script>
</script>
