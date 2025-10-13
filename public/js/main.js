(function($){
    $(document).ready(function() {

        var goodsHeight = $('#goods').height();
        var servicesHeight = $('#services').height();
        var maxGoodsServicesHeight = Math.max(goodsHeight, servicesHeight);
        $('#goods').css('min-height', maxGoodsServicesHeight + 'px');
        $('#services').css('min-height', maxGoodsServicesHeight + 'px');

        $('.tab-content .tab-pane li .item .toggle:not(.disabled)').on('click', function() {
            $(this).parent().parent().parent().children('ul').toggleClass('show');
            $(this).toggleClass('opened').toggleClass('btn-success');
        })

        $('.form-group.img').each(function() {
            $(this).height($(this).width());
        })

        $('.form-group.img img').each(function() {
            var imgW = $(this).width();
            var imgH = $(this).height();
            if (imgW >= imgH) {
                $(this).css('width', '100%');
            } else {
                $(this).css('height', '100%');
            }
        })

        $( "#contactFormModal" ).on('hidden.bs.modal', function(){
            $('.name-error').empty();
            $('.email-error').empty();
            $('.phone-error').empty();
            $('.subject-error').empty();
            $('.message-error' ).empty();
            $('.send-success' ).empty();
        });

        $("#contact_form").submit(function(e){
            e.preventDefault();
            var formData = new FormData(document.forms.contact_form);

            $('.name-error').empty();
            $('.email-error').empty();
            $('.phone-error').empty();
            $('.subject-error').empty();
            $('.message-error' ).empty();
            $('.send-success' ).empty();

            xhr = new XMLHttpRequest();

            xhr.open("POST", '/send-contact-form');
      
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if(xhr.status == 200) {
                        var data = JSON.parse(xhr.response);
                        if(data.errors!=undefined){
                            if(data.errors.name){
                                $( '.name-error' ).append( 
                                    '<div class="form-group alert alert-danger">'
                                    + data.errors.name[0]
                                    +'</div>'
                                );
                            }
                            if(data.errors.email){
                                $( '.email-error' ).append(
                                '<div class="form-group alert alert-danger">'
                                + data.errors.email[0]
                                +'</div>'
                                );
                            }
                            if(data.errors.phone){
                                $( '.phone-error' ).append(
                                '<div class="form-group alert alert-danger">'
                                + data.errors.phone[0]
                                +'</div>' 
                                );
                            }

                            if(data.errors.subject){
                                $( '.subject-error' ).append(
                                '<div class="form-group alert alert-danger">'
                                + data.errors.subject[0]
                                +'</div>' 
                                );
                            }

                            if(data.errors.message){
                                $( '.message-error' ).append(
                                '<div class="form-group alert alert-danger">'
                                + data.errors.message[0]
                                +'</div>' 
                                );
                            }
                        } 

                        if(data.success != undefined){
                            $( '.send-success' ).append(
                                '<div class="form-group alert alert-success">'
                                + 'Ваш запрос успешно отправлен администратору'
                                +'</div>' 
                            );
                        }
                    }
                }
            };
            
            xhr.send(formData);
        });

        var myPageAddPostText = 'Добавить информацию';
        var myPageCollapseText = 'Свернуть Редактор';
        var oldPostContent = $('#content').data('value');

        //Summernote
        //$('#content').summernote();
        /*$('#clear_post').on('click',function(e){
            e.preventDefault();
            $('#content').summernote('code', null);
        });*/
        //$('#content').summernote('code',oldPostContent);

        //Post toggle button functionality
        $('#add_post_toggle').on('click', function() {
            $(this).text(function(i, v){
               return v === myPageAddPostText ? myPageCollapseText : myPageAddPostText;
            })
            $('#add_post').toggle();
        })
        if ( $('#add_post .errors').length ) {
            $('#add_post').toggle(true);
            $('#add_post_toggle').text(myPageCollapseText);
        }

        if ( $('#admin-side-menu .active').length == 0 ) {
            $('#admin-side-menu li.dashboard').addClass('active');
        }

        $('.sticky-post').on('click', function(e) {
            e.preventDefault();
        })

        $(window).on('resize', function() {
            blockSize('#user-photo');
            blockSize('.dashboard .col-12');
            blockSize('.product .media .photo');
        });

        blockSize('#user-photo', true);
        blockSize('.dashboard .col-12');
        blockSize('.product .media .photo', true);

        //Resources
        $('.items-list:not(.admin) .item').each(function(i,e) {
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

        $('.items-list.admin .item').each(function(i,e) {
            var childs = $(this).find('.resource:not(.heading)');
            var selector = $(this).children('.option').children('.icons-container').children('span').children('.count');
            if (childs.length > 0) {
                selector.html(childs.length);
                $(this).children('.option').children('.icons-container').children('.circle').css('display', 'none');
            } else {
                 selector.html('0');
                 selector.parent().parent().parent().css('display', 'none');
                 $(this).children('.option').children('.icons-container').children('minus').css('display', 'none');
                 $(this).children('.option').children('.icons-container').children('.plus').css('display', 'none');
                 $(this).children('.option').children('.icons-container').children('.circle').css('display', 'inline-block');
            }
        });

        $('.items-list:not(.admin) .item.parent > .option').on('click', function() {
            var childs = $(this).parent().find('input:checkbox');
            if (childs.length > 0) {
                $(this).parent().toggleClass('opened');
            }
        })
        $('.items-list:not(.admin) .item > .option .icons-container').on('click', function() {
            var childs = $(this).parent().find('input:checkbox');
            if (childs.length > 0) {
                $(this).parent().toggleClass('opened');
            }
        })

        $('.items-list.admin .item.parent > .option').on('click', function() {
            // var childs = $(this).parent().find('input:checkbox');
            // if (childs.length > 0) {
                $(this).parent().toggleClass('opened');
            // }
        })
        $('.items-list.admin .item > .option .icons-container').on('click', function() {
            // var childs = $(this).parent().find('input:checkbox');
            // if (childs.length > 0) {
                $(this).parent().toggleClass('opened');
            // }
        })


        $("#admin-add-to-resource-user select#user_id").change(function(){
            $("#admin-add-to-resource-user").submit();
        })

        function blockSize($selector, $isImage=false) {
            var outerWidth = $($selector).outerWidth();
            var innerWidth = $($selector).outerWidth();
            $($selector).css('height', outerWidth + 'px');
            $($selector).css('max-height',outerWidth + 'px');

            if ( $isImage ) {
                var img = $($selector + ' img');
                var imgW = img.width();
                var imgH = img.height();
                if (imgW > imgH) {
                    img.css('width', '100%');
                    img.css('max-height', innerWidth + 'px');
                } else {
                    img.css('width', 'auto');
                    img.css('max-height', innerWidth + 'px');
                }
            }
        }
        $('.add_cart_btn').on('click', function(e) {
            var product_id = $(this).parent().find('.product_id').val();
            var quantity = $(this).parent().find('.quantity').val();
            $.ajax({
                url: '/cart/add-cart/product-id/'+product_id+'/quantity/'+quantity,
                type: 'get',
                dataType: 'json',
                async: false,
                success: function(data) {
                    if(data.fail=='not-autorised'){
                        $("#unloginBasketModal").modal('show');
                    } else if(data.fail=='not-cooperative'){
                        $("#loginBasketModal").modal('show');
                    } else {
                        $('#cart-quantity').text(data.success.totalQuantity);
                        $('#cart-total').text(data.success.totalAmount);
                        alert('Товар был успешно добавлен в корзину!');
                    }
                }
            });
        })
    });
})(jQuery);

/***
number - исходное число
decimals - количество знаков после разделителя
dec_point - символ разделителя
thousands_sep - разделитель тысячных
***/
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}