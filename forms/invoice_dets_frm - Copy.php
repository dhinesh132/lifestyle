<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center"> 
      <table cellpadding="2" cellspacing="0" width="95%" border="0" bordercolor='#cccccc' class="tableborder_new">
        <tr class="maincontentheading"> 
          <td width="30%" align="center" valign="top" colspan="4"> <font class="whitefont_header">Invoice&nbsp;-&nbsp;<?php echo $master_data->order_id; ?></font>          </td>
        </tr>
        <?php
						
						if($paymeth=="2")
						{
						?>
        <tr> 
          <td nowrap align="left" valign="top"> <font class="postaddcontent">To 
            :<br>
            Fax : <br>
            Phone :</font> </td>
          <td width="40%" align="left" valign="top" nowrap> <font class="itemfont"> 
            <?php	
			  			echo trim($GLOBALS['site_config']['company_name']) . "<br>";
						echo trim($GLOBALS['site_config']['company_fax']) . "<br>";
						echo trim($GLOBALS['site_config']['company_phone']) ;
											
										?>
            </font> </td>
          <td width="30%" align="right" valign="top"><font class="postaddcontent">From 
            : <br>
            <!-- Order Number :<br> -->
            Total Pages : <br>
            Phone : <br>
            Date : </font></td>
          <td width="30%" align="left" valign="top"> 
            <?php 
				echo stripslashes($master_data->bill_fname . " " . $master_data->bill_lname) ; ?>
            <br> <?php echo ("__________");?><br> <?php echo ("__________");?><br> 
            <?php echo convert_date($master_data->date_entered); ?> </td>
        </tr>
        <tr> 
          <td colspan="4" align="left"> <hr size="0"></td>
        </tr>
        <?php
						}
						?>
        <tr> 
          <td nowrap align="left" valign="top"><img src="images/invoice_logo.jpg"  /></td>
          <td valign="top" align="left" nowrap> <font class="itemfont"> 
            <?php

						echo trim(stripslashes($GLOBALS['site_config']['company_name'])) . "<br>";
						echo trim(stripslashes($GLOBALS['site_config']['company_address']));
											

										?>
            <br>
            </font> </td>
          <td width="30%" align="right" valign="top"><font class="postaddcontent">Invoice Number 
            : <br>
            <!-- Order Number :<br> -->
            Order Date :<br>
            Order Status :<br>
            </font></td>
          <td width="30%" align="left" valign="top" class="itemfont"><?php
		  if(strlen($_REQUEST['order_id']) <4){
			$len = strlen($_REQUEST['order_id'])+1;
			for($i=$len; $i<=4;$i++){
				$str .= "0";
			}
			}
			else
			$str='';
			//echo $str;
			$barcodeval = $str.$_REQUEST['order_id'];

			$barcodeval = date("Ymd",strtotime($master_data->date_entered)).$barcodeval;
		   echo $barcodeval; ?><br> 
            <?php echo convert_date($master_data->date_entered); ?><br> 
            <?php 
			//$GLOBALS['site_config']['debug'] =1;
	
			
			switch($master_data->order_status)
			{
			
				case 0:
					echo "Not Paid";
					break;
				
				case 1:
					if($ship_deatils ==1)
					echo "Paid, Shipment Pending";
					else
					echo "Shipped";
					break;
				
				case 2:
					echo "Shipped";
					break;
				
			}; 
			
			?>          </td>
        </tr>
        <tr> 
          <td colspan=4 id="paydescid"></td>
        </tr>
        <tr> 
          <td colspan="4" align="left"> <hr size="0"></td>
        </tr>
        <tr> 
          <td colspan="2" align="left" valign="top" class="itemfont"> <font class="postaddcontent"><u>Payment 
            Details </u></font><br>
            <font class="postaddcontent">Payable Amount :</font> <?php echo "$ " . format_number($master_data->payable_amount); ?> 
            <br> <font class="postaddcontent">Payment Method :</font> 
            <?php 
						
						echo $db_con_obj->fetch_field("paymentmethods", "payment_type", "paymeth_id = '" . $master_data->pay_method . "'"); 
						if($master_data->pay_method == 1)
						echo ", " . $master_data->callback_number;
						
						?>
            <font class="itemfont">&nbsp; </font><font class="postaddcontent"> 
            <br>
            </font><font class="itemfont"> 
            <?php 
			  
			  /*
			  echo stripslashes($master_data->bill_compname) . "<br>";
              echo stripslashes($master_data->bill_ads1) . "<br>";
			  if(strlen(trim($master_data->bill_ads2)) > 0)
              echo stripslashes($master_data->bill_ads2) . "<br>";
              
			  echo stripslashes($master_data->bill_city);

              $bst = $db_con_obj->fetch_field("state", "statename", "state_code = '". $master_data->bill_state . "'");
			  if(strlen($bst) > 0)
			  	echo " " . stripslashes($bst) . "<br>";
			  else
			  	echo "<br>";
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->bill_country . "'");
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry . " " . $master_data->bill_zip);
			  */
			  
			  ?>
            </font></td>
          <td nowrap width="30%" align="right" valign="top"><font class="postaddcontent"><br>
            </font></td>
          <td width="30%" valign="top" align="left" nowrap><br> </td>
        </tr>
        <tr> 
          <td colspan="4" align="left"> <hr size="0"></td>
        </tr>
		<?php 
		
		
		 
		  if($ship_deatils == 1)
		  {
		?>
        <tr align="center" valign="top"> 
          <td align="left"><font class="postaddcontent"><u>Shipment 
            Details:</u></font> </td>
          <td colspan="3" align="left"><font class="itemfont"><?php  
		  
		  	 echo stripslashes($master_data->ship_fname) . "<br>";
              echo stripslashes($master_data->ship_ads1);
			  if(strlen(trim($master_data->ship_ads2)) > 0)
              echo ", ".stripslashes($master_data->ship_ads2) . ",<br>";
              else
			  echo ",<br>";
			  echo stripslashes($master_data->ship_city);

              $bst = $db_con_obj->fetch_field("state", "statename", "state_code = '". $master_data->ship_state . "'");
			  if(strlen($bst) > 0)
			  	echo ", " . stripslashes($bst) . ",<br>";
			  else
			  	echo ",<br>";
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->ship_country . "'");
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry . ", " . $master_data->ship_zip); ?>.</font></td>
        </tr>
		<?php 
		}
		
	?>
		
        <tr> 
          <td colspan="4"> <table cellSpacing=0 cellPadding=0 width="100%" border=0 class=borderline>
              <tr class=heading> 
                <td height=25 align=center style="padding: 2px;"><font class="whitefont" ><u>Contents 
                  of Cart</u></font> </td>
              </tr>
              <tr> 
                <td align=middle bgColor=#ffffff></td>
              </tr>
              <tr> 
                <td > <table cellspacing="0" cellpadding="0" width="100%">
                    <tr> 
                      <td width="8%" align="center" class="billheader" height=25><font class='postaddcontent'>Item</font></td>
                      <td width="50%"  align="left" class="billheader" colspan="2"><font  class='postaddcontent'>Stock Code</font></td>
                      
                      <td width="22%" align="center" class="billheader"><font class='postaddcontent'>Quantity</font></td>
                      <td width="20%"  align="right" class="billheader"><font class='postaddcontent'>Ext. 
                        Price&nbsp;($) </font></td>
                    </tr>
                    <tr> 
                      <td colspan=5 align=right><hr size="0"> </td>
                    </tr>
                    <?php 
									$while_ctr = 0;
									$sub_total = 0;
									while($ord_dets_data = mysql_fetch_object($detail_res[0])) { 
									$while_ctr++;
									?>
                    <tr class="itemcolor"> 
                      <td align="center" width=69 height=60><font class='itemfont' ><?php echo $while_ctr; ?></font></td>
                      <td align="justify" colspan="2"><font class='itemfont' >#<?php echo $GLOBALS['db_con_obj']->fetch_field("product_master","stock_code","prod_id='".$ord_dets_data->prod_id."'"); ?></font><br />
          
                      </td>
                      <td align="center"><font class='itemfont'><?php echo stripslashes($ord_dets_data->prod_quantity); ?></font></td>
                      <td align="right"><font class='itemfont'> 
                        <?php 
									  $ext_price = format_number($ord_dets_data->prod_unit_price * $ord_dets_data->prod_quantity);
									  echo $ext_price; 
									  $sub_total += $ext_price
									  ?>
                        </font></td>
                    </tr>
                     
                    <tr> 
                      <td colspan=6 align=right> <hr size="0"> </td>
                    </tr>
                    <?php } ?>
                    <tr valign="center" align="left"> 
                      <td colspan=2> </td>
                      <td colspan=2 align="right" height=25><font class='postaddcontent'>Sub 
                        Total ($):</font></td>
                      <td align=right><font class='itemfont'><?php echo format_number($sub_total); ?></font></td>
                    </tr>
                   
					<?php if($master_data->shipping_cost > 0) { ?>
                    <tr valign="center" align="left" bgcolor="#ffffff"> 
                      <td colspan=2> </td>
                      <td colspan=2 align="right" height=25><font class='postaddcontent'>&nbsp;&nbsp;Shipping&nbsp;Cost&nbsp;($):</font></td>
                      <td align=right><font class='itemfont'><?php echo format_number($master_data->shipping_cost); ?></font></td>
                    </tr>
                    <?php }
									if($master_data->discount_id != 0) 
									{	?>
                    <tr valign="center" align="left" bgcolor="#ffffff"> 
                      <td colspan=2> </td>
                      <td colspan=2 align="right" height=25><font class='postaddcontent'>Discount 
                        Coupon 
                        <?php 
									  //Changed at 01/03/07 
									  	$dis_res_id = $master_data->discount_id ;
										$dis_obj = new discount_coupon();
										$cond= "dis_id ='$dis_res_id'";
										$res_query1=$dis_obj->fetch_flds($dis_obj->cls_tbl, "*", $cond);
										$dis_data1 = mysql_fetch_object($res_query1[0]);
											$dis_con = $dis_data1->dis_percent;
											if($dis_con=="freeshipping")
											echo ":";
											else
											echo "($):";
									  		?>
                        </font></td>
                      <td align=right><font class='itemfont'> 
                        <?php 
									  if($dis_data1->dis_percent=="freeshipping")
											echo "Free shipping";
											else
											echo format_number($master_data->discount_amount);
											   ?>
                        </font></td>
                    </tr>
                    <?php
									}
									?>
                    <tr valign="top"> 
                      <td nowrap align="right" colspan=5>&nbsp;</td>
                    </tr>
                    <tr valign="top"> 
                      <td nowrap align="right" colspan=4><font class='postaddcontent'>Payable 
                        Amount ($):</font></td>
                      <td align="right" style="border-top: double 3px"><font class='itemfont'><?php echo format_number($master_data->payable_amount); ?></font>                      </td>
                    </tr>
                    <tr> 
                      <td colspan=6 align=right> <hr size="0"> </td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td>&nbsp; </td>
          <td align="right" colspan=7>&nbsp;</td>
        </tr>
      </table>
    </td>
              </tr>
            </table>