<?php

require_once("header.php"); 
$from_page = "latest";

require_once("classes/product_master.class.php");

$prod_obj = new product_master();

include("classes/your_review.class.php");


$your_review_obj = new your_review();

/*
include("admin_header.php"); 


$res = $rev_obj->fetch_flds($rev_obj->cls_tbl, "*", "status = 1 and prod_id ='".$data->prod_id ."'");*/

//select *  from your_review where status=1 group by prod_id order by modify_datetime desc limit 0,3
//$GLOBALS['site_config']['debug'] = 1;

$rev_qry = "select prod_id, category_id, prod_name, prod_our_price,prod_normal_price, prod_th_image,editor_review,rating from ".$prod_obj->cls_tbl." where editor_choice = '1' and prod_status = '1'";


$rev_res = $GLOBALS['db_con_obj']->execute_sql($rev_qry);


?>

<table width="95%" cellpadding="0" cellspacing="0" align="center" >
<tr>
  <td colspan="3" valign="top" class="content"><font class="heading">Editor Choice</font></td>
  </tr>
  <tr><td>
<?php
if ($rev_res[1] > 0)
{
while($rev_data=mysql_fetch_object($rev_res[0]))
{
//print_r($rev_data);


		  
		 $med_img_path1 = $prod_obj->attachment_path . $rev_data->prod_th_image;
		  
		if(file_exists($med_img_path1) && is_file($med_img_path1))
		  	$disp_img1 = $med_img_path1;
		else
			$disp_img1 = $prod_obj->attachment_path . 'default_prod.gif';
?>

<table><tr><td width="68" valign="top"><img src="<?php echo $disp_img1; ?>" border="0" alt="<?php echo stripslashes($rev_data->prod_name); ?>"></td>
<td width="135" valign="top"><table width="100%" align="left" border="0">
  
    <tr><td><a href="#" class="link"><?php echo stripslashes($rev_data->prod_name);?></a>
    </td></tr>
    <tr><td>
    <?php 	
	$k ="";
	$j ="";
	
	$reminder=(($rev_data->rating*10)%10);
				 
				for($k=1; $k<=$rev_data->rating;$k++)
				{?>
                
				<img src='<?php echo "images/gray.png";?>' border="0" align="absmiddle">
                
				<?php
				}
				if($reminder >=5  && $reminder !=0)
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
	
	
	$sub_cat = $GLOBALS['db_con_obj']->fetch_flds("category_master","parent_id,cat_name","cat_id = '".$rev_data->category_id."'");
	
	$subcat_data = mysql_fetch_object($sub_cat[0]);
	
	
	$cat = $GLOBALS['db_con_obj']->fetch_field("category_master","cat_name","cat_id = '".$subcat_data->parent_id."'");
	
	echo stripslashes($cat)."->".stripslashes($subcat_data->cat_name);
	?></font><br>
    <font class="type">Our Price :</font>&nbsp;<font class="price">$<?php echo $rev_data->prod_our_price;?></font>
    <br>
    <font class="type">Normal Price :</font>&nbsp;<font class="price1">$<?php echo $rev_data->prod_normal_price;?></font>
    </td></tr>
  </table></td>
<td width="296"><font class="newsletter"><?php 
echo stripslashes($rev_data->editor_review);
?></font></td>
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
<?php

require_once("footer.php"); 

?>
