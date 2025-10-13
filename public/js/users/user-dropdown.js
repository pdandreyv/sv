$('#user-name').keyup(function(event) {
    $('.users-dropdown').empty();
    $('#user_to_id').val('');
    var userName = $('#user-name').val();
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
                       $('#user-name').val('');
                       $('#user_to_id').val('');                                                      
                   } else {
                       $('#user-name').val(data.name);
                       $('#user_to_id').val(data.id);
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
                    $('.users-dropdown').append(res_item);                    
                } 
            }
        });
    }
});

$('.users-dropdown').on('click', '.user-tip-item', function(event) {        
    $('#user-name').val($(this).find('.full-name').text());
    var userId = $(this).find('.user_id').val();    
    $('#user_to_id').val(userId);

    var mode = $(this).parent().parent().find('.users-block').find('#additionalMode').val();    
    switch(mode) {
        case 'addOrder':
            getUserAddresses(userId);
            break;

        default:
        break;
    }

    $('.users-dropdown').empty();        
});

$('#user-name').on('keypress', function(e) {
    return e.which !== 13;
});

function getUserAddresses(userId){
    $.ajax({
        url: '/admin/orders/user-addresses/'+userId,
        type: 'get',
        dataType: 'html',
        async: false,
        success: function(data) {
            $('#selectAddresses').append(data);
        }
    });
}