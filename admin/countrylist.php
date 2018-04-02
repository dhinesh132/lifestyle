<?php

require_once("../classes/country.class.php");
$country_obj = new country();


?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td>
<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px>
    <td width="15%">Country Id</td>
    <td width="55%">Country</td>
    <td width="19%">Country Code</td> 
  </tr>
  <?php
  
 

$paging_cls = new paging($country_obj->cls_sql . " order by country_status desc, countryname asc");
unset($_SESSION['ses_temp_country_obj']);
//echo $paging_cls->start_index ." - " . $paging_cls->end_index . "<hr>";

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
 if(file_exists("../includes/admin_alternate_color.php"))
  include("../includes/admin_alternate_color.php");
  else
  include("includes/admin_alternate_color.php");

?>
  <tr <?php echo $row_bg_color; ?>  height=30px>
    <td><a class='blue_link' href="country.php?submit_action=preview&countryid=<?php echo stripslashes($data->countryid); ?>" target="_blank"><?php
	
	 echo stripslashes($data->countryid); 
	 
	 ?></a></td>
    <td> 
      <?php
	 
	 echo stripslashes($data->countryname);
	 
	 
	 ?>
    </td>
    <td><?php echo stripslashes($data->countrycode); ?></td>
	
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="5" algin='center'> <font class='redfont'>No country found.</font></td>
  </tr>
  <?php

}

?>
</table>
	</td>
  </tr>
</table>
<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
  
  <tr> 
    <td align="center" width="33%"> 
      <?php
	
	
$paging_cls->print_prev();


	
	
	?>
    </td>
    <td colspan="3" align="center" width="34%"> 
      <?php
	
$paging_cls->print_numbered_links();

$paging_cls->print_pages_of();

	
	?>
    </td>
    <td align="center" width="33%"> 
      <?php
	
	$paging_cls->print_next();

	
	?>
    </td>
  </tr>
</table>