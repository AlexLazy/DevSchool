<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set('display_errors', 1);

    $host  = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    $private = '';
    $company = '';

    require( dirname( __FILE__ ) . '/date.php' );//Подключение файла данных
    require( dirname( __FILE__ ) . '/functions.php' );//Подключение функций
   
    
    if (isset($_GET['id'])) {
        $_GET['id'] = (int)$_GET['id'];
        deletePost();
    }elseif(isset($_POST['submit'])) {
        parseForm();
//        header("Location: http://$host");
    }
    
    require( dirname( __FILE__ ) . '/header.html' );//Подключение шапки
    
    if(isset($_GET['post_id'])) {
        $_GET['post_id'] = (int)$_GET['post_id'];
        require( dirname( __FILE__ ) . '/single_post.html' );//Выводит заполненную форму
       
    }else{
        require( dirname( __FILE__ ) . '/form.html' );//Выводит пустую форму
        showPost();
    }

    require( dirname( __FILE__ ) . '/footer.html' );//Подключение подвала
    
?>