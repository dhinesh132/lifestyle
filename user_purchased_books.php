<?php 
//$customer_page = 1;
require_once("header.php"); 
require_once("classes/order_master.class.php"); 
require_once("classes/product_master.class.php"); 

$ord_mobj = new order_master();
$ord_dobj = new order_details();
$prod_obj = new product_master();

//$qry = "select " . $prod_obj->cls_tbl . ".prod_id, " . $prod_obj->cls_tbl . ".prod_name, " . $ord_mobj->cls_tbl . ".date_entered, " . $ord_mobj->cls_tbl . ".order_id, " . $ord_dobj->cls_tbl . ".prod_unit_price, " . $ord_dobj->cls_tbl . ".download_status, " . $ord_dobj->cls_tbl . ".detail_id from " . $ord_mobj->cls_tbl . ", " . $ord_dobj->cls_tbl . ", " . $prod_obj->cls_tbl . " where " . $ord_mobj->cls_tbl . ".order_id = " . $ord_dobj->cls_tbl . ".order_id and " . $ord_dobj->cls_tbl . ".prod_id = " . $prod_obj->cls_tbl . ".prod_id and " . $ord_mobj->cls_tbl . ".user_id = '" . $_SESSION['ses_customer_id'] . "' and " . $prod_obj->cls_tbl . ".prod_id not in (" . implode(",",$GLOBALS['consultations_prod_id']) . ") group by " . $prod_obj->cls_tbl . ".prod_id order by " . $ord_mobj->cls_tbl . ".order_id desc";
$qry = "select " . $prod_obj->cls_tbl . ".prod_id, ". $prod_obj->cls_tbl . ".prod_name, "  . $ord_mobj->cls_tbl . ".order_status, ". $ord_mobj->cls_tbl . ".date_entered, " . $ord_mobj->cls_tbl . ".order_id, " . $ord_dobj->cls_tbl . ".prod_unit_price, " . $ord_dobj->cls_tbl . ".download_status, " . $ord_dobj->cls_tbl . ".detail_id from " . $ord_mobj->cls_tbl . ", " . $ord_dobj->cls_tbl . ", " . $prod_obj->cls_tbl . " where " . $ord_mobj->cls_tbl . ".order_id = " . $ord_dobj->cls_tbl . ".order_id and " . $ord_mobj->cls_tbl . ".order_status = 1 and ". $ord_dobj->cls_tbl . ".prod_id = " . $prod_obj->cls_tbl . ".prod_id and " . $ord_mobj->cls_tbl . ".user_id = '" . $_SESSION['ses_customer_id'] . "' order by " . $ord_mobj->cls_tbl . ".order_id desc";

$spl_doc_title = "Your purchased eBooks";

?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td><?php require_once("includes/error_message.php"); ?>
      <table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
        <tr class="maincontentheading" height=25px> 
          <td>Inv #</td>
          <td>Title</td>
          <td nowrap>Purchased On</td>
          <td align="center" nowrap>Price ($)</td>
          <td align="center" nowrap>Download Status</td>
        </tr>
        <?php
  
 

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
        <tr <?php echo $row_bg_color; ?>  height=30px> 
          <td nowrap><a href="invoice.php?order_id=<?php echo $data->order_id; ?>"> 
            <?php
	
	 echo stripslashes($data->order_id); 
	 
	 ?>
            </a></td>
          <td> 
            <?php
	
	 echo stripslashes($data->prod_name); 
	 
	 ?>
            </td>
          <td nowrap> 
            <?php
	
	 echo convert_date($data->date_entered,"m/d/Y H:i:s"); 
	 
	 ?>
          </td>
          <td align="center"><?php echo $data->prod_unit_price; ?></td>
          <td align="center"> 
            <?php
		  if($data->download_status == 1)
		  	echo "<img src='images/download_completed.gif' alt='Downloaded'>";
		  else
		  	echo "<a href='product_download.php?prod_id=". $data->prod_id ."&ord_id=". $data->order_id ."&dwn_link=1' title='Download ". $bk_name ."' target='_blank'><img border='0' src='images/download_small.gif' alt='Not yet downloaded'></a>";
		  ?>
          </td>
        </tr>
        <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
        <tr> 
          <td colspan="5" algin='center'> <font class='redfont'>No ebooks were 
            purchased so far.</font></td>
        </tr>
        <?php

}

?>
      </table>
      <br>
<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
 
  <tr>
	  <td height=5px>
	  </td>
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
</table>
</td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>