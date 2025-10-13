<div class="add_item" id="add_item">
    <hr>
    <form method="post" 
        @if (\Request::is('post/edit/*'))
            action="{{ route('posts.update', $post_id) }}"
        @elseif (\Request::is('admin/post/edit/*'))
            action="{{ route('admin.post.update', $post_id) }}"
        @elseif (\Request::is('admin/faq/edit/*'))
            action="{{ route('admin.faq.update', $id) }}"
        @elseif (\Request::is('admin/faq/add'))
            action="{{ route('admin.faq.create') }}"
        @elseif (\Request::is('posts/add'))
            action="{{ route('posts.create') }}"
        @endif
    class="form-horizontal" enctype="multipart/form-data">
        @if (\Request::is('post/edit/*') || \Request::is('post/edit/*/delete') || \Request::is('admin/post/edit/*'))
            <input type="hidden" name="author_id" id="author_id" value="{{$author_id}}" />
        @endif
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">
                {{$title_label}}
            </label>
            @if (\Request::is('post/edit/*') || \Request::is('admin/faq/edit/*'))
                <input id="title" name="title" class="form-control" type="text" value="{{$title}}" required />
            @else
                <input id="title" name="title" class="form-control" type="text" value="{{old('title') or ''}}" required />
            @endif
        </div>
        @if (\Request::is('admin/faq/edit/*') || \Request::is('admin/faq/add'))
            <div class="form-group sort-order">
                <label for="order"><span>Порядок сортировки</span></label>
                <input type="number" class="form-control col-2" min="0" value="{{ $order ?? 0 }}" id="order" name="order" />
                <span class="validate"></span>
            </div>
        @endif
        @if($errors->has('title'))
            <div class="form-group alert alert-danger errors">
                {{ $errors->first('post_title') }}
            </div>
        @endif
        <div class="form-group">
            <label for="content">{{$content_label}}</label>
            @if (\Request::is('post/edit/*') || \Request::is('admin/faq/edit/*'))
                <textarea id="content" name="content" class="form-control" data-value="{{$content}}" required>{{$content}}</textarea>
            @else
                <textarea id="content" name="content" class="form-control" data-value="{{old('content')}}" required>{{old('content')}}</textarea>
            @endif
        </div>
        @if($errors->has('content'))
            <div class="form-group alert alert-danger errors">
                {{ $errors->first('post_content') }}
            </div>
        @endif
        @if (\Request::is('post/edit/*') || \Request::is('admin/post/edit/*') || \Request::is('posts/add'))
            <div class="form-group row sticky">
                <input type="hidden" value="0" name="stick_on_top">
                <input type="checkbox" class="switch-checkbox" id="stick_on_top" name="stick_on_top" value="1" {{isset($stick_on_top)&&$stick_on_top=='1' ? 'checked' : ''}} />
                <label for="stick_on_top" class="post_checkbox_label"></label>
                <span>Закрепить запись вверху страницы</span>
            </div>
        @endif
        @if (\Request::is('admin/faq/edit/*') || \Request::is('admin/faq/add'))
            <div class="form-group row show_on_page">
                <input type="hidden" value="0" name="active">
                <input type="checkbox" class="switch-checkbox" id="active" name="active" value="1" {{isset($active)&&$active=='1' ? 'checked' : ''}} />
                <label for="active" class="checkbox_label"></label>
                <label><span>Показать на странице</span></label>
            </div>
        @endif
        <div class="form-group">
            @if (\Request::is('post/edit/*') || \Request::is('admin/faq/edit/*'))
                <button class="btn btn-success" type="submit">Обновить</button>
                <a href="{{ route('admin.faq') }}" class="btn btn-default" title="Назад">
                    <span>Назад</span>
                </a>
                <button class="btn btn-warning pull-right" id="clear_post">Очистить</button>
                @if (\Request::is('post/edit/*'))
                    <a href="{{ route('posts.delete', ['post_id' => $post_item->post_id]) }}" title="Удалить запись"  onclick='return confirm("Удалить?")'  class="btn btn-danger pull-right">Удалить</a>
                @endif
                @if (\Request::is('admin/faq/edit/*'))
                    <a href="{{ route('admin.faq.delete', ['faq_id' => $id]) }}" title="Удалить запись"  onclick='return confirm("Удалить?")'  class="btn btn-danger pull-right">Удалить</a>
                @endif
            @else
                <button class="btn btn-success" type="submit">Добавить</button>
                <button class="btn btn-warning pull-right" id="clear_post">Очистить</button>
            @endif
        </div>
    </form>
    <hr>
</div>