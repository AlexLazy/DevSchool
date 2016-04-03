<form  method="POST">
    {html_radios name="private" options=$private_arr selected=$private}
    <div class="input-group">
        <label for="fld_seller_name" class="label label-primary">
            <b>Ваше имя</b>
        </label>
        <input required type="text" maxlength="40" pattern="(\D+)" class="form-control" value='{$seller_name}' name="seller_name" id="fld_seller_name">
    </div>
    <div class="input-group">
        <label for="fld_email" class="label label-primary">Электронная почта</label>
        <input type="text" class="form-control" pattern="(\w+@[a-zA-Z_]+?\.[a-zA-Z]{ldelim}2,6{rdelim})" value='{$email}' name="email" id="fld_email">
    </div>
    <div class="input-group">
        <label class="form-label-checkbox" for="allow_mails">
            {html_checkboxes name="allow_mails" options=$allow_mails_arr selected=$allow_mails}
        </label>
    </div>
    <div class="input-group">
        <label id="fld_phone_label" for="fld_phone" class="label label-primary">Номер телефона</label>
        <input type="text" class="form-control" value="{$phone}" name="phone" id="fld_phone">
    </div>
    <div id="f_location_id" class="input-group">
        <div class="input-group">
            <label for="region" class="label label-primary">Город</label>
            <select title="Выберите Ваш город" name="location_id" id="region" class="form-control">
                <option value="">-- Выберите город --</option>
                <option class="opt-group" disabled="disabled">-- Города --</option>
                {html_options options=$location selected=$location_id}
                <option id="select-region" value="0">Выбрать другой...</option>
            </select>
        </div>
    </div>
    <div class="input-group">
        <label for="fld_category_id" class="label label-primary">Категория</label>
        <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-control">
            <option value="">-- Выберите категорию --</option>
        {html_options options=$category selected=$category_id}
        </select>
    </div>
    <div id="f_title" class="input-group">
        <label for="fld_title" class="label label-primary">Название объявления</label>
        <input required type="text" maxlength="50" class="form-control" value="{$title}" name="title" id="fld_title">
    </div>
    <div class="input-group">
        <label for="fld_description" class="label label-primary" id="js-description-label">Описание объявления</label>
        <textarea maxlength="3000" rows="7" cols="30" name="description" id="fld_description" class="form-control">{$description}</textarea>
    </div>
    <div id="price_rw" class="input-group">
        <label id="price_lbl" for="fld_price" class="label label-primary">Цена</label>
        <input required pattern="^[0-9]+$" type="text" class="form-control" value="{$price}" name="price" id="fld_price">
    </div>
    {if isset($smarty.get.ads) && $smarty.get.ads > 0}
        <a href="http://{$host}" class="btn btn-primary">Назад</a>
    {elseif isset($smarty.get.edit) && $smarty.get.edit > 0}
        <a href="http://{$host}" class="btn btn-primary">Назад</a>
        <input type="submit" value="Сохранить" id="form_submit" name="submit" class="btn btn-success">
        {if $smarty.post.submit}
            <div class="panel panel-success" id="edit">
                <div class="panel-body">
                    Изменения сохранены
                </div>
            </div>
        {/if}
    {else}
        <input type="submit" value="Отправить" id="form_submit" name="submit" class="btn btn-primary">
        <a class="btn btn-danger" href="?id=-1">Удалить все объявления</a>
        
            {foreach from=$ads key=key item=val}
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <a href="index.php?ads={$key}">{$ads.$key.title}</a>
                    </div>
                    <div class="panel-body">
                        {$ads.$key.price}руб |
                        {$ads.$key.seller_name} |
                        <a href="?id={$key}">Удалить</a> |
                        <a href="?edit={$key}">Редактировать</a>
                    </div>
                </div>
            {/foreach}
        
    {/if}
