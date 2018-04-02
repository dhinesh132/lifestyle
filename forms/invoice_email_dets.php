<?php 

$table_class = "border:1px #efead4 solid;";
$class_bottom_border= "font-size:13px; font-family:'DINNextLTPro-Light'; color:#807b5f; line-height:16px; border-bottom:1px #efead4 solid;  padding:10px 0 10px 5px; text-align:left; vertical-align:top;";
$class_only_font= "padding:10px 0 10px 0; text-align:center; vertical-align:top;font-size:13px; font-family:'DINNextLTPro-Light'; color:#807b5f; line-height:16px;";

$email_str ='<table width="680px" border="0" cellspacing="0" cellpadding="4" style="'.$table_class.'">

         <tr><th width="100%" align="center" colspan="4" style="'.$class_only_font.'">Tax Invoice</th></tr>         
         <tr> 
        
          <tr> 

            <td align="left" width="20%" valign="top" style="'.$class_bottom_border.'"><img src="'.$GLOBALS['site_config']['site_path'].'invoice/eof.png" width="100px" /></td>

            <td width="40%" valign="top" align="left" style="'.$class_bottom_border.'">'; 
		  
		  	 $email_str .= trim(stripslashes($GLOBALS['site_config']['company_name'])) . "<br>";
			   $email_str .= nl2br(stripslashes($GLOBALS['site_config']['company_address'])) . "<br>";
			   if($master_data->ship_country ==189){
				  $email_str .= "GST REG ".nl2br(stripslashes($GLOBALS['site_config']['gst_reg_no'])) . "<br>"; 
			  }
			  $email_str .='</td>';

            $email_str .='<td nowrap width="20%" align="right" valign="top" style="'.$class_bottom_border.'">Invoice Details :</td>

            <td width="30%" valign="top" style="'.$class_bottom_border.'" nowrap>';
		  if(strlen($ordnum) <4){
			$len = strlen($ordnum)+1;
			for($i=$len; $i<=4;$i++){
				$str .= "0";
			}
			}
			else
			$str='';
			$barcodeval = $str.$ordnum;

			$barcodeval = date("Ymd",strtotime($master_data->date_entered)).$barcodeval;
		   $email_str .= "ID: ".$barcodeval.'<br>'; 
           $email_str .= "Date: ".convert_date($master_data->date_entered).'<br>'; 
             
			switch($master_data->order_status)
			{
			
				case 0:
					$email_str .="Status: Not Paid";
					break;
				
				case 1:
					$email_str .= "Status: Paid, Shipment Pending";
					break;
				
				case 2:
					$email_str .= "Status: Shipped";
					break;
				
			};
			$email_str .='</td>

          </tr>

         
          <tr valign="top"> 
            <td align="left" style="'.$class_bottom_border.'">Ship To:</td>';
            $email_str .='<td style="'.$class_bottom_border.'" >'; 
		  
		  	 $email_str .= stripslashes($master_data->ship_fname) . "<br>";
              $email_str .= stripslashes($master_data->ship_ads1);
			  if(strlen(trim($master_data->ship_ads2)) > 0)
              $email_str .= ", ".stripslashes($master_data->ship_ads2) . ",<br>";
              else
			 $email_str .= ",<br>";
			 
			  if(strlen(trim($master_data->ship_unit)) > 0)
			  $email_str .= stripslashes($master_data->ship_unit) . ", ";
			  if(strlen(trim($master_data->ship_building)) > 0)
              	$email_str .= stripslashes($master_data->ship_building) . ",<br>";
              else
			  $email_str .= ",<br>";
			  
			  $email_str .= stripslashes($master_data->ship_city);

              $email_str .= ", " . stripslashes($master_data->ship_state) . ",<br>";
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->ship_country . "'");
			  if(strlen($bctry) > 0)
			  $email_str .= stripslashes($bctry . ", " . $master_data->ship_zip).'.<br>';
			  
			   $email_str .='Mobile :'. $master_data->ship_mobile.'<br>';
			  if(strlen($master_data->bill_landline) >0){
			  	$email_str .='Landline :'. $master_data->ship_landline.'<br>';
			  }
			  
			  $email_str .='</td>';
			  
			  
			$email_str .='</td>
            <td width="20%" align="right" style="'.$class_bottom_border.'">Billing Address:</td>
            <td width="30%"  style="'.$class_bottom_border.'">';
			
			$email_str .=stripslashes($master_data->bill_fname) . "<br>";
              $email_str .=stripslashes($master_data->bill_ads1);
			  if(strlen(trim($master_data->bill_ads2)) > 0)
              $email_str .=", ".stripslashes($master_data->bill_ads2) . ",<br>";
              else
			  $email_str .= ",<br>";
			  
			   if(strlen(trim($master_data->bill_unit)) > 0)
			    $email_str .= stripslashes($master_data->bill_unit) . ", ";
			  if(strlen(trim($master_data->bill_building)) > 0)
              	 $email_str .= stripslashes($master_data->bill_building) . ",<br>";
              else
			   $email_str .= ",<br>";
			  
			 $email_str .= stripslashes($master_data->bill_city)." ";

			 $email_str .= ", " . stripslashes($master_data->bill_state) . ",<br>";
			
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->bill_country . "'");
			  if(strlen($bctry) > 0)
			  $email_str .= stripslashes($bctry . ", " . $master_data->bill_zip).'.<br>';
			  
			  $email_str .='Mobile :'. $master_data->bill_mobile.'<br>';
			  if(strlen($master_data->bill_landline) >0){
			  	$email_str .='Landline :'. $master_data->bill_landline.'<br>';
			  }
			   
			  
              $email_str .='</font></td>
          </tr>
          </table>';
		  
		 
          $email_str .='<table width="710px" style="'.$table_class.'">
                	<tr>
                    	<th width="50%" align="left" style="'.$class_only_font.'">'.ITEM.'</th>
                        <th width="10%" style="'.$class_only_font.'">'.WEIGHT.'</th>
                        <th width="15%" style="'.$class_only_font.'">'.UNITPRICE.'</th>
                        <th width="10%" style="'.$class_only_font.'">'.QUANTITY.'</th>
                        <th width="15%" style="'.$class_only_font.'">'.PRICECART.'</th>
                    </tr>';

     
        
		if($detail_res[1] >0){
			while($ord_dets_data = mysql_fetch_object($detail_res[0])) { 
			
			$prod_res = $GLOBALS['db_con_obj']->fetch_flds("products","EnName,ChName,Image,Weight,ProdCode","Id='".$ord_dets_data->prod_id."'");
			$prod_data = mysql_fetch_object($prod_res[0]);
			
			
			$file_path = $prod_obj->attachment_path . $prod_data->Image;
			if(file_exists($file_path) && is_file($file_path))
		  		$disp_img = $file_path;
			else
				$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
			
        $email_str .='<tr>
                    	<td width="50%" style="'.$class_only_font.'">
                        <p><strong>'. display_field_value($prod_data,"Name").'</strong><br />';
						
						if($ord_dets_data->size >0) {
						 $siz_res = $GLOBALS['db_con_obj']->fetch_flds('product_sizes','EnTitle,prod_code','Id ='.$ord_dets_data->size);
							 $siz_data = mysql_fetch_object($siz_res[0]);							 
							 $email_str .="<div>Size: ".$siz_data->EnTitle." (".$siz_data->prod_code.")</div>";
						}
						if($ord_dets_data->colour >0) {
							  $email_str .="<div>Colour : ".$GLOBALS['db_con_obj']->fetch_field('product_colours','EnTitle','Id ='.$ord_dets_data->colour)."</div>"; 
						}
						 
                    $email_str .='</p></td>
                        <td width="10%" style="'.$class_only_font.'">'.$prod_data->Weight.' Kg </td>
                        <td width="15%" style="'.$class_only_font.'">SGD  '.$ord_dets_data->prod_unit_price.'</td>
                        <td width="10%" style="'.$class_only_font.'">'.$ord_dets_data->prod_quantity.'
                        </td>
                        <td width="15%" style="'.$class_only_font.'">SGD ';
						  $ext_price = format_number($ord_dets_data->prod_unit_price * $ord_dets_data->prod_quantity);
									 $email_str .= $ext_price; 
									  $sub_total += $ext_price;
									  
									  $email_str .='</td>
                    </tr>';
       
		  $tot_quantity = $tot_quantity+$var['prod_quantity'];
		  }//end foreach
		}else
		  {
		 
         $email_str .='<tr valign="center" align="left"> 
          <td colspan="5" align="center" style="text-align:center;'.$class_only_font.'" >'. CARTISEMPTY.'</td>
        </tr>';
		  
		  } 
          $email_str .='</table>';
          
          $email_str .='<div class="total">
                    	
                  <table width="710px">
                        	<tr>
                            	<td width="50%"></td>
                                <td width="50%" style="border-bottom:1px #D4CA9A solid;">
                                
                                	<table width="342px">
                                    	<tr>
                                       	  <td width="75%" style="'.$class_only_font.'">'. SUBTOTAL." (".GSTINCL.")".':<br /><br />';
										  if($master_data->ship_country !=189){
											  $email_str .='LESS GST ('.$GLOBALS['site_config']['gst_percentage'].'%):<br /><br />';  
										  }
                                            $email_str .=SHIPPINGCOST.':<br /><br />  
                                          </td>
                                          <td width="25%" style="'.$class_only_font.'"> 
                                            SGD '.format_number($sub_total).'<br /><br />';
											if($master_data->ship_country !=189){
												$email_str .='SGD -'.format_number($master_data->tax_collected).'<br /><br />';
											}
											
											$email_str .='SGD '.format_number($master_data->shipping_cost).'
                                          </td>
                                        </tr>
                                    </table>
                              </td>
                            </tr>';
                            
                            $email_str .='<tr>
                            	<td width="50%">&nbsp;</td>
                                <td width="50%">
                                
                                	<table width="342px">
                                    	<tr>
                                       	  <td width="65%" style="'.$class_only_font.'">
                                           '. TOTALCOST.':   <br />';
										  if($master_data->ship_country ==189){
											  $email_str .='<span style="font-size:10px">(Inclusive of GST('.$GLOBALS['site_config']['gst_percentage'].'%) of SGD'.$master_data->tax_collected.')</span> ';
										   }
                                          $email_str .='</td>
                                          <td width="35%" style="'.$class_only_font.'"> 
                                            <em>&nbsp; &nbsp; SGD '. format_number($master_data->payable_amount).'</em><br />
                                          </td>
                                        </tr>
                                    </table>
                                    
                              </td>
                            </tr>
                        </table>
                    </div>
         
      </table>';
	  
	  
	  $email_string = $email_str;
	  
	  //exit;
	  
	  ?>