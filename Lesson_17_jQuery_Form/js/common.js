$(document).ready(function () {
    $.getJSON('ajax.php')
        .always(function(response){
            panelMaker(response);
            pagination(response);
        });

    var formOptions = {
        beforeSubmit:  validate,
        success:       showResponse,
        replaceTarget: true,
        url:           'ajax.php?action=save',
        dataType:      'json',
        resetForm:     true
    }; 
     
    $('form').ajaxForm(formOptions);

    function validate() {
        if(fieldsChecker()) {
            errorHandler(fieldsChecker());
        }else{
            $('#message').fadeIn().html('Произошла ошибка');
            setTimeout(function () {
                    $('#message').fadeOut();
                }, 1000);
        };
    }

    //проверка на заполненность поля
    function fieldsChecker() {
        var error = [];

        $('input').popover({//установка значений всем поповерам
            trigger:'manual',
            template:'<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
        });
    
        if($('#fld_seller_name').val() == "") error.push('#fld_seller_name');
        if($('#fld_title').val() == "")       error.push('#fld_title');
        if($('#fld_price').val() == "")       error.push('#fld_price');

        if(!error.length)
            return false;
        else
            return error;

    }

    //обработка не заполненных полей формы
    function errorHandler(error) {
        error.forEach(function(item, i, arr) {
            $(item).popover('show');
        });
    };

    function showResponse(response) {
        panelMaker(response);

        $('#message').fadeIn().html('Объявление добавлено');
        setTimeout(function () {
            $('#message').fadeOut();
        }, 1000);
        pagination(response);
    }

    //уведомление об отутствии объявлений
    function showAlert() {
        if($('#ads-list').html() == 0) $('#alert').fadeIn();
    }

    //очистка полей формы
    function clearForm() {
        $('input[name=private]:first').prop('checked', true);
        $('#fld_price').val('0');
        $(':input, form')
            .not(':button, :submit, :reset, #fld_price, input[name=private]:first')
            .val('')
            .removeAttr('selected')
            .removeAttr('checked');
    }

    //заполнение полей формы
    function fillForm(action) {
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
    }

    //переключение кнопок управления формой
    $(document).on('click', '.title, .edit', function(){
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
                return false;
            });
            $('#del-all').hide();
            $('#form_submit').fadeIn();
        };
        
        fillForm(action);
        return false;
    });
    
    //создание хтмла панелей с объявлениями
    function panelMaker(response) {
        $('#ads-list').html('').append($.each(response, function (i, value) {
                        var color = (value.private == 1) ? "success" : "warning";
                        $('#ads-list').append('<div class="panel panel-' 
                            + color + '"><div class="panel-heading">Название: <a class="title">'
                            + value.title + '</a><a class="close" title="Удалить"> × </a></div><div class="panel-body" >Цена: '
                            + value.price + 'руб | Имя: '
                            + value.seller_name + ' | <a class="edit"> Редактировать </a> </div><i class="hidden">'
                            + value.id + '</i></div>');
        }));
    }

    $(document).on('focus', 'input', function(){
        $(this).popover('destroy');
    });

    //удаление выбранного объявления
    $(document).on('click', '.panel .close', function () {
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
        return false;
    });

    //удаление всех объявлений
    $('#del-all').click(function(){
        var action = {"action":'delete',"id":-1};
        
        $.getJSON('ajax.php', action)
            .always(function(){
                $('#ads-list').children().fadeOut(function(){
                    $(this).remove();
                    showAlert();
                }).end().show();
        });
        return false;
    });

    //сортировка
    $('#title, #seller_name, #price').on('click', function () {
        var val    = this.id;
            action = {"action":'sort',"id":val};
        $.cookie('sort', val);
        $.getJSON('ajax.php', action)
            .always(function(response){
                panelMaker(response);
                pagination(response);
            });
        return false;
    });

    //пагинация
    function pagination(response) {
        var amtItems     = response.length,
            visibleItems = 5,
            pages        = Math.ceil(amtItems/visibleItems);

        $("#ads-list").children().hide();
        $("#ads-list").children().slice(0, 5).show();

        $('#pagination').bootpag({
            total: pages,
            maxVisible: 5
        }).on("page", function(event, num){
            var pages = Math.ceil($("#ads-list").children().length/visibleItems);

            $(this).bootpag({total: pages});
            $("#ads-list").children().hide();
            $("#ads-list").children().slice(num * visibleItems - visibleItems, num * visibleItems).show();
        });
    }
})
