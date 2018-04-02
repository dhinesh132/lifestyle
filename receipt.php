<?php 
$spl_doc_title ="cart";
require_once("includes/code_header.php"); 
require_once("includes/top_header.php");
$BreadCrumb = INVOICEBREADCRUMB;
require_once("classes/order_master.class.php");
require_once("classes/products.class.php");
$ord_m_obj = new order_master();
$ord_d_obj = new order_details();
$prod_obj = new products();

$order_id = $_REQUEST['id'];

$master_res = $ord_m_obj->fetch_record($order_id );
$detail_res = $ord_d_obj->fetch_flds("order_details","*", "order_id = '" . $order_id  . "'");

$master_data = mysql_fetch_object($master_res[0]);

if($master_data->order_status ==1)
{

		$prod_res =$GLOBALS['db_con_obj']->fetch_flds("order_details","prod_id", "order_id = '" . $master_data->order_id . "'");

				
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

				if($ship_deatils ==1)
				$upd_qry ="update order_master set order_status ='1' where order_id = '" . $ordnum . "'";
				else
				$upd_qry ="update order_master set order_status ='2' where order_id = '" . $ordnum . "'";
				$GLOBALS['db_con_obj']->execute_sql($upd_qry,"update");
				
}

$paymeth = $master_data->pay_method;

if($popup == 1)
{
?>
<html><head><title><?php echo stripslashes($GLOBALS['site_config']['company_name']); ?></title>
<?php require_once("includes/inside_head_tag.php"); ?>
</head><body marginheight="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0">
<?php if($close_window == 1) { ?>
<script language="JavaScript">
window.close();
</script>
<?php 

} 

}

?>
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
<div style="padding-left:640px; padding-top:10px;"><img src="images/print-icon.png" width="30" onClick="javascript:printDiv('printablediv')" /></div>
<div id="printablediv">
<div id="container" style=" width: 780px;">
<div id="content"  style=" width: 780px;">       	
            	<div class="shopping-cart">
                
<?php
	
	require_once("includes/error_message.php");
	
	
	switch ($paymeth)
	{
		
		case "2":
			
			require_once("forms/invoice_dets_frm.php");
			break;
		
		default:
			require_once("forms/invoice_dets_frm.php");
			break;
		
	}
	
	
	?>
    </div>
</div>

</div>