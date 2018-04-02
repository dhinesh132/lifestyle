<table cellSpacing=0 cellPadding=0 width="100%" border=0 class=borderline>
             
               <tr class=heading>
				 <td height=25 align=center style="padding: 2px;"><font class="whitefont" ><u>Contents of Cart</u></font>
				 </td>
			   </tr>
			   <tr>
				<td align=middle bgColor=#ffffff></td>
                </tr>
				<tr><td >
<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
        <tr> 
          <td align="center" class="billheader" height=25><font class='postaddcontent'>Item</font></td>
          <td  align="center" class="billheader"><font  class='postaddcontent'>Description</font></td>
          <td  align="center" class="billheader"><font class='postaddcontent'>Price 
            ($) </font></td>
          <td align="center" class="billheader"><font class='postaddcontent'>Quantity</font></td>
          <td  align="center" class="billheader"><font class='postaddcontent'>Ext. 
            Price&nbsp;($) </font></td>
          <?php $colspan = 5; if($from_page == "basket") { $colspan = 6;?>
		  <td  align="right" class="billheader"><font class='postaddcontent'>Action</font></td>
		  <?php } ?>
        </tr>
        <tr> 
          <td colspan=<?php echo $colspan; ?> align=right><hr size="0"> </td>
        </tr>
        <?php 
			
			if(is_array($_SESSION['ses_cart_items']))
			{
			$amount = 0;
			$weight = 0;
			foreach($_SESSION['ses_cart_items'] as $k => $crt_obj) 
			{ 
			//$var = get_object_vars($crt_obj);
			$var = $crt_obj;
			$temp_amount = format_number(round($var['prod_unit_price'] * $var['prod_quantity'], 2));
			$temp_weight = format_number(round($var['prod_weight'] * $var['prod_quantity'], 2));
			$amount += $temp_amount;
			$weight += $temp_weight;
			//print_r($var);
			?>
        <tr class="itemcolor"> 
          <td align="center" width=65 height=60> <img src="<?php echo $var['prod_thumb_path']; ?>" border=0 style="cursor:hand" onclick=enlargeimg("upload/<?=$detail['image1']?>",<?=$width1 + 50?>,<?=$height1 + 110?>)></a> 
          </td>
          <td align="justify"><a class=click href="product_detail.php?prod_id=<?php echo ($var['prod_prnt_id'] > 0)?$var['prod_prnt_id']:$var['prod_id']; ?>"><font class='itemfont'><?php echo stripslashes($var['prod_name']); ?></font></a></td>
          <td align="center"><font class='itemfont'><?php echo stripslashes($var['prod_unit_price']); ?></font></td>
          <td align="center"> 
            <?php if($from_page == "basket") { ?>
            <input type=text style="text-align:right" name="quantity<?=$k?>" size=7 value="<?php echo stripslashes($var['prod_quantity']); ?>" onfocus="setbool(frm_obj.boolcheck, '1')" onblur="setbool(frm_obj.boolcheck, '0')" onkeypress="check_integer_value(this.value)"> 
            <?php } else { echo stripslashes($var['prod_quantity']); } ?>
          </td>
          <td align="right"><font class='itemfont'><?php echo stripslashes($temp_amount); ?></font></td>
          <?php if($from_page == "basket") { ?>
		  <td align="right" colspan="2"><a class=click style="cursor:hand" onclick="confirm_delete('<?php echo $k; ?>')"><img src="images/icon_delete.gif" title=delete border=0></a> 
          </td>
		  <?php } ?>
        </tr>
        <?php 
		  
		  }//end foreach
		  
		  }//end if(is_array($_SESSION['ses_cart']))
		  
		  if(count($_SESSION['ses_cart_items']) <= 0)
		  {
		  ?>
        <tr valign="center" align="left" bgcolor="#ffffff"> 
          <td colspan="<?php echo $colspan; ?>" align="center"><font class='redfont'>Cart Is Empty.</font></td>
        </tr>
        <?php 
		  
		  } 
		  else
		  {
		  
		  ?>
        <tr valign="center" align="left" bgcolor="#ffffff"> 
          <td colspan=2> </td>
          <td colspan=2 align="right" height=25><font class='postaddcontent'>Sub 
            Total ($):</font></td>
          <td align=right><font class='itemfont'><?php 

		  $payable_amt = format_number($amount);

		  echo $payable_amt; 

		  ?></font></td>
		  <?php if($from_page == "basket") { ?>
          <td></td>
		  <?php } ?>
        </tr>
        <?php if($from_page == "basket") { ?>
        <tr> 
          <td colspan="<?php echo $colspan; ?>" align=right><input name="submit2" type="submit" value="Update"></td>
        </tr>
        <tr> 
          <td colspan="<?php echo $colspan; ?>" align=right> <hr size="0"> </td>
        </tr>
        <?php } } ?>
		<?php 
		
		if($from_page != "basket") { 
		
		if(1 == 2) {
		?>
        <tr valign="top"> 
          <td nowrap align="right" colspan=4><font class="postaddcontent">Sales 
            Tax:</font></td>
          <td nowrap align="right">&nbsp;</td>
        </tr>
        <tr valign="top"> 
          <td nowrap align="right" colspan=4><font class="postaddcontent">Discount 
            Coupon:</font></td>
          <td nowrap align="right">&nbsp;</td>
        </tr>
        <tr valign="top"> 
          <td nowrap align="right" colspan=4><font class="postaddcontent">GiftCertificate 
            Balance:</font></td>
          <td nowrap align="right">&nbsp;</td>
        </tr>
		<?php 
		
		} 
		
		
		if($from_page == "payment") {
		
		$ship_arr = explode("|-|", $_SESSION['ses_cart_shipping_method']);
		$payable_amt += trim($ship_arr[0]);
		
		?>
        <tr valign="top"> 
          <td nowrap align="right" colspan=4><font class="postaddcontent">Shipping 
            method&nbsp;-&nbsp;<?php echo $db_con_obj->fetch_field("shipmenttypes", "typename", "st_id = '" . $ship_arr[1] . "'"); ?>&nbsp;($):</font></td>
          <td nowrap align="right"><?php echo format_number($ship_arr[0]); ?></td>
        </tr>
		<?php } ?>
        <tr valign="top"> 
          <td nowrap align="right" colspan=<?php echo $colspan; ?>>&nbsp;</td>
        </tr>
        <tr valign="top"> 
          <td nowrap align="right" colspan=4><font class='postaddcontent'>Final 
            Payment ($):</font></td>
          <td align="right" style="border-top: double 3px"><font class='itemfont'><?php echo format_number($payable_amt); ?></font><input type="hidden" name="payable_amt" value="<?php echo format_number($payable_amt); ?>"></td>
		  <?php if($from_page == "basket") { ?>
          <td>&nbsp;</td>
		  <?php } ?>
        </tr>
		<?php } ?>
        <tr> 
          <td colspan=6 align=right> <hr size="0"> </td>
        </tr>
        <?php if($from_page == "basket") { ?>
        <tr bgcolor="#ffffff"> 
          <td align="left" colspan=5> <input name="submit3" type="button" value="Continue" onClick="window.location.href='<?php echo (strlen(trim($_SESSION['ses_continue_url'])) > 0)?$_SESSION['ses_continue_url']:"category_list.php"; ?>';"> 
          </td>
          <td calspan="3"align="right"> <input name="submit" type="button" value="Check out" <?php if(count($_SESSION['ses_cart_items']) > 0) { ?> onClick="window.location.href='ship_bill.php';" <?php } ?>> 
          </td>
        </tr>
        <tr> 
          <td colspan=6 align=right> <hr size="0"> </td>
        </tr>
        <?php } ?>
      </table>
</td></tr>	</table>