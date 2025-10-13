@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9 create-category">
        <div class="title">
            <h3>Добавить подкатегорию в "{{$parent->title}}" (id:{{$parent->id}})</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.product-categories') }}" class="btn btn-default btn-add">Назад</a>
        </div>
        <hr />
        <form action="{{route('admin.product-categories.store-child')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="for_service" id="for_service"  value={{old('for_service')?old('for_service'):$parent->for_service}}>
            <input type="hidden" name="parent_id" id="parent_id" value={{$parent->id}}>
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" name="title" class="form-control" value="{{old('title')}}" >
            </div>
            @if($errors->has('title'))
                <div class="form-group alert alert-danger">
                    {{ $errors->first('title') }}
                </div>
            @endif
            
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea  name="description" class="form-control" value="{{old('description')}}"></textarea>
            </div>

            <div class="pictures">
                <div class="form-group col-sm-12 col-md-6" style="padding-left: 0; padding-right: 7.5px;">
                    <label for="photo_file">Фото</label>
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

                <div class="form-group col-sm-12 col-md-6" style="padding-right: 7.5px; padding-right: 0;">
                    <label for="name">Иконка</label>
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

            <div class="form-group">
                <button type="submit" class="btn btn-success">Добавить</button>
            </div>
        </form>

        <script type="text/javascript">
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

    </div>




@endsection