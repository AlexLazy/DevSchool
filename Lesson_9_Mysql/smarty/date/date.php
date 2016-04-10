<?php
$location = select($mysqli, 'ds_location');
$category = select($mysqli, 'ds_category', 'category');

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

if(isset($_POST['submit'])){
    isset($_POST['allow_mails']) ? $allow_mails = 1 : $allow_mails = 0;
    $post = [
        'private' => (int)$_POST['private'],
        'seller_name' => (string) $_POST['seller_name'],
        'email'       => (string) $_POST['email'],
        'allow_mails'  => $allow_mails,
        'phone'       => (string) $_POST['phone'],
        'location_id' => (int) $_POST['location_id'],
        'category_id' => (int) $_POST['category_id'],
        'title'       => (string) $_POST['title'],
        'description' => (string) $_POST['description'],
        'price'       => (int) $_POST['price']
    ];
}

