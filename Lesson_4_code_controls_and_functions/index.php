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
$nomination = 0;
$ordered = 0;
$price = 0;
$disk = 0;

function diskont($val){
    global $disk;
    switch($val['diskont'])
    {
        case 'diskont1':
            $disk = 10;
            break;
        case 'diskont2':
            $disk = 20;
            break;
        case 'diskont0':
            $disk = 0;
            break;
    }
    return $disk;
}

function bigBossFunction($arr) {
    global $disk, $nomination, $ordered, $price;
    static $diskont = 'diskont';
    foreach ($arr as $key => $val) {
        $diskont($val);
        $nomination++;
        echo '<tr>';
            echo '<td>' . $key . '</td>';
            echo '<td>' . $val['цена'] . ' руб</td>';
            echo '<td>' . $val['количество заказано'] . ' шт.</td>';
            echo '<td>' . $val['осталось на складе'] . ' шт.</td>';
            echo '<td>';
                if($val['осталось на складе'] == 0) {
                    $nomination--;
                    echo 'Нет в наличии';
                }elseif($val['осталось на складе'] < $val['количество заказано']) {
                    echo 'Не хватает на складе '.($val['количество заказано'] - $val['осталось на складе']).' шт.';
                }
            echo '</td>';
            echo '<td>';
                if($disk !== 0) {
                    echo $disk.'%';
                }elseif($key === 'игрушка детская велосипед' && $val['количество заказано'] >= 3 && $val['осталось на складе'] >= 3) {
                    $disk = 30;
                    echo '30%';
                }
            echo '</td>';
            echo '<td>';
                if($val['осталось на складе'] < $val['количество заказано'] && $val['осталось на складе'] != 0) {
                    echo ($val['количество заказано'] = $val['осталось на складе']).' шт.';
                    $ordered += $val['количество заказано'];
                }elseif($val['осталось на складе'] != 0) {
                    echo $val['количество заказано'].' шт.';
                    $ordered += $val['количество заказано'];
                }
            echo '</td>';
            echo '<td>';
                if($disk == 30) {
                    echo ($val['цена'] - ($val['цена'] * .3)) * $val['количество заказано'].' руб';
                    $price += ($val['цена'] - ($val['цена'] * .3)) * $val['количество заказано'];
                }elseif($val['осталось на складе'] != 0) {
                    echo ($val['цена'] - ($val['цена'] * $disk / 100)) * $val['количество заказано'].' руб';
                    $price += ($val['цена'] - ($val['цена'] * $disk / 100)) * $val['количество заказано'];
                }
            echo '</td>';
        echo '</tr>';
    }
}

?>

<style>
</style>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo ($_SERVER['HTTP_HOST'])?></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <style>form{display: inline-block; margin-top: 30px; text-align: left}.input-group{margin-bottom:10px}.btn{margin-bottom:20px}</style>
</head>
<h1>Корзина</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <td>Наименование товара</td>
            <td>Цена шт.</td>
            <td>Заказано</td>
            <td>На складе</td>
            <td>Уведомления</td>
            <td>Скидка</td>
            <td>В заказе шт.</td>
            <td>К оплате за шт.</td>
        </tr>
    </thead>
    <tbody>
        <?= bigBossFunction($bd) ?>
    </tbody>
</table>
<p>Позиций в заказе: <?= $nomination ?> шт.</p>
<p>Единиц товара в заказе: <?= $ordered ?> шт.</p>
<p>Всего к оплате: <?= $price ?> руб</p>