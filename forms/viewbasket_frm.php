<script language="JavaScript">
function confirm_delete(item_ky)
{
	if(confirm('Are you sure to delete this item from the cart?\n(Ok = Yes, Cancel = No)'))
	window.location.href = "cart_process.php?submit_action=deletecart&del_key=" + item_ky;
}


</script>

<?php

require_once("classes/product_master.class.php");
$prod_obj = new product_master();

//print_r($_SESSION['ses_cart_items']);
?>
<input type="hidden" name="apply_dis" value="0">
<table width="686px">
                	<tr>
                    	<th width="40%" align="left"><?php echo ITEM ?></th>
                        <th width="10%"><?php echo WEIGHT?></th>
                        <th width="15%"><?php echo UNITPRICE ?></th>
                        <th width="10%"><?php echo QUANTITY ?></th>
                        <th width="15%"><?php echo PRICECART ?></th>
                    </tr>

     
        <?php 
			//print_r($_SESSION['ses_cart_items']);
			if(is_array($_SESSION['ses_cart_items']))
			{
			
			$amount = 0;
			$weight = 0;
			//******************** changed 03022007
			$temp_tax_con=0;
			$tot_quantity =0;
			//************************************
			foreach($_SESSION['ses_cart_items'] as $k => $crt_obj) 
			{ 
			//$var = get_object_vars($crt_obj);
			$var = $crt_obj;
			
			//echo $var['prod_unit_price'];
			//echo $var['prod_quantity'];
			
			$temp_amount = format_number(round($var['prod_unit_price'] * $var['prod_quantity'], 2));
			if($var['Weight'] <=0)
				$temp_weight = format_number($GLOBALS['site_config']['prod_weight'] * $var['prod_quantity'], 3);
			else
				$temp_weight = format_number($var['Weight'] * $var['prod_quantity'], 3);
			$amount += $temp_amount;
			$weight += $temp_weight;
			//print_r($var);
			//******************** changed 03022007
			
			$prod_id = ($var['prod_prnt_id'] > 0)?$var['prod_prnt_id']:$var['prod_id'];
			require_once("classes/cart.class.php");
			$cart_class_obj = new cart();
			$a=$cart_class_obj->salestax($prod_id,$temp_amount);
			$temp_tax_con += $a;
			
			
			//*********************************
			//$res = $prod_obj->fetch_field($prod_obj->cls_tbl,"prod_med_image",$prod_obj->primary_fld . " = '" . $prod_id . "'");
			//$data = mysql_fetch_object($res[0]);
			
			$file_path = $var['prod_thumb_path'];
			
			if(file_exists($file_path) && is_file($file_path))
		  		$disp_img = $file_path;
			else
				$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
			?>
        <tr>
                    	<td width="40%">
                        <p><img src="phpthump/phpThumb.php?src=../<?php echo $disp_img; ?>&w=76&h=60&q=95" alt="" align="left" class="border" /><strong><?php echo $var['prod_name']; ?></strong><br /><?php if($from_page == "basket") { ?>
                        <a href="#" onclick="confirm_delete('<?php echo $k; ?>')"><em><?php echo REMOVEITEM?></em></a>
                        <?php } ?>
                        </p></td>
                        <td width="10%">    <?php echo $var['Weight']; ?> Kg </td>
                        <td width="15%">SGD <?php echo stripslashes($var['prod_unit_price']); ?>  </td>
                        <td width="10%"> <?php if($from_page == "basket") { ?>
                        	<select class="select" title="Select one" name="quantity<?=$k?>" onchange="$('#cart_frm').submit();">
                           <?php
						   $qty=='';
                           $prod_qty = ProductQuantity($var['prod_id']);
							if($prod_qty <=10)
								$totQty = $prod_qty;
							else
							    $totQty = 10;
							for($qty=1;$qty<=$totQty;$qty++){?>
                            <option value="<?php echo $qty; ?>" <?php if($var['prod_quantity']== $qty){?> selected="selected"<?php }?> ><?php echo $qty; ?></option>
                            <?php }?>
                            </select>
                            <?php } else{
								echo $var['prod_quantity'];
							}?>
                        </td>
                        <td width="15%">SGD <?php echo stripslashes($temp_amount); ?></td>
                    </tr>
        <?php 
		  $tot_quantity = $tot_quantity+$var['prod_quantity'];
		  }//end foreach
		  
		  }//end if(is_array($_SESSION['ses_cart']))
		  
		  if(count($_SESSION['ses_cart_items']) <= 0)
		  {
		  ?>
        <tr valign="center" align="left"> 
          <td colspan="5" align="center" style="text-align:center"><?php echo CARTISEMPTY;?>.</td>
        </tr>
        
        <?php 
		  
		  } 
		 ?>
          </table>
         <?php if($from_page == "payment") {?>
		 <div class="total">
                    	
                  <table width="685px">
                        	<tr>
                            	<td width="50%"><img src="images/card.jpg" alt="" align="left" /></td>
                                <td width="50%" style="border-bottom:1px #D4CA9A solid;">
                                
                                	<table width="342px">
                                    	<tr>
                                       	  <td width="65%" style="text-align:right">
                                            <?php echo SUBTOTAL." (".GSTINCL.")"?>:<br /><br />
                                            <?php echo SHIPPINGCOST?>:<br /><br />
                                             <?php 
											 $show_gst =0;
											if($_SESSION['ses_ship_bill_arr']['country'] !=189){?>
                                             LESS <?php echo GST." (".$GLOBALS['site_config']['gst_percentage']."%)"?>:<br /><br />
                                             <?php }?>
                                            <a href="#shipping-box" class="login-window"><em> <?php echo VIEWSHIPPINGRATES ?></em></a>     
                                          </td>
                                          <td width="35%" style="text-align:right; padding-right:18px"> 
                                            SGD <?php 
												$payable_amt = format_number($amount);
												$_SESSION['ses_payable_amount'] = $payable_amt;
												$percent=$_SESSION['ses_dis_percent'];
												
												$_SESSION['ses_dis_amt']=$cart_obj->discount_amount($percent,$payable_amt);
												
												echo $payable_amt;											 
											  
											 ?>
                                              <br /><br /> SGD
                                              <?php 
											  $shippingcost = findShippingCost($weight,$bctry_data->countrycode);
											  echo $shippingcost;
											  $_SESSION['ses_cart_shipping_cost'] = $shippingcost;									  
											  ?>
                                              <?php
											  $gst_amount =0.00;
											  $gst_cal_amount = $shippingcost + $payable_amt;
											  $display_gst = findGSTamount($gst_cal_amount);
											  $_SESSION['ses_tax_con'] =  $display_gst;
											  
                                               if($_SESSION['ses_ship_bill_arr']['country'] !=189){?>
                                             <br /><br /> SGD <?php	echo "-". $display_gst;  											   
											   $gst_amount = $display_gst; }?> 
                                          </td>
                                        </tr>
                                    </table>
                                    
                              </td>
                            </tr>
                            
                            <tr>
                            	<td width="50%">&nbsp;</td>
                                <td width="50%">
                                
                                	<table width="342px">
                                    	<tr>
                                       	  <td width="65%" style="text-align:right">
                                           <?php echo TOTALCOST ?>:   <br />
                                            <?php if($_SESSION['ses_ship_bill_arr']['country'] ==189){?>
                                            <span style="font-size:10px">(Inclusive of GST(<?php echo $GLOBALS['site_config']['gst_percentage']?>%) of SGD<?php echo $display_gst;?>)</span>
                                            <?php }?>
                                          </td>
                                          <td width="35%" style="text-align:right; padding-right:14px"> 
                                            <em>&nbsp; &nbsp; SGD <?php 											
											 	echo $final_payment =  format_number(($shippingcost+$payable_amt)-$gst_amount);
											 
											 $_SESSION['ses_payment_vars']['payable_amt'] = $final_payment;
											 ?></em><br />
                                          </td>
                                        </tr>
                                    </table>
                                    
                              </td>
                            </tr>
                        </table>
                    </div>
		<?php  } ?>
       
       
        <?php if($from_page == "basket") { ?>
        <div class="total">
                    	
                  <table width="685px">
                        	<tr>
                            	<td width="50%"><img src="images/card.jpg" alt="" align="left" /></td>
                                <td width="50%" style="border-bottom:1px #D4CA9A solid;">
                                
                                	<table width="342px">
                                    	<tr>
                                       	  <td width="65%" style="text-align:right">
                                           <?php echo SUBTOTAL." (".GSTINCL.")"?>:<br />
                                          </td>
                                          <td width="35%" style="text-align:right; padding-right:18px"> 
                                            SGD <?php 
												$payable_amt = format_number($amount);
												$_SESSION['ses_payable_amount'] = $payable_amt;
												$percent=$_SESSION['ses_dis_percent'];
												
												$_SESSION['ses_dis_amt']=$cart_obj->discount_amount($percent,$payable_amt);
												
												echo $payable_amt; 
									
											  ?> <br />
                                          </td>
                                        </tr>
                                    </table>
                                    
                              </td>
                            </tr>                           
                           
                        </table>
                    </div>
        
        <?php 
		
		} ?>	
      </table>