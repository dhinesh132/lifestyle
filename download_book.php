<?php 
$customer_page = 1;
require_once("includes/code_header.php");
//require_once("header.php"); 
require_once("classes/email.class.php");
require_once("classes/product_master.class.php");
require_once("classes/customers.class.php");
require_once("classes/order_master.class.php");
require_once("classes/download.class.php");

$prod_obj = new product_master();

$cust_obj = new customers();

//$rec = $prod_obj->fetch_record($_SESSION['ses_download_book_id']);
$temp_pid = $_REQUEST['pid'];
$rec = $prod_obj->fetch_flds($prod_obj->cls_tbl,"book_file,prod_name","prod_id = '" . $temp_pid . "'");

$rec_data = mysql_fetch_object($rec[0]);

$pth = $prod_obj->books_path . $rec_data->book_file;

$dwnload_fname = str_replace(" ", "_", $rec_data->prod_name);

$dwnload_fname .= substr($rec_data->book_file,-4);

$ord_mas_obj = new order_master();
$ord_det_obj = new order_details();

$dwn_status = $GLOBALS['db_con_obj']->fetch_field($ord_det_obj->cls_tbl, "download_status", "detail_id = '" . $_SESSION['ses_download_book_id'][$temp_pid] . "'");


if(isset($_SESSION['ses_download_book_id'][$temp_pid]) && $_SESSION['ses_download_book_id'][$temp_pid] != "" && $dwn_status == 0)
{

$qry = "update " . $ord_det_obj->cls_tbl . " set download_status = '1', download_ipads = '" . $_SERVER['REMOTE_ADDR'] . "', download_date = now() where detail_id = '" . $_SESSION['ses_download_book_id'][$temp_pid] . "'";

$GLOBALS['db_con_obj']->execute_sql($qry, "update");

 $order_id = $GLOBALS['db_con_obj']->fetch_field($ord_det_obj->cls_tbl, "order_id", "detail_id = '" . $_SESSION['ses_download_book_id'][$temp_pid] . "'");

 $user_id = $GLOBALS['db_con_obj']->fetch_field($ord_mas_obj->cls_tbl, "user_id", "order_id = '" . $order_id . "'");

 $chk_data = $GLOBALS['db_con_obj']->fetch_field($ord_mas_obj->cls_tbl, "dwn_count", "order_id = '" . $order_id . "'");

$qry = "update " . $ord_mas_obj->cls_tbl . " set dwn_count = '".($chk_data + 1 )."' where order_id = '" . $order_id . "'";

$GLOBALS['db_con_obj']->execute_sql($qry, "update");
	
$res = $cust_obj->fetch_record($user_id);

$cust_obj = set_values($cust_obj,"db",$res[0]);


$eml_cls = new email();

$email_content = "<p>Dear " . stripslashes($cust_obj->cust_firstname['value'] . " " . $cust_obj->cust_lastname['value']) . ", </p>";
$email_content .= "<table border='0' cellpadding='3' cellspacing='2' width='100%'><tr><td>";
$email_content .= "Thank you for downloading the ebook from " . stripslashes($GLOBALS['site_config']['company_name']) . ".</td></tr><tr><td>";
//$email_content .= "You may also be interested in the books listed in the following url : </td></tr><tr><td>";
//$email_content .= trim($GLOBALS['site_config']['site_path']) . "product_category.php?cat_id=" . $catid_data->category_id . "</td></tr>";
$email_content .= "We appreciate your business.</td></tr>";
$email_content .= "<tr><td><p>Thank again!</p><p>" .  stripslashes($GLOBALS['site_config']['company_name']) . "</td></tr></table>";


$eml_cls->email_type = 'html';
$eml_cls->email_subject = "Thank you for downloading your book at " .  stripslashes($GLOBALS['site_config']['company_name']) . " !!";
$eml_cls->email_message = $email_content;

$eml_cls->send_email($cust_obj->cust_email['value']); 




$myPath = substr($prod_obj->books_path,0,-1);

// New Object
$objDownload = new EasyDownload();

// Set physical path
$objDownload->setPath($myPath);

// Set file name on the server (real full name)
$objDownload->setFileName($rec_data->book_file);

// In case that it does not desire to effect download with original name.  
// It configures the alternative name
$objDownload->setFileNameDown($dwnload_fname);

// get file
$objDownload->Send();


/*
header('Cache-Control: maxage=3600'); //Adjust maxage appropriately
header('Pragma: public');
header('Content-type: application/pdf');
//header('Content-Disposition: attachment; filename="' . $dwnload_fname . '"');
$dwn_str = 'Content-Disposition: attachment; filename="' . $dwnload_fname . '"';
header($dwn_str);
readfile($pth);
*/

//session_unset();
unset($_SESSION['ses_download_book_id'][$temp_pid]);

}
else
{
	
require_once("header.php");

	?>
	<p>&nbsp;</p><p>&nbsp;</p>
<p align="center">You have already downloaded your book.</p> <p align="center">To download your ebook 
  again please contact admin at <a href="mailto:<?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?>"><?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?></a></p>



<?php 

require_once("footer.php"); 

}
?>
