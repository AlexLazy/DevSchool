<?php

$smarty->assign('private_arr', [
                            1 => 'Частное лицо',
                            0 => 'Компания'
                            ]);
$smarty->assign('private', 1);

$smarty->assign('seller_name');
$smarty->assign('email');

$smarty->assign('allow_mails_arr', [1 => 'Я не хочу получать вопросы по объявлению по e-mail']);
$smarty->assign('allow_mails');

$smarty->assign('phone');


$smarty->assign('location', $location);
$smarty->assign('location_id');


$smarty->assign('category', $category);

$smarty->assign('category_id');

$smarty->assign('title');
$smarty->assign('description');
$smarty->assign('price', '0');