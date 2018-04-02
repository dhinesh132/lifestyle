
<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this email? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="subscriber.php?" + url;
 }
}

function order_record(url)
{
 	  window.location.href="subscriber.php?" + url;
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
<div align="center" class="whitebox mtop15" style="min-height:0px">
<form name="order_search_frm" method="post" action="" onSubmit="return check_orderform(window.document.order_search_frm);">
<table  align="center" cellpadding="5" cellspacing="0" width="65%" class="tableborder_new">
 
    <tr> 
      <td><table align="center" border="0" cellspacing="3" cellpadding="3">
                     
          <tr valign="top"> 
            <td align="right" style="border-bottom:0px;"><span class="whitefont">Filter By:</span></td>
            <td style="border-bottom:0px;">
            <select name="filter_column" class="mediumtxtbox">
                <option value="name" <?php echo (stripslashes($_SESSION['ses_sub_srch_vars']['filter_column']) == "name")?"selected":""; ?>>Name</option>            	<option value="email" <?php echo (stripslashes($_SESSION['ses_sub_srch_vars']['filter_column']) == "email")?"selected":""; ?>>Email</option>
                <option value="ContactNo" <?php echo (stripslashes($_SESSION['ses_sub_srch_vars']['filter_column']) == "ContactNo")?"selected":""; ?>>Phone</option>
              </select>
                <select name="Nametype" class="mediumtxtbox">
                <option value="= '#val#'" <?php echo (stripslashes($_SESSION['ses_sub_srch_vars']['Nametype']) == "= '#val#'")?"selected":""; ?>>Equals</option>
                <option value="like '%#val#%'" <?php echo (stripslashes($_SESSION['ses_sub_srch_vars']['Nametype']) == "like '%#val#%'")?"selected":""; ?>>Contains</option>
              </select> <input type="text" name="filter_srch_val" value="<?php echo stripslashes($_SESSION['ses_sub_srch_vars']['filter_srch_val']); ?>" class="mediumtxtbox"></td>
          </tr>
          
          <tr valign="top"> 
		  <td><a href="subscriber.php?submit_action=clear"> <img border="0" src="../images/clear.jpg"  name="clear" value="Clear"></a>
		  <input type="hidden" name="submit_action" value="search"></td>
		 
            <td align="right"><input type="image" src="../images/search12.gif"  name="search" value="Search" /></td>
            <td width="61" align="right"><input type="hidden" name="submit_action"  value="search">			</td>		 
          </tr>
        </table></td>
    </tr>
    
	   
  </table>
  </form>
  </div>
 <br />
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/subscriber_lists_preview_frm.php";
  $export_url="../forms/admin/mailing_list_export_frm.php";
  ?>
  <table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><div align="right" class="pagination"><a class='blue_link'  href="#" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=1&url=<?php echo $export_url; ?>',400,700,'yes','yes')";>Export Data</a> </div><div align="right" class="pagination"><a href="subscriber.php?submit_action=add" class="blue_link">Add new email</a> </div></td></tr></table>
    
    <div align="center" class="whitebox mtop15">


<table width="67%" border="0" cellspacing="0" cellpadding="3" align="center" class="listing">
   <tbody>
  <tr class="maincontentheading" height=25px> 
    <th width="10%" nowrap class="listtitle">Id # </th>
    <th width='25%' class="listtitle">Name</th>
    <th width='25%' class="listtitle">Email</th>
     <th width='20%' class="listtitle">Contact No</th>
    <th width="20%" align="center" class="listtitle">Actions</th>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/subscriber_preview_frm.php";
 
 if(!empty($_SESSION['ses_sub_srch_qry']))	 
	 $qry = $_SESSION['ses_sub_srch_qry'];
else 
	$qry = "select * from " . $email_obj->cls_tbl . " where 1=1 order by id desc";

//echo $qry;

$paging_cls = new paging($qry);

unset($_SESSION['ses_subscriber_obj']);
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
    <td><?php echo stripslashes($data->id); ?></td>
    <td><?php echo stripslashes($data->name); ?>    </td>
    <td><?php echo stripslashes($data->email); ?>    </td>
     <td><?php echo stripslashes($data->ContactNo); ?>    </td>
    
    <td align="center"><a href="subscriber.php?submit_action=edit&<?php echo $email_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit" title="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $email_obj->primary_fld; ?>=<?php echo stripslashes($data->id); ?>')" alt="Delete" title="Delete"></a></td>
  </tr>
  <?php

  
  }
  
}

if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan='7' algin='center'> <font class='redfont'>No records available 
      !!.</font></td>
  </tr>
  <?php

}

?>
</table>
<br />
<table width="60%" cellspacing="0" cellpadding="4" border="0">
<tbody><tr>
	<td width="" align="left" style="font-size:12px;">
		<?php $paging_cls->print_pages_of();?>	</td>
	<td align="right">
		<div class="pagination">
                <?php 
				$paging_cls->print_prev();
				$paging_cls->print_numbered_links();
				$paging_cls->print_next();?>
        </div>
	</td>
</tr>
</tbody></table>


</div>