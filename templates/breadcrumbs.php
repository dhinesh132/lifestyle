<div class="breadcrumb"><a href="<?php echo $GLOBALS['site_config']['site_path'];?>" class="breadlink">Home</a> /
<?php  
if(strtolower($spl_doc_title)=="about us"){ 
	echo ABOUTUSBREADCRUMB ." / ".$BreadCrumb;
} else if(strtolower($spl_doc_title)=="products"){
	echo '<a href="'.$bredcruburl.'" class="breadlink">'.$BreadCrumb.'</a>'; 
	if(isset($data->EnName)){
	echo " / ".display_field_value($data,"Name");
	}
}else if(strtolower($spl_doc_title)=="promotion"){ 
	echo '<a href="'.$bredcruburl.'" class="breadlink">'.$BreadCrumb.'</a>'; 
	if(isset($promo_data->EnTitle)){
	echo " / ".$promo_data->EnTitle;
	}
}
else if(strtolower($spl_doc_title)=="corporate"){ 
	echo CORPORATEGIFTBREADCRUMB ;
}else if(strtolower($spl_doc_title)=="member"){ 
	echo "Member"." / ".$BreadCrumb;
}else if(strtolower($spl_doc_title)=="shopping cart"){
	echo $spl_doc_title." / ".$BreadCrumb;
}
?>
</div>