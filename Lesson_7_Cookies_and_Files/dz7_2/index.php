<?php
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);

    $host  = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

    require( dirname( __FILE__ ) . '/date.php' );//Подключение файла данных
    require( dirname( __FILE__ ) . '/functions.php' );//Подключение функций

    if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) >= -1) {
        ($_GET['id'] == -1) ? deletePost() : deletePost($_GET['id']);
    }elseif(isset($_POST['submit'])) {
        saveAds();
        editAds();
    }
    
    require( dirname( __FILE__ ) . '/header.html' );//Подключение шапки

    if(isset($_GET['post_id']) && filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_INT) > 0) {
        unpackAds($ads);
        
        if(isset($ads[$_GET['post_id']])) {
            require( dirname( __FILE__ ) . '/form.html' );//Выводит форму
            formBtnCompleted();
        }else{
            echo 'Объявление отсутствует';
            exit;
        }
        
    }elseif(isset($_GET['edit']) && filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT) > 0) {
        require( dirname( __FILE__ ) . '/form.html' );//Выводит форму
        formBtnEdit();
    }else{
        require( dirname( __FILE__ ) . '/form.html' );//Выводит форму
        formBtnMain();
        showPost();
    }

    require( dirname( __FILE__ ) . '/footer.html' );//Подключение подвала
    
?>