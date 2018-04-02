<a href="index.php">Home</a> >
<?php 
if(strtolower($spl_doc_title)=="about us"){ 
	echo ABOUTUSBREADCRUMB ." > ".$BreadCrumb;
} else if(strtolower($spl_doc_title)=="products"){
	echo '<a href="'.$bredcruburl.'">'.$BreadCrumb.'</a>'; 
	if(isset($data->EnName)){
	echo " > ".display_field_value($data,"Name");
	}
}else if(strtolower($spl_doc_title)=="promotion"){ 
	echo PROMOTIONPAGEBREADCRUMB ." > ".$BreadCrumb;
}
else if(strtolower($spl_doc_title)=="corporate"){ 
	echo CORPORATEGIFTBREADCRUMB ;
}else if(strtolower($spl_doc_title)=="member"){ 
	echo Member." > ".$BreadCrumb;
}else if(strtolower($spl_doc_title)=="cart"){
	echo CARTBREADCRUMB." > ".$BreadCrumb;
}
?>
<hr />