$('.name-control').keyup(function(event) {
    var parent = $(this).parent();
    parent.find('.users-dropdown').empty();
    parent.find('.id-hidden').val('');
    var userType = parent.find('.id-hidden').attr('id');    
    var userName = $(this).val();
    if(userName.length < 1){                    
        return false;
    }
    if(event.keyCode==13){            
        $.ajax({
            url: '/admin/network/users-find/'+userName+'/user-type/'+userType,
            type: 'get',
            dataType: 'json',
            async: false,
            success: function(data) {
                   if(data.error != undefined){                           
                       parent.find('.name-control').val('');
                       parent.find('.id-hidden').val('');
                       if(userType == 'ups1_id'){
                            $('#ups2_id').val('');
                            $('.ups2-name').val('');
                            $('#ups3_id').val('');
                            $('.ups3-name').val('');
                       }
                   } else {
                        parent.find('.name-control').val(data.user.fullName);
                        parent.find('.id-hidden').val(data.user.id);

                        if(userType == 'ups1_id'){
                            if(data.ups2){
                                 $('#ups2_id').val(data.ups2.id);
                                 $('.ups2-name').val(data.ups2.fullName);
                                 if(data.ups3){
                                     $('#ups3_id').val(data.ups3.id);
                                     $('.ups3-name').val(data.ups3.fullName);
                                 } else {
                                     $('#ups3_id').val('');
                                     $('.ups3-name').val('');
                                 }
                            } else {
                                $('#ups2_id').val('');
                                $('.ups2-name').val('');
                                $('#ups3_id').val('');
                                $('.ups3-name').val('');
                            }
                        }                       
                   }                              
            }
        });
    } else {                        
        $.ajax({
            url: '/admin/network/users-drop-down/'+userName+'/user-type/'+userType,
            type: 'get',
            dataType: 'json',
            async: false,
            success: function(data) {
                for(var i in data){
                    if(data[i].photo){
                        var src = '/images/users_photos/'+data[i].photo;
                    } else {
                        var src = PLACEHOLDER_URL + '100x100/00d2ff/ffffff';
                    }

                    var res_item = '<li class="user-tip-item">'
                        +'<div class="img-container">'
                            +'<img class="preview-img" width="100" src="'+src+'" alt="Generic placeholder image">'
                        +'</div>'
                        +'<ul class="info-container">'                   
                            +'<li class="full-name">'+data[i].last_name+' '+data[i].first_name+' '+data[i].middle_name+'</li>'
                        +'</ul>'
                        +'<input type="hidden" class="user_id" value="'+data[i].id+'">'
                    +'</li>';
                    parent.find('.users-dropdown').append(res_item);                    
                } 
            }
        });
    }
});

$('.users-dropdown').on('click', '.user-tip-item', function(event) {   
    var wrapperEl = $(this).parent().parent();
    
    wrapperEl.find('.name-control').val($(this).find('.full-name').text());
    var userId = $(this).find('.user_id').val();    
    wrapperEl.find('.id-hidden').val(userId);    

    wrapperEl.find('.users-dropdown').empty(); 
    
    var userType = wrapperEl.find('.id-hidden').attr('id');
    
    if(userType == 'ups1_id'){
        $.ajax({
            url: '/admin/network/ups1-get-parent-nodes/'+userId,
            type: 'get',
            dataType: 'json',
            async: false,
            success: function(data) {
                if(data.ups2){
                    $('#ups2_id').val(data.ups2.id);
                    $('.ups2-name').val(data.ups2.fullName);
                    if(data.ups3){
                        $('#ups3_id').val(data.ups3.id);
                        $('.ups3-name').val(data.ups3.fullName);
                    } else {
                        $('#ups3_id').val('');
                        $('.ups3-name').val('');
                    }
                } else {
                    $('#ups2_id').val('');
                    $('.ups2-name').val('');
                    $('#ups3_id').val('');
                    $('.ups3-name').val('');
                }
            }
        });
    }
});

$('.name-control').on('keypress', function(e) {
    return e.which !== 13;
});