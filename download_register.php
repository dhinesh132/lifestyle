<?php 
$customer_page = 1;
require_once("header.php"); 

if($_SESSION['ses_download_login'] != 1)
{
	frame_notices("You are not authorized to access that url !!", "redfont");
	header("location:cust_login.php");
	exit();
}



$spl_doc_title = "Register to download your eBook";

$book_id = $_SESSION['ses_download_vars']['bkid'];

require_once("classes/order_master.class.php");
require_once("classes/product_master.class.php");

$ord_mobj = new order_master();
$ord_dobj = new order_details();
$prod_obj = new product_master();

/*
$qry = "select * from " . $ord_dobj->cls_tbl . " where detail_id = '" . $book_id . "'";

$res = $GLOBALS['db_con_obj']->execute_sql($qry);
*/

$res = $GLOBALS['db_con_obj']->fetch_flds($ord_dobj->cls_tbl, "order_id,download_status","detail_id = '" . $book_id . "'");

$order_d_data = mysql_fetch_object($res[0]);

//check whether this download is allowed for the login id - Start

//$chk_qry = "select user_id, dwn_link_status from " . $ord_mobj->cls_tbl . " where order_id = '" . $order_d_data->order_id . "'";
$chk_qry = "select user_id, dwn_link_status, dwn_count from " . $ord_mobj->cls_tbl . " where order_id = '" . $book_id . "'";

$chk_res = $GLOBALS['db_con_obj']->execute_sql($chk_qry);

$chk_data = mysql_fetch_object($chk_res[0]);

//if already registered take the user to download page... - Start

if($chk_data->dwn_link_status == 1 )
{
	header("location:download_page.php");
	exit();
}

//if already registered take the user to download page... - End


//check whether this download is allowed for the login id - End

$submit_action = $_REQUEST['submit_action'];

if($submit_action == "save")
{

	$customer_details = $GLOBALS['db_con_obj']->fetch_flds("customer_master", "cust_firstname,cust_lastname,cust_email","cust_id = '" . $_SESSION['ses_customer_id'] . "'");

	$customer_data = mysql_fetch_object($customer_details[0]);

	$qry = "update " . $ord_dobj->cls_tbl . " set dwn_fname = '" . wrap_values($customer_data->cust_firstname) . "', dwn_lname = '" . wrap_values($customer_data->cust_lastname) . "', dwn_email = '" . wrap_values($customer_data->cust_email) . "' where order_id = '" . $book_id . "'";
	//$qry = "update " . $ord_dobj->cls_tbl . " set dwn_fname = '" . wrap_values($_REQUEST['dwn_fname']) . "', dwn_lname = '" . wrap_values($_REQUEST['dwn_lname']) . "', dwn_email = '" . wrap_values($_REQUEST['dwn_email']) . "' where order_id = '" . $book_id . "'";
	//echo $qry;
	//exit();
	$GLOBALS['db_con_obj']->execute_sql($qry, "update");
	
	$qry = "update " . $ord_mobj->cls_tbl . " set dwn_link_status = '1' where order_id = '" . $book_id . "'";

	$GLOBALS['db_con_obj']->execute_sql($qry, "update");
	
	$qry = "update " . $ord_mobj->cls_tbl . " set dwn_count = '".($chk_data->dwn_count + 1 )."' where order_id = '" . $book_id . "'";

	//$GLOBALS['db_con_obj']->execute_sql($qry, "update");
	
	//frame_notices("Book registration is successfull. Select the download link to download the book. You are allowed to download this book only once !!", "greenfont");$chk_data->dwn_count
	//frame_notices("Thank you for registering with us. You can download this eBook only once !!", "greenfont");
	frame_notices("You can download this ebook only once !!", "greenfont");
	header("location:download_page.php");
	exit();

}

if($chk_data->user_id != $_SESSION['ses_customer_id'])
frame_notices(" ", "redfont");

?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td align="center"><p>&nbsp;</p><table border="0" cellspacing="0" cellpadding="0" width="98%" align="center"><tr><td>
	<?php
	require_once("includes/error_message.php");
	
	/* if($chk_data->user_id != $_SESSION['ses_customer_id'])
	{
	?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center"><tr><td align="center" nowrap><strong>Sorry, invalid authentication. You cannot download this book.<br>To download this book you need to login with the purchasers account (who placed this order).</strong></td></tr></table>
	<?php
	session_unset();
	}
	else
	{*/
	
	?>
	<script language="JavaScript">
	function check_validate()
	{
		error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";
		check_empty(form.elements["dwn_fname"].name,"Enter firstname!");
		check_empty(form.elements["dwn_lname"].name,"Enter lastname!");
		check_email(form.elements["dwn_email"].name,"Enter email address!");
	}
	</script>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center"><tr><td align="center" nowrap><form name="reg_frm" method="post" action="" onSubmit="return check_form(window.document.reg_frm);">
	    <table border="0" align="center" cellpadding="3" cellspacing="0" class="tableborder_new">
          <tr> 
            <td colspan="2" class="maincontentheading">Register your ebook in 
              the name of :</td>
          </tr>
          <tr> 
            <td><span class="whitefont">First Name</span><span class="red_hint_font">*</span></td>
            <td><input type="text" name="dwn_fname"></td>
          </tr>
          <tr> 
            <td><span class="whitefont">Last Name</span><span class="red_hint_font">*</span></td>
            <td><input type="text" name="dwn_lname"></td>
          </tr>
          <tr> 
            <td><span class="whitefont">Email Address</span><span class="red_hint_font">*</span></td>
            <td><input type="text" name="dwn_email"></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><input align="absmiddle" style="border:0px;" type="image" src="images/buttons/submit.jpg" name="Submit" value="Submit">
              <input type="hidden" name="submit_action" value="save"></td>
          </tr>
        </table>
	</form></td></tr></table>
	<?php
	
	//}
	
	?></td></tr></table></td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>