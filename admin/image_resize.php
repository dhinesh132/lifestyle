<?php

require_once("admin_header.php"); 

require_once("../classes/product_master.class.php");


$prod_obj = new product_master();

$folder_name = "images";


$sel_qry = "select prod_name,prod_id from ".$prod_obj->cls_tbl." where prod_med_image='' and prod_th_image='' and prod_big_image='' and prod_large_image='' order by prod_id limit 0,100";

$prd_res = $GLOBALS['db_con_obj']->execute_sql($sel_qry);




function resizeImage($img, $imgPath, $suffix, $by, $quality)
{
    // Open the original image.
    

	for ($i = 1; $i <= 4; $i++) {
	$original = imagecreatefromjpeg("$imgPath/$img") or die("Error Opening original (<em>$imgPath/$img</em>)");
    list($width, $height, $type, $attr) = getimagesize("$imgPath/$img");

	$newNameE = explode(".", $img);
	
		
    if($i ==1)
	{
		$newWidth = 60;
		$newHeight = 60;
		$newName = "thump_".$newNameE[0]. date("YmdHis").".".$newNameE[1];
		$name1 = $newName;
	}
	if($i ==2)
	{
		$newWidth = 110;
		$newHeight = 110;
		$newName = "med_".$newNameE[0]. date("YmdHis").".".$newNameE[1];
		$name2 = $newName;
	}
	if($i ==3)
	{
		$newWidth = 250;
		$newHeight = 250;
		$newName = "big".$newNameE[0]. date("YmdHis").".".$newNameE[1];
		$name3 = $newName;
	}
	if($i ==4)
	{
		$newWidth = 350;
		$newHeight = 350;
		$newName = "large_".$newNameE[0]. date("YmdHis").".".$newNameE[1];
		$name3 = $newName;
	}
	
		// Resample the image.
		$tempImg = imagecreatetruecolor($newWidth, $newHeight) or die("Cant create temp image");
		imagecopyresized($tempImg, $original, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height) or die("Cant resize copy");
	
		// Create the new file name.
		
	
		// Save the image.
		imagejpeg($tempImg, "$imgPath/test/$newName", $quality) or die("Cant save image");
	
		// Clean up.
		
		imagedestroy($original);
		imagedestroy($tempImg);
		
		$update = "update product_master set prod_th_image='".$name1."',prod_med_image='".$name2."',prod_big_image='".$name3."',prod_large_image='".$name4."' where prod_id = '".$by."'";
		
		$GLOBALS['db_con_obj']->execute_sql($update,"update");
	}
    return true;
}

if($prd_res[1] >0) 
{
	while ($prod_data = mysql_fetch_object($prd_res[0]))
	{
		$file_name = $prod_data->prod_name;
		
		$file_name = $file_name."jpg";
		
			resizeImage($file_name, $folder_name, date("YmdHis"), $prod_data->prod_id, "10");
	}
}
else
{
 echo "All products images resized successfully";
}

require_once("admin_footer.php"); 

?>