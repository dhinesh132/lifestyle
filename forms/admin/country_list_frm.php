

<script language="JavaScript">
function delete_record(url)
{
 doyou = confirm("Do you want to Delete this country(OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="country.php?" + url;
 }
}
</script>
<p align="right"><a href="country.php?submit_action=add" class="blue_link">Add 
      New country</a></p>
<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px>
    <td width="15%">Country Id</td>
    <td width="45%">Country</td>
    <td width="19%">Country Code</td> 
	<td width="25%">Status</td> 
    <td width="21%" align="center">Actions</td>
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
	<td><?php 
	if($data->country_status ==1)
		echo "Active";
	else
	    echo "In-Active";
	  ?></td>
    <td align="center"><a href="country.php?submit_action=edit&<?php echo $country_obj->primary_fld; ?>=<?php echo stripslashes($data->countryid); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&countryid=<?php echo stripslashes($data->countryid); ?>')" alt="Delete"></a></td>
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
<br>
<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
  <tr> 
    <td colspan="5" align="center"><span class="hintstyle">Note : State for this country should be deleted before deleting it 
      country .</span></td>
  </tr>
  <tr>
	  <td height=5px>
	  </td>
  </tr>
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

