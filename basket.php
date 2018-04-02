<?php 
$step =1;
$from_page = "basket";
$search ="no";
$spl_doc_title ="Shopping Cart";
require_once("header.php"); 
$BreadCrumb = "Cart"; 
require_once("classes/cart.class.php"); 
require_once("classes/temp_cart.class.php"); 
$temp_cart = new temp_cart();
$c_obj = new cart();
if(isset($_SESSION['ses_customer_id']) && $_SESSION['ses_customer_id'] >0 && $_SESSION['ses_customer_id'] !=2){
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


     <?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>Shopping cart</div>
      </div>
      <div class="carttable w-clearfix">
      <?php	
		require_once(dirname(__FILE__) . '/includes/error_message.php');
		?>
        <div class="cart-table-con">
          <?php  require_once("templates/cart_steps.php"); ?>
          <form name="cart_frm" id="cart_frm" method="post" action="cart_process.php">
          <?php require_once("templates/viewbasket_frm.php"); ?>
          <input name="submit_action" type="hidden" id="submit_action" value="savecart">
          </form>
          <div class="promo-code-blk w-clearfix">
           <?php  if(count($_SESSION['ses_cart_items']) > 0 )
		  {
		  ?>
            <div class="code-blk">
              <div class="w-form">
                <form class="w-clearfix" id="coupon-form" name="coupon-form" data-name="Email Form" action="cart_process.php">
                  <div class="form-row">
                    <div class="code-field"><input class="code-input nfield w-input"  id="Coupon-Code" maxlength="256" name="code" data-name="Coupon" required="required" placeholder="Enter coupon code" type="text"></div>
                    <div class="code-apply">
                    <input type="hidden" name="submit_action" value="apply_promotion" />
                    <input class="apply-btn w-button" data-wait="Please wait..." type="submit" value="Apply"></div>
                  </div>
                </form>
                
              </div>
            </div>
            <?php } ?>
            <div class="updateblk"><a class="update-cart-btn w-button" href="#" onclick="$('#cart_frm').submit();">update shopping cart</a></div>
          </div>
          <div class="sub-totalblk">
            
              
            <div class="sub-relblk">
              <div class="sub-item">
                <div class="sub--item-blks">
                  <div>Sub-Total </div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div>$ <?php $payable_amt = format_number($amount/ 1.07);
								echo $payable_amt; 
							?></div>
                  </div>
                </div>
              </div>
              <div class="sub-item">
                <div class="sub--item-blks">
                  <div>Inclusive <?php echo $GLOBALS['site_config']['gst_percentage']?>% GST</div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div>$ <?php
				$taxcalc_amt =format_number($payable_amt);
				echo $display_gst = findGSTamount($taxcalc_amt);?></div>
                  </div>
                </div>
              </div>
               <?php if(isset($_SESSION['ses_coupon_code']) && isset($_SESSION['ses_discount_amount'])){ ?>
              <div class="sub-item">
                <div class="sub--item-blks">
                  <div>Coupon(<em><?php echo $_SESSION['ses_coupon_code'];?></em>)</div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div>- $ <?php echo $dis_amount = format_number($_SESSION['ses_discount_amount']);	?></div>
                  </div>
                </div>
              </div>
              <?php $payable_amt = $payable_amt-$dis_amount; } ?>
              <div class="bold sub-item">
                <div class="sub--item-blks">
                  <div>Total Amount Inclusive of GST</div>
                </div>
                <div class="sec sub--item-blks">
                  <div class="sub--item-blks">
                    <div>$ <?php echo $final_payment =  format_number($payable_amt+ $display_gst);
				 $_SESSION['ses_payment_vars']['payable_amt'] = $final_payment;
				?></div>
                  </div>
                </div>
              </div>
               <div class="proceed-blk"><a class="update-cart-btn w-button continue" href="<?php echo $GLOBALS['site_config']['site_path']?>index/Promotions" style="margin-bottom:5px;">CONTINUE SHOPPING</a>
              <?php	if($_SESSION['ses_customer_id'] > 0) {
						$chkout_url = $GLOBALS['site_config']['site_path']."checkout/shipping-billing-info";
					}  else  {										 
						$chkout_url = $GLOBALS['site_config']['site_path']."login";
					}
		  	    ?>
             <a class="update-cart-btn w-button" href="<?php echo $chkout_url?>" style="margin-bottom:5px;">proceed to checkout</a></div>
            </div>
          </div>
        </div>
        <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
      </div>
 

<?php 

require_once("footer.php"); 

?>