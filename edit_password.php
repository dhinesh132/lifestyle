<?php 
$customer_page = 1;
require_once("header.php"); 
$spl_doc_title="member";
require_once("classes/customers.class.php");

$BreadCrumb = "Edit Password"; 

$cust_obj = new customers();

$submit_action = $_REQUEST['submit_action'];

$display_what = "detail_frm";

switch ($submit_action)
{

	case "update_password":
		//$GLOBALS['site_config']['debug'] =1;
		if($cust_obj->update_pwd($_SESSION['ses_customer_id']))
			$redirect_url = $GLOBALS['site_config']['site_path']."myaccount";
		else{
			frame_notices("Password does not exists in our database!!", "redfont");
			$redirect_url = $GLOBALS['site_config']['site_path']."account/editpassword";
		}
		header("location:$redirect_url");
		//exit();
		break;

}//end switch
//echo $_SESSION['ses_customer_id'];

$cust_res = $GLOBALS['db_con_obj']->fetch_flds($cust_obj->cls_tbl,"*","cust_id=".$_SESSION['ses_customer_id']);
$cust_data = mysql_fetch_object($cust_res[0]);

?>
<?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>Update Password</div>
      </div>
      <div class="carttable w-clearfix">
        <?php	
		require_once(dirname(__FILE__) . '/includes/error_message.php');
		?>
        <div class="normal-con-with-sb">
          <div class="check-out-login w-clearfix">
          
            <div class="login-form ">
                <form data-name="Email Form 4" id="email-form-4" name="" method="post" action="" >
                <input class="login nfiled w-input" data-name="Password" id="old_password" maxlength="256" name="old_password" placeholder="Current Password" type="password" required="required">
                <input class="login nfiled w-input" data-name="Password" id="password" maxlength="256" name="password" placeholder="New Password" type="password" required="required">
                <input class="login nfiled w-input" data-name="Password" id="cust_cpassword" maxlength="256" name="cust_cpassword" placeholder="Confirm Password" type="password" required="required">
                  
                  <input class="n-btn-orange w-button"  type="submit" value="Update Password">
                  <input class="w-input text-input" id="Email-2" type="hidden" name="cust_email" required="required" data-name="Email" value="<?php echo $cust_data->cust_email ?>">
                <input type="hidden" name="submit_action" value="update_password">
                <input type="hidden" name="cust_status" value="1">
                <input type="hidden" name="cust_id" value="<?php echo $cust_data->cust_id ?>">
                <input type="hidden" name="cust_create_datetime" value="<?php echo (strlen($cust_data->cust_create_datetime) > 0)?$cust_data->cust_create_datetime:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="cust_modify_datetime" value="<?php echo date("Y-m-d H:i:s"); ?>"></form>
             
              </div>
            
          </div>
        </div>
        <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
        
      </div>
<br />
<?php 

require_once("footer.php"); 

?>