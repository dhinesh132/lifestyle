<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this customer(OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="customers.php?" + url;
 }
}
function update_record(url)
{
 	  window.location.href="customers.php?" + url;
}
</script>
<div align="center" class="whitebox mtop15" style="min-height:0px">
<form name="order_search_frm" method="post" action="" onSubmit="return check_orderform(window.document.order_search_frm);">
<table  align="center" cellpadding="5" cellspacing="0" width="65%" class="tableborder_new">
  
    <tr> 
      <td><table align="center" border="0" cellspacing="3" cellpadding="3">
        <tr valign="top"> 
            <td align="right" style="border-bottom:0px;"><span class="whitefont">Registered From:</span></td>
            <td style="border-bottom:0px;">
            <select name="register_from" class="mediumtxtbox">
            <option value="" >All</option>
			<option value="wayonnet" <?php echo ($_SESSION['ses_cust_srch_vars']['register_from'] == 'wayonnet')?"selected":""; ?>>Emblems of Fortune</option>
            <option value="fengshui" <?php echo ($_SESSION['ses_cust_srch_vars']['register_from'] == 'fengshui')?"selected":""; ?>>Way OnNet</option>
            <option value="academy" <?php echo ($_SESSION['ses_cust_srch_vars']['register_from'] == 'academy')?"selected":""; ?>>Way Academy</option>
            <option value="encyclopedia" <?php echo($_SESSION['ses_cust_srch_vars']['register_from'] == 'encyclopedia')?"selected":"";?>>Way Encyclopedia </option>
            </select></td>
          </tr> 
         <!-- <tr valign="top"> 
            <td width="149" align="right"><font class="whitefont">Status:</font></td>
            <td width="349"> <select name="cust_status">
			<option value="">Show All </option>
                <option value="0" <?php echo (stripslashes($_SESSION['ses_cust_srch_vars']['cust_status']) == "0")?"selected":""; ?>>De-Active</option>
				<option value="1" <?php echo (stripslashes($_SESSION['ses_cust_srch_vars']['cust_status']) == "1")?"selected":""; ?>>Active</option>                
            </select></td>
          </tr>       -->   
           
          <tr valign="top"> 
            <td align="right" style="border-bottom:0px;"><span class="whitefont">Name:</span></td>
            <td style="border-bottom:0px;">
            <select name="filter_column" class="mediumtxtbox">
                <option value="cust_firstname" <?php echo (stripslashes($_SESSION['ses_cust_srch_vars']['filter_column']) == "cust_firstname")?"selected":""; ?>>First Name</option>
                <option value="cust_lastname" <?php echo (stripslashes($_SESSION['ses_cust_srch_vars']['filter_column']) == "cust_lastname")?"selected":""; ?>>Last Name</option>
                <option value="cust_email" <?php echo (stripslashes($_SESSION['ses_cust_srch_vars']['filter_column']) == "cust_email")?"selected":""; ?>>Email</option>
                <option value="cust_phone" <?php echo (stripslashes($_SESSION['ses_cust_srch_vars']['filter_column']) == "cust_phone")?"selected":""; ?>>Phone</option>
              </select>
                <select name="Nametype" class="mediumtxtbox">
                <option value="= '#val#'" <?php echo (stripslashes($_SESSION['ses_cust_srch_vars']['Nametype']) == "= '#val#'")?"selected":""; ?>>Equals</option>
                <option value="like '%#val#%'" <?php echo (stripslashes($_SESSION['ses_cust_srch_vars']['Nametype']) == "like '%#val#%'")?"selected":""; ?>>Contains</option>
              </select> <input type="text" name="filter_srch_val" value="<?php echo stripslashes($_SESSION['ses_cust_srch_vars']['filter_srch_val']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top"> 
            <td align="right" style="border-bottom:0px;"><span class="whitefont">Sort&nbsp;By:</span></td>
            <td style="border-bottom:0px;"><select name="sort_column" class="mediumtxtbox">
             	<option value='cust_id desc' >Default</option>
                <option value='cust_firstname asc' <?php echo ($_SESSION['ses_cust_srch_vars']['sort_column'] == "cust_firstname asc")?"selected":""; ?>>First Name Ascending</option>
				<option value='cust_firstname desc' <?php echo($_SESSION['ses_cust_srch_vars']['sort_column'] == "cust_lastname desc")?"selected":""; ?>>First Name Descending</option>
                <option value='cust_lastname asc' <?php echo($_SESSION['ses_cust_srch_vars']['sort_column'] == "cust_lastname asc")?"selected":""; ?>>Last Name Ascending</option>
                <option value='cust_lastname desc' <?php echo($_SESSION['ses_cust_srch_vars']['sort_column'] == "cust_lastname desc")?"selected":""; ?>>Last Name Descending</option>
              </select> 
			 </td>
          </tr>
          <tr valign="top"> 
		  <td style="border-bottom:0px;"><a href="customers.php?submit_action=clear"> <img border="0" src="../images/clear.jpg"  name="clear" value="Clear"></a>
		  <input type="hidden" name="submit_action" value="search"></td>
		 
            <td align="right" style="border-bottom:0px;"><input type="image" src="../images/search12.gif"  name="search" value="Search" /></td>
            <td width="61" align="right" style="border-bottom:0px;"><input type="hidden" name="submit_action"  value="search">			</td>		 
          </tr>
        </table></td>
    </tr>
    
	   
  </table>
  </form>
 </div>
 <br />
 
 <?php 
 $export_url="../forms/admin/customer_export_frm.php";
 ?>
  <table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><div align="right" class="pagination"><a href="customers.php?submit_action=add" class="pagelink">Add New Customer</a> <a class='blue_link'  href="#" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=1&url=<?php echo $export_url; ?>',400,700,'yes','yes')";>Export Data</a> </div></div></td></tr></table>
    
    <div align="center" class="whitebox mtop15">
 
