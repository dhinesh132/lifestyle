<?php
require_once("classes/product_master.class.php");

$prod_obj = new product_master();

$modelid = $_REQUEST['id'];

?>

<script language="JavaScript" type="text/javascript">
function handleSubmit(aValue)
{
document.popup.prodid.value=aValue;
window.opener.location='product_detail.php?cat_id=&prod_id='+aValue; 
window.close();

}
</script>
<p><font class="desc_cat"><?php echo $cat_heirarchy; ?></font></p>
<form action="" method="" name="popup" id="popup">
<table width="80%" cellpadding="0" cellspacing="0" align="center" >
<tr><td height="10px;"></td></tr>
  <tr>
<?php
$k ="";
$qry = "select prod_id,color_code,stock_code,prod_big_image ,prod_med_image from product_master where auto_modelid='".$modelid."'  and prod_status='1' order by prod_id asc";

$tstr = $prod_obj->image_copies['prod_med_image'][1];
$tstr_arr = explode(",", $tstr);

$med_img_ht_arr = explode("|", $tstr_arr[1]);
$med_img_ht = $med_img_ht_arr[3];

$paging_cls = new matrixpaging($qry,10,11,1);


				
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
	
	$fpath = $prod_obj->attachment_path.$data->prod_med_image;
													  
	if(!(file_exists($fpath) && is_file($fpath)))
	$fpath = $prod_obj->attachment_path."default_med_prod.gif";
?>
  <td valign="bottom" width="166"> <table cellspacing="5" cellpadding="3" height="50px" class="productborder" border="0">
  
	<tr><td><a href="javascript:void();" onclick="handleSubmit(<?php echo $data->prod_id;?>);"><img src="phpthump/phpThumb.php?src=../<?php echo $fpath; ?>&w=300&q=95" name="<?php echo $data->prod_name;?>" border="0" id="<?php echo $data->prod_name;?>" title="<?php echo $data->prod_name;?>"  /></a>
    </td>
	</tr>
    
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
  </tr>
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
?></td>
  </tr>
 
</table>
<input  type="hidden" name="prodid" />
<input  type="hidden" name="submit_action" value="refresh_form"/>
</form>

