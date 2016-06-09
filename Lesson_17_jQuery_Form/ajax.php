<?php
	require_once('initialization.php');

	switch ($_GET['action']) {
	   case "save": {
	      if($_POST['private'] == 1)
				$ad = new PrivateAds($_POST);
	      else
	         $ad = new CompanyAds($_POST);

	      if(!Validator::check($ad))  $ad->save();
	      break;
	   }
	   case "delete": {
	   	if(isset($_GET['id']) && $_GET['id'] == -1)
	   		$ads->delete();
	   	elseif(isset($_GET['id']))
	   		$ads->delete($_GET['id']);
	   	break;
	   }
	   case "ad": {
	   	if(isset($_GET['id']))
	   		echo $ads->getAdJSON($_GET['id']);
	   	break;
	   }
	   case "sort": {
	   	if(isset($_GET['id']))
	   		echo $ads->getAdsJSON($_GET['id']);
	   	break;
	   }
	   default:
	   	if(isset($_COOKIE['sort']))
	      	echo $ads->getAdsJSON($_COOKIE['sort']);
	      else
	      	echo $ads->getAdsJSON();
	      break;
	}