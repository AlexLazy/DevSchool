<?php

class Ads
{
    public $id;
    public $seller_name;
    public $email;
    public $allow_mails;
    public $phone;
    public $location_id;
    public $category_id;
    public $title;
    public $description;
    public $price;
    
    public function __construct($ad)
    {
        foreach ($ad as $key=>$val)
        {
            if(isset($ad['id'])) $this->id=$ad['id'];
            if($key == 'submit') continue;
            $this->$key = $val;
        }
    }
    
    public function save()
    {
        global $mysqli;
        $vars = get_object_vars($this);
        $mysqli->query('REPLACE INTO ?_ads_list (?#) VALUES(?a)', array_keys($vars), array_values($vars));
        header("Location: http://" . $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
        exit();
    }
    
    public function delete($id = null)
    {
        global $mysqli;
        if ($id != null)
        {
            $mysqli->query("DELETE FROM ?_ads_list WHERE id=?d", $id);
        }
        else
        {
            $mysqli->query("DELETE FROM ?_ads_list");
        }

        header("Location: http://" . $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
        exit;
    }
    
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getName()
    {
        return $this->seller_name;
    }
    public function getPrice()
    {
        return $this->price;
    }
    
    //Получение данных для селектов из БД
    public function getLocation()
    {
        global $mysqli;
        return $this->location = $mysqli->selectCol("SELECT id AS ARRAY_KEY, name FROM ?_location");
    }
    public function getCategory()
    {
        global $mysqli;
        $arr = $mysqli->select("SELECT id AS ARRAY_KEY, name, parent_id AS PARENT_KEY FROM ?_category");
        foreach($arr as $cat)
        {
            foreach($cat['childNodes'] as $key => $val)
            {
                $res[$cat['name']][$key] = $val['name'];
            }
        }
        return $this->category = $res;
    }   
}

//Класс частного лица
class PrivateAds extends Ads
{
    public $private = 1;
    public function __construct($ad)
    {
        parent::__construct($ad);
    }
}

//Класс компании
class CompanyAds extends Ads
{
    public $private = 0;
    public function __construct($ad)
    {
        parent::__construct($ad);
    }
}

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
        $all = $mysqli->select("SELECT * FROM ?_ads_list");
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