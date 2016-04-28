<?php

class Validator
{
    static function check(Ads $ad)
    {
        global $smarty;
        $error = [];
        $ad = $ad->getObjVars();
        
        if(empty($ad['seller_name'])) $error[] = 'seller_name';
        if(empty($ad['title'])) $error[] = 'title';
        if(empty($ad['price']) && $ad['price'] != '0') $error[] = 'price';
        
        if(empty($error)) {
            return FALSE;
        } else {
            return $error;
        }
    }
}