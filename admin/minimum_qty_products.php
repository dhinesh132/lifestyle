<?php
require_once("admin_header.php"); 

require_once("../classes/minimum_qty_products.class.php");

$qty_notify = new minimum_qty_products();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";


$date_stroed = $GLOBALS['db_con_obj']->fetch_field($qty_notify->cls_tbl,"DateStored","1=1 order by DateStored asc Limit 0, 1");
$yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
$updated_date =strtotime($date_stroed);

if($updated_date <$yesterday){
	$qty_notify->delete_records_from_table();
	//$GLOBALS['site_config']['debug']=1;	
	$prod_res = $GLOBALS['db_con_obj']->fetch_flds("products","Id","ProdStatus=1 order by Id asc");
	while($prod_data = mysql_fetch_object($prod_res[0])){
				
		$qty = MinimumProductQuantity($prod_data->Id);
		
		
		
		if($qty < $GLOBALS['site_config']['notify_min_prod_qty']){
			
			$qty_notify->ProdId['save_todb']='true';
			$qty_notify->Qty['save_todb']='true';
			$qty_notify->DateStored['save_todb']='true';
			$qty_notify->ProdId['value']=$prod_data->Id;
			$qty_notify->Qty['value']=$qty;
			$qty_notify->DateStored['value']=date("Y-m-d H:i:s");
			$qty_notify->insert();
		}
	}
	
}


switch ($submit_action)
{
	case "preview":
		$edit = 1;
		$edit_id = $_REQUEST[$qty_notify->primary_fld];
		if($edit_id <= 0)
		{
			header("location:minimum_qty_products.php");
			exit();
		}
		
		$edit_res = $qty_notify->fetch_record($id);
	    $display_what = "preview_frm";
	 break;
	
	case "add":
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "edit":
		$edit = 1;
		$edit_id = $_REQUEST[$qty_notify->primary_fld];
		if($edit_id <= 0)
		{
			header("location:minimum_qty_products.php");
			exit();
		}
		
		$edit_res = $qty_notify->fetch_record($id);
		$display_what = "detail_frm";
		$hid_action = "save";
		break;

	case "save":
		$id = $_REQUEST[$qty_notify->primary_fld];
			
		$redirect_page = 1;
		if($id <= 0)
		{//need to add the record
			
			if($qty_notify->insert())
				$redirect_url = "minimum_qty_products.php";
			else
				$redirect_url = "minimum_qty_products.php?submit_action=add";
		
		}
		else
		{//update the record
 
 			if($qty_notify->update($id))
				$redirect_url = "minimum_qty_products.php";
			else
				$redirect_url = "minimum_qty_products.php?submit_action=edit&" . $qty_notify->primary_fld . "=" . $_REQUEST[$qty_notify->primary_fld];
		} 
		break;

	case "delete":
	
		echo $id = $_REQUEST[$qty_notify->primary_fld];
		if($id <= 0)
		{
			header("location:minimum_qty_products.php");
			exit();
		}
		else
		{
		
			$qty_notify->delete($id); 
			$redirect_page = 1;
			$redirect_url = "minimum_qty_products.php";
		}
		break;
		
	case "status":
	
		$id = $_REQUEST['ban_id'];
		if($id <= 0)
		{
			header("location:minimum_qty_products.php");
			exit();
		}
		else
		{
		
			$ban_status = $_REQUEST['ban_status'];

			if($ban_status == 1)
				$update = "update ".$qty_notify->cls_tbl." set ban_status = 0 where ban_id='".$id."'";
			else if($ban_status == 0)
				$update = "update ".$qty_notify->cls_tbl." set ban_status = 1 where ban_id='".$id."'";
				
			$GLOBALS['db_con_obj']->execute_sql($update,"update");
			frame_notices("Status successfully updated !!", "greenfont", 1);
			$redirect_page = 1;
			$redirect_url = "minimum_qty_products.php";
		}
		break;
	break;

} //end switch


if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}
	
?>


<table <?php echo $inner_table_param; ?> align="center">
  <tr>
    <td>
<?php
	
require_once("../includes/error_message.php");

switch ($display_what)
{

	case "detail_frm";
		require_once("../forms/admin/minimum_qty_products_detail_frm.php"); 
		break;
	
	case "list_frm";
		require_once("../forms/admin/minimum_qty_products_list_frm.php"); 
		break;

	

} //end switch

?>
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>