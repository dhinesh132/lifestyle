<p align="right"><a href="newsletter.php">Back to newsletter</a></p><table align="center" width="98%" cellpadding="5">
  <tr> 
<?php

$nl_month = array("1" => "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

$fetch_rec = $GLOBALS['db_con_obj']->fetch_flds($nlobj->cls_tbl,"news_id","1=1");

$qry = "select news_id from ". $nlobj->cls_tbl . " where year = '" . date("Y") . "' and month = '" . date("m") . "' order by year desc, month desc";

$res = $GLOBALS['db_con_obj']->execute_sql($qry);


$qry = $nlobj->cls_sql . " and ((year <= '" . date("Y") . "' and month < '" . date("m") . "') or year < '" . date("Y") . "') order by year desc, month desc";

//echo $qry . "<hr>";
$paging_cls = new matrixpaging($qry,10,11,5);
				
//echo $paging_cls->start_index ." - " . $paging_cls->end_index . "<hr>";

if($res[1] == 0)
{
	$paging_cls->start_index += 1;
	$paging_cls->end_index += 1;
}

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

$product_link = "product_category.php?cat_id=" . $data->category_id;

?>
  <td> <table width="120" border="0" cellspacing="5" cellpadding="3">
        <tr> 
          <td><div align="center"><a href="nl_archive.php?nl_mth=<?php echo $data->month; ?>&nl_yr=<?php echo $data->year; ?>" target="_blank"><?php echo $nl_month[$data->month] . " " . $data->year; ?></a></div></td>
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
  <tr>
    <td align="center" colspan="<?php echo $paging_cls->mat_cols; ?>"> 
<?php 

if($paging_cls->num_of_rows > 0)
{
	$paging_cls->print_prev();
	$paging_cls->print_numbered_links();
	$paging_cls->print_next();
	$paging_cls->print_pages_of(); 
}
else
{
	echo "<span class='redfont'>No newsletters were moved to archives so far.</span>";
}
?> 
</td>
  </tr>
</table>
