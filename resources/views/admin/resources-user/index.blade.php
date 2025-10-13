@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Список пожеланий</h3>
        </div>
        <hr />
        <div class="btn-container form-group">
            <a href="{{ route('admin.resources.index') }}" class="btn btn-info btn-back"><i class="fas fa-arrow-left"></i>Назад</a>
        </div>
        <hr />
        <div class="btn-container user-select-field">
            @include('admin.resources-user.form-user-resources', ['users' => $users])
        </div>
        <hr />
        <form id="admin-user-resources" action="{{route('admin.resources.save')}}" class="form-horizontal" method="get">
            {{ csrf_field() }}
            <div class="items-list">
                @include('admin.resources-user.categories', ['categories' => $categories, 'resources_checked' => $resources_checked])
            </div>
        </form>
    </div>

    <script>
        $( document ).ready(function() {
            var sendTimer;
            var doneTimer = 600;
            var $checkboxInput = $('.items-list input:checkbox');
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