<?php

require_once("admin_header.php"); 

require_once("../classes/promotion_products.class.php");
require_once("../components/fckeditor/fckeditor.php"); 
$ban_obj = new promotion_products();

$submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";



$cat_count_qry = "select min(display_order), max(display_order) from ". $ban_obj->cls_tbl;

$cat_count_res = $GLOBALS['db_con_obj']->execute_sql($cat_count_qry);

$cat_count_data = mysql_fetch_array($cat_count_res[0]);





switch ($submit_action)

{

	case "preview":

		$edit = 1;

		$edit_id = $_REQUEST[$ban_obj->primary_fld];

		if($edit_id <= 0)

		{

			header("location:promotion_product.php");

			exit();

		}

		

		$edit_res = $ban_obj->fetch_record($id);

	    $display_what = "preview_frm";

	 break;

	

	case "add":

		$display_what = "detail_frm";

		$hid_action = "save";

		break;



	case "edit":

		$edit = 1;

		$edit_id = $_REQUEST[$ban_obj->primary_fld];

		if($edit_id <= 0)

		{

			header("location:promotion_products.php");

			exit();

		}

		

		$edit_res = $ban_obj->fetch_record($id);

		$display_what = "detail_frm";

		$hid_action = "save";

		break;



	case "save":
	
		
		$id = $_REQUEST[$ban_obj->primary_fld];
		$promotionCatId = $_REQUEST['promotion_cat_id'];
		$redirect_page = 1;

		if($id <= 0)

		{//need to add the record

			

			if($ban_obj->insert())

				$redirect_url = "promotion_products.php?promotion_cat_id=$promotionCatId";

			else

				$redirect_url = "promotion_products.php?submit_action=add&promotion_cat_id=$promotionCatId";

		

		}

		else

		{//update the record

 

 			if($ban_obj->update($id))

				$redirect_url = "promotion_products.php?promotion_cat_id=$promotionCatId";

			else

				$redirect_url = "promotion_products.php?submit_action=edit&" . $ban_obj->primary_fld . "=" . $_REQUEST[$ban_obj->primary_fld];

		} 
		
		
		break;



	case "delete":

	

		$id = $_REQUEST[$ban_obj->primary_fld];
		$promotionCatId = $_REQUEST['promotion_cat_id'];
		if($id <= 0)

		{

			header("location:promotion_products.php?promotion_cat_id=$promotionCatId");

			exit();

		}

		else

		{

		

			$ban_obj->delete($id); 

			$redirect_page = 1;

			$redirect_url = "promotion_products.php?promotion_cat_id=$promotionCatId";

		}

		break;

		

	case "status":

	

		$id = $_REQUEST['id'];
		$promotionCatId = $_REQUEST['promotion_cat_id'];
		if($id <= 0)

		{

			header("location:promotion_products.php?promotion_cat_id=$promotionCatId");

			exit();

		}

		else

		{

		

			$Status = $_REQUEST['status'];
			
			



			if($Status == 1)

				$update = "update ".$ban_obj->cls_tbl." set status = 0 where id='".$id."'";

			else if($Status == 0)

				$update = "update ".$ban_obj->cls_tbl." set status = 1 where id='".$id."'";

				

			$GLOBALS['db_con_obj']->execute_sql($update,"update");

			frame_notices("Status successfully updated !!", "greenfont", 1);
			

			$redirect_page = 1;

			$redirect_url = "promotion_products.php?promotion_cat_id=$promotionCatId";

		}

		break;
		



} //end switch





if($redirect_page == 1)

{

	header("location:$redirect_url");

	exit();

}

	

?>


<?php 
  $promotionCatId = $_REQUEST['promotion_cat_id'];  
  //Get Promotion Category
  $promotion_res = $GLOBALS['db_con_obj']->fetch_flds('promotion_banner',"EnTitle","Id='".$promotionCatId."'");
  $promotion_data = mysql_fetch_object($promotion_res[0]);
  ?>

 <h1>Manage (<?php print $promotion_data->EnTitle;?>) Products</h1>

<?php

	

require_once("../includes/error_message.php");



switch ($display_what)

{



	case "detail_frm";

		require_once("../forms/admin/promotion_products_detail_frm.php"); 

		break;

	

	case "list_frm";

		require_once("../forms/admin/promotion_products_list_frm.php"); 

		break;



	



} //end switch



?>
<?php 
require_once("admin_footer.php");
?>