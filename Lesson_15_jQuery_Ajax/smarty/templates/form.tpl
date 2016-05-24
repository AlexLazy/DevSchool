<form  class="col-md-6 text-left" method="POST">
    <input type="hidden" value='{$id}' name='id'>
    {html_radios name="private" options=$private_arr selected=$private}
    <div class="input-group {$input_seller_name}">
        <label for="fld_seller_name" class="label label-primary">
            <b>Ваше имя</b>
        </label>
        <input type="text" maxlength="40" class="form-control" pattern="[A-Za-zА-Яа-яЁё]+" value='{$seller_name}' name="seller_name" id="fld_seller_name" >
        <label class="help-block {$error_seller_name}" for="fld_seller_name">Укажите ваше имя</label>
    </div>
    <div class="input-group {$input_email}">
        <label for="fld_email" class="label label-primary">Электронная почта</label>
        <input type="text" class="form-control" pattern="(\w+@[a-zA-Z_]+?\.[a-zA-Z]{ldelim}2,6{rdelim})" value='{$email}' name="email" id="fld_email">
    </div>
    <div class="input-group">
        <label class="form-label-checkbox" for="allow_mails">
            {html_checkboxes name="allow_mails" options=$allow_mails_arr selected=$allow_mails}
        </label>
    </div>
    <div class="input-group {$input_phone}">
        <label id="fld_phone_label" for="fld_phone" class="label label-primary">Номер телефона</label>
        <input type="text" class="form-control" value="{$phone}" name="phone" id="fld_phone">
    </div>
    <div class="input-group {$input_location_id}">
        <label for="region" class="label label-primary">Город</label>
        <select title="Выберите Ваш город" name="location_id" id="region" class="form-control">
            <option value="">-- Выберите город --</option>
            <option class="opt-group" disabled="disabled">-- Города --</option>
            {html_options options=$location selected=$location_id}
            <option id="select-region" value="0">Выбрать другой...</option>
        </select>
    </div>
    <div class="input-group {$input_category_id}">
        <label for="fld_category_id" class="label label-primary">Категория</label>
        <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-control">
            <option value="">-- Выберите категорию --</option>
        {html_options options=$category selected=$category_id}
        </select>
    </div>
    <div id="f_title" class="input-group {$input_title}">
        <label for="fld_title" class="label label-primary">Название объявления</label>
        <input type="text" maxlength="50" class="form-control" value="{$title}" name="title" id="fld_title" >
        <label class="help-block {$error_title}" for="fld_title">Укажите название объявления</label>
    </div>
    <div class="input-group {$input_description}">
        <label for="fld_description" class="label label-primary" id="js-description-label">Описание объявления</label>
        <textarea maxlength="3000" rows="7" cols="30" name="description" id="fld_description" class="form-control">{$description}</textarea>
    </div>
    <div id="price_rw" class="input-group {$input_price}">
        <label id="price_lbl" for="fld_price" class="label label-primary">Цена</label>
        <input pattern="^[0-9]+$" type="text" class="form-control" value="{$price}" name="price" id="fld_price" >
        <label class="help-block {$error_price}" for="fld_title">Укажите цену</label>
    </div>
    {if isset($smarty.get.ads) && $smarty.get.ads > 0}
        <a href="index.php" class="btn btn-primary">Назад</a>
    {elseif isset($smarty.get.edit) && $smarty.get.edit > 0}
        <a href="index.php" class="btn btn-primary">Назад</a>
        <input type="submit" value="Сохранить" id="form_submit" name="submit" class="btn btn-success">
    {else}
        <input type="submit" value="Отправить" id="form_submit" name="submit" class="btn btn-primary">
        <a id="del-all" class="btn btn-danger">Удалить все объявления</a>
    {/if}
    </form>
    <div class="col-md-6">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <a href="{$sort_by_title}" class="btn btn-default" role="button">Название</a>
            <a href="{$sort_by_name}" class="btn btn-default" role="button">Имя</a>
            <a href="{$sort_by_price}" class="btn btn-default" role="button">Цена</a>
        </div>
        <div id="ads-list">
            {$ads}
        </div>
        