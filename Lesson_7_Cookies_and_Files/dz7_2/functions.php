<?php
    
    function packAds(&$ads) {
        $ads = serialize($ads);
        file_put_contents('ads.php', $ads);
    }
    
    function unpackAds(&$ads) {
        $ads = file_get_contents('ads.php');
        $ads = unserialize($ads);
    }

    function saveAds () {//Собирает данные из массива пост в файл posts.php при отправке формы
        
        if(!file_get_contents('ads.php')) {
            exit;
        }else{
            unpackAds($ads);
        
            if ($_POST['submit'] === 'Отправить' && is_array($_POST) && $_POST != '' && is_array($ads) && end($ads) !== $_POST) {
                $ads[time()] = $_POST;
                packAds($ads);
            }
        }
    }

    function editAds () {//Сохраняет отредактированное объявление в файл posts.php
        
        if(!file_get_contents('ads.php')) {
            exit;
        }else{
            if($_POST['submit'] === 'Сохранить' && is_array($_POST) && $_POST != '') {
                unpackAds($ads);
                $ads[$_GET['edit']] = $_POST;
                packAds($ads);
            }
        }
        
    }
    
    function showSelect($array, $name) {//Выводит селекты формы
        
        if(!file_get_contents('ads.php')) {
            exit;
        }else{
            unpackAds($ads);
            
            if(isset($_GET['post_id'])) {
                $session = $ads[$_GET['post_id']];
            }elseif(isset($_GET['edit'])) {
                $session = $ads[$_GET['edit']];
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
        
    }

    function showInput($val) {//Выводит инпуты
        
        if(isset($_GET['post_id']) || isset($_GET['edit'])) {
            if(!file_get_contents('ads.php')) {
            exit;
            }else{
                unpackAds($ads);
                
                if (isset($_GET['post_id']) && isset($ads[$_GET['post_id']][$val])) {
                    $value = $ads[$_GET['post_id']][$val];  
                }elseif(isset($_GET['edit']) && isset($ads[$_GET['edit']][$val])) {
                    $value = $ads[$_GET['edit']][$val];
                }
                
                if ($val == 'private' && $value == '1') {
                    echo 'checked';
                    //Очень стыдно за штуку что ниже)))
                }elseif($val == 'company' && ((isset($_GET['edit']) && $ads[$_GET['edit']]['private'] == '0') || (isset($_GET['post_id']) && $ads[$_GET['post_id']]['private'] == '0'))) {
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
        
        if(!file_get_contents('ads.php')) {
            exit;
        }else{
            unpackAds($ads);
            if(isset($ads)) {
                foreach ($ads as $key => $value) {
                    echo "<div class='panel panel-success'>";
                    echo "<div class='panel-heading'><a href='index.php?post_id=" .
                           strip_tags($key) . "'>" . 
                           strip_tags($ads[$key]['title']) . "</a></div>";
                    echo "<div class='panel-body'>" . 
                           strip_tags($ads[$key]['price']) . " руб | " . 
                           strip_tags($ads[$key]['seller_name']) . " | <a href='?id=" .
                           strip_tags($key) . "'>Удалить</a>" . " | <a href='?edit=" .
                           strip_tags($key) . "'>Редактировать</a></div>";
                    echo "</div>";
                }
            }
        } 
        
    }

    function deletePost($var) {//Удаляет из файлa posts.php объявление
        global $host;
        
        if(!file_get_contents('ads.php')) {
            exit;
        }else{
            unpackAds($ads);
            if(isset($var)) {
                unset($ads[$var]);
            }else{
                unset($ads);
                $ads = [];
            }
            packAds($ads);
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