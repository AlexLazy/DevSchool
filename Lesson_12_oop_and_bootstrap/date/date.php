<?php

$smarty->assign('private_arr', [
                            1 => 'Частное лицо',
                            0 => 'Компания'
                            ]);
$smarty->assign('private', 1);

$smarty->assign('allow_mails_arr', [1 => 'Я не хочу получать вопросы по объявлению по e-mail']);

$smarty->assign('location', $location);
$smarty->assign('category', $category);

$smarty->assign('price', '0');


