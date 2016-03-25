<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set('display_errors', 1);
    
    session_start();

    $host  = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    $_SESSION['posts'][0]=null;
    $private = '';
    $company = '';
    
    require( dirname( __FILE__ ) . '/date.php' );//Подключение файла данных
    require( dirname( __FILE__ ) . '/functions.php' );//Подключение функция
    require( dirname( __FILE__ ) . '/header.html' );//Подключение шапки
    
    if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[1-9]+$/"))) && isset($_SESSION['posts'][$_GET['id']])) {
        deletePost();
        parseForm();
    }elseif(isset($_POST['submit'])) {
        parseForm();
    }
    
    if(filter_input(INPUT_GET, 'post_id', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[1-9]+$/")))) {
        require( dirname( __FILE__ ) . '/single_post.html' );//Выводит заполненную форму
       
    }else{
        require( dirname( __FILE__ ) . '/form.html' );//Выводит пустую форму
        showPost();
    }

    require( dirname( __FILE__ ) . '/footer.html' );//Подключение подвала
    
?>