@extends('layouts.app')

@section('content')

    @include('parts.sidebar')

    <div class="col-md-9">
        <div class="title">
            <h3>Моя потребительская корзина</h3>
        </div>
        <hr />
        <div class="panel panel-info">
            Если в списке отсутсвует желаемый товар, то Вы можете отправить запрос на добавление через форму обртаной связи или связаться со своим УПС по телефону.
        </div>
        <hr />
        <form action="{{route('resources.save')}}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            <div class="items-list">
                @include('resources.categories', ['categories' => $categories, 'resources_checked' => $resources_checked, 'resources_units' => $resources_units ])
            </div>
        </form>
    </div>

    <script>
        $( document ).ready(function() {
            var sendTimer;
            var doneTimer = 500;
            var $checkboxInput = $('.resources-index input:checkbox');
            var $volumeInput = $('.label-count input');
            $checkboxInput.click(function () {
              clearTimeout(sendTimer);
              sendTimer = setTimeout(sendUserResources, doneTimer, this, 'checkbox', $(this).prop('checked'));
            });
            $volumeInput.on('keyup', function () {
                clearTimeout(sendTimer);
                sendTimer = setTimeout(sendUserResources, doneTimer, this, 'input_field', '');
            });
            $volumeInput.on('keydown', function () {
              clearTimeout(sendTimer);
            });
            $volumeInput.on('focusout', function () {
              setTimeout(sendUserResources, doneTimer, this, 'input_field');
            });

            function sendUserResources (obj, type, checked) {
                var resource_id = $(obj).data('resource-id');
                var category_id = $(obj).data('category-id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                var user_id = {{ Auth::user()->id }};
                if (type == 'input_field') {
                    console.log('input_field');
                    var volume = $(obj).val();
                    var $checkboxSelector = $(obj).parent().parent().children('.label-check').children('.switch-checkbox');
                    if ( volume == 0) {
                        checked = 'false';
                        $checkboxSelector.prop('checked', false); 
                    } else {
                        checked = 'true';
                        $checkboxSelector.prop('checked', true);
                    }
                } else if (type == 'checkbox') {
                    $('.items-list .item').each(function(i,e) {
                        var childs = $(this).find('input:checkbox');
                        var checked = $(this).find('input:checkbox:checked');
                        var selector = $(this).children('.option').children('.icons-container').children('span').children('.count');
                        if (childs.length > 0) {
                            selector.html(checked.length + ' из ' + childs.length);
                            $(this).children('.option').children('.icons-container').children('.circle').css('display', 'none');
                        } else {
                             selector.html('0');
                             selector.parent().parent().parent().css('display', 'none');
                             $(this).children('.option').children('.icons-container').children('minus').css('display', 'none');
                             $(this).children('.option').children('.icons-container').children('.plus').css('display', 'none');
                             $(this).children('.option').children('.icons-container').children('.circle').css('display', 'inline-block');
                        }
                    });
                    var $volumeSelector = $(obj).parent().parent().children('.label-count').children('input');
                    var volume = $volumeSelector.val();
                    if ( checked == true && volume == 0 ) {
                        volume = 1;
                        $volumeSelector.val(1);
                    } else if (checked == false) {
                        volume = 0;
                        $volumeSelector.val(0);
                    }
                }
                volume = volume.replace(',','.');
                volume = parseFloat(volume)
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/resources/save',
                    dataType: 'json',
                    data: {_token, checked, category_id, resource_id, user_id, volume},
                    async: true
                });
            }
        });
    </script>

@endsection