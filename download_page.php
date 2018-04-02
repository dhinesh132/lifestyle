<?php 
$customer_page = 1;

require_once("header.php"); 

if($_SESSION['ses_download_login'] != 1)
{
	frame_notices("You are not authorized to access that url !!", "redfont");
	header("location:index.php");
	exit();
}

$spl_doc_title = "Download your eBook";

$book_id = $_SESSION['ses_download_vars']['bkid'];

require_once("classes/order_master.class.php");
require_once("classes/product_master.class.php");

$ord_mobj = new order_master();
$ord_dobj = new order_details();
$prod_obj = new product_master();

$qry = $GLOBALS['db_con_obj']->fetch_field($ord_mobj->cls_tbl, "dwn_link_status", "order_id = '" . $book_id . "'");

if($qry <= 0)
{
	header("location:download_register.php");
	exit();
}


/*
$res = $GLOBALS['db_con_obj']->fetch_flds($ord_dobj->cls_tbl, "order_id,prod_id,download_status","detail_id = '" . $book_id . "'");

$order_d_data = mysql_fetch_object($res[0]);

$download_prefix = "download" . $_SESSION['ses_customer_id'] . "-" . $order_d_data->order_id . "-" . $order_d_data->prod_id;

$enc_str = md5($download_prefix);

$rec = $prod_obj->fetch_record($order_d_data->prod_id);

$rec_data = mysql_fetch_object($rec[0]);

$pth = $prod_obj->attachment_path . $rec_data->book_file;
*/

//$qry = "select prod_id, detail_id from " . $ord_dobj->cls_tbl . " where order_id = '" . $book_id . "' and prod_id not in (" . implode(",", $GLOBALS['consultations_prod_id']) . ")";

//$GLOBALS['site_config']['debug']=1;
$qry = "select prod_id, detail_id from " . $ord_dobj->cls_tbl . " where order_id = '" . $book_id . "'";
$res = $GLOBALS['db_con_obj']->execute_sql($qry);
$download_prefix = "download" . $_SESSION['ses_customer_id'] . "-" . $book_id;
$normal_str = "";

while($ord_ddata = mysql_fetch_object($res[0]))
{
	$normal_str	= $normal_str . "-" . $ord_ddata->prod_id;
}

$final_str = $download_prefix . $normal_str;
$encrypt_str = md5($final_str);
	
	$res = $GLOBALS['db_con_obj']->fetch_flds($ord_dobj->cls_tbl, "prod_id,detail_id", "download_status = '0' and order_id = '" .$book_id . "'");

//exit;
?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td width="100%"><p>&nbsp;</p>
	<?php
	require_once("includes/error_message.php");
	
	//if(1==2 && $order_d_data->download_status == 1)
	if($res[1] <= 0)
	{
	?>
	  <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
       
        <tr> 
          <td align="center" nowrap><p align="center"><strong>The ebook can be downloaded only once and to download the ebook again please contact admin at</strong></p>
            <p align="center"><a href="mailto:<?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?>"><?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?></a></p></td>
        </tr>
      </table>
	<?php
	unset($_SESSION['ses_download_vars']);
	unset($_SESSION['ses_download_login']);
	}
	else
	{
	//echo $book_id . " == " . $encrypt_str . " == " . $_SESSION['ses_download_vars']['arg'] . "<hr>";
	if($encrypt_str == $_SESSION['ses_download_vars']['arg'])
	{
	
	?>
	  <table border="0" cellpadding="5" cellspacing="3" width="95%">
        <?php
	
	while($data = mysql_fetch_object($res[0]))
	{
	
	$bk_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl, "prod_name,book_file,category_id", "prod_id = '" .$data->prod_id . "'");
	
	$bk_data = mysql_fetch_object($bk_res[0]);
	
	$pth = $prod_obj->books_path . $bk_data->book_file;
	
	$id_count = substr_count($GLOBALS['site_config']['ebook_cat'],$bk_data->category_id);
	
	if(file_exists($pth) && is_file($pth) && $id_count >0)
	{
	$_SESSION['ses_download_book_id'][$data->prod_id] = $data->detail_id;
	?>
        <tr> 
          <td><strong><?php echo stripslashes($bk_data->prod_name); ?></strong></td>
          <td><a href="download_book.php?pid=<?php echo $data->prod_id; ?>">Download Now</a></td>
        </tr>
        <?php
	}
	else if($id_count >0)
	{
		echo "<tr><td><a href=\"product_detail.php?prod_id=" . $data->prod_id . "\">" . stripslashes($bk_data->prod_name) . "</a></td><td><strong>Sorry, for the inconvenience. You cannot download your book at this time. Please try again later !!</strong></td></tr>";
		//session_unset();
	}
	
	}//end while
	
	?>
        <tr>
          <td colspan="2"><hr size="0"></td>
        </tr>
        <tr> 
          <td colspan="2"> <p align="center"><strong>If you don't have adobe reader, 
              you can download it from the following link</strong></p>
            <p align="center"><!-- http://www.adobe.com/products/acrobat/readstep2.html --><a href="http://www.adobe.com/" target="_blank"><img src="images/adobe_pdf.gif" border="0" alt="Download Adobe Reader Here"></a></p></td>
        </tr>
        <tr> 
          <td colspan="2"><p align="center"><strong>To download the ebook again please contact admin at</strong></p>
            <p align="center"><a href="mailto:<?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?>"><?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?></a></p></td>
        </tr>
      </table>
	<?php
	
	}
	else
	{
	?>	
	  <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center"><tr><td align="center" nowrap>Book cannot be downloaded, invalid url to download the book.</strong></td></tr></table>
	<?php
	session_unset();
	}
	}
	?>
	</td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>