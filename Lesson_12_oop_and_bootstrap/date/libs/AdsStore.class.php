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
    
    private function addAds(Ads $ad)
    {
        if(!($this instanceof AdsStore)) die('AdsStore');
        $this->ads[$ad->getId()] = $ad;
    }
    
    private function delete($id = null)
    {
        global $mysqli;
        
        if ($id != null)
        {
            unset($this->ads[$id]);
            $mysqli->query("DELETE FROM ?_ads_list WHERE id=?d", $id);
            return TRUE;
        }
        else
        {
            unset($this->ads);
            $mysqli->query("DELETE FROM ?_ads_list");
            return TRUE;
        }
    }
    
    private function sort()
    {
        global $smarty;
        
        $rout = explode('?', $_SERVER['REQUEST_URI']);
        $second_rout = explode('&', $rout[1]);
        if(isset($rout[1]))
        {
            $pre = '?'.$rout[1].'&';
            if(isset($second_rout[1]))
            {
                $pre = '?'.$second_rout[0].'&';
            }
        }
        else
        {
            $pre ='?';
        }
        
        return $pre;
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
        
        if (filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT) >= -1)
        {
            if($_GET['delete'] == -1)
            {
                self::delete();
            }
            else
            {
                self::delete($_GET['delete']);
            }
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
                foreach ($fillAds->getObjVars() as $key => $value)//Заполнение полей формы
                {
                    $smarty->assign($key, $value);
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
            if(isset($this->ads))
            {
                foreach ($this->ads as $ad)
                {
                    $smarty->assign('ad', $ad);
                    $ads.= $smarty->fetch('ad.tpl');
                }
                $smarty->assign('ads', $ads);
            }
            
        }
        $smarty->assign('sort_by_title', $this->sort().'sort=title');
        $smarty->assign('sort_by_name', $this->sort().'sort=seller_name');
        $smarty->assign('sort_by_price', $this->sort().'sort=price');
        
        return self::$instance;    
    }
    
    public function run()
    {
        global $smarty;

        self::getAllAdsFromDB();
        self::prepareForOut();
        
        $smarty->display('header.tpl');
        $smarty->display('form.tpl');
        $smarty->display('footer.tpl');
                
    }
}