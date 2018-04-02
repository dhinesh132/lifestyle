<table width="100%" cellpadding="0" cellspacing="0" align="center" >
<tr>
  <td colspan="3" valign="top" class="content"><font class="heading"><?php echo $cat_name;?></font></td>
  </tr>
  <tr>
<?php

if($featured_product_page == 1 || $from_page == "index")
{}
else
{
$chk_data = mysql_fetch_object($chk_res[0]);
$qry = "select prod_id, category_id, prod_name, prod_our_price,prod_normal_price, prod_med_image,prod_th_image,rating from " . $prod_obj->cls_tbl . " where prod_id in (" . $chk_data->products . ") and prod_id <> '" . $data->prod_id . "' order by  prod_name asc";
}

$tstr = $prod_obj->image_copies['prod_med_image'][1];
$tstr_arr = explode(",", $tstr);

$med_img_ht_arr = explode("|", $tstr_arr[1]);
$med_img_ht = $med_img_ht_arr[3];

$paging_cls = new matrixpaging($qry,50,11,4);


				
//echo $paging_cls->start_index ." - " . $paging_cls->end_index . "<hr>";

$mat_col_cnt = 0;

for($i=$paging_cls->start_index;$i<$paging_cls->end_index;$i++)
{
  if(mysql_data_seek($paging_cls->resultset,$i))
  {
  	$data = mysql_fetch_object($paging_cls->resultset);  
  }
  else
  {
  	unset($data);
  }
  
  if(isset($data))
  {
	$mat_col_cnt++;
/*
 if(strlen($row_bg_color) <= 0)
  	$row_bg_color = "bgcolor='#E8E9EA'";
  else
  	$row_bg_color = "";
*/

$detail_link = "product_detail.php?cat_id=" . $data->category_id . "&prod_id=" . $data->prod_id;

?>
  <td valign="top"> <table border="0" cellspacing="5" cellpadding="3" height="100%" class="productborder">
  
        <tr> 
          <td  valign="top"><?php
		  
		  $med_img_path = $prod_obj->attachment_path . $data->prod_med_image;
		  
		if(file_exists($med_img_path) && is_file($med_img_path))
		  	$disp_img = $med_img_path;
		else
			$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
		  
		  ?><div align="left"><a href="<?php echo $detail_link; ?>"><img src="<?php echo $disp_img; ?>" border="0" alt="<?php echo stripslashes($data->prod_name); ?>"></a></div></td>
        </tr>
	<tr><td><a href="<?php echo $detail_link; ?>" class="link"><?php echo stripslashes($data->prod_name);?></a>
    </td></tr>
     <?php if(1==2) {?>
    <tr><td valign="mi">
    <?php 	$reminder=(($data->rating*10)%10);
				 
				for($k=1; $k<=$data->rating;$k++)
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
	
	
	$sub_cat = $GLOBALS['db_con_obj']->fetch_flds("category_master","parent_id,cat_name","cat_id = '".$data->category_id."'");
	
	$subcat_data = mysql_fetch_object($sub_cat[0]);
	
	
	$cat = $GLOBALS['db_con_obj']->fetch_field("category_master","cat_name","cat_id = '".$subcat_data->parent_id."'");
	
	echo stripslashes($cat)."->".stripslashes($subcat_data->cat_name);
	?></font><br>
    <font class="type">Our Price :</font>&nbsp;<font class="price">$<?php echo $data->prod_our_price;?></font>
    <br>
    <font class="type">Normal Price :</font>&nbsp;<font class="price1">$<?php echo $data->prod_normal_price;?></font>
    </td></tr>
    <?php }?>
    </table></td>
<?php

if(($mat_col_cnt%$paging_cls->mat_cols) == 0)
echo "</tr><tr>";

} //end if(isset($data

}//end for(	


if(($mat_col_cnt%$paging_cls->mat_cols) != 0)
{
$cnt = $paging_cls->mat_cols - ($mat_col_cnt%$paging_cls->mat_cols);
for($i = 0; $i < $cnt; $i++)
{
echo "<td>&nbsp;</td>";

}
echo "</tr>";
}

?>
  <tr>
    <td align="center" colspan="<?php echo $paging_cls->mat_cols; ?>"> 
<?php 

if($more_link == 1)
{

?><p align="right"><a href="featured_product_lists.php">more...</a></p>
<?php

}


if($paging_cls->num_of_rows > 0)
{

//$paging_cls->print_prev();
//$paging_cls->print_numbered_links();
//$paging_cls->print_next();
//$paging_cls->print_pages_of(); 

}
else
{
	echo "<span class='redfont'>No Products Available.</span>";
}
?> 
</td>
  </tr>

</table>