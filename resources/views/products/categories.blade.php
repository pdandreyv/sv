@foreach ($categories as $category)
    @if($category->children->count() > 0)
        <div class="parent col-sm-12 col-md-6 item">
    @else
        <div class="col-sm-12 col-md-6 item">
    @endif
        <div class="option">
            <label><input type="radio" name="category_id" value="{{$category->id}}" {{ isset($current) ? ($current == $category->id ? "checked" : "") : "" }} ><span>{{$category->title}}</span></label>
        </div>
        @if($category->children->count() > 0)
            @include('products.categories', ['categories' => $category->children])
        @endif
    </div>
@endforeach