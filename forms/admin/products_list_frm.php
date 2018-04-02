
<script language="JavaScript">
function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this frame page? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $product_page_url; ?>?" + url;
 }
}
function update_record(url)
{
 	  window.location.href="products.php?" + url;
}
function order_record(url)
{
 	  window.location.href="products.php?" + url;
}
</script>
<style type="text/css">
.bktitle { font-weight: normal; }
</style>
<div align="center" class=" mtop15">
<form name="order_search_frm" method="post" action="" onSubmit="return check_orderform(window.document.order_search_frm);">
<table  align="center" cellpadding="5" cellspacing="0" width="65%" class="listing">
    <tr class="maincontentheading"> 
      <th align="center"><font class="buyerfont">Filter Menu</font></th>
    </tr>
    <tr> 
      <td><table align="center" border="0" cellspacing="3" cellpadding="3" width="80%">
          <tr valign="top"> 
            <td width="149" style="border-bottom:0px;" align="right"><font class="whitefont">Status:</font></td>
            <td width="349" style="border-bottom:0px;"> <select name="ProdStatus" class="mediumtxtbox">
			<option value="">Show All Products</option>
                <option value="0" <?php echo (stripslashes($_SESSION['ses_prod_srch_vars']['ProdStatus']) == "0")?"selected":""; ?>>De-Active</option>
				<option value="1" <?php echo (stripslashes($_SESSION['ses_prod_srch_vars']['ProdStatus']) == "1")?"selected":""; ?>>Active</option>                
            </select></td>
          </tr>
          <tr valign="top"> 
            <td width="149" style="border-bottom:0px;" align="right"><font class="whitefont">Function:</font></td>
            <td width="349" style="border-bottom:0px;"><select name="Function"  class="mediumtxtbox">
            <option value="">Show All Functions</option>
            <?php 
			$fun_res = $db_con_obj->fetch_flds("functions", "FunId,EnName", "1=1 and FunStatus =1 order by EnName asc"); 
			while($fun_data = mysql_fetch_object($fun_res[0])){
			?>
			<option value="<?php echo $fun_data->FunId; ?>" <?php echo ($_SESSION['ses_prod_srch_vars']['Function'] == $fun_data->FunId)?"selected":""; ?>><?php echo $fun_data->EnName; ?></option>
			<?php } ?>
            </select></td>
          </tr>
           <tr valign="top"> 
            <td width="149" style="border-bottom:0px;" align="right"><font class="whitefont">Type:</font></td>
            <td width="349" style="border-bottom:0px;"><select name="Types"  class="mediumtxtbox">
            <option value="">Show All Types</option>
            <?php 
			$type_res = $db_con_obj->fetch_flds("types", "TypeId,EnName", "1=1 and TypeStatus =1 order by EnName asc"); 
			while($type_data = mysql_fetch_object($type_res[0])){
			?>
			<option value="<?php echo $type_data->TypeId; ?>" <?php echo ($_SESSION['ses_prod_srch_vars']['Types'] == $type_data->TypeId)?"selected":""; ?>><?php echo $type_data->EnName; ?></option>
			<?php } ?>
            </select></td>
          </tr>
           <tr valign="top"> 
            <td width="149" style="border-bottom:0px;" align="right"><font class="whitefont">Material:</font></td>
            <td width="349" style="border-bottom:0px;"> <select name="Material"  class="mediumtxtbox">
            <option value="">Show All Materials</option>
            <?php 
			$mat_res = $db_con_obj->fetch_flds("materials", "MatId,EnName", "1=1 and MatStatus =1 order by EnName asc"); 
			while($mat_data = mysql_fetch_object($mat_res[0])){
			?>
			<option value="<?php echo $mat_data->MatId; ?>" <?php echo ($_SESSION['ses_prod_srch_vars']['Material'] == $mat_data->MatId)?"selected":""; ?>><?php echo $mat_data->EnName; ?></option>
			<?php } ?>
            </select></td>
          </tr>
          <tr valign="top"> 
            <td align="right" style="border-bottom:0px;"><span class="whitefont">Product Name:</span></td>
            <td style="border-bottom:0px;">
                <select name="Nametype" class="mediumtxtbox">
                <option value="= '#val#'" <?php echo (stripslashes($_SESSION['ses_prod_srch_vars']['Nametype']) == "= '#val#'")?"selected":""; ?>>equals</option>
                <option value="like '%#val#%'" <?php echo (stripslashes($_SESSION['ses_prod_srch_vars']['Nametype']) == "like '%#val#%'")?"selected":""; ?>>contains</option>
              </select> <input type="text" name="EnName" value="<?php echo stripslashes($_SESSION['ses_prod_srch_vars']['EnName']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top"> 
            <td align="right" style="border-bottom:0px;"><span class="whitefont">Product Code:</span></td>
            <td style="border-bottom:0px;"><input type="text" name="ProdCode" value="<?php echo stripslashes($_SESSION['ses_prod_srch_vars']['ProdCode']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top"> 
            <td align="right" style="border-bottom:0px;"><span class="whitefont">Sort&nbsp;By:</span></td>
            <td style="border-bottom:0px;"><select name="sort_column" class="mediumtxtbox">
             	<option value='' >Default</option>
                <option value='asc' <?php echo ($_SESSION['ses_prod_srch_vars']['sort_column'] == "asc")?"selected":""; ?>>Name Ascending</option>
				<option value='desc' <?php echo($_SESSION['ses_prod_srch_vars']['sort_column'] == "desc")?"selected":""; ?>>Name Descending</option>
              </select> 
			 </td>
          </tr>
          <tr valign="top"> 
		  <td style="border-bottom:0px;"><a href="products.php?submit_action=clear"> <img border="0" src="../images/clear.jpg"  name="clear" value="Clear"></a>
		  <input type="hidden" name="submit_action" value="search"></td>
		 
            <td align="right" style="border-bottom:0px;"><input type="image" src="../images/search12.gif"  name="search" value="Search" /></td>
            <td width="61" align="right" style="border-bottom:0px;"><input type="hidden" name="submit_action"  value="search">			</td>		 
          </tr>
        </table></td>
    </tr>
    
	   
  </table>
  </form>
  
  </div>
   <form name="<?php echo $prod_obj->frm_name; ?>" action="" method="post" >
  <table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><div align="right" class="pagination"><a href="products.php?submit_action=add" class="pagelink">Add New Product</a>  <a href="javascript:void(0)" onclick="update_selected_item()" class="pagelink">Update Order</a></div></td></tr></table>
    
    <div align="center" class="whitebox mtop15">

