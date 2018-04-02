<?php 
$customer_page = 1;
require_once("header.php"); 
require_once("classes/order_master.class.php"); 

$spl_doc_title = "Your Orders";

?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td valign="top">
      <?php

		require_once("includes/error_message.php");
		
	$qry1 = "select concat(customer_master.cust_firstname,'&nbsp;',customer_master.cust_lastname) as cust_name, order_master.order_id, order_master.date_entered, order_master.order_status, order_master.payable_amount, customer_master.cust_firstname, customer_master.cust_lastname from order_master, customer_master where 1 = 1 and order_master.user_id = customer_master.cust_id and order_master.user_id = '" . $_SESSION['ses_customer_id'] . "' order by order_master.order_id desc ";
  
  
  
  
  $paging_cls = new paging($qry1);

?>
      <table align="center" cellpadding="4" cellspacing="0" width="100%" class="tableborder_new">
        <tr align="center" class="maincontentheading"> 
          <td width="10%" nowrap><font class='buyerfont'>Order&nbsp;#</font></td>
          <td width="30%" nowrap><font class='buyerfont'>Order Date</font></td>
          <td width="40%" nowrap><font class='buyerfont'>Order Total ($)</font></td>
          <td width="10%" nowrap><font class='buyerfont'>Status</font></td>
        </tr>
        <?php
   
	 
		$qry = "select concat(customer_master.cust_firstname,'&nbsp;',customer_master.cust_lastname) as cust_name, order_master.order_id, order_master.date_entered, order_master.order_status, order_master.payable_amount, customer_master.cust_firstname, customer_master.cust_lastname from order_master, customer_master where 1 = 1 and order_master.user_id = customer_master.cust_id and order_master.user_id = '" . $_SESSION['ses_customer_id'] . "' order by order_master.order_id desc";
		
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
		
		if($alternate_clr_ctr <= 0)
	$alternate_clr_ctr = 1;
else
	$alternate_clr_ctr++;

if(($alternate_clr_ctr%2) == 1)
 	$row_bg_color = "bgcolor='#f8fbf0'";
 else
  	$row_bg_color = "bgcolor='#ccdade'";
				
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
          <td nowrap> 
            <?php
	  echo $data->payable_amount;
	  		?>
          </td>
          <td nowrap> 
            <?php
	  if($data->order_status ==0)
	  echo "Payment pending";
	  else if($data->order_status==1)
	  echo "Paid";
	  else
	  echo "Waiting";
	  ?>
          </td>
        </tr>
        <?php
		  }
		  }
		  ?>
        <?php	 
		  
if($paging_cls->num_of_rows <= 0)

{

?>
        <tr> 
          <td colspan="4" algin='center'> <font class='redfont'>No records found.</font></td>
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
      </table>    </td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>