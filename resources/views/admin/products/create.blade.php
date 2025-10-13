@extends('layouts.app')

@section('content')

@include('admin.parts.menu')

<link href="{{ asset('css/uploader/jquery.dm-uploader.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/uploader/styles.css') }}" rel="stylesheet">
<link href="{{ asset('css/uploader/my-styles.css') }}" rel="stylesheet">

<script src="{{ asset('js/uploader/config.js') }}"></script>    
<script src="{{ asset('js/uploader/jquery.dm-uploader.min.js') }}"></script>
<script src="{{ asset('js/uploader/ui.js') }}"></script>

<div class="col-md-9">

<form action="{{route('admin.products.store')}}" class="form-horizontal" method="post">
    {{ csrf_field() }}
    <div class="form-group">
    <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a>
    <h4>Добавить продукт</h4><hr>  
    </div>  

    <div class="form-group">
        <label for="name">ПОЛЬЗОВАТЕЛЬ</label>
        <select name="user_id" class="form-control">
            <option value=""></option>           
            @foreach ($users as $user)
                @php
                    $selected = (old('user_id')!==null && $user->id == old('user_id'))?'selected="selected"':'';
                @endphp
                <option value="{{$user->id}}" {{$selected}}>{{$user->name}}</option>
            @endforeach
        </select>        
    </div>
    @if($errors->has('user_id'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('user_id') }}
        </div>
    @endif

    <div class="form-group">    
        <input type="checkbox" name="is_service" {{old('is_service')?'checked="checked"':''}} id="is_service">            
        <label>Это услуга</label>
    </div>

    <div id="categories-area">    
    
    @if(isset($categoriesNeighbours))
        @php
        $label = 0;
        @endphp

        @foreach ($categoriesNeighbours as $category => $neighbours)

            <div class="form-group"> 
            @if(!$label)
                @php
                $label = 1;
                @endphp
                <label for="parent">Категория</label>         
            @endif           
            <select class="form-control category-control" name="category_id[]">
            <option value=""></option>    
            @foreach ($neighbours as $neighbour)
                @php
                $selected = ($neighbour->id == $category);
                @endphp
                <option {{$selected?'selected="selected"':''}} value="{{$neighbour->id}}">{{$neighbour->title}}</option>
            @endforeach
            </select>
            </div>
        @endforeach 
    @else
        <div class="form-group">    
        <label for="parent">Категория</label>
        <select class="form-control category-control" name="category_id[]">
        <option value=""></option>    
        @foreach ($catLevel1 as $cat)
            <option value="{{$cat->id}}">{{$cat->title}}</option>
        @endforeach
        </select>
        </div>
    @endif
    </div>

    @if($errors->has('category_id'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('category_id') }}
        </div>
    @endif   

    <div class="form-group">
        <label for="name">Наименование</label>
        <input type="text" name="title" class="form-control" value="{{old('title')}}" >
    </div>
    @if($errors->has('title'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('title') }}
        </div>
    @endif
    
    <div class="form-group">
        <label for="description">Описание</label>
        <input type="text" name="description" class="form-control" value="{{old('description')}}" >
    </div>              
    @if($errors->has('description'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('description') }}
        </div>
    @endif

    <div class="form-group">
        <label for="description">Цена</label>
        <input type="text" name="price" class="form-control" value="{{old('price')}}" >
    </div>              
    @if($errors->has('price'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('price') }}
        </div>
    @endif

    <div class="form-group">
        <label for="description">Цена для кооператива</label>
        <input type="text" name="cooperative_price" class="form-control" value="{{old('cooperative_price')}}" >
    </div>              
    @if($errors->has('cooperative_price'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('cooperative_price') }}
        </div>
    @endif    

    <div class="form-group">
        <label for="description">Место производства</label>
        <input type="text" name="production_place" class="form-control" value="{{old('production_place')}}" >
    </div>              
    @if($errors->has('production_place'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('production_place') }}
        </div>
    @endif

    <div class="form-group">
        <label for="description">Количество</label>
        <input type="text" name="quantity" class="form-control" value="{{old('quantity')}}" >
    </div>              
    @if($errors->has('quantity'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('quantity') }}
        </div>
    @endif

    <div class="form-group">
        <label for="description">Вес</label>
        <input type="text" name="weight" class="form-control" value="{{old('weight')}}" >
    </div>              
    @if($errors->has('weight'))
        <div class="form-group alert alert-danger">
            {{ $errors->first('weight') }}
        </div>
    @endif    

    <div class="form-group">    
        <input type="checkbox" name="is_confirmed" {{old('is_confirmed')?'checked="checked"':''}}>            
        <label>Подтвержден</label>
    </div>

    @include('admin.products.parts.uploader')

    <div class="form-group">        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

</div>

<script>
    $( document ).ready(function() {
        $('#is_service').on('change', function () {        
            $('#categories-area .form-group').remove();
            var for_service = $('#is_service').prop("checked")?1:0;
            $.ajax({
                url: '/admin/product-categories/childs/0/for_service/'+for_service,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {                                                                
                    if(Object.keys(data).length){
                        var newSelect = 
                            '<div class="form-group">'
                            + '<label for="category_id">Категория</label>'
                            +'<select class="form-control category-control" name="category_id[]">'
                            + '<option value=""></option>';
                        for(i in data){
                            newSelect += '<option value="'+data[i].id+'">'+data[i].title+'</option>';                                        
                        }
                        newSelect += '</select>';
                        newSelect += '</div>';                                             

                        $('#categories-area').append(newSelect); 
                    }
                }
            });
        });        

        $('#categories-area').on('change', '.category-control', function () {
            var selected_item = $( this ).find("option:selected").val();
            var currentIdx = $(this).parent().index();
            $('#categories-area .form-group:gt(' + currentIdx + ')').remove();
            var for_service = $('#is_service').prop("checked")?1:0;
            $.ajax({
                url: '/admin/product-categories/childs/'+selected_item+'/for_service/'+for_service,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {                                                                
                    if(Object.keys(data).length){
                        var newSelect = 
                            '<div class="form-group">'
                            +'<select class="form-control category-control" name="category_id[]">'
                            + '<option value=""></option>';
                        for(i in data){
                            newSelect += '<option value="'+data[i].id+'">'+data[i].title+'</option>';                                        
                        }
                        newSelect += '</select>';
                        newSelect += '</div>';                                             

                        $('#categories-area').append(newSelect);
                    }
                }
            });        
        });            
    });
</script>

@endsection