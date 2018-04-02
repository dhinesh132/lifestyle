<?php 

//$customer_page = 1;

require_once("header.php"); 

require_once("classes/order_master.class.php");

require_once("classes/product_master.class.php");



$ord_mobj = new order_master();

$prod_obj = new product_master();



$spl_doc_title = "Download Your eBooks";



?>





<table <?php echo $inner_table_param; ?>>

  <tr> 

    <td valign="top"> 

      <?php



		require_once("includes/error_message.php");

		



?>

      <table align="center" cellpadding="4" cellspacing="0" width="100%" class="tableborder_new">

        <tr align="center" class="maincontentheading"> 

          <td width="10%" nowrap><font class='buyerfont'>Order&nbsp;#</font></td>

          <td width="10%" nowrap><font class='buyerfont'>Order Date</font></td>

          <td width="70%" nowrap>Book Name</td>

          <td width="10%" nowrap>Download</td>

        </tr>

        <?php

   

	 

		$qry = "select order_master.order_id, order_master.date_entered, order_master.order_status, order_master.payable_amount, order_details.detail_id, order_details.prod_id from order_master, order_details where 1 = 1 and order_master.order_status = 1 and order_master.order_id = order_details.order_id and order_master.user_id = '" . $_SESSION['ses_customer_id'] . "' and order_details.download_status = '0' and order_details.prod_id not in(" . implode(",", $GLOBALS['consultations_prod_id']) . ") order by order_master.date_entered asc, order_details.detail_id asc";

		

		//echo $qry;

				

		$paging_cls = new paging($qry);

		for($i=$paging_cls->start_index;$i<$paging_cls->end_index;$i++)

		

			{

		  if(mysql_data_seek($paging_cls->resultset,$i))

		  {

		  $data = mysql_fetch_object($paging_cls->resultset);  

		  

		  }

		  else

		  {

			unset($data);

		 }

		  if(isset($data))

		  {

		

		 if(file_exists("../includes/admin_alternate_color.php"))

		  include("../includes/admin_alternate_color.php");

		  else

		  include("includes/admin_alternate_color.php");

				

		?>

        <tr align="center" <?php echo $row_bg_color; ?>  height=30px> 

          <td nowrap><a  class='blue_link' href="#" onClick="popup_window('user_invoice.php?order_id=<?php echo $data->order_id; ?>',400,650,'yes','yes');"> 

            <?php

	  

	  echo $data->order_id;

	 		 ?>

            </a> </td>

          <td nowrap> 

            <?php

	  echo convert_date($data->date_entered,"m/d/Y H:i:s");

	  	  	?>

          </td>

          <td> 

            <?php $bk_name = $GLOBALS['db_con_obj']->fetch_field($prod_obj->cls_tbl, "prod_name", "prod_id = '" . $data->prod_id . "'"); ?>

            <?php echo stripslashes($bk_name); ?></td>

          <td nowrap><a href="product_download.php?prod_id=<?php echo $data->prod_id; ?>&ord_id=<?php echo $data->order_id; ?>&dwn_link=1" title="Download <?php echo $bk_name; ?>" target="_blank"><img src="images/download_small.gif" border="0"></a></td>

        </tr>

        <?php



		  }



		  }

		  

if($paging_cls->num_of_rows <= 0)



{



?>

        <tr> 

          <td colspan="4" algin='center'> <font class='redfont'>You have downloaded 

            all the books you have purchased so far.</font></td>

        </tr>

        <?php

}



?>

      </table>

      <br> <table cellpadding="0" cellspacing=0 border="0" width="100%">

        <tr> 

          <td height=5px> </td>

        </tr>

        <tr> 

          <td align="center" width="33%"> 

            <?php

$paging_cls->print_prev();

	?>

          </td>

          <td colspan="3" align="center" width="34%"> 

            <?php



$paging_cls->print_numbered_links();



$paging_cls->print_pages_of();

	?>

          </td>

          <td align="center" width="33%"> 

            <?php



	$paging_cls->print_next();



	?>

          </td>

        </tr>

      </table> </td>

  </tr>

  <tr>

    <td valign="top"><p align="center">If you don't have an adobe reader, you 
        can download it from the following link</p>

	<p align="center"><!-- http://www.adobe.com/products/acrobat/readstep2.html --><a href="http://www.adobe.com/" target="_blank"><img src="images/adobe_pdf.gif" border="0" alt="Download Adobe Reader Here"></a></p></td>

  </tr>

  <tr>

    <td valign="top">&nbsp;</td>

  </tr>

</table>





<?php 



require_once("footer.php"); 



?>