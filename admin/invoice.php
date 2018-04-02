<?php
$from_page = "invoice_preview";
//require_once("admin_header.php");
require_once("../includes/admin_code_header.php");
require_once("../classes/products.class.php"); 
require_once("../classes/order_master.class.php");

$ord_m_obj = new order_master();
$ord_d_obj = new order_details();
$prod_obj = new products();

//$GLOBALS['site_config']['debug'] =1;
$master_res = $ord_m_obj->fetch_record($_REQUEST['order_id']);
$detail_res = $ord_d_obj->fetch_flds($ord_d_obj->cls_tbl,"*", "order_id = '" . $_REQUEST['order_id'] . "'");

$master_data = mysql_fetch_object($master_res[0]);

$paymeth = $master_data->pay_method;

$submit_action = $_REQUEST['submit_action'];

	$prod_res =$GLOBALS['db_con_obj']->fetch_flds("order_details","prod_id", "order_id = '" .  $_REQUEST['order_id'] . "'");

		while($ord_prod_data = mysql_fetch_object($prod_res[0])) 
		  {
		 
		$category_id = $GLOBALS['db_con_obj']->fetch_field("product_master","category_id","prod_id='".$ord_prod_data->prod_id."'");
		 
		 $id_ship = substr_count($GLOBALS['site_config']['ebook_cat'],$category_id);
		 
		
		
		 if($id_ship <= 0)
		 {
		  $ship_deatils =1;
		  break;
		 }
		  }


	$ebookid = $GLOBALS['db_con_obj']->fetch_flds($ord_d_obj->cls_tbl,"prod_id", "order_id = '" .$_REQUEST['order_id'] . "'");
					
					$dwn_id ="";
					
					while($dwn_id = mysql_fetch_object($ebookid[0]))

					{
					$ebookid1 = $GLOBALS['db_con_obj']->fetch_field("product_master","category_id", "prod_id = '" . $dwn_id->prod_id . "'");
					$id_ebook = substr_count($GLOBALS['site_config']['ebook_cat'],$ebookid1);
					
					if($id_ebook >0)
					{
					$ebook_isavailable = 1;
					break;
					}
					
			}

if($submit_action == "reset")
{
	$det_id = $_REQUEST['det_id'];
	$qry = "update " . $ord_d_obj->cls_tbl . " set download_status = '0' where " . $ord_d_obj->primary_fld . " = '" . $det_id . "'";
	$GLOBALS['db_con_obj']->execute_sql($qry, "update");
	frame_notices("Download status for the selected book has been changed, customer can download this book now !!", "greenfont");
	$redirect_url = "invoice.php?order_id=" . $_REQUEST['ord_id'];
	header("location:$redirect_url");
	exit();
}

?>


<html><head><title><?php echo stripslashes($GLOBALS['site_config']['company_name']); ?></title>
<?php require_once("../includes/inside_head_tag.php"); ?>
</head><body marginheight="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0">
<?php if($close_window == 1) { ?>
<script language="JavaScript">
window.close();
</script>

<?php } $GLOBLAS['site_config']['debug'] ==1?>

 <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
    </script> 	
<div style="padding-left:640px; padding-top:10px;"><img src="../images/print-icon.png" width="30" onClick="javascript:printDiv('printablediv')" /></div>
<div id="printablediv">
<div id="container" style=" width: 780px;">
<div id="content"  style=" width: 780px;"> 

       	<div class="shopping-cart">
<?php	
	require_once("../includes/error_message.php");
	
	
	switch ($paymeth)
	{
		
		case "2":
			
			require_once("../forms/admin/admin_invoice_dets_frm.php");
			break;
		
		default:
			require_once("../forms/admin/admin_invoice_dets_frm.php");
			break;
		
	}
	
	
	?></div>
    </div>
    </div>
    </div>
<?php
if(strlen($temp_window_tilte1)>0)
{
?>

<script language="JavaScript">
window.document.title = "<?php echo stripslashes($temp_window_tilte1); ?>";
</script>
<?php
}
?>
</body></html>


