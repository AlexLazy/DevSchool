<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set('display_errors', 1);
    
    session_start();
             
    $mainForm = '';
    $hiddenForm = 'hidden';
    $private = '';
    $company = '';
    
    $location = [
        '641780'=>'Новосибирск',
        '641490'=>'Барабинск',
        '641510'=>'Бердск',
        '641600'=>'Искитим',
        '641630'=>'Колывань',
        '641680'=>'Краснообск'
        ];
    
    $category = [
        'Транспорт'=>[
            '9'=>'Автомобили с пробегом',
            '109'=>'Новые автомобили',
            '14'=>'Мотоциклы и мототехника',
            '81'=>'Грузовики и спецтехника'
            ],
        'Недвижимость'=>[
            '24'=>'Квартиры',
            '23'=>'Комнаты',
            '25'=>'Дома, дачи, коттеджи'
            ],
        'Работа'=>[
            '111'=>'Вакансии (поиск сотрудников)',
            '112'=>'Резюме (поиск работы)'
            ],
        'Услуги'=>[
            '114'=>'Предложения услуг',
            '115'=>'Запросы на услуги'
            ],
        'Личные вещи'=>[
            '27'=>'Одежда, обувь, аксессуары',
            '29'=>'Детская одежда и обувь',
            '30'=>'Товары для детей и игрушки'
            ]
        ];

    function parseForm () {
        if(!isset($_SESSION['posts'])) {
            if (isset($_POST['submit']) && $_POST != '') {
                $_SESSION['posts'][] = $_POST;
            }
        }elseif (isset($_POST['submit']) && $_POST != '' && end($_SESSION['posts']) !== $_POST) {
            $_SESSION['posts'][] = $_POST;
        }
    }
    
    function showSelect($array, $name, $show = '') {
        $session = $_SESSION['posts'][$_GET['post_id']];
        foreach ($array as $key => $value) {
            if(is_array($value)) {
                echo "<optgroup label='".$key."'>";
                foreach ($value as $key => $val) {
                    ($show == 'show' && $key == $session[$name]) ? $selected = 'selected' : $selected = '';
                    echo "<option value='".$key."' ".$selected.">".$val."</option>";
                }
                echo "</optgroup>";
            }else{
                ($show == 'show' && $key == $session[$name]) ? $selected = 'selected' : $selected = '';
                echo "<option value='".$key."' ".$selected.">".$value."</option>";
            }
        }
    }
    
    function showPost() {
        if(isset($_SESSION['posts'])) {
            foreach ($_SESSION['posts'] as $key => $value) {
                $val = $_SESSION['posts'];
                echo "<div class='panel panel-success'>";
                echo "<div class='panel-heading'><a href='index.php?post_id=" . $key . "'>" . $val[$key]['title'] . "</a></div>";
                echo "<div class='panel-body'>" . $val[$key]['price'] . " руб | " . $val[$key]['seller_name'] . " | <a href='?id=" . $key . "'>Удалить</a></div>";
                echo "</div>";
            }
        }
    }

    function deletePost() {
        $host  = $_SERVER['HTTP_HOST'];
        if (isset($_GET['id']) && isset($_SESSION['posts'][$_GET['id']])) {
            if ($_GET['id'] >= 0) {
                unset($_SESSION['posts'][$_GET['id']]);
                header("Location: http://$host");
                exit;
            }
        }
    }
    
    function showCompletedForm() {
        global $mainForm, $hiddenForm;
        if(isset($_GET['post_id'])) {
            $mainForm = 'hidden';
            $hiddenForm = '';
            function showInput($val) {
                global $private, $company;
                if(isset($_SESSION['posts'][$_GET['post_id']][$val])) {
                    $value = $_SESSION['posts'][$_GET['post_id']][$val];
                }
                if($val == 'private') {
                    ($value > 0) ? $private = 'checked' : $company = 'checked';
                }elseif($val == 'allow_mails' && isset($value)) {
                    echo 'checked';
                }elseif(isset($value)) {
                    echo $value;
                }
            }
        }
    }
    
    deletePost();
    parseForm();
    showCompletedForm();
    
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo ($_SERVER['HTTP_HOST'])?></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <style>form{display: inline-block; margin-top: 30px; text-align: left}.input-group{margin-bottom:10px}.btn{margin-bottom:20px}</style>
</head>
<body>
    <div class="container">
        <div class="row text-center">
            <form  method="POST" class="<?= $mainForm ?>">
                <label class="form-label-radio">
                    <input type="radio" checked value="1" name="private">
                    Частное лицо
                </label>
                <label class="form-label-radio">
                    <input type="radio" value="0" name="private">
                    Компания
                </label>
                <div class="input-group">
                    <label for="fld_seller_name" class="label label-primary">
                        <b>Ваше имя</b>
                    </label>
                    <input required type="text" maxlength="40" pattern="(\D+)" class="form-control" value="" name="seller_name" id="fld_seller_name">
                </div>
                <div class="input-group">
                    <label for="fld_email" class="label label-primary">Электронная почта</label>
                    <input type="text" class="form-control" pattern="(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})" value="" name="email" id="fld_email">
                </div>
                <div class="input-group">
                    <label class="form-label-checkbox" for="allow_mails">
                        <input type="checkbox" value="1" name="allow_mails" id="allow_mails" class="form-input-checkbox">
                        <span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span>
                    </label>
                </div>
                <div class="input-group">
                    <label id="fld_phone_label" for="fld_phone" class="label label-primary">Номер телефона</label>
                    <input type="text" class="form-control" pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" value="" name="phone" id="fld_phone">
                </div>
                <div id="f_location_id" class="input-group">
                    <div class="input-group">
                    <label for="region" class="label label-primary">Город</label>
                    <select title="Выберите Ваш город" name="location_id" id="region" class="form-control">
                        <option value="">-- Выберите город --</option>
                        <option class="opt-group" disabled="disabled">-- Города --</option>
                        <?= showSelect($location, 'location_id') ?>
                        <option id="select-region" value="0">Выбрать другой...</option>
                    </select>
                    </div>
                </div>
                <div class="input-group">
                    <label for="fld_category_id" class="label label-primary">Категория</label>
                    <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-control">
                        <option value="">-- Выберите категорию --</option>
                        <?= showSelect($category, 'category_id') ?>
                    </select>
                </div>
                <div id="f_title" class="input-group">
                    <label for="fld_title" class="label label-primary">Название объявления</label>
                    <input required type="text" maxlength="50" class="form-control" value="" name="title" id="fld_title">
                </div>
                <div class="input-group">
                    <label for="fld_description" class="label label-primary" id="js-description-label">Описание объявления</label>
                    <textarea maxlength="3000" rows="7" cols="30" name="description" id="fld_description" class="form-control"></textarea>
                </div>
                <div id="price_rw" class="input-group">
                    <label id="price_lbl" for="fld_price" class="label label-primary">Цена</label>
                    <input required pattern="^[ 0-9]+$" type="text" class="form-control" value="0" name="price" id="fld_price">
                </div>
                <input type="submit" value="Отправить" id="form_submit" name="submit" class="btn btn-primary">
                <?= showPost() ?>
            </form>
            
            
            <form  method="POST" class="<?= $hiddenForm ?>">
                <label class="form-label-radio">
                    <?php showInput('private');?>
                    <input type="radio" <?= $private ?> value="" name="private">
                    Частное лицо
                </label>
                <label class="form-label-radio">
                    <input type="radio" <?= $company ?> value="" name="private">
                    Компания
                </label>
                <div class="input-group">
                    <label for="fld_seller_name" class="label label-primary">
                        <b>Ваше имя</b>
                    </label>
                    <input required type="text" maxlength="40" pattern="(\D+)" class="form-control" value="<?= showInput('seller_name') ?>" name="seller_name" id="fld_seller_name">
                </div>
                <div class="input-group">
                    <label for="fld_email" class="label label-primary">Электронная почта</label>
                    <input type="text" class="form-control" pattern="(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})" value="<?= showInput('email') ?>" name="email" id="fld_email">
                </div>
                <div class="input-group">
                    <label class="form-label-checkbox" for="allow_mails">
                        <input type="checkbox" <?= showInput('allow_mails') ?> value="1" name="allow_mails" id="allow_mails" class="form-input-checkbox">
                        <span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span>
                    </label>
                </div>
                <div class="input-group">
                    <label id="fld_phone_label" for="fld_phone" class="label label-primary">Номер телефона</label>
                    <input type="text" class="form-control" pattern="(\d+)" value="<?= showInput('phone') ?>" name="phone" id="fld_phone">
                </div>
                <div id="f_location_id" class="input-group">
                    <div class="input-group">
                    <label for="region" class="label label-primary">Город</label>
                    <select title="Выберите Ваш город" name="location_id" id="region" class="form-control">
                        <option value="">-- Выберите город --</option>
                        <option class="opt-group" disabled="disabled">-- Города --</option>
                        <?= showSelect($location, 'location_id', 'show') ?>
                        <option id="select-region" value="0">Выбрать другой...</option>
                    </select>
                    </div>
                </div>
                <div class="input-group">
                    <label for="fld_category_id" class="label label-primary">Категория</label>
                    <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-control">
                        <option value="">-- Выберите категорию --</option>
                        <?= showSelect($category, 'category_id', 'show') ?>
                    </select>
                </div>
                <div id="f_title" class="input-group">
                    <label for="fld_title" class="label label-primary">Название объявления</label>
                    <input required type="text" maxlength="50" class="form-control" value="<?= showInput('title') ?>" name="title" id="fld_title">
                </div>
                <div class="input-group">
                    <label for="fld_description" class="label label-primary" id="js-description-label">Описание объявления</label>
                    <textarea maxlength="3000" rows="7" cols="30" name="description" id="fld_description" class="form-control"><?= showInput('description') ?></textarea>
                </div>
                <div id="price_rw" class="input-group">
                <label id="price_lbl" for="fld_price" class="label label-primary">Цена</label>
                    <input required pattern="^[ 0-9]+$" type="text" class="form-control" value="<?= showInput('price') ?>" name="price" id="fld_price">
                </div>
                <a href="/" class="btn btn-primary">Назад</a>
            </form>
        </div>
    </div>
</body>