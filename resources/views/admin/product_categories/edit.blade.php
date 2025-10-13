@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">

    <form class="form-horizontal" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
        <a href="{{ url()->previous() }}" class="btn btn-default"><i class="fas fa-arrow-left"></i>Назад</a>
        <h4>Редактировать категорию</h4><hr>  
        </div>      
        <div class="form-group">
            <label for="title">НАИМЕНОВАНИЕ</label>
            <input type="text" name="title" class="form-control" value="{{$category->title}}">
        </div>  
        @if($errors->has('title'))
            <div class="form-group alert alert-danger">
                {{ $errors->first('title') }}
            </div>
        @endif 
        <div class="form-group">
            <label for="description">Описание</label>
            <input type="text" name="description" class="form-control" value="{{$category->description}}" >
        </div>

        <div class="form-group row sticky">
            <input type="hidden" value="0" name="for_service">
            <input type="checkbox" class="switch-checkbox" id="for_service" name="for_service" value="1" {{$category->for_service?'checked="checked"':''}} />
            <label for="for_service" class="post_checkbox_label"></label>
            <span>Категория услуг</span>
        </div>
        <div id="categories-area">
            @php
                $label = 0;
            @endphp
            @foreach ($parentsNeighbours as $parent => $neighbours)
                <div class="form-group"> 
                    @if(!$label)
                        @php
                            $label = 1;
                        @endphp
                        <label for="parent">Родитель</label>
                    @endif
                    <select class="form-control category-control" name="parent[]">
                    <option value=""></option>
                    @foreach ($neighbours as $neighbour)
                        @php
                            $selected = ($neighbour->id == $parent);
                        @endphp
                        <option {{$selected?'selected="selected"':''}} value="{{$neighbour->id}}">{{$neighbour->title}}</option>
                    @endforeach
                    </select>
                </div>
            @endforeach
        </div>
        <div class="pictures">
            <div class="col-sm-12 col-md-6">
                <label for="photo_file" class="col-sm-12">Фото категории</label>
                <div class="form-group img col-sm-12">
                    @if(!empty($category->photo))
                        <img src="/images/product_category_photos/{{$category->photo}}">
                    @else
                        <img src="/images/placeholder.png" alt="Фото категории">
                    @endif
                </div>
                <div class="form-group col-sm-12 field">
                    <div class="input-group input-file scan-choose" name="photo_file">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-choose" type="button">
                                <span><i class="far fa-image"></i></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" placeholder='Выбрать...' />
                        <span class="input-group-btn">
                             <button class="btn btn-warning btn-reset" type="button">
                                <span><i class="fas fa-sync-alt"></i></span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <label for="icon_file" class="col-sm-12">Иконка категории</label>
                <div class="form-group img col-sm-12">
                    @if(!empty($category->icon))
                        <img src="/images/product_category_photos/{{$category->icon}}">
                    @else
                        <img src="/images/placeholder.png" alt="Фото категории">
                    @endif
                </div>
                <div class="form-group col-sm-12 field">
                    <div class="input-group input-file scan-choose" name="icon_file">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-choose" type="button">
                                <span><i class="far fa-image"></i></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" placeholder='Выбрать...' />
                        <span class="input-group-btn">
                             <button class="btn btn-warning btn-reset" type="button">
                                <span><i class="fas fa-sync-alt"></i></span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>

    </div>

    <script>
        $( document ).ready(function() {
            $('#for_service').on('change', function () {        
                $('#categories-area .form-group').remove();
                var for_service = $('#for_service').prop("checked")?1:0;
                $.ajax({
                    url: '/admin/product-categories/childs/0/for-service/'+for_service,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        if(Object.keys(data).length){
                            var newSelect = 
                                '<div class="form-group">'
                                + '<label for="parent">Родитель</label>'
                                +'<select class="form-control category-control" name="parent[]">'
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
                var for_service = $('#for_service').prop("checked")?1:0;
                $.ajax({
                    url: '/admin/product-categories/childs/'+selected_item+'/for-service/'+for_service,
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        if(Object.keys(data).length){
                            var newSelect = 
                                '<div class="form-group">'
                                +'<select class="form-control category-control" name="parent[]">'
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
        function bs_input_file() {
            $(".input-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0' accept='.jpg,.jpeg,.png'>");
                        element.attr("name",$(this).attr("name"));
                        element.change(function(){
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                        });
                        $(this).find("button.btn-choose").click(function(){
                            element.click();
                        });
                        $(this).find("button.btn-reset").click(function(){
                            element.val(null);
                            $(this).parents(".input-file").find('input').val('');
                        });
                        $(this).find('input').css("cursor","pointer");
                        $(this).find('input').mousedown(function() {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return element;
                    }
                }
            );
        }

        $(function() {
            bs_input_file();
        });
    </script>

@endsection