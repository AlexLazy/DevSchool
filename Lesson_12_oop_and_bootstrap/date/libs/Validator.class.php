<?php

class Validator
{
    static function check(Ads $ad)
    {
        global $smarty;
        $ad = $ad->getObjVars();
        
        if(empty($ad['seller_name']))
        {
            $smarty->assign('seller_name', 'Заполните это поле');
            return FALSE;
        }
        elseif(empty($ad['title']))
        {
            $smarty->assign('title', 'Заполните это поле');
            return FALSE;
        }
        elseif(empty($ad['price']))
        {
            $smarty->assign('price', 'Заполните это поле');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}
