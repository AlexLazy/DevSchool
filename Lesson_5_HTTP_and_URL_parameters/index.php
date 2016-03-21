<?php

$news = 'Четыре новосибирские компании вошли в сотню лучших работодателей
Выставка университетов США: открой новые горизонты
Оценку «неудовлетвоsрительно» по качеству получает каждая 5-я квартира в новостройке
Студент-изобретатель раскрыл запутанное преступление
Хоккей: «Сибирь» выстояла против «Ак Барса» в пятом матче плей-офф
Здоровое питание: вегетарианская кулинария
День святого Патрика: угощения, пивной теннис и уличные гуляния с огнем
«Красный факел» пустит публику на ночные экскурсии за кулисы и по закоулкам столетнего здания
Звезды телешоу «Голос» Наргиз Закирова и Гела Гуралиа споют в «Маяковском»';

        $news = explode("\n", $news);
        
        $min = 1;
        $max = count($news);

        function all($val, $array = 'GET') {
            echo '<div class="panel panel-primary"><div class="panel-heading">Вывод всего списка из '.$array.':</div><div class="panel-body">';
            while(!(key($val) === null)) {
                echo '<p>'.$val[key($val)].'</p>';
                next($val);
            }
            echo '</div></div>';
        }    

        //GET
        function showGET(){
            global $min, $max, $news;
            if(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)){
                if(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))) {
                    id_get();
                }elseif(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, !(array("options" => array("min_range"=>$min, "max_range"=>$max))))) {
                    all($news);
                }
            }else{
                header("HTTP/1.0 404 Not Found");
                //die();
            }
        }
        
        function id_get () {
            global $news;
            echo '<div class="alert alert-info">Вывод из GET: '.$news[filter_input(INPUT_GET, 'id')-1].'</div>';
        }

        //POST
        function showPOST() {
            global $min, $max, $news;
            if(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT)){
                if(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))) {
                    id_post();
                }elseif(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, !(array("options" => array("min_range"=>$min, "max_range"=>$max))))) {
                    all($news,'POST');

                }
            }else{
                header("HTTP/1.0 404 Not Found");
                //die();
            }
        }
        
        function id_post () {
            global $news;
            echo '<div class="alert alert-success">Вывод из POST: '.$news[filter_input(INPUT_POST, 'id')-1].'</div>';
        }

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <form method="POST" style="width:700px">
                <div class="panel panel-success">
                    <div class="panel-heading">Список новостей</div>
                    <div class="panel-body">
                        <?= join("<br>", $news) ?>
                    </div>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" name="id" placeholder="Введите id новости...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Найти</button>
                    </span>
                </div>
                <br>
                <?= showGET() ?>
                <?= showPOST() ?>
            </form>
        </div>
    </div>
</div>