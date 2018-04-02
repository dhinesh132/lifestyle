<?php 

require_once("classes/customers.class.php"); 

$cobj = new customers();


$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "login":
		if($cobj->login())
		{	
			
			$redirect_url = trim($GLOBALS['site_config']['site_path']) . "index.php"; //27072007 - take to home page they can click on the my account link to edit their personal information
			
			
			
				if(count($_SESSION['ses_cart_items']) > 0)
				{
				
					if($payment_gateway == "paypal_pro")
					{
						$temp_sid = session_id();
						$redirect_url = stripslashes(trim($GLOBALS['site_config']['ssl_url']) . "billing_info.php?PHPSESSID=" . $temp_sid);
					}
					else if($payment_gateway == "paypal")
					{
						$redirect_url = "ship_bill.php";
					}
				}
		}
		else
			$redirect_url = "cust_login.php";
	
		header("location:$redirect_url");
		exit();			
				
		break;

}//end switch

if($_SESSION['ses_customer_id'] =="")
{
?>
<form name="login_frm" method="post" action="" onSubmit="return check_form1(window.document.login_frm);">
            <table width="94%" border="0">
              <tr>
                <td colspan="2"><font class="login">Log In</font></td>
              </tr>
              <tr>
                <td width="31%"><font class="login_fld">Username : </font></td>
                <td width="69%" align="left"><input type="text" name="cust_username" class="textfield" style="width:140px; height:18px;"></td>
              </tr>
              <tr>
                <td><font class="login_fld">Password : </font></td>
                <td><input  type="password" name="cust_password" class="textfield" style="width:140px; height:18px;"></td>
              </tr>
              <tr>
                <td colspan="2" align="right" style="padding-right:20px;"><input type="image" src="images/login1.png" style="border:0px;" name="Submit2" value="Submit"><input type="hidden" name="submit_action" value="login"></td>
              </tr>
            </table> 
            </form>
<?php
}

else
{

?>
<table width="94%" border="0">
              <tr>
                <td colspan="2"><font class="login">Welcome</font></td>
              </tr>
              <tr>
                
                <td width="90%" align="center" colspan="2"><font class="login"><?php 
				
				$user_res = $GLOBALS['db_con_obj']->fetch_flds($cobj->cls_tbl,"cust_firstname,cust_lastname","cust_id='".$_SESSION['ses_customer_id']."'");
				
				$user_data = mysql_fetch_object($user_res[0]);
				
				echo $user_data->cust_firstname ." ".$user_data->cust_lastname;
				?></font></td>
              </tr>
              
              <tr>
                <td colspan="2" align="right" style="padding-right:20px;"><a href="logout.php"><img src="images/buttons/logout.png" style="border:0px;" name="Submit2" value="Submit"></a></td>
              </tr>
            </table> 
<?php }?>
