<?php 
$spl_doc_title = "Member";
require_once("header.php"); 
$BreadCrumb = FORGOTPWDBREADCRUMB; 
require_once("classes/customers.class.php");

$cust_obj = new customers();

$submit_action = $_REQUEST['submit_action'];

$display_what = "detail_frm";

switch($submit_action)
{

	case "send_fpwd":
		if($cust_obj->forgot_password() == 1)		
			$redirect_url = $GLOBALS['site_config']['site_path']."login";	
		else		
			$redirect_url = $GLOBALS['site_config']['site_path']."forgot-password";
			
		header("location:$redirect_url");
		exit();		
		break;

	case "sent":
		$display_what = "sent_frm";
		break;
	
}

?>

 <?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>Forgot Password?</div>
      </div>
      <div class="carttable w-clearfix">
       <?php	
		require_once(dirname(__FILE__) . '/includes/error_message.php');
		?>
        <div class="normal-con-with-sb">
          <div class="check-out-login w-clearfix">
            <div class="checkout-selection">
              <div class="content side-title">New Customer</div>
              <div>Register with us for future convenience:</div>
              <div class="w-form">
                <form data-name="Email Form 3" id="email-form-3" name="email-form-3" action="" method="post">
                <div>
                <br /><a href="<?php echo $GLOBALS['site_config']['site_path'];?>account/create"> <input class="n-btn-orange w-button" data-wait="Please wait..." type="button" value="Continue"></a></form>
                </div>
               </div>
                
            </div>
            <div class="login-blk">
              <div class="content side-title">Forgot Password</div>
              <div>For existing customers:</div>
              <div class="login-form ">
                <form data-name="Email Form 4" id="email-form-4" name="" method="post" action="">
                <input class="login nfiled w-input" data-name="Email" id="Email-6" maxlength="256" name="email" placeholder="Email address" required="required" type="email">
               
                  <div class="div-block"><a class="forgot-link" href="<?php echo $GLOBALS['site_config']['site_path'];?>login">Login &raquo;</a></div><input class="n-btn-orange w-button" data-wait="Please wait..." type="submit" value="Submit">
                  <input type="hidden" name="submit_action" value="send_fpwd"></form>
               
              </div>
            </div>
          </div>
        </div>
        <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
        
      </div>
      



<?php 

require_once("footer.php"); 

?>