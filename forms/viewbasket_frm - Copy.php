<script language="JavaScript">
function confirm_delete(item_ky)
{
	if(confirm('Are you sure to delete this item from the cart?\n(Ok = Yes, Cancel = No)'))
	window.location.href = "cart_process.php?submit_action=deletecart&del_key=" + item_ky;
}


</script>
<link rel='stylesheet' href='tooltip/css/tooltips.css'>
	
	<script src="tooltip/js/jquery.min.js"></script>
	<!--[if !IE | (gt IE 8)]><!-->
	<script src="tooltip/js/tooltips.js"></script>
	<script>
		$(function() {
			$(".toolTip_cls").tooltips();
		});
	</script>
<?php

require_once("classes/product_master.class.php");
$prod_obj = new product_master();

//print_r($_SESSION['ses_cart_items']);
?>
<input type="hidden" name="apply_dis" value="0">


     <table cellSpacing=0 cellPadding=0 width="100%" border=0 >
              <?php if($from_page == "basket" && 1==2) { ?>
              <tr class=heading>
				 <td height=25 align=center style="padding: 2px;"><font class="whitefont" ><u>Contents of Cart</u></font>
				 </td>
			   </tr>
			   <?php } ?>
			   <tr>
				<td align=middle></td>
                </tr>
				<tr><td >
