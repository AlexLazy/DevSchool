<?php

$visibility = 'hidden';
if(isset($_POST['submit']) && $_POST['submit'] == 'install'){
    if ($_FILES["file"]["size"] > 1024 * 2 * 1024) {
        exit('Размер файла превышает два мегабайта');
    }
    // Проверяем загружен ли файл
    if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
        // Если файл загружен успешно, перемещаем его
        // из временной директории в конечную
        move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/' . $_FILES["file"]["name"]);
    } else {
        exit('Ошибка загрузки файла');
    }
    
    file_put_contents('smarty/date/sql.cfg.php', "<?php\n");
    $servername = $_POST['server_name'];
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    $database = $_POST['database'];

    $mysqli = new mysqli($servername, $username, $password) or die('Не удалось подключиться к бд');
    $mysqli->query("CREATE DATABASE if not exists $database COLLATE 'utf8_general_ci'") or die('Не удалось создать бд');
    $mysqli = new mysqli($servername, $username, $password, $database) or die('Не удалось подключиться к бд');
    $result = $mysqli->query("show tables") or die();
    
    //Очистка бд
    if($result->num_rows > 0){
        while ( $row = $result->fetch_row() ){
            $table[$row[key($row)]] = $row[key($row)];
        }
        $result->close();
        $table = implode("`,`", $table);
        $mysqli->query("DROP TABLE `$table`;") or die('Не удалось очистить бд');
    }
    
    $all_lines = file($_FILES["file"]["name"], FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) or die('Отсутствует файл дампа');
    $templine = '';
    
    //Загрузка дампа
    foreach($all_lines as $query) {
        if(substr($query, 0, 2) == "--") {
            continue;
        }
        $templine .= $query;
        if (substr(trim($query), -1, 1) == ';') {
            $mysqli->query($templine) or die('Ошибка считывания файла дампа');
            $templine = '';
        }
        
    }
    
    file_put_contents('smarty/date/sql.cfg.php', '$servername = ' . "'" . $servername . "';\n", FILE_APPEND);
    file_put_contents('smarty/date/sql.cfg.php', '$database = ' . "'" . $database . "';\n", FILE_APPEND);
    file_put_contents('smarty/date/sql.cfg.php', '$password = ' . "'" . $password . "';\n", FILE_APPEND);
    
    $mysqli->close();
    $visibility = '';//открывает кнопку перехода на сайт
}
?>
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <title>Install</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
      <style>
            body{
                display:flex;
                height:100vh;
            }
            form{ margin:auto; }
            .input-group{ margin-bottom:10px }
            .file{
                width: 0.1px;
                height: 0.1px;
                opacity: 0;
                overflow: hidden;
                position: absolute;
                z-index: -1;
            }
      </style>
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label class="label label-primary">Server name:</label>
                <input type="text" class="form-control" value='localhost' name="server_name" required>
            </div>
            <div class="input-group">
                <label class="label label-primary">User name:</label>
                <input type="text" class="form-control" value='root' name="user_name" required>
            </div>
            <div class="input-group">
                <label class="label label-primary">Password:</label>
                <input type="text" class="form-control" value='' name="password">
            </div>
            <div class="input-group">
                <label class="label label-primary">Database:</label>
                <input type="text" class="form-control" value='' name="database" required>
            </div>
            <div class="input-group">
                <label for="file" class="btn btn-default btn-md">Загрузить дамп базы дынных</label>
                <input type="file" id="file" class="file" name="file" required accept=".sql">
            </div>
            <input type="submit" value="install" id="form_submit" name="submit" class="btn btn-success">
            <a href="index.php" class="btn btn-primary <?= $visibility ?>">Перейти на сайт</a>
        </form>
    </body>
</html>