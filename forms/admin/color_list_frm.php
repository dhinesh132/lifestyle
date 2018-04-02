<?php
?>
<p><font class="desc_cat"><?php echo $cat_heirarchy; ?></font></p>
<table width="80%" cellpadding="0" cellspacing="0" align="left" >
  <tr>
<?php
$k ="";
$qry = "select color_id,color_name from color_master where color_status='1' order by color_id asc";

$tstr = $prod_obj->image_copies['prod_med_image'][1];
$tstr_arr = explode(",", $tstr);

$med_img_ht_arr = explode("|", $tstr_arr[1]);
$med_img_ht = $med_img_ht_arr[3];

$paging_cls = new matrixpaging($qry,18,11,3);


				
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


if (in_array($data->color_id, $color))
	$str = "checked";
else
	$str = "";
	
	$k++;
?>
  <td valign="bottom" width="166"> <table border="0" cellspacing="5" cellpadding="3" height="100%" class="productborder">
  
	<tr><td><input type="checkbox" name="color[]" class="checkbox_cls" value="<?php echo $data->color_id ?>" <?php echo $str; ?>/>&nbsp;<?php echo stripslashes($data->color_name);?>
    </td></tr>
    
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
  <tr>
  <td height="2" colspan="3" valign="top" background="images/ash.png"><input type="hidden" name="color_length" value="<?php echo $k;?>" /></td>
</tr>
</table>
