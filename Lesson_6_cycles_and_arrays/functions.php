<?php

    function parseForm () {//Собирает данные из массива пост в сессию при отправке формы
        if(!isset($_SESSION['posts'])) {
            if (isset($_POST['submit']) && $_POST != '') {
                $_SESSION['posts'][] = $_POST;
            }
        }elseif (isset($_POST['submit']) && $_POST != '' && end($_SESSION['posts']) !== $_POST) {
            $_SESSION['posts'][] = $_POST;
        }
    }
    
    function showSelect($array, $name, $show = '') {//Выводит селекты формы
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
    
    function showPost() {//Выводит объявления
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

    function deletePost() {//Удаляет из сессии объявление
        $host  = $_SERVER['HTTP_HOST'] . dirname( __FILE__ );
        if (isset($_GET['id']) && isset($_SESSION['posts'][$_GET['id']])) {
            if ($_GET['id'] >= 0) {
                unset($_SESSION['posts'][$_GET['id']]);
                header("Location: http://$host");
                exit;
            }
        }
    }
    
    function showInput($val) {//Выводит инпуты со значениями из сессии
        global $private, $company;
        if (isset($_SESSION['posts'][$_GET['post_id']][$val])) {
            $value = $_SESSION['posts'][$_GET['post_id']][$val];
        }
        if ($val == 'private') {
            ($value > 0) ? $private = 'checked' : $company = 'checked';
        } elseif ($val == 'allow_mails' && isset($value)) {
            echo 'checked';
        } elseif (isset($value)) {
            echo $value;
        }
    }

    deletePost();
    parseForm();