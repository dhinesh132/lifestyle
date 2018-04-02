
<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this frame page? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $product_page_url; ?>?" + url;
 }
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
<table width="60%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><p align="right"><a href="frame_master.php?submit_action=add" class="blue_link">Add 
New Frame</a></p></td></tr></table>
<table width="60%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px> 
    <td width="17%" nowrap class="listtitle">Id # </td>
    <td width="59%" class="listtitle" >Frame Title</td>
    <td width="24%" align="center" class="listtitle">Actions</td>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/frame_master_preview_frm.php";
 
  $qry = "select frame_id, frame_name from " . $sbg_obj->cls_tbl . "  order by frame_id desc";

$paging_cls = new paging($qry);

unset($_SESSION['ses_temp_spg_obj']);
//echo $paging_cls->start_index ." - " . $paging_cls->end_index . "<hr>";

$category_name_arr = array();

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
    <td><?php echo stripslashes($data->frame_id); ?></td>
    <td><?php echo stripslashes($data->frame_name); ?></a>    </td>
    <?php if(isset($_SESSION['ses_pl_id'])) {?><?php }?>
    <td align="center"><a href="frame_master.php?submit_action=edit&<?php echo $sbg_obj->primary_fld; ?>=<?php echo stripslashes($data->frame_id); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $sbg_obj->primary_fld; ?>=<?php echo stripslashes($data->frame_id); ?>')" alt="Delete"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="temp_related.php?frame_id=<?php echo stripslashes($data->frame_id); ?>"><img src="../images/icon_config.gif" border=0 title="Assign Lens Type" alt="Assign Lens Type" align="absmiddle"></a></td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan='3' algin='center'> <font class='redfont'>No records available 
      !!.</font></td>
  </tr>
  <?php

}

?>
</table>
<?php if(isset($_SESSION['ses_pl_id']))  { ?>
<p class="starfont" align="center">Note: Replace the id of the page instead of #spid# in the following url, that will give you the link for the pagelibrary.<br /><?php echo $GLOBALS['site_config']['site_path'] . "static_page.php?static_pg_id=#spid#"; ?>
</p>
<?php } ?>
<br>
<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
 <!-- <tr> 
    <td colspan="5" align="center"><span class="hintstyle">Note : To delete a 
      frame_master it should not contain any products in it.</span></td>
  </tr> -->
  <tr>
	  <td height=5px colspan="5">
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

