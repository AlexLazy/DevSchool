<?php

//Родительский класс объявления
class Ads
{
    protected $id;
    protected $seller_name;
    protected $email;
    protected $allow_mails;
    protected $phone;
    protected $location_id;
    protected $category_id;
    protected $title;
    protected $description;
    protected $price;
    
    public function __construct($ad)
    {
        if(isset($ad['id'])) $this->id=$ad['id'];
        foreach ($ad as $key=>$val)
        {
            if($key == 'submit') continue;
            if(is_array($val))
            {
                $this->$key = 1;
            }
            else
            {
                $this->$key = strip_tags($val);
            }
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
    public function getObjVars()
    {
        return get_object_vars($this);
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