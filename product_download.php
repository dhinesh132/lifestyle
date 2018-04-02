<?php 

require_once("header.php"); 

require_once("classes/product_master.class.php"); 


$prod_obj = new product_master();

$product_id = $_REQUEST['prod_id'];

$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "save":
		$pid = $_REQUEST['prod_id'];
		$id = $_REQUEST['id'];
		$customer_id = $_SESSION['ses_customer_id'];
		$res = $rev_obj->fetch_flds($rev_obj->cls_tbl, "*", "user_id ='".$customer_id."' and prod_id = '" . $pid . "'");

		if($res[1] ==0)
		{
		$rev_obj->insert();
		}
		else
		$rev_obj->update($id);		
		header("location:product_detail.php?prod_id=$pid");
		exit();			
		break;

}//end switch

?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td><?php
	
	require_once("includes/error_message.php");
	
	require_once("forms/product_download_frm.php");
	
	
	?></td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>