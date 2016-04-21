<?php

//Родительский класс объявления
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