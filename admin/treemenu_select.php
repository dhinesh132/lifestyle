<?php

	//$tm_sel = array("product_master.php" => "1-2", "related_products.php" => "1-3", "author.php" => "1-4", "topcategory.php" => "1-5", "your_review.php" => "1-6", "orders.php" => "7-8", "orders_master_backup.php" => "7-9", "consultations.php" => "10-11", "tele_consultations.php" => "10-12", "customers.php" => "11-14", "nl_subscriber.php" => "11-15", "newsletter.php" => "12-17", "newsletter_product.php" => "12-18", "newsletter_title_img_master.php" => "12-19", "nl_content.php" => "12-20", "subadmin_settings.php" => "13-22", "admin.php" => "13-23", "newsletter_settings.php" => "13-24");
	
	switch ($_SESSION['ses_admin_id'])
	{
		
		case 1:
			$tm_sel = array("product_master.php" => "1-1", "orders.php" => "2-3", "orders_master_backup.php" => "2-4", "customers.php" => "5-5", "testimonial_master.php" => "6-6", "subadmin_settings.php" => "7-8", "admin.php" => "7-9", "payment_settings.php" => "7-10");
			break;
		
		case 2:
			$tm_sel = array("types.php" => "1-2","materials.php" => "1-3", "functions.php" => "1-4", "products.php" => "1-5","authors.php"=>"1-6","publications.php"=>"1-7", "banner_master.php" => "2-8", "subscriber.php" => "3-9",  "subadmin_settings.php" => "8-9", "admin.php" => "8-10", "payment_settings.php" => "8-11", "frame_search.php" => "13-14","customer_search.php"=>"14-15","news_master.php"=>"16-16","csv_import.php"=>"15-15");
			break;
		
		case 3:
			$tm_sel = array("product_master.php" => "1-1", "orders.php" => "2-3", "orders_master_backup.php" => "2-4", "customers.php" => "5-5",  "admin.php" => "6-6");
			//$tm_sel = array("product_master.php" => "1-2", "author.php" => "1-3", "orders.php" => "4-5", "orders_master_backup.php" => "4-6", "customers.php" => "7-7", "subadmin_settings.php" => "8-9", "admin.php" => "8-10", "payment_settings.php" => "8-11");

			break;
		
	}
	$tarr = explode("?", basename($_SERVER['REQUEST_URI']));
	$temp_val = $tm_sel[$tarr[0]];
	
	$ta = explode("-",$temp_val);
	$smcokval = $ta[1];
	$mcokval = $ta[0];
	
	
	if($smcokval != "")
	{ 

?>
<script language="javascript">
//SetCookie('clickedFolder', '');
//SetCookie('highlightedTreeviewLink', '');
SetCookie('clickedFolder', <?php echo $mcokval; ?>);
SetCookie('highlightedTreeviewLink', <?php echo $smcokval; ?>);
</script>
<?php
 }
 else
 { 
?>
<script language="javascript">
SetCookie('clickedFolder', '');
SetCookie('highlightedTreeviewLink', '');
ExpireCookie('clickedFolder');
ExpireCookie('highlightedTreeviewLink');
</script>
<?php

}

?>