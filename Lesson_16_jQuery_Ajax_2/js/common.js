$(document).ready(function () {
    function showAlert() {//уведомление об отутствии объявлений
        if($('#ads-list').html() == 0) $('#alert').fadeIn();
    };
    
    $('.panel .close').on('click', function () {//удаление выбранного объявления
        var ads    = $(this).closest('.panel'),
            id     = ads.children('i').html(),
            action = {delete:id};
            
        $.getJSON('index.php', action)
            .always(function(){
                ads.fadeOut(function(){
                    $(this).remove();
                    showAlert();
                });
                if($('input[name="id"]').val() === id){
                    $(':input, form')
                        .find('input[name=private]:first').attr('checked','checked').end()
                        .not(':button, :submit, :reset, :hidden, #fld_price, input[name=private]:first')
                        .val('')
                        .removeAttr('selected')
                        .removeAttr('checked');
                };
            });
    });
    
    $('#del-all').click(function(){//удаление всех объявлений
        var action = {delete:-1};
        
        $.getJSON('index.php', action)
            .always(function(){
                $('#ads-list').fadeOut(function(){
                    $(this).children().remove();
                    showAlert();
                });
            });
    });
});