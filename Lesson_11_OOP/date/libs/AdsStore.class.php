<?php

//Хранилище объявлений
class AdsStore
{
    private static $instance=NULL;
    private $ads=[];
    
    public static function instance()
    {
        if(self::$instance === NULL) self::$instance = new AdsStore();
        return self::$instance;
    }
    
    public function addAds(Ads $ad)
    {
        if(!($this instanceof AdsStore)) die('AdsStore');
        $this->ads[$ad->getId()] = $ad;
    }
    
    public function getAllAdsFromDB()
    {
        global $mysqli;
        
        (isset($_GET['sort'])) ? $order = (string)$_GET['sort'] : $order = 'id';//сортировка
        $all = $mysqli->select("SELECT * FROM ?_ads_list ORDER BY $order");
        foreach ($all as $value)
        {
            ($value['private'] == '1') ? $ad = new PrivateAds($value) : $ad = new CompanyAds($value);
            self::addAds($ad);
        }
        return self::$instance;
    }

    public function prepareForOut()
    {
        global $smarty;
        
        //Занесение данных в смарти
        $smarty->assign('location', Ads::getLocation());
        $smarty->assign('category', Ads::getCategory());
        if (filter_input(INPUT_GET, 'ads', FILTER_VALIDATE_INT) > 0 || filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT) > 0)//Во время просмотра/редактирования
        {
            if ((isset($_GET['ads']) && empty($this->ads[$_GET['ads']])) || (isset($_GET['edit']) && empty($this->ads[$_GET['edit']])))
            {
                echo "Объявление отсутствует <a href='index.php'>назад</a>";
                exit;
            }
            else
            {
                (isset($_GET['ads'])) ? $fillAds = $this->ads[$_GET['ads']] : $fillAds = $this->ads[$_GET['edit']];
                foreach (get_object_vars($fillAds) as $key => $value)//Заполнение полей формы
                {
                    $smarty->assign($key, strip_tags($value));
                }
                foreach ($this->ads as $ad)//Заполнение обьектов объявлений
                {
                    $smarty->assign('ad', $ad);
                    $ads.= $smarty->fetch('ad.tpl');
                }
                $smarty->assign('ads', $ads);
            }
        }
        else
        {
            $smarty->assign('location', Ads::getLocation());
            $smarty->assign('category', Ads::getCategory());
            foreach ($this->ads as $ad)
            {
                $smarty->assign('ad', $ad);
                $ads.= $smarty->fetch('ad.tpl');
            }
            $smarty->assign('ads', $ads);
        }
        
        return self::$instance;    
    }
    
    public function display()
    {
        global $smarty;

        $smarty->display('header.tpl');
        $smarty->display('form.tpl');
        $smarty->display('footer.tpl');
                
    }
}