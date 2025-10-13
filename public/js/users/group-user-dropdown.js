$('.users-block').on('keyup', '.user-name', function(event) {
    $('.users-dropdown').empty();
    $(this).parent().find('.user_to_id').val('');
    var userName = $(this).val();
    var currentInput = $(this);
    if(userName.length < 1){                    
        return false;
    }
    if(event.keyCode==13){            
        $.ajax({
            url: '/user/users-find/'+userName,
            type: 'get',
            dataType: 'json',
            async: false,
            success: function(data) {
                if(data.error != undefined){                           
                    currentInput.val('');
                    currentInput.parent().find('.user_to_id').val('');                                                                               
                } else {
                   currentInput.val(data.name);
                   currentInput.parent().find('.user_to_id').val(data.id);
                }                              
            }
        });
    } else {                        
        $.ajax({
            url: '/user/users-drop-down/'+userName,
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
                    currentInput.parent().find('.users-dropdown').append(res_item);                    
                } 
            }
        });
    }
});

$('.users-block').on('click', '.user-tip-item', function(event) {        
    $(this).parent().parent().find('.user-name').val($(this).find('.full-name').text());
    $(this).parent().parent().find('.user_to_id').val($(this).find('.user_id').val());         
    $('.users-dropdown').empty();        
});

$('.users-block').on('keypress', '.user-name', function(event) {        
    return event.which !== 13;
});

function addNewUserInput(){
    var memberInputHtml = '';

    memberInputHtml = '<div class="form-group">'
                        + '<div class="user-block">'
                        +'<div class="wrapper-dropdown">'
                        +'<input type="text" class="user-name form-control" value="" required="required" autocomplete="off">'
                        +'<input type="hidden" name="to_user_id[]" class="user_to_id" value="">'                   
                        +'<ul class="users-dropdown"></ul>'
                        +'</div>'
                        +'</div>'
                        +'</div>';

    $('.users-block').append(memberInputHtml);
}