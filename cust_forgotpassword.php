<?php 


require_once("includes/code_header.php");

require_once("classes/customers.class.php");

$cust_obj = new customers();

$submit_action = $_REQUEST['submit_action'];

$display_what = "detail_frm";

switch($submit_action)
{

	case "send_fpwd":
	
		if($cust_obj->forgot_password() == 1)
		
			$redirect_url = "cust_forgotpassword1.php?submit_action=sent";
			
		else
		
			$redirect_url = "cust_forgotpassword1.php";
			
		header("location:$redirect_url");
		exit();		
		break;

	case "sent":
		$display_what = "sent_frm";
		break;
	
	
}

?>

<script language="javascript">
function check_validate_pwd() {
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";
        check_email(form.elements["email"].name,"Email address should not be empty !");
        
}
</script>
<table <?php echo $inner_table_param; ?>>
  <tr>
    <td>
	<?php
	
	require_once("includes/error_message.php");
	
	?>
	<?php
	
	switch ($display_what)
	{
	
		case "detail_frm":
			require_once("forms/cust_fpwd_frm.php");
			break;
		
		case "sent_frm":
	?>
	<br />
	<h3>Forgot Password?</h3>
	Your Password has been sent to the email id you have provided.<br />
	<a class="clickher2" href="cust_login.php">Click Here</a> to go Login Page.
	<?php
		break;
	
	}//end switch
	
	?>
	</td>
  </tr>
</table>