<table width="90%" border="0" cellspacing="0" cellpadding="3" align="center" class="listing">
 <tbody>
  <tr class="maincontentheading" height=25px> 
    <th width="10%">User Id</th>
	<th width="15%">First Name</th>
	<th width="15%">Last Name</th>
    <th width="15%">Email</th>
	<th width="15%">Phone</th>
    <th width="15%" align="center">Created On</th>
    <th width="15%" align="center">Actions</th>
  </tr>
  <?php
  
  $preview_url="../forms/admin/customers_preview_frm.php";
 $list_url="customers.php";

if(!empty($_SESSION['ses_cust_srch_qry']))	 
	 $qry = $_SESSION['ses_cust_srch_qry'];
else
	$qry = "select cust_id, cust_firstname, cust_lastname, cust_username, cust_email, cust_create_datetime,cust_phone,cust_status from " . $cust_obj->cls_tbl . " order by cust_id desc";
	
	//echo $qry;

$paging_cls = new paging($qry);
unset($_SESSION['ses_temp_cust_obj']);
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
    <td><a class='blue_link' href="#" onClick="popup_window('basedesign_nh.php?submit_action=preview&id=<?php echo stripslashes($data->cust_id); ?>&url=<?php echo $preview_url; ?>&list_url=<?php echo $list_url; ?>',650,550,'yes','yes')";><?php
	
	 echo stripslashes($data->cust_id);  
	 ?></a></td>
    <td>
     <?php  echo trim_text($data->cust_firstname,18); ?>
     </td>
     <td>
       <?php  echo trim_text($data->cust_lastname,18); ?>
     </td>
	 <td><a title="<?php echo $data->cust_email; ?>"  class="emaillink" href="mailto:<?php echo $data->cust_email; ?>" target="_blank"><?php echo trim_text(($data->cust_email),15); ?></a></td>
	 <td><?php  echo trim_text($data->cust_phone,12); ?></td>
	 	 
    <td align="center"><?php echo convert_date($data->cust_create_datetime); ?></td>
    <td align="center"><?php if($data->cust_status == 1) { ?><a href="#"><img border="0" onclick="update_record('submit_action=status&cust_status=1&id=<?php echo stripslashes($data->cust_id); ?>')"  src="../images/icon_approve.gif" alt="De-Activate" title="De-Activate"></a> &nbsp;&nbsp;&nbsp;<?php } else {?> <a href="#"><img border="0" onclick="update_record('submit_action=status&cust_status=0&id=<?php echo stripslashes($data->cust_id); ?>')"  src="../images/icon_disapprove.gif" alt="Activate" title="Activate"></a> &nbsp;&nbsp;&nbsp; <?php }?><a href="customers.php?submit_action=edit&<?php echo $cust_obj->primary_fld; ?>=<?php echo stripslashes($data->cust_id); ?>"><img src="../images/icon_edit.gif" border=0 alt="Edit"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $cust_obj->primary_fld; ?>=<?php echo stripslashes($data->cust_id); ?>')" alt="Delete"></a></td>
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
