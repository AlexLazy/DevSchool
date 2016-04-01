<?php

    function parseForm () {//Собирает данные из массива пост в файл posts.php при отправке формы
        
        if(!file_get_contents('posts.php')) {
            if ($_POST['submit'] === 'Отправить' && is_array($_POST) && $_POST != '') {
                $post[time()] = $_POST;
                $post = serialize($post);
                file_put_contents('posts.php', $post);
            }
        }else{
            $posts = file_get_contents('posts.php');
            $posts = unserialize($posts);
            if($_POST['submit'] === 'Отправить' && is_array($_POST) && $_POST != '' && end($posts) !== $_POST) {
                $posts[time()] = $_POST;
                $posts = serialize($posts);
                file_put_contents('posts.php', $posts);
            }
        }
        
    }

    function editeForm () {//Сохраняет отредактированное объявление в файл posts.php
        
        if(!file_get_contents('posts.php')) {
            exit;
        }else{
            if($_POST['submit'] === 'Сохранить' && is_array($_POST) && $_POST != '') {
                $posts = file_get_contents('posts.php');
                $posts = unserialize($posts);
                $posts[$_GET['edit']] = $_POST;
                $posts = serialize($posts);
                file_put_contents('posts.php', $posts);
            }
        }
        
    }
    
    function showSelect($array, $name) {//Выводит селекты формы
        
        $posts = file_get_contents('posts.php');
        $posts = unserialize($posts);
        if(isset($_GET['post_id'])) {
            $session = $posts[$_GET['post_id']];
        }elseif(isset($_GET['edit'])) {
            $session = $posts[$_GET['edit']];
        }
        
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                echo "<optgroup label='" . $key . "'>";
                foreach ($value as $key => $val) {
                    ($key == $session[$name]) ? $selected = 'selected' : $selected = '';
                    echo "<option value='" . $key . "' " . $selected . ">" . $val . "</option>";
                }
                echo "</optgroup>";
            }else{
                ($key == $session[$name]) ? $selected = 'selected' : $selected = '';
                echo "<option value='" . $key . "' " . $selected . ">" . $value . "</option>";
            }
        }
        
    }

    function showInput($val) {//Выводит инпуты
        
        if(isset($_GET['post_id']) || isset($_GET['edit'])) {
            if(!file_get_contents('posts.php')) {
            exit;
            }else{
                $posts = file_get_contents('posts.php');
                $posts = unserialize($posts);
                
                if (isset($_GET['post_id']) && isset($posts[$_GET['post_id']][$val])) {
                    $value = $posts[$_GET['post_id']][$val];  
                }elseif(isset($_GET['edit']) && isset($posts[$_GET['edit']][$val])) {
                    $value = $posts[$_GET['edit']][$val];
                }
                
                if ($val == 'private' && $value == '1') {
                    echo 'checked';
                    //Очень стыдно за штуку что ниже)))
                }elseif($val == 'company' && ((isset($_GET['edit']) && $posts[$_GET['edit']]['private'] == '0') || (isset($_GET['post_id']) && $posts[$_GET['post_id']]['private'] == '0'))) {
                    echo 'checked';
                }elseif($val == 'allow_mails' && isset($value)) {
                    echo 'checked';
                }elseif(isset($value)) {
                    echo strip_tags($value);
                }
            }
        }else{
            if($val == 'private') {
                echo 'checked';
            }elseif($val == 'price' && !isset($value)) {
                echo '0';
            }
        }
  
    }
    
    function showPost() {//Выводит объявления
        
        if(!file_get_contents('posts.php')) {
            exit;
        }else{
            $posts = file_get_contents('posts.php');
            $posts = unserialize($posts);
            if(isset($posts)) {
                foreach ($posts as $key => $value) {
                    $val = $posts;
                    echo "<div class='panel panel-success'>";
                    echo "<div class='panel-heading'><a href='index.php?post_id=" .
                           strip_tags($key) . "'>" . 
                           strip_tags($val[$key]['title']) . "</a></div>";
                    echo "<div class='panel-body'>" . 
                           strip_tags($val[$key]['price']) . " руб | " . 
                           strip_tags($val[$key]['seller_name']) . " | <a href='?id=" .
                           strip_tags($key) . "'>Удалить</a>" . " | <a href='?edit=" .
                           strip_tags($key) . "'>Редактировать</a></div>";
                    echo "</div>";
                }
            }
        } 
        
    }

    function deletePost($var) {//Удаляет из файлa posts.php объявление
        
        global $host;
        if(!file_get_contents('posts.php')) {
            exit;
        }else{
            $posts = file_get_contents('posts.php');
            $posts = unserialize($posts);
            if(isset($var)) {
                unset($posts[$var]);
            }else{
                unset($posts);
                $posts = [];
            }
            $posts = serialize($posts);
            file_put_contents('posts.php', $posts);
            header("Location: http://$host");
            exit;
        }
        
    }
    
    //Кнопки форм
    function formBtnMain() {
        
        echo '<input type="submit" value="Отправить" id="form_submit"'
            . ' name="submit" class="btn btn-primary"><a class="btn btn-danger"'
            . ' href="?id=-1">Удалить все объявления</a>';
        
    }
    
    function formBtnCompleted() {
        
        global $host;
        
        echo '<a href="http://'. $host . '" class="btn btn-primary">Назад</a>';
        
    }
    
    function formBtnEdit() {
        
        global $host;
        
        echo '<a href="http://' . $host . '" class="btn btn-primary">Назад</a>'
            . '<input type="submit" value="Сохранить" id="form_submit"'
            . ' name="submit" class="btn btn-success">';
        if(isset($_POST['submit'])) {
            echo '<div class="panel panel-success" id="edit"><div class="panel-body">
                    Изменения сохранены</div></div>';
        }
        
    }