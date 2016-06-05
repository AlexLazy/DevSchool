$(document).ready(function () {
            
    function showAlert() {//уведомление об отутствии объявлений
        if($('#ads-list').html() == 0) $('#alert').fadeIn();
    };
    
    function clearForm() {//очистка полей формы
        $('input[name=private]:first').prop('checked', true);
        $(':input, form')
            .not(':button, :submit, :reset, #fld_price, input[name=private]:first')
            .val('')
            .removeAttr('selected')
            .removeAttr('checked');
    };

    function fillForm(action) {//заполнение полей формы
        $.getJSON('ajax.php', action)
                .always(function(response){
                    $.each(response[0], function (index, val){
                        var field = $('[name^='+index+']');
                        if(index == 'allow_mails'){
                            if(val) field.prop('checked', true);
                            else field.val(1);
                        }else if(index == 'private'){
                            if(val == 1) field.first().prop('checked', true);
                            else field.last().prop('checked', true);
                        }else if((index == 'location_id' || index == 'category_id') && val == 0){
                            field.val('');
                        }else field.val(val);
                    });
                });
    };

    function switchButtons() {//переключение кнопок управления формой
            $('.title, .edit').click(function(){
            var id     = $(this).closest('.panel').children('i').html(),
                action = {"action":'ad',"id":id},
                ths    = $(this).attr('class');
                
            clearForm()    
            if(ths == 'title') {
                $('#back').fadeIn().on('click', function() {
                    clearForm()
                    $(this).hide();
                    $('#form_submit, #del-all').fadeIn();
                });
                $('#form_submit, #del-all').hide();
            }else if(ths == 'edit'){
                $('#back').fadeIn().on('click', function() {
                    clearForm()
                    $(this).hide();
                    $('#form_submit, #del-all').fadeIn();
                });
                $('#del-all').hide();
                $('#form_submit').fadeIn();
            };
            
            fillForm(action);
        });
    };

    function sorting() {//сортировка
        $('#title, #seller_name, #price').on('click', function () {
            var val = this.id;
                action = {"action":'sort',"id":val};

            $.getJSON('ajax.php', action)
                .always(function(response){
                    panelMaker(response);
                    delAD();
                    switchButtons();
                });
        });    
    };

    function panelMaker(response) {//создание хтмла панелей с объявлениями
        $('#ads-list').html('').append($.each(response, function (i, value) {
                        var color = (value.private == 1) ? "success" : "warning";
                        $('#ads-list').append('<div class="panel panel-' 
                            + color + '"><div class="panel-heading">Название: <a class="title">'
                            + value.title + '</a><a class="close"> × </a></div><div class="panel-body" >Цена: '
                            + value.price + 'руб | Имя: '
                            + value.seller_name + ' | <a class="edit"> Редактировать </a> </div><i class="hidden">'
                            + value.id + '</i></div>');
        }));
    };
    
    function fieldsChecker() {//проверка на заполненность поля
        var error = [];

        $('input').popover({//установка значений всем поповерам
            trigger:'click',
            template:'<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
        });
        if($('#fld_seller_name').val() == "") error.push('#fld_seller_name');
        if($('#fld_title').val() == "") error.push('#fld_title');
        if($('#fld_price').val() == "") error.push('#fld_price');
        if(!error.length)
            return false;
        else
            return error;

    };

    function errorHandler(error) {//обработка не заполненных полей формы
        error.forEach(function(item, i, arr) {
            $(item).popover('show');
        });
    };
    
    function delAD() {
        $('.panel .close').on('click', function () {//удаление выбранного объявления
            var ads    = $(this).closest('.panel'),
                id     = ads.children('i').html(),
                action = {"action":'delete',"id":id};

            $.getJSON('ajax.php', action)
                .always(function(){
                    ads.fadeOut(function(){
                        $(this).remove();
                        showAlert();
                    });
                    if($('input[name="id"]').val() === id) clearForm();
                });
        });    
    };

    $('#del-all').click(function(){//удаление всех объявлений
        var action = {"action":'delete',"id":-1};
        
        $.getJSON('ajax.php', action)
            .always(function(){
                $('#ads-list').children().fadeOut(function(){
                    $(this).remove();
                    showAlert();
                }).end().show();
        });
    });

    $("form").submit(function () {//отправка формы
        var th = $(this);
        $.ajax({
            type: "POST",
            url: "ajax.php?action=save",
            data: th.serialize(),
            dataType: 'json'
        }).done(function (response) {
            panelMaker(response);

            $('input').popover('destroy');
            $('#message').fadeIn().html('Объявление добавлено');
            setTimeout(function () {
                th.trigger("reset");
                $('#message').fadeOut();
            }, 1000);

            delAD();
            switchButtons();
        }).error(function() {
            if(fieldsChecker()) {
                errorHandler(fieldsChecker());
            }else{
                $('#message').fadeIn().html('Произошла ошибка');
                setTimeout(function () {
                        $('#message').fadeOut();
                    }, 1000);
            };
        });
        return false;
    });

    delAD();
    switchButtons();
    sorting();
});