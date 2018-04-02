<?php

include("classes/your_review.class.php");


$your_review_obj = new your_review();

/*
include("admin_header.php"); 


$res = $rev_obj->fetch_flds($rev_obj->cls_tbl, "*", "status = 1 and prod_id ='".$data->prod_id ."'");*/

//select *  from your_review where status=1 group by prod_id order by modify_datetime desc limit 0,3
//$GLOBALS['site_config']['debug'] = 1;

$res = $GLOBALS['db_con_obj']->fetch_flds($your_review_obj->cls_tbl, "*", "status=1 group by prod_id order by modify_datetime desc limit 0,3 ");


?>

<table width="95%" cellpadding="0" cellspacing="0" align="center" >
<tr>
  <td colspan="3" valign="top" class="content"><font class="heading">Latest Reviews</font></td>
  </tr>
  <tr><td>
<?php
if ($res[1] > 0)
{
while($rev_data=mysql_fetch_object($res[0]))
{

$rev_qry = "select prod_id, category_id, prod_name, prod_our_price,prod_normal_price, prod_th_image,rating from ".$prod_obj->cls_tbl." where prod_id = '".$rev_data->prod_id."'";

$rev_res = $GLOBALS['db_con_obj']->execute_sql($rev_qry);

$rev_data1 = mysql_fetch_object($rev_res[0]);
		  
		  $med_img_path1 = $prod_obj->attachment_path . $rev_data1->prod_th_image;
		  
		if(file_exists($med_img_path1) && is_file($med_img_path1))
		  	$disp_img1 = $med_img_path1;
		else
			$disp_img1 = $prod_obj->attachment_path . 'default_prod.gif';
?>

<table><tr><td width="68" valign="top"><img src="<?php echo $disp_img1; ?>" border="0" alt="<?php echo stripslashes($rev_data1->prod_name); ?>"></td>
<td width="135" ><table width="100%" align="left" border="0">
  
    <tr><td><a href="#" class="link"><?php echo stripslashes($rev_data1->prod_name);?></a>
    </td></tr>
    <tr><td>
    <?php 	
	$k ="";
	$j ="";
	$reminder=(($rev_data1>rating*10)%10);
				 
				for($k=1; $k<=$rev_data1->rating;$k++)
				{?>
                
				<img src='<?php echo "images/gray.png";?>' border="0" align="absmiddle">
                
				<?php
				}
				if($reminder >5)
				{
				$k= $k+1;
				?>
				<img src='<?php echo "images/half_above.png";?>' border="0" align="absmiddle">
			 	<?php	}
				else if($reminder !=0 && $reminder < 5)
				{
				$k= $k+1;
				?>
                <img src='<?php echo "images/half_star.png";?>' border="0" align="absmiddle">
                <?php
				}
				for($j=5; $j >= $k; $j--)
				{?>
                
				<img src='<?php echo "images/ash.png";?>' border="0" align="absmiddle">
                
				<?php
				}
				
				?>
    </td></tr>
    <tr><td><font class="type"><?php 
	
	
	$sub_cat = $GLOBALS['db_con_obj']->fetch_flds("category_master","parent_id,cat_name","cat_id = '".$rev_data1->category_id."'");
	
	$subcat_data = mysql_fetch_object($sub_cat[0]);
	
	
	$cat = $GLOBALS['db_con_obj']->fetch_field("category_master","cat_name","cat_id = '".$subcat_data->parent_id."'");
	
	echo stripslashes($cat)."->".stripslashes($subcat_data->cat_name);
	?></font><br>
    <font class="type">Our Price :</font>&nbsp;<font class="price">$<?php echo $rev_data1->prod_our_price;?></font>
    <br>
    <font class="type">Normal Price :</font>&nbsp;<font class="price1">$<?php echo $rev_data1->prod_normal_price;?></font>
    </td></tr>
  </table></td>
<td width="296"><font class="newsletter"><?php 
if(strlen($rev_data->review_text) > 150)
{
echo $description = show_short_description($rev_data->review_text,150);
?> -<a href="latest_review.php" class="blue_link">read more</a>
<?php }
else
{
?>
<?php echo $rev_data->review_text;?>
<?php } ?></font></td>
        </tr>
						 <tr>
                         <td valign="top" colspan="3" height="15"></td>
</tr></table>
<?php
}
 }
 else
 {
 ?>
 
 <strong> There are no User Reviews for this eBook. </strong>
 
 <?php
 }
 ?></td>
 </tr>
 </table>
