<?php 

require_once("includes/code_header.php");

$required = $_REQUEST['required'];

//$alpha = array(1 => "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");


//echo "dsdsaddaaasdsdsd";
//exit();
switch ($required)
{

	case "state":
			
			$country_id = $_REQUEST['country_id'];
			$frm_fld_name = $_REQUEST['frm_fld_name'];
			$selected_val = $_REQUEST['selected_val'];
			
			$st_res = $db_con_obj->fetch_flds("state", "stateid,state_code,statename", "countryid='" . $country_id . "'");
			
			if($st_res[1] > 0)
			{
				if(strlen($display_fld) <= 0)
				$display_fld = "state_code";
				
				$display_cont = "";
				
				$display_cont .= "<select style='width:200px' name='" . $frm_fld_name . "' onchange=\"window.document.customer_frm.cust_state.value=this.value\">";
				$display_cont .= "<option value=''>Select a State</option>";
				
				while($st_data = mysql_fetch_object($st_res[0]))
				{
	
				$sel_txt = ($selected_val == $st_data->$display_fld)?"selected":"";
				$display_cont .= "<option value='" . $st_data->$display_fld . "' " . $sel_txt . ">" . stripslashes($st_data->statename) . "</option>";
				
				} 
				$display_cont .= "</select>";
			}
			else
			{
			$display_cont = "<input style='width:193px' type='text' name='" . $frm_fld_name . "' value='" . stripslashes($selected_val) . "' onblur=\"window.document.customer_frm.cust_state.value=this.value\">";
			}
			echo $display_cont;
		break;
	
	case "filename":
		if(strlen(trim($_REQUEST['bkname'])) > 0)
		{
			$fname = strtolower(str_replace(" ","_",$_REQUEST['bkname']));
			$flname = "book_" . date("YmdHis") . "_" . $fname . ".pdf";
		}
		else
			$flname = "Please enter your book name !!";
		echo stripslashes($flname);
		break;
	case "set_currency":
				
		     $currency_code = $_REQUEST['selected_val'];
			 if($currency_code =="RM" || $currency_code =="")
			 {
			 $msg_str = "<br><font class='newsletter1' >RM is currently not available</font>";
			 $currency_code = "USD";
			 }
			 else
			 $msg_str ="";
			 
			 $_SESSION['ses_currency_code'] = $currency_code;
			 
			 $string = "get_dynamic_dropdown('currency_fld','ajax_content4.php','required=set_currency&frm_fld_name=currency&selected_val='+this.value);";
			 
	 		 $field = "<select name='currency' class='textfield' style='width:75;' onchange=$string>";
			 $field .= "<option value='' >Select</option>";
             $sel_txt = ($currency_code == "USD")?"selected":"";
			 $field .= "<option value='USD' ".$sel_txt.">USD</option>";
			 $sel_txt1 = ($currency_code == "SGD")?"selected":"";
             $field .= "<option value='SGD' ".$sel_txt1." >SGD</option>";
         	 $field .= "<option value='RM' >RM</option></select>";
		  
		  echo $field. $msg_str ;
		break;
		
	case "set_avalible":
		 		 
		$buyed = "";
		$stocks = "select stocks_available from product_master where prod_id='".$_REQUEST['prod_id']."'";
		$stocks_res = $GLOBALS['db_con_obj']->execute_sql($stocks);
		$stocks_data = mysql_fetch_object($stocks_res[0]);
		
			if($_REQUEST['selected_val'] =="add")
				$update_amount = $stocks_data->stocks_available + $_REQUEST['temp_amount'];
			else if($_REQUEST['selected_val'] !="")
				$update_amount = $stocks_data->stocks_available - $_REQUEST['temp_amount'];
			else
			   $update_amount = $stocks_data->stocks_available;
				
			$update_qry = "update product_master set stocks_available='".$update_amount."' where prod_id = '".$_REQUEST['prod_id']."'";
			
			$GLOBALS['db_con_obj']->execute_sql($update_qry,"update");
				
		$order_qry = "select prod_quantity from order_details where prod_id='".$_REQUEST['prod_id']."'";
		
		$order_res = $GLOBALS['db_con_obj']->execute_sql($order_qry);
		
		while($order_data = mysql_fetch_object($order_res[0]))
			{
				$buyed = $buyed + $order_data->prod_quantity;
			}
		
		$remaining = $update_amount - $buyed;
		echo $remaining.'<input type="hidden" name="stocks_available" value="'.$remaining.'" />';
		break;
		
	case "check_prod":
		 		 
				
			if($_REQUEST['color_code'] =="" || $_REQUEST['size1'] =="" || $_REQUEST['size2'] ==""|| $_REQUEST['size3'] ==""|| $_REQUEST['model'] =="")
			{
				$result = "<table width='100%' ><tr><td colspan='2' align='center'><font class='newsletter1' >Sorry, Enter all fields (Marked by *) !</td></tr>
					<tr>
            <td width='26%' class='postaddcontent'><font class='whitefont'>Stock Code</font></td>
            <td width='74%' colspan='3'><input type='text' name='stock_code' value='' disabled='disabled' style='width:120px;'/></td>
          </tr></table></font>";
				echo $result;
			}
			else
			{			
				$size = $_REQUEST['size1'] ."-". $_REQUEST['size2']."-". $_REQUEST['size3'];
			
				$fetch_rec = $GLOBALS['db_con_obj']->fetch_flds("product_master","prod_id","color_code='".wrap_values($_REQUEST['color_code'])."' and size='".$size."' and model_no='".wrap_values($_REQUEST['model'])."'");
			
				if($fetch_rec[1] >0)
				{
					$result = "<table width='100%' ><tr><td colspan='2' align='center'><font class='newsletter1' >Sorry, This records already exist !</font></td></tr>
					<tr>
            <td width='26%' class='postaddcontent'><font class='whitefont'>Stock Code</font></td>
            <td width='74%' colspan='3'><input type='text' name='stock_code1' value='' disabled='disabled' style='width:120px;'/></td>
          </tr><tr><td colspan='2' align='center'><input type='hidden' name='auto_modelid' value='' /><input type='hidden' name='auto_colorid' value='' /><input type='hidden' name='auto_sizeid' value='' /><input type='hidden' name='stock_code' value=''></td></tr></table>";
		  			    $_SESSION['prod_values']['stock_code'] = '';
						$_SESSION['prod_values']['auto_modelid'] = '';
						$_SESSION['prod_values']['auto_colorid'] = '';
						$_SESSION['prod_values']['auto_sizeid'] = '';
					echo $result;
				}
				else
				{
				
				   $three_rec = $GLOBALS['db_con_obj']->fetch_flds("product_master","prod_id,auto_colorid,auto_modelid,auto_sizeid","model_no='".wrap_values($_REQUEST['model'])."' and color_code='".wrap_values($_REQUEST['color_code'])."' order by auto_modelid desc, auto_colorid desc, auto_sizeid desc limit 0,1");
				   
				   if($three_rec[1] >0)
				   { 
					
						$data = mysql_fetch_object($three_rec[0]);
						$sizeid = $data->auto_sizeid+1;
						
						$stock_code = $data->auto_modelid.$alpha[$data->auto_colorid].$sizeid;
						
						
						$result = "<table width='100%' ><tr><td colspan='2' align='center'><font class='newsletter1' >Available, You continue !</font></td></tr>
						<tr>
				<td width='26%' class='postaddcontent'><font class='whitefont'>Stock Code</font></td>
				<td width='74%' colspan='3'><input type='text' name='stock_code1' value='".$stock_code."' disabled='disabled' style='width:120px;'/></td>
			  </tr><tr><td colspan='2' align='center'><input type='hidden' name='auto_modelid' value='".$data->auto_modelid."' /><input type='hidden' name='auto_colorid' value='".$data->auto_colorid."' /><input type='hidden' name='auto_sizeid' value='".$sizeid."' /><input type='hidden' name='stock_code' value='".$stock_code."'></td></tr></table>";
			  			$_SESSION['prod_values']['stock_code'] = $stock_code;
						$_SESSION['prod_values']['auto_modelid'] = $data->auto_modelid;
						$_SESSION['prod_values']['auto_colorid'] = $data->auto_colorid;
						$_SESSION['prod_values']['auto_sizeid'] = $sizeid;
						echo $result;
					}
					else
					{
						 $two_rec = $GLOBALS['db_con_obj']->fetch_flds("product_master","prod_id,auto_colorid,auto_modelid,auto_sizeid","model_no='".wrap_values($_REQUEST['model'])."' order by auto_modelid desc, auto_colorid desc limit 0,1");
					
					  if($two_rec[1] >0)
				   	  { 
					
						$data2 = mysql_fetch_object($two_rec[0]);
						$sizeid = 1;
						$al_array = $data2->auto_colorid+1;
						
						$stock_code = $data2->auto_modelid.$alpha[$al_array].$sizeid;
						
						
						$result = "<table width='100%' ><tr><td colspan='2' align='center'><font class='newsletter1' >Available, You continue !</font></td></tr>
						<tr>
				<td width='26%' class='postaddcontent'><font class='whitefont'>Stock Code</font></td>
				<td width='74%' colspan='3'><input type='text' name='stock_code1' value='".$stock_code."' disabled='disabled' style='width:120px;'/></td>
			  </tr><tr><td colspan='2' align='center'><input type='hidden' name='auto_modelid' value='".$data2->auto_modelid."' /><input type='hidden' name='auto_colorid' value='".$al_array."' /><input type='hidden' name='auto_sizeid' value='".$sizeid."' /><input type='hidden' name='stock_code' value='".$stock_code."'></td></tr></table>";
			  			$_SESSION['prod_values']['stock_code'] = $stock_code;
						$_SESSION['prod_values']['auto_modelid'] = $data2->auto_modelid;
						$_SESSION['prod_values']['auto_colorid'] = $al_array;
						$_SESSION['prod_values']['auto_sizeid'] = $sizeid;
						echo $result;
						}
						
						else
						{
						$single_rec = $GLOBALS['db_con_obj']->fetch_flds("product_master","prod_id,auto_colorid,auto_modelid,auto_sizeid","1=1 order by auto_modelid desc limit 0,1");
					
					  if($single_rec[1] >0)
				   	  { 
					
						$data2 = mysql_fetch_object($single_rec[0]);
						$sizeid = 1;
						$model_no = $data2->auto_modelid+1;
						if(strlen($model_no)==1)						
						$stock_code = "000".$model_no.$alpha[1].$sizeid;
						else if(strlen($model_no)==2)	
						$stock_code = "00".$model_no.$alpha[1].$sizeid;
						else if(strlen($model_no)==3)	
						$stock_code = "0".$model_no.$alpha[1].$sizeid;
						else
						$stock_code = $model_no.$alpha[1].$sizeid;
						
						$model_id = substr($stock_code, 0, 4);  
						
						$result = "<table width='100%' ><tr><td colspan='2' align='center'><font class='newsletter1' >Available, You continue !</font></td></tr>
						<tr>
				<td width='26%' class='postaddcontent'><font class='whitefont'>Stock Code</font></td>
				<td width='74%' colspan='3'><input type='text' name='stock_code1' value='".$stock_code."' disabled='disabled' style='width:120px;'/></td>
			  </tr><tr><td colspan='2' align='center'><input type='hidden' name='auto_modelid' value='".$model_id."' /><input type='hidden' name='auto_colorid' value='1' /><input type='hidden' name='auto_sizeid' value='".$sizeid."' /><input type='hidden' name='stock_code' value='".$stock_code."' /></td></tr></table>";
			  			$_SESSION['prod_values']['stock_code'] = $stock_code;
						$_SESSION['prod_values']['auto_modelid'] = $model_id;
						$_SESSION['prod_values']['auto_colorid'] = 1;
						$_SESSION['prod_values']['auto_sizeid'] = $sizeid;
						echo $result;
						
						}
						else
						{
						$result = "<table width='100%' ><tr><td colspan='2' align='center'><font class='newsletter1' >Available, You continue !</font></td></tr>
						<tr>
				<td width='26%' class='postaddcontent'><font class='whitefont'>Stock Code</font></td>
				<td width='74%' colspan='3'><input type='text' name='stock_code1' value='0001A1' disabled='disabled' style='width:120px;'/></td>
			  </tr><tr><td colspan='2' align='center'><input type='hidden' name='auto_modelid' value='0001' /><input type='hidden' name='auto_colorid' value='1' /><input type='hidden' name='auto_sizeid' value='1' /><input type='hidden' name='stock_code' value='0001A1' /></td></tr></table>";
			  			$_SESSION['prod_values']['stock_code'] = '0001A1';
						$_SESSION['prod_values']['auto_modelid'] = '0001';
						$_SESSION['prod_values']['auto_colorid'] = 1;
						$_SESSION['prod_values']['auto_sizeid'] = 1;
						echo $result;
						}
					}
				}
				
			}
		}
		
		exit;
		break;
		
		case "sizes":
		
			  $field_name =$_REQUEST['field_name']; 
			  $value = $_REQUEST['t_width'];
			  $field = '<input type="text" name="'.$field_name.'" value="'.$value.'" style="width:40px;" disabled="disabled"/>';
			echo $field;
			
		break;
		
		case "atataplus":
			$h=0;
			$start =($_REQUEST['start_limit']+.25);
			$end = $_REQUEST['end_limit'];
			$result = '<select name="'.$_REQUEST['fld_name'].'" >';
			
				for($h=$start;$h <=$end;$h=$h +.25) 	
				{
				
				if($lens_obj->sph_at_pasi['value'] ==format_number($h))
					$str ="selected";
				else
					$str ="";
				$result .='<option value="'.format_number($h).'"'. $str.'>'.format_number($h).'</option>';
			} 
			$result .='</select>';
			
			echo $result;
		
		break;
		
		
	case "set_price":
			
			//print_r($_REQUEST);
			
			
			$biprice=$GLOBALS['db_con_obj']->fetch_field("bifocal","focal_price","bid='".$_REQUEST['biprice']."'");
			$multiprice=$GLOBALS['db_con_obj']->fetch_field("bifocal","focal_price","bid='".$_REQUEST['multifocal']."'");
			
			$prod_id = $_REQUEST['prod_id'];
			$lens_coating = $_REQUEST['lens_coating'];
			$lens_no = $_REQUEST['lens_no'];
			
		    $prod_price = $GLOBALS['db_con_obj']->fetch_field("product_master","price","prod_id='".$_REQUEST['prod_id']."'");
			
			
			if($lens_no!=''){
				$lens_price = $GLOBALS['db_con_obj']->fetch_field("lens_product","base_price","lens_id='".$_REQUEST['lens_no']."'");
				
				
			$right_sph = $_REQUEST['right_sph'];
			$right_cyl  = $_REQUEST['right_cyl'];
			$left_sph  = $_REQUEST['left_sph'];
			$left_cyl  = $_REQUEST['left_cyl'];
			
			$lens_type = $_REQUEST['lens_type'];
			if(isset($_REQUEST['lens_id']))
				$lens_id = $_REQUEST['lens_id'];
			else if(isset($_REQUEST['lens_no']))
				$lens_id = $_REQUEST['lens_no'];
			
			
			
			$lens_res = $GLOBALS['db_con_obj']->fetch_flds("lens_product","*","lens_id='".$lens_id."'");
			
			$lens_data = mysql_fetch_object($lens_res[0]);
			
			//print_r($lens_data);
				if($lens_data->sph_atat_naga <=$right_sph && $lens_data->sph_at_naga >$right_sph)
					$price2 = $lens_data->sph_atat_naga_price;
				else if($lens_data->sph_at_naga <=$right_sph && $lens_data->sph_base_negative > $right_sph)
					$price2 = $lens_data->sph_at_naga_price;
				else if($lens_data->sph_base_pasitive >=$right_sph)
					$price2 = 0;
				else if($lens_data->sph_at_pasi >=$right_sph)
					$price2 = $lens_data->sph_at_pasi_price;
				else if($lens_data->sph_atat_pasi >=$right_sph)
					$price2 = $lens_data->sph_atat_pasi_price;
					
				//echo $price2;	
				//echo $right_sph;	
				
				if($lens_data->cyl_atat_naga <=$right_cyl  && $lens_data->cyl_at_naga >$right_cyl)
					$price3 = $lens_data->cyl_atat_naga_price;
				else if($lens_data->cyl_at_naga <=$right_cyl && $lens_data->cyl_base_negative >$right_cyl)
					$price3 = $lens_data->cyl_at_naga_price;
				else if($lens_data->cyl_base_pasitive >=$right_cyl)
					$price3 = 0;	
				else if($lens_data->cyl_at_pasi >=$right_cyl)
					$price3 = $lens_data->cyl_at_pasi_price;
				else if($lens_data->cyl_atat_pasi >=$right_cyl)
					$price3 = $lens_data->cyl_atat_pasi_price;
				
				
				
				if($price2 >$price3)
					$price4 = $price2;
				else
					$price4 = $price3;
			
				if($lens_data->sph_atat_naga <=$left_sph && $lens_data->sph_at_naga >$left_sph)
					$price6 = $lens_data->sph_atat_naga_price;
				else if($lens_data->sph_at_naga <=$left_sph && $lens_data->sph_base_negative > $left_sph)
					$price6 = $lens_data->sph_at_naga_price;
				else if($lens_data->sph_base_pasitive >=$left_sph)
					$price6 = 0;
				else if($lens_data->sph_at_pasi >=$left_sph)
					$price6 = $lens_data->sph_at_pasi_price;
				else if($lens_data->sph_atat_pasi >=$left_sph)
					$price6 = $lens_data->sph_atat_pasi_price;
					
				
				
				 if($lens_data->cyl_atat_naga <=$left_cyl && $lens_data->cyl_at_naga >$left_cyl)
					$price7 = $lens_data->cyl_atat_naga_price;
				else if($lens_data->cyl_at_naga <=$left_cyl && $lens_data->cyl_base_negative >$left_cyl)
					$price7 = $lens_data->cyl_at_naga_price;
				else if($lens_data->cyl_base_pasitive >=$left_cyl)
					$price7 = 0;	
				else if($lens_data->cyl_at_pasi >=$left_cyl)
					$price7 = $lens_data->cyl_at_pasi_price;
				else if($lens_data->cyl_atat_pasi >=$left_cyl)
					$price7 = $lens_data->cyl_atat_pasi_price;
			
				
				if($price6 >$price7)
					$price8 = $price6;
				else
					$price8 = $price7;
					
					
				$lens_price = $lens_price+$price8+$price4;
				
				
			}
			
		
			$result = $biprice + $multiprice + $prod_price + $lens_price + $lens_coating; 
			$current_price = $result;
			$result ="US$ ".format_number($result);
			$result .='<input type="hidden" name="price" value="'.$current_price.'"> <input type="hidden" name="current_price" value="'.$current_price.'">';
			
			
			$_SESSION['ses_product']['price'] = $current_price;
			echo $result;
			
		break;	
		case 'set_bifocal':
			//$bid=$_REQUEST['bid'];		
			
			$biprice=$GLOBALS['db_con_obj']->fetch_field("bifocal","focal_price","bid='".$_REQUEST['biprice']."'");
			
			$multiprice=$GLOBALS['db_con_obj']->fetch_field("bifocal","focal_price","bid='".$_REQUEST['multifocal']."'");
			
			$prod_id = $_REQUEST['prod_id'];
			$lens_coating = $_REQUEST['lens_coating'];
			$lens_no = $_REQUEST['lens_no'];
			
			$prod_price = $GLOBALS['db_con_obj']->fetch_field("product_master","price","prod_id='".$_REQUEST['prod_id']."'");
			
			if($lens_no!=''){
				$lens_price = $GLOBALS['db_con_obj']->fetch_field("lens_product","base_price","lens_id='".$_REQUEST['lens_no']."'");
				
				
			$right_sph = $_REQUEST['right_sph'];
			$right_cyl  = $_REQUEST['right_cyl'];
			$left_sph  = $_REQUEST['left_sph'];
			$left_cyl  = $_REQUEST['left_cyl'];
			
			$lens_type = $_REQUEST['lens_type'];
			if(isset($_REQUEST['lens_id']))
				$lens_id = $_REQUEST['lens_id'];
			else if(isset($_REQUEST['lens_no']))
				$lens_id = $_REQUEST['lens_no'];
			
			
			
			$lens_res = $GLOBALS['db_con_obj']->fetch_flds("lens_product","*","lens_id='".$lens_id."'");
			
			$lens_data = mysql_fetch_object($lens_res[0]);
			
				if($lens_data->sph_atat_naga <=$right_sph && $lens_data->sph_at_naga >$right_sph)
					$price2 = $lens_data->sph_atat_naga_price;
				else if($lens_data->sph_at_naga <=$right_sph && $lens_data->sph_base_negative > $right_sph)
					$price2 = $lens_data->sph_at_naga_price;
				else if($lens_data->sph_base_pasitive >=$right_sph)
					$price2 = 0;
				else if($lens_data->sph_at_pasi >=$right_sph)
					$price2 = $lens_data->sph_at_pasi_price;
				else if($lens_data->sph_atat_pasi >=$right_sph)
					$price2 = $lens_data->sph_atat_pasi_price;
					
				//echo $price2;	
				//echo $right_sph;	
				
				if($lens_data->cyl_atat_naga <=$right_cyl  && $lens_data->cyl_at_naga >$right_cyl)
					$price3 = $lens_data->cyl_atat_naga_price;
				else if($lens_data->cyl_at_naga <=$right_cyl && $lens_data->cyl_base_negative >$right_cyl)
					$price3 = $lens_data->cyl_at_naga_price;
				else if($lens_data->cyl_base_pasitive >=$right_cyl)
					$price3 = 0;	
				else if($lens_data->cyl_at_pasi >=$right_cyl)
					$price3 = $lens_data->cyl_at_pasi_price;
				else if($lens_data->cyl_atat_pasi >=$right_cyl)
					$price3 = $lens_data->cyl_atat_pasi_price;
				
				
				
				if($price2 >$price3)
					$price4 = $price2;
				else
					$price4 = $price3;
			
				if($lens_data->sph_atat_naga <=$left_sph && $lens_data->sph_at_naga >$left_sph)
					$price6 = $lens_data->sph_atat_naga_price;
				else if($lens_data->sph_at_naga <=$left_sph && $lens_data->sph_base_negative > $left_sph)
					$price6 = $lens_data->sph_at_naga_price;
				else if($lens_data->sph_base_pasitive >=$left_sph)
					$price6 = 0;
				else if($lens_data->sph_at_pasi >=$left_sph)
					$price6 = $lens_data->sph_at_pasi_price;
				else if($lens_data->sph_atat_pasi >=$left_sph)
					$price6 = $lens_data->sph_atat_pasi_price;
					
				
				
				 if($lens_data->cyl_atat_naga <=$left_cyl && $lens_data->cyl_at_naga >$left_cyl)
					$price7 = $lens_data->cyl_atat_naga_price;
				else if($lens_data->cyl_at_naga <=$left_cyl && $lens_data->cyl_base_negative >$left_cyl)
					$price7 = $lens_data->cyl_at_naga_price;
				else if($lens_data->cyl_base_pasitive >=$left_cyl)
					$price7 = 0;	
				else if($lens_data->cyl_at_pasi >=$left_cyl)
					$price7 = $lens_data->cyl_at_pasi_price;
				else if($lens_data->cyl_atat_pasi >=$left_cyl)
					$price7 = $lens_data->cyl_atat_pasi_price;
			
				
				if($price6 >$price7)
					$price8 = $price6;
				else
					$price8 = $price7;
					
					
				$lens_price = $lens_price+$price8+$price4;
				
				
			}
	
			$result = $biprice +$multiprice + $prod_price + $lens_price + $lens_coating; 
			
			$current_price = $result;
			
			$result ="US$ ".format_number($current_price);
			$result .='<input type="hidden" name="price" value="'.$current_price.'"> <input type="hidden" name="current_price" value="'.$current_price.'">';
						
			$_SESSION['ses_product']['price'] = $current_price;
		echo $result;
		break;
		
		case 'set_lenscoat':
			
			
					
			$biprice=$GLOBALS['db_con_obj']->fetch_field("bifocal","focal_price","bid='".$_REQUEST['biprice']."'");
			
			$multiprice=$GLOBALS['db_con_obj']->fetch_field("bifocal","focal_price","bid='".$_REQUEST['multifocal']."'");
			
			$prod_id = $_REQUEST['prod_id'];
			$lens_coating = $_REQUEST['lens_coating'];
			$lens_no = $_REQUEST['lens_no'];
			
			$prod_price = $GLOBALS['db_con_obj']->fetch_field("product_master","price","prod_id='".$_REQUEST['prod_id']."'");
			
			if($lens_no!=''){
				$lens_price = $GLOBALS['db_con_obj']->fetch_field("lens_product","base_price","lens_id='".$_REQUEST['lens_no']."'");
				
				
			$right_sph = $_REQUEST['right_sph'];
			$right_cyl  = $_REQUEST['right_cyl'];
			$left_sph  = $_REQUEST['left_sph'];
			$left_cyl  = $_REQUEST['left_cyl'];
			
			$lens_type = $_REQUEST['lens_type'];
			
			if(isset($_REQUEST['lens_id']))
				$lens_id = $_REQUEST['lens_id'];
			else if(isset($_REQUEST['lens_no']))
				$lens_id = $_REQUEST['lens_no'];
			
			$lens_res = $GLOBALS['db_con_obj']->fetch_flds("lens_product","*","lens_id='".$lens_id."'");
			
			$lens_data = mysql_fetch_object($lens_res[0]);
			
				if($lens_data->sph_atat_naga <=$right_sph && $lens_data->sph_at_naga >$right_sph)
					$price2 = $lens_data->sph_atat_naga_price;
				else if($lens_data->sph_at_naga <=$right_sph && $lens_data->sph_base_negative > $right_sph)
					$price2 = $lens_data->sph_at_naga_price;
				else if($lens_data->sph_base_pasitive >=$right_sph)
					$price2 = 0;
				else if($lens_data->sph_at_pasi >=$right_sph)
					$price2 = $lens_data->sph_at_pasi_price;
				else if($lens_data->sph_atat_pasi >=$right_sph)
					$price2 = $lens_data->sph_atat_pasi_price;
					
				//echo $price2;	
				//echo $right_sph;	
				
				if($lens_data->cyl_atat_naga <=$right_cyl  && $lens_data->cyl_at_naga >$right_cyl)
					$price3 = $lens_data->cyl_atat_naga_price;
				else if($lens_data->cyl_at_naga <=$right_cyl && $lens_data->cyl_base_negative >$right_cyl)
					$price3 = $lens_data->cyl_at_naga_price;
				else if($lens_data->cyl_base_pasitive >=$right_cyl)
					$price3 = 0;	
				else if($lens_data->cyl_at_pasi >=$right_cyl)
					$price3 = $lens_data->cyl_at_pasi_price;
				else if($lens_data->cyl_atat_pasi >=$right_cyl)
					$price3 = $lens_data->cyl_atat_pasi_price;
				
				
				
				if($price2 >$price3)
					$price4 = $price2;
				else
					$price4 = $price3;
			
				if($lens_data->sph_atat_naga <=$left_sph && $lens_data->sph_at_naga >$left_sph)
					$price6 = $lens_data->sph_atat_naga_price;
				else if($lens_data->sph_at_naga <=$left_sph && $lens_data->sph_base_negative > $left_sph)
					$price6 = $lens_data->sph_at_naga_price;
				else if($lens_data->sph_base_pasitive >=$left_sph)
					$price6 = 0;
				else if($lens_data->sph_at_pasi >=$left_sph)
					$price6 = $lens_data->sph_at_pasi_price;
				else if($lens_data->sph_atat_pasi >=$left_sph)
					$price6 = $lens_data->sph_atat_pasi_price;
					
				
				
				 if($lens_data->cyl_atat_naga <=$left_cyl && $lens_data->cyl_at_naga >$left_cyl)
					$price7 = $lens_data->cyl_atat_naga_price;
				else if($lens_data->cyl_at_naga <=$left_cyl && $lens_data->cyl_base_negative >$left_cyl)
					$price7 = $lens_data->cyl_at_naga_price;
				else if($lens_data->cyl_base_pasitive >=$left_cyl)
					$price7 = 0;	
				else if($lens_data->cyl_at_pasi >=$left_cyl)
					$price7 = $lens_data->cyl_at_pasi_price;
				else if($lens_data->cyl_atat_pasi >=$left_cyl)
					$price7 = $lens_data->cyl_atat_pasi_price;
			
				
				if($price6 >$price7)
					$price8 = $price6;
				else
					$price8 = $price7;
					
					
				$lens_price = $lens_price+$price8+$price4;
				
				
			}
	
			$result = $biprice + $prod_price + $lens_price + $lens_coating +$multiprice; 
			
			$current_price = $result;

			$result ="US$ ".format_number($result);
			
			$result .='<input type="hidden" name="price" value="'.$current_price.'"> <input type="hidden" name="current_price" value="'.$current_price.'">';
			
			$_SESSION['ses_product']['price'] = $current_price;
						
		echo $result;
		break;
		
	case 'lens_number':
		$lens_type = $_REQUEST['lens_type'];
		$lens_res = $GLOBALS['db_con_obj']->fetch_flds("lens_product","lens_id,lens_no","lenstype_id='".$lens_type."' and prod_status=1");
		
		$first = '<select name="lens_no" class="" onchange="submit_frm();">
		<option value="">Select Number</option>';
		$last ='</select>';
		
		while($lens_data=mysql_fetch_object($lens_res[0])){
		   $options .='<option value="'.$lens_data->lens_id.'">'.$lens_data->lens_no.'</option>';
		}
		$result = $first.$options.$last;
		echo $result;
	break;
}//end switch

?>