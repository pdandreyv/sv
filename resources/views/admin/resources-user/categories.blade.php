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
                <span class="switch circle"><i class="fas fa-circle"></i></span>
                <span class="icons"><i class="fas fa-folder"></i><i class="fas fa-folder-open"></span></i><span class="title">{{$category->title}}</span><span class="count-container">(<span class="count"></span>)</span>
            </div>
            @foreach ($category->resources as $resource)
                <div class="resource">
                    <div class="label-check">
                        <input
                            type="hidden"
                            value="0"
                            name="{{'resource_'.$resource->id.'_'.$resource->category_id}}"
                        />
                        <input
                            type="checkbox"
                            name="{{'resource_'.$resource->id.'_'.$resource->category_id}}"
                            id="{{'resource_'.$resource->id.'_'.$resource->category_id}}"
                            data-category-id="{{$resource->category_id}}"
                            data-resource-id="{{$resource->id}}"
                            {{isset($resources_checked[$resource->category_id][$resource->id]) ? 'checked' : ''}}
                            class="switch-checkbox"
                        />
                        <label for="{{'resource_'.$resource->id.'_'.$resource->category_id}}" class="post_checkbox_label"><span>{{$resource->name}}</span></label>
                    </div>
                    <label class="label-count">
                        <input 
                            type="number"
                            min="0"
                            step="0.01"
                            name="{{'volume_resource_'.$resource->id.'_'.$resource->category_id}}"
                            data-category-id="{{$resource->category_id}}" data-resource-id="{{$resource->id}}"
                            value="{{isset($resources_checked[$resource->category_id][$resource->id]) ? $resources_checked[$resource->category_id][$resource->id] : 0 }}"
                            placeholder="Количество"
                        />
                    </label>
                </div>
            @endforeach
        </div>
        @if ($category->children->count() > 0)
            @include('admin.resources-user.categories', ['categories' => $category->children, 'resources_checked' => $resources_checked])
        @endif
    </div>
@endforeach