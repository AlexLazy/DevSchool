<?php

//Класс компании
class CompanyAds extends Ads
{
    public $private = 0;
    public function __construct($ad)
    {
        parent::__construct($ad);
    }
}