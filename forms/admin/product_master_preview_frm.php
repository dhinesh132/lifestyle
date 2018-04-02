<?php
require_once("../classes/product_master.class.php");
require_once("../classes/productattributes.class.php");




if($edit == 1 && $edit_id > 0)
{
 $prod_obj = new product_master();
 $prod_attr_obj = new productattributes();

	
	$res = $prod_obj->fetch_record($edit_id);
	$prod_obj = set_values($prod_obj, "db", $res[0]);
	
}


?>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
  <tr class="maincontentheading"> 
    <td height="29" colspan="2" align='center' class='whitefont_header'> <?php echo stripslashes($prod_obj->prod_name['value']); ?></td>
  </tr>
  <?php
  
  $fpath = $prod_obj->attachment_path . $prod_obj->prod_med_image['value'];
  
  
  ?>
  <tr valign="top"> 
    <td align="center" ><?php if(file_exists($fpath) && is_file($fpath)) { ?><img src="<?php echo $fpath; ?>" border="0" alt="<?php echo stripslashes($prod_obj->prod_name['value']); ?> "><?php
  }
  ?></td>
    <td> <table width="90%" height="100">
	<?php if(1 ==2 ) {?>
        <tr> 
          <td width="10%"><span class="whitefont">Book Name</span></td>
          <td width="50%" nowrap> 
            <?php 

	echo stripslashes($prod_obj->prod_name['value']); 
	?>          </td>
        </tr>
		<?php }?>
        <tr valign="top" > 
          <td><span class="whitefont">Author</span></td>
          <td>
            <?php echo stripslashes($prod_obj->author['value']); ?> </td>
        </tr>
		
        <tr valign="top" > 
          <td nowrap><span class="whitefont">Published By</span></td>
          <td><?php echo stripslashes($prod_obj->published_by['value']); ?> </td>
        </tr>
        <?php if($prod_obj->prod_our_price['value'] > 0) { ?>
        <tr valign="top" >
          <td><span class="whitefont">ISBN</span></td>
          <td><?php echo stripslashes($prod_obj->isbn_no['value']); ?></td>
        </tr>
        <tr valign="top" > 
          <td><span class="whitefont">Our Price</span></td>
          <td><?php echo stripslashes($prod_obj->prod_our_price['value']); ?>&nbsp;($)</td>
        </tr>
        <?php } 
		if($prod_obj->prod_weight['value'] >0) {
  ?>
  	 <tr valign="top" > 
          <td><span class="whitefont">Normal Price</span></td>
          <td><?php echo stripslashes($prod_obj->prod_normal_price['value']); ?>&nbsp;($)</td>
        </tr>
        <tr valign="top" >
          <td><span class="whitefont">Weight</span></td>
          <td><?php echo $prod_obj->prod_weight['value'];?>&nbsp;(ounces)</td>
        </tr>
		<?php } ?>
        <tr valign="top" > 
          <td><span class="whitefont">Stock Available</span></td>
          <td><?php  
								
								$buyed = "";									
								$order_qry = "select prod_quantity from order_details where prod_id='".$prod_obj->prod_id['value']."'";
								$order_res = $GLOBALS['db_con_obj']->execute_sql($order_qry);
								while($order_data = mysql_fetch_object($order_res[0]))
								{
								    $buyed = $buyed + $order_data->prod_quantity;
								}
								
							  echo $remaining = $prod_obj->stocks_available['value'] - $buyed;?></td>
        </tr>
       <tr valign="top" >
          <td><span class="whitefont">Rating</span></td>
          <td><?php echo $prod_obj->rating['value'];?></td>
        </tr>
        
        <tr valign="top" > 
          <td><span class="whitefont">Status</span></td>
          <td><?php echo ($prod_obj->prod_status['value'] == 1)?"Active":"In-Active"; ?></td>
        </tr>
    </table></td>
  </tr>
  
 
  <tr valign="top" > 
    <td><span class="whitefont">Description</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top" > 
    <td colspan="2"><?php echo stripslashes($prod_obj->prod_desc['value']); ?>    </td>
  </tr>
   <tr valign="top" >
    <td><span class="whitefont">Minimum number of books to single order</span></td>
    <td><?php echo $prod_obj->min_orders['value'];?></td>
  </tr>
  <tr valign="top" >
    <td><span class="whitefont">Maximum number of books to single order</span></td>
    <td><?php echo $prod_obj->max_orders['value'];?></td>
  </tr>
  <?php if($prod_obj->prod_discount_val['value'] > 0) { ?>
  <tr valign="top" > 
    <td><span class="whitefont">Product Discount</span></td>
    <td><?php echo stripslashes($prod_obj->prod_discount_val['value'] . " " . $prod_obj->prod_discount_typ['value']); ?></td>
  </tr>
  <tr valign="top" > 
    <td><span class="whitefont">Discount Duration</span></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>From</td>
          <td><?php echo convert_date(stripslashes($prod_obj->dis_st_dt['value']['yr']."-".$prod_obj->dis_st_dt['value']['mt']."-".$prod_obj->dis_st_dt['value']['dt']),"m/d/Y h:i:s"); ?></td>
        </tr>
        <tr> 
          <td>Till</td>
          <td><?php echo convert_date(stripslashes($prod_obj->dis_end_dt['value']['yr']."-".$prod_obj->dis_end_dt['value']['mt']."-".$prod_obj->dis_end_dt['value']['dt']),"m/d/Y h:i:s"); ?></td>
        </tr>
      </table></td>
  </tr>
  <?php } ?>
  <?php  
  if(1==2) { 
  ?>
  <tr valign="top" > 
    <td height="31"><span class="whitefont">Product Weight</span></td>
    <td><?php echo stripslashes($prod_obj->prod_weight['value']); ?>&nbsp;(ounce)</td>
  </tr>
  <tr valign="top" > 
    <td><span class="whitefont">Supplier</span></td>
    <td> 
      <?php
	 
	  $tmp_supplier = $prod_obj->supplier_id['value'];
	  if(is_numeric($prod_obj->supplier_id['value']) && $prod_obj->supplier_id['value'] > 0)
	  {
		$tmp_supplier=$db_con_obj->fetch_field($s_obj->cls_tbl,"concat(sup_firstname,' ', sup_lastname) as supplier_name", $s_obj->primary_fld . " = '" . $prod_obj->supplier_id['value'] . "'");
	  }
		echo (strlen(trim($tmp_supplier)) > 1)?$tmp_supplier:"No Supplier";
				  
	?>    </td>
  </tr>
  <?php } 
  if($prod_obj->category_id['value'] ==1) {?>
  <tr valign="top" > 
    <td nowrap><span class="whitefont">Total number of downloads</span></td>
    <td><?php echo $prod_obj->get_total_downloads($prod_obj->prod_id['value']); ?></td>
  </tr>
  <?php } ?>
  <tr valign="top" > 
    <td><span class="whitefont">Created On</span></td>
    <td> <?php echo convert_date(stripslashes($prod_obj->date_entered['value'])); ?>    </td>
  </tr>
  <tr valign="top" > 
    <td><span class="whitefont">Modified On</span></td>
    <td> <?php echo convert_date(stripslashes($prod_obj->date_modified['value'])); ?>    </td>
  </tr>
  <tr> 
    <td align="center" colspan="2"> <img align="absmiddle" src="../images/close.jpg" onClick="window.close();"> </td>
  </tr>
  <tr> 
    <td colspan="2" height="8px"> </td>
  </tr>
</table>
<?php
$temp_window_tilte = $prod_obj->prod_name['value'];
?>	  
 