<?php

$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

';
$bd =  parse_ini_string($ini_string, true);
$quan = count($bd);
$special_disk = 0;
$nomination = 0;
$ordered = 0;
$price = 0;
$disk = 0;
$notification = [];
var_dump($bd);
function diskont($val){
    global $disk;
    switch($val['diskont'])
    {
        case 'diskont1':
            $diskont = 10;
            break;
        case 'diskont2':
            $diskont = 20;
            break;
        case 'diskont0':
            $diskont = 0;
            break;
    }
    //$disk = $val['цена']*$diskont/100;
    $disk = $diskont;
}


?>

<style>
    .item {
        display: inline-block;
        margin:10px;
        padding:10px;
        background-color: #ccc;
        border-radius: 5px;
    }
    .item h2 {
        text-transform: uppercase;
    }
    .item p {
        display: inline-block;
        margin-right: 20px;
    }
    .notification {
        color: red;
    }
    .discount {
        font-style: italic;
        text-shadow: 1px 1px 2px black, 0 0 1em #ccc;
    }
</style>
<div class="busket">
    
    <?php
    
    echo '<h1>Корзина</h1>';
    
        for ($i = 0; $i < $quan; $i++) {
            $item = $bd[key($bd)];
            echo '<div class="item">';
                echo '<h2>'.key($bd).'</h2>';
                echo '<p class="price">Цена: '.$item['цена'].'руб</p>';
                echo '<p class="ordered">В корзине: '.$item['количество заказано'].'шт.</p>';
                echo '<p class="stock">Осталось на складе: '.$item['осталось на складе'].'шт.</p>';
            echo '</div>';
            next($bd);
        }
    
    reset($bd);
    
    echo '<h2>Итого:</h2>';
    goto a;
    for ($a = 0; $a < $quan; $a++) {
        $diskont = 'diskont';
        $nomination += 1;
        static $special_diskont = 0;
        $diskont($bd[key($bd)]);
        if($bd[key($bd)]['количество заказано'] > $bd[key($bd)]['осталось на складе']) {
            $notification[key($bd)] = key($bd);
            $bd[key($bd)]['цена'] = 0;
            $bd[key($bd)]['количество заказано'] = 0;
            $disk = 0;
            $nomination -= 1;
        }
        if (key($bd) === 'игрушка детская велосипед' && $bd['игрушка детская велосипед']['количество заказано'] >= 3) {
            $special_diskont = $bd[key($bd)]['цена']*30/100;
            $disk = 0;
            $special_disk = 1;
        }
        $ordered += $bd[key($bd)]['количество заказано'];
        $price += ($bd[key($bd)]['цена'] - ($bd[key($bd)]['цена']*$disk/100) - $special_diskont) * $bd[key($bd)]['количество заказано'];
        next($bd);
    }
    
    echo '<p>Наименований заказано '.$nomination.'шт.</p>';
    echo '<p>Товаров заказано '.$ordered.'шт.</p>';
    echo '<p>Общая сумма заказа составляет: '.$price.'руб.</p>';
    
    echo '<h2>Уведомления:</h2>';
    
    for($i = 0; count($notification) > $i; $i++) {
        echo '<p class="notification">На складе отсутствует данное количество товара: '.key($notification).'</p>';
        next($notification);
    }
    echo '<h2>Скидки:</h2>';
    
    echo ($special_disk === 1)?'<p class="discount">Вы получили скидку на товар игрушка детская велосипед в размере 30%</p>':'';
    exit();
 //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@   
    
    a:
     for ($a = 0; $a < $quan; $a++) {
        $diskont = 'diskont';
        $nomination += 1;
        static $special_diskont = 0;
        $diskont($bd[key($bd)]);
        if($bd[key($bd)]['количество заказано'] > $bd[key($bd)]['осталось на складе']) {
            $bd[key($bd)]['количество заказано'] = $bd[key($bd)]['осталось на складе'];
            if($bd[key($bd)]['осталось на складе'] == 0) {
                $bd[key($bd)]['цена'] = 0;
                $disk = 0;
                $nomination -= 1;
                $empty[] = key($bd);
            }
        }
        if (key($bd) === 'игрушка детская велосипед' && $bd['игрушка детская велосипед']['количество заказано'] >= 3) {
            $special_diskont = $bd[key($bd)]['цена']*30/100;
            $disk = 0;
            $special_disk = 1;
        }
        $ordered += $bd[key($bd)]['количество заказано'];
        $price += ($bd[key($bd)]['цена'] - ($bd[key($bd)]['цена']*$disk/100) - $special_diskont) * $bd[key($bd)]['количество заказано'];
        //var_dump($price);
        next($bd);
    }
    
    echo '<p>Наименований заказано '.$nomination.'шт.</p>';
    echo '<p>Товаров заказано '.$ordered.'шт.</p>';
    echo '<p>Общая сумма заказа составляет: '.$price.'руб.</p>';
    
    echo '<h2>Уведомления:</h2>';
    if(isset($empty)) {
        foreach($empty as $val) {
            echo '<p class="notification">Товар: '.$val.' отсутствует на складе</p>';
        }
    }
    
    echo '<h2>Скидки:</h2>';
    //var_dump($bd);
    foreach ($bd as $key => $value) {
        $diskont($bd[$key]);
        echo ($disk > 0) ? "<p>Скидка на товар $key : ".$disk." %</p>" : '';
}
    echo ($special_disk === 1)?'<p class="discount">Вы получили скидку на товар игрушка детская велосипед в размере 30%</p>':'';   
    ?>
</div>
<hr>