<table cellspacing="0" cellpadding="0" width="100%" >
        <tr class="productheadingbg"> 
          <td width="106" height=25 align="center" class="pdlistconte" ><font class='pdlistconte'>Image</font></td>
          <td width="472"  align="center" class="pdlistconte"><font  class='pdlistconte'>Item #</font></td>
          <td width="139"  align="center" class="pdlistconte" nowrap="nowrap"><font class='pdlistconte'>Price 
            (US$) </font></td>
          <td width="147" align="center" class="pdlistconte"><font class='pdlistconte'>Quantity</font></td>
          <td width="166"  align="right" class="pdlistconte" nowrap="nowrap"><font class='pdlistconte'>Ext. 
            Price&nbsp;(US$) </font></td>
          <?php $colspan = 5; if($from_page == "basket") { $colspan = 6;?>
          <td width="197"  align="center" class="pdlistconte"><font class='pdlistconte'>Action</font></td>
          <?php } ?>
        </tr>
        <tr> 
          <td colspan=<?php echo $colspan; ?> align=right><hr size="0"> </td>
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
			$temp_weight = format_number(round($GLOBALS['site_config']['prod_weight'] * $var['prod_quantity'], 2));
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
        <tr class="itemcolor"> 
          <td align="center" width=106 height="85" valign="middle"> <img src="phpthump/phpThumb.php?src=../<?php echo $disp_img; ?>&w=60&h=60&q=95"  align="top" border=0 style="cursor:hand" <?php if($var['prod_id'] != $GLOBALS['consultations_prod_id']['2hr'] && $var['prod_id'] != $GLOBALS['consultations_prod_id']['30min']) { ?> onclick="javascript:<?php echo $script_txt; ?>;"<?php } ?>>          </td>
          <td align="left">&nbsp;<font class='login'><?php echo $var['prod_name']; ?><br /><?php echo $var['prod_code']; ?></font><br />
          <td align="center"><font class='newsletter'><?php echo stripslashes($var['prod_unit_price']); ?></font></td>
          <td align="center"><font class="newsletter"> 
            <?php 
									 
			if($from_page == "basket" &&  $id_count <=0) { 
			
			?>
            <input type=text style="text-align:right" name="quantity<?=$k?>"  size=7 value="<?php echo stripslashes(ltrim($var['prod_quantity'],"0")); ?>" onfocus="setbool(frm_obj.boolcheck, '1')" onblur="setbool(frm_obj.boolcheck, '0')" onkeypress="check_integer_value(this.value)"><input type="hidden" name="stocks<?=$k?>" value="<?php echo stripslashes(ltrim($var['prod_stocks'],"0")); ?>" />
            <?php } else {
			
			$tot_quantity = $tot_quantity+$var['prod_quantity'];
			 echo stripslashes(ltrim($var['prod_quantity'],"0")); ?><input type="hidden" name="quantity<?=$k?>" value="1" />   <?php } ?>  </font>     </td>
          <td align="right"><font class='newsletter'><?php echo stripslashes($temp_amount); ?></font></td>
          <?php if($from_page == "basket") { ?>
          <td align="center" colspan="2"><a class=click style="cursor:hand" onclick="confirm_delete('<?php echo $k; ?>')"><img src="images/icon_delete.gif" title=delete border=0></a>          </td>
          <?php } ?>
        </tr>
        <tr valign="center" align="left"> 
          <td colspan="<?php echo $colspan; ?>" align="center" height="1" bgcolor="#000000"></td>
        </tr>
        <tr valign="center" align="left"> 
          <td colspan="<?php echo $colspan; ?>" align="center" height="3"></td>
        </tr>
        <?php 
		  
		  }//end foreach
		  
		  }//end if(is_array($_SESSION['ses_cart']))
		  
		  if(count($_SESSION['ses_cart_items']) <= 0)
		  {
		  ?>
        <tr valign="center" align="left"> 
          <td colspan="<?php echo $colspan; ?>" align="center"><font class='redfont'>Cart 
            Is Empty.</font></td>
        </tr>
        <?php 
		  
		  } 
		  else
		  {
		  
		  ?>
        <tr valign="center" align="left"> 
          <td colspan=2> </td>
          <td colspan=2 align="right" height=25><font class='login'>Sub 
            Total (US$):</font></td>
          <td align=right><font class='newsletter'> 
            <?php 

			$payable_amt = format_number($amount);
			$_SESSION['ses_payable_amount'] = $payable_amt;
			$percent=$_SESSION['ses_dis_percent'];
			
			$_SESSION['ses_dis_amt']=$cart_obj->discount_amount($percent,$payable_amt);
			
			echo $payable_amt; 

		  ?>
            </font></td>
          <?php if($from_page == "basket") { ?>
          <td></td>
          <?php } ?>
        </tr>
		
		<?php if($from_page == "payment") {?>
		 <tr valign="center" align="left"> 
          <td colspan=2> </td>
          <td colspan=2 align="right" height=25><font class='login'>Shipping Cost 
            (US$):</font></td>
          <td align=right><font class='newsletter'> 
            <?php 
			//echo $_SESSION['ses_ship_bill_arr']['country'];
			/*if($_SESSION['ses_ship_bill_arr']['country'] ==189 && $tot_quantity >3 || $_SESSION['ses_ship_bill_arr']['country'] ==150 && $tot_quantity >3)
				$ship_rate = 0;
			else
			{
				if($tot_quantity ==1)
					$ship_rate = $GLOBALS['site_config']['single_book'];
				elseif($tot_quantity ==2)
					$ship_rate = $GLOBALS['site_config']['two_books'];
				else
				 	$ship_rate =$tot_quantity * $GLOBALS['site_config']['three_books'];
			}
			
			*/
			$weight = format_number($weight,1);
			
			$cty = $GLOBALS['db_con_obj']->fetch_field("country","countrycode","countryid='".$_SESSION['ses_ship_bill_arr']['country']."'");
			
			$price = 'select shipping_table from shipping_details where concat(",",countries,",") like "%,'.$cty.',%"';
			
			$rates = $GLOBALS['db_con_obj']->execute_sql($price);
			
			$rate_data = mysql_fetch_object($rates[0]);
			
			
			$rate_array = explode(";", $rate_data->shipping_table);
			//print_r($rate_array);
			
		    //echo $weight = $GLOBALS['site_config']['prod_weight'];
			$weight = $weight;
			
			foreach($rate_array as $k => $val)
			{
			 $weights=explode(":",$val);
				if($weights[0] == $weight)
				$ship_rate = $weights[1];
					
			}
			
		
		
			if($ship_rate >0)	
				echo format_number($ship_rate); 
			else
			    echo "Free Shipping";
			
			$_SESSION['ses_cart_shipping_cost'] = $ship_rate;
		  ?>
            </font></td>
          <?php if($from_page == "basket") { ?>
          <td></td>
          <?php } ?>
        </tr>
		<?php } ?>
        <?php if($from_page == "basket") { ?>
        <tr> 
          <td colspan="<?php echo $colspan; ?>" align=right><input name="submit2" type="image"  src="images/buttons/update.jpg" value="Update"  style="border:0"></td>
        </tr>
        <tr> 
          <td colspan="<?php echo $colspan; ?>" align=right></td>
        </tr>
        <?php } } ?>
        <?php 
		
		
		if($from_page == "payment" || $from_page == "callme")
		{
		?>
        <tr valign="top"> 
          <td nowrap align="right" colspan=<?php echo $colspan; ?>>&nbsp;</td>
        </tr>
        <tr valign="top"> 
          <td nowrap align="right" colspan=4><font class='login'>Final 
            Payment (US$):</font></td>
          <td align="right" style="border-top: double 3px"><font class='login'> 
            <?php echo format_number($payable_amt+$ship_rate); ?>
            </font> <input type="hidden" name="payable_amt" value="<?php echo format_number($payable_amt+ $ship_rate); ?>"></td>
          <?php if($from_page == "basket") { ?>
          <td>&nbsp;</td>
          <?php } ?>
        </tr>
        <?php } ?>
        <tr> 
          <td colspan=6 align=right> <hr size="0"> </td>
        </tr>
        <?php if($from_page == "basket") { ?>
        <tr> 
          <td align="left" colspan=5><!--<a href="#"> <img  border="0" src="images/continue.jpg" onClick="window.location.href='<?php echo (1==2 && strlen(trim($_SESSION['ses_continue_url'])) > 0)?$_SESSION['ses_continue_url']:"index.php"; ?>';"></a>-->           <a href="index.php"><img src="images/buttons/back.jpg" border="0" /></a></td>
          <td calspan="3"align="right"> <!-- <input type="button" value="Check out" style="background-color: #990099; font-weight: bolder; font-size: 11px; color:#ffffff; font-family: Arial;"> --><a href="#"><img border="0" src="images/buttons/checkout.jpg" <?php if(count($_SESSION['ses_cart_items']) > 0) { ?> onClick="window.location.href='<?php
		  
		  if($_SESSION['ses_customer_id'] > 0) 
		  {
			  if($payment_gateway == "paypal_pro")
			  {
				  $temp_sid = session_id();
				  $chkout_url = stripslashes("billing_info.php?PHPSESSID=" . $temp_sid);
			  }
			  else if($payment_gateway == "paypal")
			  {
			  	$chkout_url = "ship_bill.php";
			  }
			  
			  
			 
			 
			  
		  }
		  else
		  {
		  //frame_notices("Login to continue !!", "redfont");
		  $chkout_url = stripslashes("cust_login.php");
		  }
		   echo $chkout_url;
		   ?>';" <?php } ?>> </a>
		  
		  </td>
        </tr>
        <tr> 
          <td colspan=6 align=right> <hr size="0"> </td>
        </tr>
        <?php 
		
		} ?>	
      </table>
</td></tr>	</table>