<script language="JavaScript">
function delete_record(url)
{
 doyou = confirm("Do you want to Delete this admin(OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="admin.php?" + url;
 }
}
</script>
<p align="right"><a href="admin.php?submit_action=add" class="blue_link">Add 
      New admin</a></p>
<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px>
    <td  width="10%" >ID</td>
    <td width="26%">Admin name</td>
    <td width="18%">Priority</td>
	<td width="22%">Password</td>
    <td width="20%" align="center">Actions</td>
  </tr>
  <?php

//echo $admin_obj->cls_sql . " order by admin_id desc";
$paging_cls = new paging($admin_obj->cls_sql . " order by admin_id desc");
unset($_SESSION['ses_temp_admin_obj']);
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
    <td><a class='blue_link' href="admin.php?submit_action=preview&admin_id=<?php echo stripslashes($data->admin_id); ?>" target="_blank"><?php
	
	 echo stripslashes($data->admin_id); 
	 
	 ?></a></td>
    <td>
      <?php
	
	 echo stripslashes($data->admin_uname); 
	 
	 ?>
      </td>
	  <td>
      <?php
	
	 echo stripslashes($data->priority); 
	 
	 ?>
      </td>
    <td><?php echo stripslashes($data->admin_password); ?></td>
    <td align="center"><a href="admin.php?submit_action=edit&<?php echo $admin_obj->primary_fld; ?>=<?php echo stripslashes($data->admin_id); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit"></a><a href="admin.php?submit_action=edit&<?php echo $admin_obj->primary_fld; ?>=<?php echo stripslashes($data->admin_id); ?>"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $admin_obj->primary_fld; ?>=<?php echo stripslashes($data->admin_id); ?>')" alt="Delete"></a><a href="admin.php?submit_action=edit&<?php echo $admin_obj->primary_fld; ?>=<?php echo stripslashes($data->admin_id); ?>"></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="5" algin='center'> <font class='redfont'>No admin found.</font></td>
  </tr>
  <?php

}

?>
</table>
<br>
<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
 
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

