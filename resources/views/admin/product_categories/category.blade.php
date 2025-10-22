<ul>
    @foreach ($categories as $item)
        @if (!$service)
            @if ( $item->for_service )
                @continue
            @endif
        @else
            @if ( (!$item->for_service) )
                @continue
            @endif
        @endif
        @if($item->children->count() > 0)
            <li class="parent">
        @else
            <li>
        @endif
            <div class="item">
                <div>
                    <span>{{$item->title}}</span>
                    <small class="text-muted">(sort: {{$item->sort ?? 0}})</small>
                </div>
                <div class="tools">
                    @if($item->children->count() > 0)
                        <div class="toggle btn btn-sn btn-info">
                            <i class="fas fa-caret-down"></i>
                        </div>
                    @else
                        <div class="toggle btn btn-sn btn-info disabled">
                            <i class="fas fa-caret-down"></i>
                        </div>
                    @endif
                    <a href="{{ route('admin.product-categories.update', ['id' => $item->id]) }}" title="Редактировать категорию" class="btn btn-info btn-sm">
                        <span><i class="fas fa-edit"></i></span>
                    </a>
                    <a href="{{ route('admin.product-categories.create-child', ['id' => $item->id]) }}" title="Добавить подкатегорию"  class="btn btn-warning btn-sm">
                        <span><i class="fas fa-plus-circle"></i></span>
                    </a>
                    <a href="{{ route('admin.product-categories.delete', ['id' => $item->id]) }}" title="Удалить категорию"  class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить категорию?'); if(!result) return false;">
                        <span><i class="fas fa-trash-alt"></i></span>
                    </a>
                </div>
            </div>
        @if($item->children->count() > 0)
            @include('admin.product_categories.category', ['categories' => $item->children])
        @endif
        </li>
    @endforeach
</ul>

