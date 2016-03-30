<?php

    function parseForm () {//Собирает данные из массива пост в куку при отправке формы
        
        if(isset($_COOKIE['posts'])) {
            $posts = unserialize($_COOKIE['posts']);
        }
        if(!isset($_COOKIE['posts'])) {
            if (is_array($_POST) && $_POST != '') {
                $posts[] = $_POST;
            }
        }elseif(is_array($_POST) && $_POST != '' && end($posts) !== $_POST) {
            $posts[] = $_POST;
        }
        $posts = serialize($posts);
        setcookie('posts', $posts, time()+3600*24*7);
        
    }
    
    function showSelect($array, $name, $show = '') {//Выводит селекты формы
        
        $posts = unserialize($_COOKIE['posts']);
        $session = $posts[$_GET['post_id']];
        
        foreach ($array as $key => $value) {
            if(is_array($value)) {//многомерный массив
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
        
    function showInput($val) {//Выводит инпуты со значениями из куки
        
        global $private, $company;
        $posts = unserialize($_COOKIE['posts']);
        
        if (isset($posts[$_GET['post_id']][$val])) {//инпут
            $value = $posts[$_GET['post_id']][$val];
        }
        if ($val == 'private') {//радио-баттон и чекбокс
            ($value > 0) ? $private = 'checked' : $company = 'checked';
        } elseif ($val == 'allow_mails' && isset($value)) {
            echo 'checked';
        } elseif (isset($value)) {
            echo strip_tags($value);
        }
        
    }
    
    function showPost() {//Выводит объявления
        
        if(isset($_COOKIE['posts'])) {
            $posts = unserialize($_COOKIE['posts']);
            foreach ($posts as $key => $value) {
                $val = $posts;
                echo "<div class='panel panel-success'>";
                echo "<div class='panel-heading'><a href='index.php?post_id=" . 
                        strip_tags($key) . "'>" . strip_tags($val[$key]['title']) . "</a></div>";
                echo "<div class='panel-body'>" . strip_tags($val[$key]['price']) . " руб | " . 
                        strip_tags($val[$key]['seller_name']) . " | <a href='?id=" . strip_tags($key) . "'>Удалить</a></div>";
                echo "</div>";
            }
        } 
        
    }

    function deletePost() {//Удаляет из куки объявление
        
        global $host;
        
        $posts = unserialize($_COOKIE['posts']);
        unset($posts[$_GET['id']]);
        $posts = serialize($posts);
        setcookie('posts', $posts, time()+3600*24*7);
        header("Location: http://$host");
        exit;
    }