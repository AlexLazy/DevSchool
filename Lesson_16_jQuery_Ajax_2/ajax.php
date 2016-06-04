<?php
	require_once('initialization.php');

	switch ($_GET['action']) {
	   case "save": {
	         if($_POST['private'] == 1)
					$ad = new PrivateAds($_POST);
	         else
	            $ad = new CompanyAds($_POST);
	         break;
	   }
	   case "delete": {
	   	if(isset($_GET['id']))
	   		$ads->delete($_GET['id']);
	   	else
	   		$ads->delete();
	   	break;
	   }
	   case "ads": {
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
	      	echo $ads->getAdsJSON();
	      break;
	}

	if ($ad) {
	    $error = Validator::check($ad);
	    if ($error) {
	        $ads->errorHandler($ad, $error);
	    } else {
	        $ad->save();
	    }
	}