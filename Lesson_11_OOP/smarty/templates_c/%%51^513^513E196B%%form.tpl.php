<?php /* Smarty version 2.6.25-dev, created on 2016-04-20 19:46:03
         compiled from form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'form.tpl', 3, false),array('function', 'html_checkboxes', 'form.tpl', 16, false),array('function', 'html_options', 'form.tpl', 29, false),)), $this); ?>
<form  class="col-md-6" method="POST">
    <input type="hidden" value='<?php echo $this->_tpl_vars['id']; ?>
' name='id'>
    <?php echo smarty_function_html_radios(array('name' => 'private','options' => $this->_tpl_vars['private_arr'],'selected' => $this->_tpl_vars['private']), $this);?>

    <div class="input-group">
        <label for="fld_seller_name" class="label label-primary">
            <b>Ваше имя</b>
        </label>
        <input required type="text" maxlength="40" class="form-control" pattern="[A-Za-zА-Яа-яЁё]+" value='<?php echo $this->_tpl_vars['seller_name']; ?>
' name="seller_name" id="fld_seller_name">
    </div>
    <div class="input-group">
        <label for="fld_email" class="label label-primary">Электронная почта</label>
        <input type="text" class="form-control" pattern="(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})" value='<?php echo $this->_tpl_vars['email']; ?>
' name="email" id="fld_email">
    </div>
    <div class="input-group">
        <label class="form-label-checkbox" for="allow_mails">
            <?php echo smarty_function_html_checkboxes(array('name' => 'allow_mails','options' => $this->_tpl_vars['allow_mails_arr'],'selected' => $this->_tpl_vars['allow_mails']), $this);?>

        </label>
    </div>
    <div class="input-group">
        <label id="fld_phone_label" for="fld_phone" class="label label-primary">Номер телефона</label>
        <input type="text" class="form-control" value="<?php echo $this->_tpl_vars['phone']; ?>
" name="phone" id="fld_phone">
    </div>
    <div id="f_location_id" class="input-group">
        <div class="input-group">
            <label for="region" class="label label-primary">Город</label>
            <select title="Выберите Ваш город" name="location_id" id="region" class="form-control">
                <option value="">-- Выберите город --</option>
                <option class="opt-group" disabled="disabled">-- Города --</option>
                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['location'],'selected' => $this->_tpl_vars['location_id']), $this);?>

                <option id="select-region" value="0">Выбрать другой...</option>
            </select>
        </div>
    </div>
    <div class="input-group">
        <label for="fld_category_id" class="label label-primary">Категория</label>
        <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-control">
            <option value="">-- Выберите категорию --</option>
        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['category'],'selected' => $this->_tpl_vars['category_id']), $this);?>

        </select>
    </div>
    <div id="f_title" class="input-group">
        <label for="fld_title" class="label label-primary">Название объявления</label>
        <input required type="text" maxlength="50" class="form-control" value="<?php echo $this->_tpl_vars['title']; ?>
" name="title" id="fld_title">
    </div>
    <div class="input-group">
        <label for="fld_description" class="label label-primary" id="js-description-label">Описание объявления</label>
        <textarea maxlength="3000" rows="7" cols="30" name="description" id="fld_description" class="form-control"><?php echo $this->_tpl_vars['description']; ?>
</textarea>
    </div>
    <div id="price_rw" class="input-group">
        <label id="price_lbl" for="fld_price" class="label label-primary">Цена</label>
        <input required pattern="^[0-9]+$" type="text" class="form-control" value="<?php echo $this->_tpl_vars['price']; ?>
" name="price" id="fld_price">
    </div>
    <?php if (isset ( $_GET['ads'] ) && $_GET['ads'] > 0): ?>
        <a href="index.php" class="btn btn-primary">Назад</a>
    <?php elseif (isset ( $_GET['edit'] ) && $_GET['edit'] > 0): ?>
        <a href="index.php" class="btn btn-primary">Назад</a>
        <input type="submit" value="Сохранить" id="form_submit" name="submit" class="btn btn-success">
    <?php else: ?>
        <input type="submit" value="Отправить" id="form_submit" name="submit" class="btn btn-primary">
        <a class="btn btn-danger" href="?delete=-1">Удалить все объявления</a>
    <?php endif; ?>
    </form>
    <?php echo $this->_tpl_vars['ads']; ?>

        