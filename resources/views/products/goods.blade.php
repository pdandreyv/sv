@extends('layouts.app')

@section('content')
<br>    
    <div class="title">
        <center><h2>{{$pageTitle}}</h2></center>
    </div>
    <br><br>
<div class="panel-categories">
    <br>
    <div class="row">
        @foreach ($categories as $category)
            <div class="col-md-2 category-item">
                    <a href="{{ route('products.category', ['category_id' => $category->id]) }}" title="{{$category->description}}">
                         <div class="photo">
                            @if (!empty($category->photo))
                                <img class="cat-img" src="/images/product_category_photos/{{$category->photo}}" alt="{{$category->title}}">
                             @else
                               <img src="/images/placeholder.png" alt="temporary_no_photo">
                            @endif
                         </div>
                         <div class="title">
                            <h3>{{$category->title}}</h3>
                         </div>
                    </a>
            </div>
        @endforeach
    </div>
   <br><br>
</div>
@endsection