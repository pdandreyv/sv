<div class="row dm-uploader-panel">
    <div style="padding-left:0" class="col-md-6 col-sm-12">
        <!-- Our markup, the important part here! -->
        <div id="drag-and-drop-zone" class="dm-uploader p-5">
            <h3 class="mb-5 mt-5 text-muted text-center">Вы можете перетащить сюда изображения</h3>

            <div class="btn btn-primary btn-block mb-5">
                <span>Загрузить изображения</span>
                <input type="file" title='Click to add Files' />
            </div>
        </div><!-- /uploader -->
    </div>

    <div style="padding-right:0" class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
              Список изображений
            </div>
            <ul class="list-unstyled p-2 flex-column" id="files">
                @if(isset($uploadedFiles))
                    @foreach ($uploadedFiles as $uploadedFile)
                        <li class="media">
                        <input type="radio" name="main_photo" value="{{$uploadedFile['new_name']}}" 
                        @if (old('main_photo'))
                            @if ($uploadedFile['new_name'] === old('main_photo'))
                                checked="checked"
                            @endif
                        @else
                            @if ($uploadedFile['main'])
                                checked="checked"
                            @endif
                        @endif
                        >
                        <img class="mr-3 mb-2 preview-img" src="{{asset('images/products/'.$uploadedFile['new_name'])}}" alt="Generic placeholder image">

                        <div class="media-body mb-1">
                            <p class="mb-2">
                            <strong>{{$uploadedFile['old_name']}}</strong> - Status: <span class="text-success">Upload Complete</span>
                            </p>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-primary bg- bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                            </div>        
                            <hr class="mt-1 mb-1" />
                        </div>
                        <span class="fa fa-times delete-icon" aria-hidden="true"></span>
                        </li>
                    @endforeach
                @else
                    <li class="text-muted text-center empty">Изображения еще не загружены</li>
                @endif  
            </ul>
        </div>
    </div>
</div><!-- /file list -->
  
<!--<div class="row">
    <div class="col-12">
    <div class="card h-100">
        <div class="card-header">
        Debug Messages
        </div>

        <ul class="list-group list-group-flush" id="debug">
            <li class="list-group-item text-muted empty">Loading plugin....</li>
        </ul>
    </div>
    </div>
</div>--> <!-- /debug -->

<!-- File item template -->
<script type="text/html" id="files-template">
    <li class="media">
    <input type="radio" name="main_photo" value="">
    <img class="mr-3 mb-2 preview-img" src="https://danielmg.org/assets/image/noimage.jpg?v=v10" alt="Generic placeholder image">

    <div class="media-body mb-1">
        <p class="mb-2">
        <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
        </p>
        <div class="progress mb-2">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
            role="progressbar"
            style="width: 0%" 
            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>        
        <hr class="mt-1 mb-1" />
    </div>
    <span class="fa fa-times delete-icon" aria-hidden="true"></span>
    </li>
</script>

<!-- Debug item template -->
<script type="text/html" id="debug-template">
    <li class="list-group-item text-%%color%%"><strong>%%date%%</strong>: %%message%%</li>
</script>

<script type="text/javascript">

    uploadUrl = '/admin/products/ajaxUpload';

     $('#files').on('click', '.delete-icon', function(){        
        var fileName = $(this).parent().find("[name='main_photo']").val();
        var product_id = $('#product_id').val();        
        $.ajax({
            type: "POST",
            url: "/admin/products/fileRemove",
            datatype: 'json',
            data: {
                name: fileName,
                product_id: product_id
            },
            success: function(json){
                $('[value="'+fileName+'"]').parent().remove();
            }
        });
    })
</script>