<?php 
$step =3;
$customer_page = 1;
$from_page = "payment";
$search ="no";
$spl_doc_title ="Shopping Cart";
require_once("header.php"); 
$BreadCrumb = "Overview";
require_once('classes/cart.class.php');
$cart_obj =new cart();
require_once("classes/shipping_settings.class.php");
$ship_obj =new shipping_settings();
if(count($_SESSION['ses_cart_items']) <= 0)
{
	header("location:basket.php");
	exit;
}

$submit_action = $_REQUEST['submit_action'];

switch($submit_action)
{

	case "save_payment":
		 $temp_meth = $_REQUEST['payment_method'];
		
		 $_SESSION['ses_payment_method'] = $_REQUEST['payment_method'];
		 $_SESSION['ses_shipment_email'] = $_REQUEST['shipment_email'];
		switch ($temp_meth)
		{

			case 2:
				$redirect_page = 1;
				require_once("save_order.php");
				$redirect_url = "invoice.php?order_id=" . $order_id;
				break;
			
			default:
				$redirect_page = 1;
				foreach($_REQUEST as $ky => $vl)
				$_SESSION['ses_payment_vars'][$ky] = $vl;
				
				
				switch ($temp_meth)
				{
					case 1:
						$redirect_url = "callme.php";
						break;
					case 2:
						$redirect_url = "faxorder.php";
						break;
					case 3:
						$redirect_url = "paypro_step1.php";
						break;
					case 4:
						if(isset($_SESSION['ses_customer_id']))
						{
						//$GLOBALS['site_config']['debug']=1;
							$ord_status = 0;
							require_once("save_order.php");
							unset($_SESSION['ses_ship_details']);
							unset($_SESSION['ses_download_book']);
							$_SESSION['ses_temp_order_id'] = $order_id;
							$redirect_url = $GLOBALS['site_config']['site_path']."paypal_step1.php?submit_action=processpayment&action=process";
						}
						else
						{
							$redirect_url = "cust_register.php";
						}	
						break;
					case 5:
						$redirect_url = "authorize_step1.php";
						break;
				}
				break;
		} //end switch
		break;	
		
}

if($redirect_page == 1)
{
	header("location:$redirect_url");
	exit();
}

?>

     <?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>Cart Overview</div>
      </div>
      <div class="carttable w-clearfix">
        <div class="cart-table-con">
          <?php  require_once("templates/cart_steps.php"); ?>
          <form name="cart_frm" id="cart_frm" method="post" action="" >
          <?php require_once(dirname(__FILE__) . '/templates/order_summary.php'); ?>
          
          <?php require_once("templates/viewbasket_frm.php"); ?>
          
         
          <div class="sub-totalblk">
            <div class="sub-relblk">
              <div class="sub-item">
                <div class="sub--item-blks">
                  <div>Sub-Total (GST Incl.)</div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div>$ <?php //$payable_amt = format_number($amount/ 1.07);
								$payable_amt = format_number($amount);
								echo $payable_amt; 
							?></div>
                  </div>
                </div>
              </div>
              
              <div class="sub-item">
                <div class="sub--item-blks">
                  <div>Shipping Cost</div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div>$ <?php 
					$shippingcost = findShippingCost($weight,$bctry_data->countrycode,$payable_amt);
					 echo $shippingcost;
					$_SESSION['ses_cart_shipping_cost'] = $shippingcost;									  
					 ?></div>
                  </div>
                </div>
              </div>
              
              <div class="sub-item">
                <div class="sub--item-blks">
                  <div>GST <?php echo $GLOBALS['site_config']['gst_percentage']?>% </div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div><?php if($_SESSION['ses_ship_bill_arr']['country'] !=189){
						$taxcalc_amt =format_number($payable_amt + $shippingcost);
				$display_gst = findGSTamount($taxcalc_amt);
				$_SESSION['ses_tax_con'] =  $display_gst;
				echo "-$ ".$display_gst;
					} else {
				$taxcalc_amt =format_number($payable_amt+ $shippingcost);
				$display_gst = findGSTamount($taxcalc_amt);
				$_SESSION['ses_tax_con'] =  $display_gst;
				echo "$ ".$display_gst;
					}?></div>
                  </div>
                </div>
              </div>
              <?php if(isset($_SESSION['ses_coupon_code']) && isset($_SESSION['ses_discount_amount'])){ ?>
              <div class="sub-item">
                <div class="sub--item-blks">
                  <div>Coupon (<em><?php echo $_SESSION['ses_coupon_code'];?></em>)</div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div>-$ <?php $dis_amount = $_SESSION['ses_discount_amount'];
					echo format_number($dis_amount);
					$payable_amt = format_number($payable_amt-$dis_amount);?></div>
                  </div>
                </div>
              </div>
              <?php } ?>
              
              <div class="bold sub-item">
                <div class="sub--item-blks">
                <div>Total Amount
				<?php if($_SESSION['ses_ship_bill_arr']['country'] ==189){?>
                  <span style="font-size:10px;">(Inclusive of GST)</span>
                  <?php } ?>
                  </div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div>$ <?php 
					if($_SESSION['ses_ship_bill_arr']['country'] ==189){
					$final_payment =  format_number($payable_amt + $shippingcost );
					}
					else
					$final_payment =  format_number($payable_amt + $shippingcost - $display_gst);
					
				 echo $_SESSION['ses_payment_vars']['payable_amt'] = $final_payment;
				?></div>
                  </div>
                </div>
              </div>
            
              <div class="proceed-blk"><a class="update-cart-btn w-button continue" href="<?php echo $GLOBALS['site_config']['site_path']?>checkout/shipping-billing-info" style="margin-bottom:5px;">BACK</a>
              <input type="hidden" name="submit_action" value="save_payment">
              <input type='hidden' name='payment_method' value="4" > 
              <a class="update-cart-btn w-button continue" href="javascript:void()" onclick="$('#cart_frm').submit();" style="margin-bottom:5px;">CONFIRM</a></div>
            </div>
          </div>
          </form>
        </div>
        <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
      </div>
 


<?php 

require_once("footer.php"); 

?>