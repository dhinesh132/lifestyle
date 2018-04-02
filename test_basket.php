<?php 
$from_page = "basket";
$search ="no";
$spl_doc_title ="cart";
require_once("header.php"); 
$BreadCrumb = BASKETBREADCRUMB; 
require_once("classes/cart.class.php"); 
require_once("classes/temp_cart.class.php"); 
$temp_cart = new temp_cart();
$c_obj = new cart();
if(isset($_SESSION['ses_customer_id']) && $_SESSION['ses_customer_id'] >0){
		$temp_cart->delete_cart($_SESSION['ses_customer_id']);
		foreach($_SESSION['ses_cart_items'] as $k => $v)
		{			
				$temp_cart->UserId['value'] = $_SESSION['ses_customer_id'];
				$temp_cart->SessionId['value'] = session_id();
				$temp_cart->ProductId['value'] = $v['prod_id'];
				$temp_cart->ProdQty['value'] = $v['prod_quantity'];
				$temp_cart->DateStored['value'] = date("Y-m-d H:i:s");							
				$temp_cart->insert();
		}	
}

?>

 <div id="content"><?php
	 require_once("includes/breadcrumbs.php");	 
 	require_once("includes/template_left.php");
	require_once("includes/error_message.php");
	?>
	<form name="cart_frm" id="cart_frm" method="post" action="cart_process.php">
    <div class="right">
        	<div class="title-header">
            	<img src="images/t-cart.jpg" alt="" />
            	<hr />
            </div>
            	<div class="shopping-cart">
                <h1><?php echo SHOPPINGCART; ?></h1><br />
                
            <div id="cart-bg" style="background:url(images/step1.jpg)">
                	<table width="685px">
                    	<tr>
                        	<td style="color:#FFFFFF"><?php echo STEP?> 1: <?php echo CARTITEMS?></td>
                            <td><?php echo STEP?> 2: <?php echo SHIPANDBILL?></td>
                            <td><?php echo STEP?> 3: <?php echo CONFIRMATION?></td>
                        </tr>
                    </table>
                </div><br /><br />
                
                <?php echo ITEMRESERVEDFOR?><br /><br />
                <?php 
				foreach($_SESSION['ses_cart_items'] as $k => $crt_obj) 
				{ 
					print_r($crt_obj);
					echo "<hr>";
				}
				require_once("forms/viewbasket_frm.php"); ?>
                  <br /><br />
               <div align="center" style="padding-top:40px">
                 <a style="margin-left:14px" class="gradient-btn" href="product_lists.php?fun=all"><?php echo CONTINUESHOPPING?></a>
                  <a href="javascript:void(0)" class="orage_gradient-btn" style="color:#FFFFFF; margin-left:400px" <?php if(count($_SESSION['ses_cart_items']) > 0) { ?> onClick="window.location.href='<?php
		  
		  if($_SESSION['ses_customer_id'] > 0) 
		  {
			  if($payment_gateway == "paypal_pro")
			  {
				  $temp_sid = session_id();
				  $chkout_url = stripslashes("billing_info.php?PHPSESSID=" . $temp_sid);
			  }
			  else if($payment_gateway == "paypal")
			  {
			  	$chkout_url = "ship_bill.php";
			  }
		  }
		  else
		  {
		 
		  $chkout_url = stripslashes("cust_login.php");
		  }
		   echo $chkout_url;
		   ?>';" <?php } ?>><?php echo CONTINUEBTN ?></a>	
                </div>
                </div><!-- shopping-cart-->
               
                
        	
        </div>
	<?php //require_once("forms/viewbasket_frm.php"); ?>
	
	<input name="submit_action" type="hidden" value="savecart">
	<input type="hidden" value="0" name="boolcheck">
	</form>
<script language="JavaScript">
var frm_obj = eval("window.document.cart_frm");
</script>	</div>

<?php 

require_once("footer.php"); 

?>