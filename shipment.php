<?php 
$customer_page = 1;
$from_page = "shipment";
$search ="no";
require_once("header.php"); 

/*if($redirect_page != 1)
require_once("shipping_options.php");*/

$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "save_shipment":
		$_SESSION['ses_cart_shipping_method'] = $_REQUEST['shipping_method'];
		$_SESSION['ses_ship_bill_arr']['handling_msg'] = $_REQUEST['handling_msg'];
		$redirect_page = 1;
		//$redirect_url = $GLOBALS['site_config']['ssl_url'] . "payment.php";
		$redirect_url = "payment.php";
		$_SESSION['ses_basket_page'] = 0;
		break;

}

if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}

?>
<table <?php echo $inner_table_param; ?>>
  <tr>
    <td><?php
	
	unset($_SESSION['ses_download_book']);
	unset($_SESSION['ses_ship_details']);
	require_once("includes/error_message.php");
	require_once("forms/payment_frm.php");
	
	
	?></td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>