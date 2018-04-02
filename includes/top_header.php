<?php


if(isset($_SESSION['ses_lang'])&& $_SESSION['ses_lang']!=''){
	if($_SESSION['ses_lang'] =="Ch"){
		define("LANG", "Ch");
		$_SESSION['ses_lang'] ="Ch";
		include("languages/Ch.php");
		$engStyle="";
		$chStyle="color:#FF6600;"; 
	}
	else{
		$_SESSION['ses_lang'] ="En";
		define("LANG", "En");
	  	include("languages/En.php");
		$engStyle="color:#FF6600;";
		$chStyle=""; 
	}
}else{
	$_SESSION['ses_lang'] ="En";
	define("LANG", "En");
	include("languages/En.php");
	$engStyle="color:#FF6600;";
	$chStyle="";
}

$action = $_REQUEST['action'];
switch($action)
{
	case "language":
		$_SESSION['ses_lang'] =$_REQUEST['language'];
		if($_SESSION['ses_lang'] =="Ch"){
			define("LANG", "Ch");
			$_SESSION['ses_lang'] ="Ch";
			include("languages/Ch.php");
		}
		else{
			$_SESSION['ses_lang'] ="En";
			define("LANG", "En");
			include("languages/En.php"); 
		}
		header("location:index.php");
	break;
	
	case "subscribe":
		require_once("classes/subscriber.class.php");
		$sub_obj = new subscriber();
		if($sub_obj->insert()){
			$redirect_url = $GLOBALS['site_config']['site_path']."index/Subscription-successful";
	  		
		}
		else{
			$redirect_url = $GLOBALS['site_config']['site_path']."index/Subscription-Falied";
	  		
		}
		header("location:$redirect_url");
		exit;
	break;
	
}
require_once("includes/inside_head_tag.php");

$action1 = $_REQUEST['price'];

switch($action1)
{
case "yes":
	$price1 = $_REQUEST['price1'];
	$price2 = $_REQUEST['price2'];
	header("location:product_lists.php?price1=$price1&price2=$price2");
	exit;
	
break;
}


?>