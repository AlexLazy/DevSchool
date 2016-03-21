<?php
    $date = array(1,2,3,4,5);
    mt_srand(time());
    for ($i = 0; $i < 5; $i++) {
        $date[$i] = mt_rand();
        echo date('d.m.Y', $date[$i]).'<br>';
    }
    function day($val){
        for ($a = 0; $a < 5; $a++) {
            $val[$a] = date('d', $val[$a]);
        }
        echo '<p style="color:blue">'.'наименьший день '.(min($val)).'</p>';
    }
    day($date);
    function month($val){
        for ($a = 0; $a < 5; $a++) {
            $val[$a] = date('m', $val[$a]);
        }
        echo '<p style="color:red">'.'наибольший месяц '.(max($val)).'</p>';
    }
    month($date);
    sort($date);

    $selected = array_pop($date);
    echo date('d.m.Y H:i:s', $selected);
    echo '<br>';
    date_default_timezone_set('America/New_York');
    echo date('d.m.Y H:i:s', $selected);
    ?>
