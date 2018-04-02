<?php 
$spl_doc_title = "Member";
require_once("header.php"); 
$BreadCrumb = "Login"; 
require_once("classes/customers.class.php"); 
require_once("classes/temp_cart.class.php"); 
$cobj = new customers();
$temp_cart = new temp_cart();
//$GLOBALS['site_config']['debug']=1;



$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "mainlogin":
		$GLOBALS['site_config']['debug'] =1;
		if($cobj->login())
		{	
		$temp_cart->delete_temp_cart();
			
			$redirect_url =  $GLOBALS['site_config']['site_path']."myaccount"; 
			$temp_cart->cart_items_from_db($_SESSION['ses_customer_id']);
			    if(isset($_REQUEST['prodId']) && $_REQUEST['prodId'] >0){
					$redirect_url = "product_detail.php?prod_id=".$_REQUEST['prodId'];
				}			
				else if(count($_SESSION['ses_cart_items']) > 0)
				{				
					if($payment_gateway == "paypal_pro")
					{
						$temp_sid = session_id();
						$redirect_url = stripslashes(trim($GLOBALS['site_config']['ssl_url']) . "billing_info.php?PHPSESSID=" . $temp_sid);
					}
					else if($payment_gateway == "paypal")
					{
						$redirect_url =  $GLOBALS['site_config']['site_path']."shipping-billing-info"; 
					}
				}
			
		}	
		else
		
			$redirect_url = $redirect_url = $GLOBALS['site_config']['site_path']."login";
		//exit;
		header("location:$redirect_url");
		exit();			
		break;
		
		case "activate":
			if($cobj->cust_activate())
			{
				$redirect_url = $GLOBALS['site_config']['site_path']."login";
			}
			else{
				$redirect_url =  $GLOBALS['site_config']['site_path']."login";
			}
			
			header("location:$redirect_url");
			exit();	
		break;
		
		case "guestlogin":
		$_SESSION['ses_customer_id'] = 1;
		$redirect_url =  $GLOBALS['site_config']['site_path']; 
			//$temp_cart->cart_items_from_db($_SESSION['ses_customer_id']);
			    if(isset($_REQUEST['prodId']) && $_REQUEST['prodId'] >0){
					$redirect_url = "product_detail.php?prod_id=".$_REQUEST['prodId'];
				}			
				else if(count($_SESSION['ses_cart_items']) > 0)
				{				
					if($payment_gateway == "paypal_pro")
					{
						$temp_sid = session_id();
						$redirect_url = stripslashes(trim($GLOBALS['site_config']['ssl_url']) . "billing_info.php?PHPSESSID=" . $temp_sid);
					}
					else if($payment_gateway == "paypal")
					{
						$redirect_url =  $GLOBALS['site_config']['site_path']."shipping-billing-info"; 
					}
				}
		
		header("location:$redirect_url");
		exit();			
		break;

}//end switch

?>

     <?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>Customer</div>
      </div>
      <div class="carttable w-clearfix">
       
        <div class="normal-con-with-sb">
          <div class="check-out-login w-clearfix">
            <div class="checkout-selection">
              <div class="content side-title">New Customer</div>
              <div>Register with us for future convenience.</div>
              <div>Sign up now to view your invoice and stay connected with Way Fengshui Group for news, promotion and articles.</div>
              <div class="">
                <form data-name="Email Form 3" id="email-form-3" name="email-form-3" action="" method="post">
                <div>
                <br /><a href="<?php echo $GLOBALS['site_config']['site_path'];?>account/create"> <input class="n-btn-orange w-button" data-wait="Please wait..." type="button" value="Continue"></a><br /></form>
                
                </div>
               </div>
               <br />
                <div class="content side-title">Guest User</div>
              <div class="">
             
                <form name="login"  id="Guestlogin" action="" method="post" >    
                <input class="buynow-btn w-button" data-wait="Please wait..." type="submit" value="CONTINUE AS GUEST">
                <input type="hidden" name="submit_action" value="guestlogin">
                </form>
               <br>
              </div>
            </div>
            <div class="login-blk">
            <?php	
				require_once(dirname(__FILE__) . '/includes/error_message.php');
				?>
              <div class="content side-title">Login</div>
              <div>For existing customers:</div>
              <div class="login-form w-form">
                <form data-name="Email Form 4" id="email-form-4" name="" method="post" action="<?php echo $GLOBALS['site_config']['site_path'];?>login">
                <input class="login nfiled w-input" data-name="Email" id="Email-6" maxlength="256" name="cust_email" placeholder="Email address" required="required" type="email">
                <input class="login nfiled w-input" data-name="Password" id="Password" maxlength="256" name="cust_password" placeholder="Password" type="password" required="required">
                  <div class="div-block"><a class="forgot-link" href="<?php echo $GLOBALS['site_config']['site_path'];?>forgot-password">Forgot password &raquo;</a></div><input class="n-btn-orange w-button" data-wait="Please wait..." type="submit" value="Submit">
                  <input type="hidden" name="submit_action" value="mainlogin"></form>
               
              </div>
            </div>
          </div>
        </div>
        <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
        
      </div>

      
      
 
<?php 

require_once("footer.php"); 

?>