<?php

//Хранилище объявлений
class AdsStore
{
    private static $instance=NULL;
    
    public static function instance()
    {
        if(self::$instance === NULL) self::$instance = new AdsStore();
        return self::$instance;
    }
    
    public function delete($id = null)
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
    
    public function getAdsJSON($sort="NULL")
    {
        global $mysqli;

        if(isset($sort) && (($sort=='title')||($sort=='seller_name')||($sort=='price')))
            return json_encode($mysqli->select("SELECT * FROM ?_ads_list ORDER BY $sort"));
        else
            return json_encode($mysqli->select("SELECT * FROM ?_ads_list"));
    }
    
    public function getAdJSON($id)
    {
        global $mysqli;
        
        return json_encode($mysqli->select("SELECT * FROM ?_ads_list WHERE id=?d", $id));
    }

    private function prepareForOut()
    {
        global $smarty;
        
        //Селекты
        $smarty->assign('location', Ads::getLocation());
        $smarty->assign('category', Ads::getCategory());
        
        return self::$instance;    
    }
    
    public function run()
    {
        global $smarty;

        self::prepareForOut();
        
        $smarty->display('header.tpl');
        $smarty->display('form.tpl');
        $smarty->display('footer.tpl');
                
    }
}