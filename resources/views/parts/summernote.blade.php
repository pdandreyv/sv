<div class="add_post" id="add_post">
    <hr>
    @if (\Request::is('post/edit/*'))
        <form method="post" action="{{ route('posts.update', $post_id) }}" class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" name="author_id" id="author_id" value="{{$author_id}}" />
    @elseif (\Request::is('admin/post/edit/*'))
        <form method="post" action="{{ route('admin.post.update', $post_id) }}" class="form-horizontal" enctype="multipart/form-data">
            <input type="hidden" name="author_id" id="author_id" value="{{$author_id}}" />
    @elseif (\Request::is('post/edit/*/delete'))
            <input type="hidden" name="author_id" id="author_id" value="{{$author_id}}" />
    @else
        <form method="post" class="form-horizontal" enctype="multipart/form-data">
    @endif
            {{ csrf_field() }}
            <div class="form-group">
                <label for="post_title">Заголовок записи</label>
                @if (\Request::is('post/edit/*') || \Request::is('admin/post/edit/*'))
                    <input id="post_title" name="post_title" class="form-control" placeholder="Название" value="{{$post_title}}" type="text"/>
                @else
                    <input id="post_title" name="post_title" class="form-control" data-value="{{old('post-title')}}" placeholder="Название" value="{{old('post-title')}}" type="text" />
                @endif
            </div>
            @if($errors->has('post_title'))
                <div class="form-group alert alert-danger errors">
                    {{ $errors->first('post_title') }}
                </div>
            @endif
            <div class="form-group">
                <label for="content">Содержимое записи</label>
                @if (\Request::is('post/edit/*') || \Request::is('admin/post/edit/*'))
                    <textarea id="content" name="post_content" class="form-control" placeholder="Что нового?.." data-value="{{$post_content}}">{{$post_content}}</textarea>
                @else
                    <textarea id="content" name="post_content" class="form-control" placeholder="Что нового?.." data-value="{{old('post_content')}}">{{old('post_content')}}</textarea>
                @endif
            </div>
            @if($errors->has('post_content'))
                <div class="form-group alert alert-danger errors">
                    {{ $errors->first('post_content') }}
                </div>
            @endif
            <div class="form-group row sticky">
                <input type="hidden" value="0" name="stick_on_top">
                <input type="checkbox" class="switch-checkbox" id="stick_on_top" name="stick_on_top" value="1" {{isset($stick_on_top)&&$stick_on_top=='1' ? 'checked' : ''}} />
                <label for="stick_on_top" class="post_checkbox_label"></label>
                <span>Закрепить запись вверху страницы</span>
            </div>
            @if (\Request::is('admin/post/edit/*'))
                <div class="form-group row approved">
                    <input type="hidden" value="0" name="approved">
                    <input type="checkbox" class="switch-checkbox" id="approved" name="approved" value="1" {{isset($approved)&&$approved=='1' ? 'checked' : ''}} />
                    <label for="approved" class="checkbox_label"></label>
                    <label><span>Одобрить</span></label>
                </div>
            @endif
            <div class="form-group">

                @if (\Request::is('post/edit/*') || \Request::is('admin/post/edit/*')) 
                    <button title="Обновить" class="btn btn-success" type="submit">Обновить</button>
                    
                    <a href="{{ route('profile.my-page', ['id' => Auth::user()->id])}}" title="К записям" class="btn btn-default">К записям</a>

                    <div class="pull-right">
                        <a href="{{ route('posts.delete', $post_id) }}" title="Удалить запись"  onclick='return confirm("Вы действительно хотите удалить запись?")'  class="btn btn-danger">Удалить</a>
                        
                        <button class="btn btn-warning" id="clear_post">Очистить</button>
                    </div>
                @else
                    <button class="btn btn-success" type="submit">Добавить</button>
                    <button class="btn btn-warning pull-right" id="clear_post">Очистить</button>
                @endif
            </div>
    </form>
    <hr>
</div>
