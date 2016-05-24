$(document).ready(function () {
    $('.panel .close').on('click', function () {//удаление выбранного объявления
        var ads = $(this).closest('.panel'),
            id = ads.children('i').html();
            
        $.get('index.php?delete=' + id, function(){
            ads.fadeOut('slow',function(){
                $(this).remove();
            })
        });
    });
    
    $('#del-all').click(function(){//удаление всех объявлений
        $.get('index.php?delete=-1', function(){
            $('#ads-list').fadeOut('slow',function(){
                $(this).remove();
            })
        });
    });
});