<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="listing">
 <tbody>
  <tr class="maincontentheading" height=25px> 
   <th width="5%" nowrap class="listtitle"> </th>
    <th width="5%" nowrap class="listtitle">Id # </th>
    <th width="15%" class="listtitle" >Products</th>
    <th width="5%" class="listtitle" >Price($)</th>
    <th width="8%" class="listtitle" >Function(s)</th>
    <th width="13%" class="listtitle" >Type(s)</th>
    <th width="13%" class="listtitle" >Materials(s)</th>
    <th width='7%' class="listtitle" align="center">Display Order</th>
    <th width="34%" style="text-align:center" class="listtitle">Actions</th>
  </tr>
  <?php
  $preview_url = 0;
  $preview_url="../forms/admin/products_preview_frm.php";
 
 if(isset($_SESSION['ses_prod_srch_qry']) )
  	$qry =$_SESSION['ses_prod_srch_qry'] ;
 else
  	$qry = "select Id, EnName,Price,Quantity,Types,Material,Function,ProdStatus,DisplayOrder from " . $prod_obj->cls_tbl . " WHERE ProdType=1  order by DisplayOrder desc";

//echo $qry;
$paging_cls = new paging($qry);

unset($_SESSION['ses_temp_prod_obj']);
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
   <td ><input type="checkbox" name="Ids[]" value="<?php echo $data->Id; ?>"></td>
    <td><?php echo stripslashes($data->Id); ?></td>
    <td><?php echo stripslashes($data->EnName); ?></td>
    <td><?php echo stripslashes($data->Price); ?> </td>
    <td><?php 
	 $fun_res = $GLOBALS['db_con_obj']->fetch_flds('functions','EnName','FunId in ('.$data->Function.')'); 
	 while($fun_data = mysql_fetch_object($fun_res[0])){
		 echo $fun_data->EnName."<br>";
	 }
	//echo $GLOBALS['db_con_obj']->fetch_field("functions","EnName","FunId=".$data->Function); ?></td>
    <td><?php 
	 $typs_res = $GLOBALS['db_con_obj']->fetch_flds('types','EnName','TypeId in ('.$data->Types.')'); 
	 while($typs_data = mysql_fetch_object($typs_res[0])){
		 echo $typs_data->EnName."<br>";
	 }
	//echo $GLOBALS['db_con_obj']->fetch_field("types","EnName","TypeId=".$data->Types); ?></td>
    <td><?php 
	$mat_res = $GLOBALS['db_con_obj']->fetch_flds('materials','EnName','MatId in ('.$data->Material.')'); 
	 while($mat_data = mysql_fetch_object($mat_res[0])){
		 echo $mat_data->EnName."<br>";
	 }
	//echo $GLOBALS['db_con_obj']->fetch_field("materials","EnName","MatId=".$data->Material); ?></td>
    <td align="center"><input type="text" name="Ord<?php echo stripslashes($data->Id); ?>" value="<?php echo $data->DisplayOrder;?>" class="mediumtxtbox" style="width:35px;"/></td>
    <td align="center"><?php if($data->ProdStatus == 1) { ?><a href="#"><img border="0" onclick="update_record('submit_action=status&ProdStatus=1&id=<?php echo stripslashes($data->Id); ?>')"  src="../images/icon_approve.gif" alt="De-Activate" title="De-Activate"></a> &nbsp;&nbsp;<?php } else {?> <a href="#"><img border="0" onclick="update_record('submit_action=status&ProdStatus=0&id=<?php echo stripslashes($data->Id); ?>')"  src="../images/icon_disapprove.gif" alt="Activate" title="Activate"></a> &nbsp;&nbsp; <?php }?><a href="products.php?submit_action=edit&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>"><img src="../images/icon_edit.gif" border=0 title="Edit" alt="Edit"></a>&nbsp;&nbsp;<a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>')" title="Delete" alt="Delete"></a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="products.php?submit_action=update_qty&<?php echo $prod_obj->primary_fld; ?>=<?php echo stripslashes($data->Id); ?>">Update Quantity</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="select_sizes.php?prod=<?php echo stripslashes($data->Id); ?>">Manage Sizes</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="select_colour.php?prod=<?php echo stripslashes($data->Id); ?>">Manage Colours</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="select_images.php?prod=<?php echo stripslashes($data->Id); ?>">Manage Images</a></td>
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
</tbody>
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

<input type="hidden" name="submit_action" > 
</div>
</form>

<script>
function update_selected_item()
{
	
	var del_process = 0;
	for(i=0; i < window.document.<?php echo $prod_obj->frm_name; ?>.elements.length; i++)
	{
		//alert(window.document.<?php echo $prod_obj->frm_name; ?>.elements[i].name);
		if(window.document.<?php echo $prod_obj->frm_name; ?>.elements[i].name == "Ids[]")
		{
			if(window.document.<?php echo $prod_obj->frm_name; ?>.elements[i].checked == true)
			{
				del_process = 1;
				break;
			}
		}
	}
	
	if(del_process == 0)
	{
		alert("Select records to be change order !!");
	}
	else
	{
		 doyou = confirm("Do you want to update order of selected record(s)? (OK = Yes   Cancel = No)");
		 if (doyou == true)
		 {
		  	window.document.<?php echo $prod_obj->frm_name; ?>.submit_action.value='updateorder'; 
		 	window.document.<?php echo $prod_obj->frm_name; ?>.submit();
		 }
	}
	
}
</script>
