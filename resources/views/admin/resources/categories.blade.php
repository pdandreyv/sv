@foreach ($categories as $category)
    @if( $category->children->count() > 0 )
        <div class="parent item {{ ($category->resources->count()>0) ? 'has-resources' : '' }}">
    @else
        <div class="item {{ ($category->resources->count()>0) ? 'has-resources' : 'empty' }}">
    @endif
        <div class="option">
            <div class="icons-container">
                <span class="switch plus"><i class="fas fa-plus"></i></span>
                <span class="switch minus"><i class="fas fa-minus"></i></span>
                <span class="icons"><i class="fas fa-folder"></i><i class="fas fa-folder-open"></span></i><span class="title">{{$category->title}}</span><span class="count-container">(<span class="count"></span>)</span>
            </div>
            @if ( $category->resources->count()>0 )
                <div class="admin-table-title row resource heading admin-table-item">
                    <div class="id col-md-1">
                        ИД
                    </div>
                    <div class="title col-md-6">
                        Название
                    </div>
                    <div class="category col-md-1">
                        Единица
                    </div>
                    <div class="quantity col-md-2">
                        Количество
                    </div>
                    <div class="tools col-md-2">
                        <!-- Инструменты -->
                    </div>
                </div>
            @endif
            @foreach ($category->resources as $resource)
                <div class="resource admin-table-item">
                    <div class="title col-md-1">
                        <a href="{{ route('admin.resources.edit', ['id' => $resource->id]) }}" title="Редактировать Пожелание">{{ $resource->id }}</a>
                    </div>
                    <div class="title col-md-6">
                        <a href="{{ route('admin.resources.edit', ['id' => $resource->id]) }}" title="Редактировать Пожелание">{{ $resource->name }}</a>
                    </div>
                     <div class="unit col-md-1">
                        {{isset($resource->unit->name) ? $resource->unit->name : ''}}
                    </div>
                    <div class="quantity col-md-2">
                        {{isset($resources_chosen_count[$resource->id]) ? $resources_chosen_count[$resource->id] : '0'}}
                    </div>
                    <div class="tools col-md-2">
                        <div class="post-control pull-right row">
                            <a href="{{ route('admin.resources.edit', ['id' => $resource->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.resources.delete', ['id' => $resource->id]) }}" onclick='return confirm("Вы действительно хотите удалить пожелание?")' title="Удалить вопрос" class="btn btn-danger btn-sm">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($category->children->count() > 0)
            @include('admin.resources.categories', ['categories' => $category->children])
        @endif
    </div>
@endforeach