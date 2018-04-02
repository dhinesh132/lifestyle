<table width="100%" border="0" cellspacing="0" cellpadding="4">

         <tr><th width="100%" align="center" colspan="4"><h1 style="color: #807B5F;font-family: 'DINNextLTPro-Light'; font-size: 20px; font-weight: bold;line-height: 24px;">Tax Invoice </h1></th></tr> 
          <tr> 

            <td align="left" width="20%" valign="top"> <font class="postaddcontent"><img src="invoice/eof.png" /></font></td>

            <td width="35%" valign="top" align="left" style="text-align:left;">
             
              <?php	
			   echo trim(stripslashes($GLOBALS['site_config']['company_name'])) . "<br>";
			   echo nl2br(stripslashes($GLOBALS['site_config']['company_address'])) . "<br>";
			  ?>
              <?php if($master_data->ship_country ==189){?>
              GST REG <?php echo $GLOBALS['site_config']['gst_reg_no'];
			  }
			  ?>
			  </td>

            <td nowrap width="15%" align="right" valign="top"></td>

            <td width="30%" valign="top" style="text-align:left;" nowrap> <?php
		  if(strlen($order_id ) <4){
			$len = strlen($order_id )+1;
			for($i=$len; $i<=4;$i++){
				$str .= "0";
			}
			}
			else
			$str='';
			//echo $str;
			$barcodeval = $str.$order_id ;

			$barcodeval = date("Ymd",strtotime($master_data->date_entered)).$barcodeval;
		   echo "NO: ".$barcodeval; ?><br> 
            <?php echo "Date: ".convert_date($master_data->date_entered); ?><br> 
            <?php 
			//echo $master_data->order_status;
			switch($master_data->order_status)
			{
			
				case 0:
					echo "Status: Not Paid";
					break;
				
				case 1:
					echo "Status: Paid, Shipment Pending";
					break;
				
				case 2:
					echo "Status: Shipped";
					if(strlen($master_data->ship_tracking_number)>0)
					echo "<br> Tracking No: ".$master_data->ship_tracking_number;
					break;
				
			}; 
			
			?></td>

          </tr>

         
          <tr valign="top"> 
            <td align="left">Ship To:</td>
            <td style="text-align:left;"><?php  
		  
		  	 echo stripslashes($master_data->ship_fname) . "<br>";
              echo stripslashes($master_data->ship_ads1);
			  if(strlen(trim($master_data->ship_ads2)) > 0)
              echo ", ".stripslashes($master_data->ship_ads2) . ",<br>";
              else
			  echo ",<br>";
			  echo stripslashes($master_data->ship_city).", ";              
			  echo stripslashes($master_data->ship_state).",<br>";
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->ship_country . "'");
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry . ", " . $master_data->ship_zip);  ?>.<br />
			  <?php echo "Mobile :". $master_data->ship_mobile."<br>";
			  if(strlen($master_data->ship_landline) >0)
			  echo "Landline :". $master_data->ship_landline."<br>";
			 ?>
			</td>
            <td width="20%" align="right">Billing Address:</td>
            <td width="30%" style="text-align:left;">
            <?php  
		  
		  	 echo stripslashes($master_data->bill_fname) . "<br>";
              echo stripslashes($master_data->bill_ads1);
			  if(strlen(trim($master_data->bill_ads2)) > 0)
              echo ", ".stripslashes($master_data->bill_ads2) . ",<br>";
              else
			  echo ",<br>";
			  echo stripslashes($master_data->bill_city).", ";

              echo stripslashes($master_data->bill_state).",<br>";
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->bill_country . "'");
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry . ", " . $master_data->bill_zip);?>.<br /> 
			  <?php 
			  echo "Mobile :". $master_data->bill_mobile."<br>";
			  if(strlen($master_data->bill_landline) >0)
			  echo "Landline :". $master_data->bill_landline."<br>";
			  ?>
              </font></td>
          </tr>
          </table>
          <table width="686px">
                	<tr>
                    	<th width="40%" align="left"><?php echo ITEM ?></th>
                        <th width="10%"><?php echo WEIGHT?></th>
                        <th width="15%"><?php echo UNITPRICE ?></th>
                        <th width="10%"><?php echo QUANTITY ?></th>
                        <th width="15%"><?php echo PRICECART ?></th>
                    </tr>

     
        <?php 
		if($detail_res[1] >0){
			while($ord_dets_data = mysql_fetch_object($detail_res[0])) { 
			
			$prod_res = $GLOBALS['db_con_obj']->fetch_flds("products","EnName,ChName,Image,Weight","Id='".$ord_dets_data->prod_id."'");
			$prod_data = mysql_fetch_object($prod_res[0]);
			
			
			$file_path = $prod_obj->attachment_path . $prod_data->Image;
			if(file_exists($file_path) && is_file($file_path))
		  		$disp_img = $file_path;
			else
				$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
			?>
        <tr>
                    	<td width="40%">
                        <p><img src="phpthump/phpThumb.php?src=../<?php echo $disp_img; ?>&w=76&h=60&q=95" alt="" align="left" class="border" /><strong><?php echo display_field_value($prod_data,"Name");?></strong><br />
                        </p></td>
                        <td width="10%">    <?php echo $prod_data->Weight; ?> Kg </td>
                        <td width="15%">SGD  <?php echo $ord_dets_data->prod_unit_price;
									 
									  ?>  </td>
                        <td width="10%"> <?php echo $ord_dets_data->prod_quantity?>
                        </td>
                        <td width="15%">SGD <?php  $ext_price = format_number($ord_dets_data->prod_unit_price * $ord_dets_data->prod_quantity);
									  echo $ext_price; 
									  $sub_total += $ext_price ?></td>
                    </tr>
        <?php 
		  $tot_quantity = $tot_quantity+$var['prod_quantity'];
		  }//end foreach
		}else
		  {
		  ?>
        <tr valign="center" align="left"> 
          <td colspan="5" align="center" style="text-align:center"><?php echo CARTISEMPTY;?>.</td>
        </tr>
        
        <?php 
		  
		  } 
		 ?>
          </table>
          
          <div class="total">
                    	
                  <table width="685px">
                        	<tr>
                            	<td width="50%"></td>
                                <td width="50%" style="border-bottom:1px #D4CA9A solid;">
                                
                                	<table width="352px">
                                    	<tr>
                                       	  <td width="65%" style="text-align:right">
                                            <?php echo SUBTOTAL." (".GSTINCL.")"?>:<br /><br />
                                            <?php if($master_data->ship_country !=189){?>
                                            LESS GST (<?php echo $GLOBALS['site_config']['gst_percentage']?>%):<br /><br />
                                            <?php }?>
                                            <?php echo SHIPPINGCOST?>:<br /><br />
                                            <!--<a href="#shipping-box" class="login-window"><em> <?php //echo VIEWSHIPPINGRATES ?></em></a>   -->  
                                          </td>
                                          <td width="35%" style="text-align:right; padding-right:18px"> 
                                            SGD <?php echo format_number($sub_total); ?><br /><br />
                                            <?php if($master_data->ship_country !=189){?>
                                            SGD <?php echo "-".format_number($master_data->tax_collected); ?><br /><br />
                                            <?php }?> 
                                            SGD <?php echo format_number($master_data->shipping_cost); ?>
                                          </td>
                                        </tr>
                                    </table>
                                    
                              </td>
                            </tr>
                            
                            <tr>
                            	<td width="50%">&nbsp;</td>
                                <td width="50%">
                                
                                	<table width="352px">
                                    	<tr>
                                       	  <td width="65%" style="text-align:right">
                                           <?php echo TOTALCOST ?>:   <br />
                                           <?php if($master_data->ship_country ==189){?>
                                           <span style="font-size:10px">(Inclusive of GST(<?php echo $GLOBALS['site_config']['gst_percentage']?>%) of SGD<?php echo format_number($master_data->tax_collected); ?>)</span>
                                           <?php } ?>
                                          </td>
                                          <td width="35%" style="text-align:right; padding-right:14px"> 
                                            <em>&nbsp; &nbsp; SGD <?php echo format_number($master_data->payable_amount); ?></em><br />
                                          </td>
                                        </tr>
                                    </table>
                                    
                              </td>
                            </tr>
                        </table>
                    </div>
         
      </table>

