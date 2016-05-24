<?php /* Smarty version 2.6.25-dev, created on 2016-05-24 16:34:29
         compiled from form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'form.tpl', 3, false),array('function', 'html_checkboxes', 'form.tpl', 17, false),array('function', 'html_options', 'form.tpl', 29, false),)), $this); ?>
<form  class="col-md-6 text-left" method="POST">
    <input type="hidden" value='<?php echo $this->_tpl_vars['id']; ?>
' name='id'>
    <?php echo smarty_function_html_radios(array('name' => 'private','options' => $this->_tpl_vars['private_arr'],'selected' => $this->_tpl_vars['private']), $this);?>

    <div class="input-group <?php echo $this->_tpl_vars['input_seller_name']; ?>
">
        <label for="fld_seller_name" class="label label-primary">
            <b>Ваше имя</b>
        </label>
        <input type="text" maxlength="40" class="form-control" pattern="[A-Za-zА-Яа-яЁё]+" value='<?php echo $this->_tpl_vars['seller_name']; ?>
' name="seller_name" id="fld_seller_name" >
        <label class="help-block <?php echo $this->_tpl_vars['error_seller_name']; ?>
" for="fld_seller_name">Укажите ваше имя</label>
    </div>
    <div class="input-group <?php echo $this->_tpl_vars['input_email']; ?>
">
        <label for="fld_email" class="label label-primary">Электронная почта</label>
        <input type="text" class="form-control" pattern="(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})" value='<?php echo $this->_tpl_vars['email']; ?>
' name="email" id="fld_email">
    </div>
    <div class="input-group">
        <label class="form-label-checkbox" for="allow_mails">
            <?php echo smarty_function_html_checkboxes(array('name' => 'allow_mails','options' => $this->_tpl_vars['allow_mails_arr'],'selected' => $this->_tpl_vars['allow_mails']), $this);?>

        </label>
    </div>
    <div class="input-group <?php echo $this->_tpl_vars['input_phone']; ?>
">
        <label id="fld_phone_label" for="fld_phone" class="label label-primary">Номер телефона</label>
        <input type="text" class="form-control" value="<?php echo $this->_tpl_vars['phone']; ?>
" name="phone" id="fld_phone">
    </div>
    <div class="input-group <?php echo $this->_tpl_vars['input_location_id']; ?>
">
        <label for="region" class="label label-primary">Город</label>
        <select title="Выберите Ваш город" name="location_id" id="region" class="form-control">
            <option value="">-- Выберите город --</option>
            <option class="opt-group" disabled="disabled">-- Города --</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['location'],'selected' => $this->_tpl_vars['location_id']), $this);?>

            <option id="select-region" value="0">Выбрать другой...</option>
        </select>
    </div>
    <div class="input-group <?php echo $this->_tpl_vars['input_category_id']; ?>
">
        <label for="fld_category_id" class="label label-primary">Категория</label>
        <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-control">
            <option value="">-- Выберите категорию --</option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['category'],'selected' => $this->_tpl_vars['category_id']), $this);?>

        </select>
    </div>
    <div id="f_title" class="input-group <?php echo $this->_tpl_vars['input_title']; ?>
">
        <label for="fld_title" class="label label-primary">Название объявления</label>
        <input type="text" maxlength="50" class="form-control" value="<?php echo $this->_tpl_vars['title']; ?>
" name="title" id="fld_title" >
        <label class="help-block <?php echo $this->_tpl_vars['error_title']; ?>
" for="fld_title">Укажите название объявления</label>
    </div>
    <div class="input-group <?php echo $this->_tpl_vars['input_description']; ?>
">
        <label for="fld_description" class="label label-primary" id="js-description-label">Описание объявления</label>
        <textarea maxlength="3000" rows="7" cols="30" name="description" id="fld_description" class="form-control"><?php echo $this->_tpl_vars['description']; ?>
</textarea>
    </div>
    <div id="price_rw" class="input-group <?php echo $this->_tpl_vars['input_price']; ?>
">
        <label id="price_lbl" for="fld_price" class="label label-primary">Цена</label>
        <input pattern="^[0-9]+$" type="text" class="form-control" value="<?php echo $this->_tpl_vars['price']; ?>
" name="price" id="fld_price" >
        <label class="help-block <?php echo $this->_tpl_vars['error_price']; ?>
" for="fld_title">Укажите цену</label>
    </div>
    <?php if (isset ( $_GET['ads'] ) && $_GET['ads'] > 0): ?>
        <a href="index.php" class="btn btn-primary">Назад</a>
    <?php elseif (isset ( $_GET['edit'] ) && $_GET['edit'] > 0): ?>
        <a href="index.php" class="btn btn-primary">Назад</a>
        <input type="submit" value="Сохранить" id="form_submit" name="submit" class="btn btn-success">
    <?php else: ?>
        <input type="submit" value="Отправить" id="form_submit" name="submit" class="btn btn-primary">
        <a id="del-all" class="btn btn-danger">Удалить все объявления</a>
    <?php endif; ?>
    </form>
    <div class="col-md-6">
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <a href="<?php echo $this->_tpl_vars['sort_by_title']; ?>
" class="btn btn-default" role="button">Название</a>
            <a href="<?php echo $this->_tpl_vars['sort_by_name']; ?>
" class="btn btn-default" role="button">Имя</a>
            <a href="<?php echo $this->_tpl_vars['sort_by_price']; ?>
" class="btn btn-default" role="button">Цена</a>
        </div>
        <div id="ads-list">
            <?php echo $this->_tpl_vars['ads']; ?>

        </div>
        