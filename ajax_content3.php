<?php 

require_once("includes/code_header.php");

$required = $_REQUEST['required'];

$alpha = array(1 => "A", "B", "C", "D", "E", "F", "G","H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

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
			
			if($_REQUEST['selected_val'] =="add")
				$update_amount = $_REQUEST['stocks_available'] + $_REQUEST['temp_amount'];
			else
				$update_amount = $_REQUEST['stocks_available'] - $_REQUEST['temp_amount'];
				
			$update_qry = "update product_master set stocks_available='".$update_amount."' where prod_id = '".$_REQUEST['prod_id']."'";
			
			$GLOBALS['db_con_obj']->execute_sql($update_qry,"update");
				
		$order_qry = "select prod_quantity from order_details where prod_id='".$_REQUEST['prod_id']."'";
		
		$order_res = $GLOBALS['db_con_obj']->execute_sql($order_qry);
		
		while($order_data = mysql_fetch_object($order_res[0]))
			{
				$buyed = $buyed + $order_data->prod_quantity;
			}
								
		$remaining = $update_amount - $buyed;
		echo $remaining .'<input type="hidden" name="stocks_available" value="'.$update_amount.'" />';
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
			{			//$GLOBALS['site_config']['debug']=1;
				$size = $_REQUEST['size1'] ."-". $_REQUEST['size2']."-". $_REQUEST['size3'];
			
				$fetch_rec = $GLOBALS['db_con_obj']->fetch_flds("product_master","prod_id","color_code='".wrap_values($_REQUEST['color_code'])."' and size='".$size."' and model_no='".wrap_values($_REQUEST['model'])."'");
			
				if($fetch_rec[1] >0)
				{
					$result = "<table width='100%' ><tr><td colspan='2' align='center'><font class='newsletter1' >Sorry, This records already exist !</font></td></tr>
					<tr>
            <td width='26%' class='postaddcontent'><font class='whitefont'>Stock Code</font></td>
            <td width='74%' colspan='3'><input type='text' name='stock_code1' value='' disabled='disabled' style='width:120px;'/></td>
          </tr><tr><td colspan='2' align='center'><input type='hidden' name='auto_modelid' value='' /><input type='hidden' name='auto_colorid' value='' /><input type='hidden' name='auto_sizeid' value='' /><input type='hidden' name='stock_code' value=''></td></tr></table>";
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
						echo $result;
						
						}
						else
						{
						$result = "<table width='100%' ><tr><td colspan='2' align='center'><font class='newsletter1' >Available, You continue !</font></td></tr>
						<tr>
				<td width='26%' class='postaddcontent'><font class='whitefont'>Stock Code</font></td>
				<td width='74%' colspan='3'><input type='text' name='stock_code1' value='0001A1' disabled='disabled' style='width:120px;'/></td>
			  </tr><tr><td colspan='2' align='center'><input type='hidden' name='auto_modelid' value='0001' /><input type='hidden' name='auto_colorid' value='1' /><input type='hidden' name='auto_sizeid' value='1' /><input type='hidden' name='stock_code' value='0001A1' /></td></tr></table>";
						echo $result;
						}
					}
				}
				
			}
		}
		break;
		
		case "sizes":
		
			  $field_name =$_REQUEST['field_name']; 
			  $value = $_REQUEST['t_width'];
			  $field = '<input type="text" name="'.$field_name.'" value="'.$value.'" style="width:40px;" disabled="disabled"/>';
			echo $field;
			
		break;
		
		case "select_value":
			$h=0;
			$start =($_REQUEST['start_limit']+.25);
			$end = $_REQUEST['end_limit'];
			$fld_name= $_REQUEST['fld_name'];
			
		//$str="get_dynamic_dropdown('atataplus','../ajax_content3.php','required=select_value&fld_name=".$fld_name."&start_limit='+this.value+'&end_limit=".$end."')";
			$result = '<select name="'.$_REQUEST['fld_name'].'" onchange="'.$str.'" disabled>';
			
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
		case "select_value1":
			$h=0;
			$start =$_REQUEST['start_limit'];
			$end = $_REQUEST['end_limit']-.25;
			
			$fld_name= $_REQUEST['fld_name'];
			
			//$str="get_dynamic_dropdown('atataplus1','../ajax_content3.php','required=select_value1&fld_name=".$fld_name."&end_limit='+this.value+'&start_limit=".$start."')";
		
			$result = '<select name="'.$_REQUEST['fld_name'].'" onchange="'.$str.'" disabled>';
			
				for($h=$end;$h <=$end;$h=$h +.25) 	
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
		
		case "select_value2":
			$h=0;
			$start =$_REQUEST['start_limit'];
			$end = $_REQUEST['end_limit']+.25;
			
			$fld_name= $_REQUEST['fld_name'];
			
			//$str="get_dynamic_dropdown('atataplus1','../ajax_content3.php','required=select_value1&fld_name=".$fld_name."&end_limit='+this.value+'&start_limit=".$start."')";
		
			$result = '<select name="'.$_REQUEST['fld_name'].'" onchange="'.$str.'" disabled>';
			
				for($h=$end;$h <=$end;$h=$h +.25) 	
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
		
		
		
}//end switch

?>