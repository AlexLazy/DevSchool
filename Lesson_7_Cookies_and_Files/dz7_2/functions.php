<?php

    function parseForm () {//Собирает данные из массива пост в сессию при отправке формы
        
        if(!file_get_contents('posts.php')) {
            if (is_array($_POST) && $_POST != '') {
                $post[] = $_POST;
                $post = serialize($post);
                file_put_contents('posts.php', $post);
            }
        }else{
            $posts = file_get_contents('posts.php');
            $posts = unserialize($posts);
                if(is_array($_POST) && $_POST != '' && end($posts) !== $_POST) {
                $posts[] = $_POST;
                $posts = serialize($posts);
                file_put_contents('posts.php', $posts);
            }
        }
        
    }
    
    function showSelect($array, $name, $show = '') {//Выводит селекты формы
        
        $posts = file_get_contents('posts.php');
        $posts = unserialize($posts);
        $session = $posts[$_GET['post_id']];
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                echo "<optgroup label='" . $key . "'>";
                foreach ($value as $key => $val) {
                    ($show == 'show' && $key == $session[$name]) ? $selected = 'selected' : $selected = '';
                    echo "<option value='" . $key . "' " . $selected . ">" . $val . "</option>";
                }
                echo "</optgroup>";
            }else{
                ($show == 'show' && $key == $session[$name]) ? $selected = 'selected' : $selected = '';
                echo "<option value='" . $key . "' " . $selected . ">" . $value . "</option>";
            }
        }
        
    }

    
    function showInput($val) {//Выводит инпуты со значениями из сессии
        
        global $private, $company;
        
        if(!file_get_contents('posts.php')) {
            exit;
        }else{
            $posts = file_get_contents('posts.php');
            $posts = unserialize($posts);
            if (isset($posts[$_GET['post_id']][$val])) {//инпут
                $value = $posts[$_GET['post_id']][$val];
            }
            if ($val == 'private') {                    //радио-баттон и чекбокс
                ($value > 0) ? $private = 'checked' : $company = 'checked';
            } elseif ($val == 'allow_mails' && isset($value)) {
                echo 'checked';
            } elseif (isset($value)) {
                echo $value;
            }
        }
        
    }
    
    function showPost() {//Выводит объявления
        
        if(!file_get_contents('posts.php')) {
            exit;
        }else{
            $posts = file_get_contents('posts.php');
            $posts = unserialize($posts);
            foreach ($posts as $key => $value) {
                $val = $posts;
                echo "<div class='panel panel-success'>";
                echo "<div class='panel-heading'><a href='index.php?post_id=" . $key . "'>" . $val[$key]['title'] . "</a></div>";
                echo "<div class='panel-body'>" . $val[$key]['price'] . " руб | " . $val[$key]['seller_name'] . " | <a href='?id=" . $key . "'>Удалить</a></div>";
                echo "</div>";
            }
        } 
        
    }

    function deletePost() {//Удаляет из сессии объявление
        
        global $host;
        
        if(!file_get_contents('posts.php')) {
            exit;
        }else{
            $posts = file_get_contents('posts.php');
            $posts = unserialize($posts);
            unset($posts[$_GET['id']]);
            $posts = serialize($posts);
            file_put_contents('posts.php', $posts);
            header("Location: http://$host");
            exit;
        }
        
    }