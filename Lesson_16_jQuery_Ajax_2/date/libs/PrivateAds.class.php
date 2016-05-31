<?php

//Класс частного лица
class PrivateAds extends Ads
{
    public $private = 1;
    public function __construct($ad)
    {
        parent::__construct($ad);
    }
}