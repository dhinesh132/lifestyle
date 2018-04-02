<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">

function popup_window_new(url, h, w, sb, rz, stb)
{
	
	if(h <= 0)
	h=200;
	
	if(w <= 0)
	w=200;
	
	if(sb.length <= 0)
	sb='yes';
	
	if(rz.length <= 0)
	rz='yes';
	
	if(stb.length <= 0)
	rz='yes';
	
	var params = 'height=' + h + ',width=' + w + ',scrollbars=' + sb + ',resizable=' + rz + ',left=50,top=50,status=' + stb;
	 
	window.open(url,'',params);
	
}
var chk_discount = 0;
function check_validate() 
{

	error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";
	check_empty(form.elements["model_no"].name,"Model number should not be empty !");
	check_empty(form.elements["color_code"].name,"Color code should not be empty !");
	if(form.size1.value =="" || form.size2.value =="" || form.size3.value =="")
	{
		err=1;
		error_message +="* Please give appropriate sizes in three fields !\n";
	}
	
	
	var color_process = 0;
	for(i=0; i < form.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(form.elements[i].name == "color[]")
		{
			if(form.elements[i].checked == true)
			{
				color_process = 1;
				break;
			}
		}
	}
	
	if(color_process == 0)
	{
		err=1;
		error_message +="* Select atleast one color for product !\n";
	}
	
	var gender_process = 0;
	for(i=0; i < form.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(form.elements[i].name == "gender[]")
		{
			if(form.elements[i].checked == true)
			{
				gender_process = 1;
				break;
			}
		}
	}
	
	if(gender_process == 0)
	{
		err=1;
		error_message +="* Select atleast one gender for product !\n";
	}
	var material_process = 0;
	for(i=0; i < form.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(form.elements[i].name == "material[]")
		{
			if(form.elements[i].checked == true)
			{
				material_process = 1;
				break;
			}
		}
	}
	
	if(material_process == 0)
	{
		err=1;
		error_message +="* Select atleast one material for product !\n";
	}
	
	
	check_empty(form.elements["frame_type"].name,"Select frame type !");
	check_empty(form.elements["price"].name,"Enter our price of the book!");
	check_empty(form.elements["stocks_available"].name,"Enter stocks available of the product!");
	//check_empty(form.elements["prod_weight"].name,"Enter weight of the product!");
	
	}


</script>
<style type="text/css">
.lengthy_txtfld
{
	width: 150px;
}
</style>
<?php 

$hid_action = "save";

if($edit == 1 && $edit_id > 0)
{
	
	$res = $prod_obj->fetch_record($edit_id);
	$prod_obj = set_values($prod_obj, "db", $res[0]);
	
	$size = explode("-",$prod_obj->size['value']);
		$size1 = $size[0];
		$size2 = $size[1];
		$size3 = $size[2];
	
$measurments= explode("-",$prod_obj->measurments['value']);

$color = explode(",",$prod_obj->color_id['value']);	

$gender = explode(",",$prod_obj->gen_id['value']);	

$material = explode(",",$prod_obj->mat_id['value']);	

}


else if(isset($_SESSION['ses_temp_product_obj']) && is_array($_SESSION['ses_temp_product_obj']))
{

$res = $prod_obj->fetch_record($_SESSION['ses_temp_product_obj']['prod_id']);
	$prod_obj = set_values($prod_obj, "db", $res[0]);
	
	$size = explode("-",$prod_obj->size['value']);
		$size1 = $size[0];
		$size2 = $size[1];
		$size3 = $size[2];
	
$measurments= explode("-",$prod_obj->measurments['value']);

$gender = explode(",",$prod_obj->gen_id['value']);	

$material = explode(",",$prod_obj->mat_id['value']);	

 if($_SESSION['ses_temp_product_obj']['submit_action']=="model_color")
{
$prod_obj->stock_code['value'] ="";
$size1 = "";
		$size2 = "";
		$size3 = "";
		$color = explode(",",$prod_obj->color_id['value']);	
}
if($_SESSION['ses_temp_product_obj']['submit_action']=="size")
{
//echo "hai";
$prod_obj->color_code['value'] ="";
$prod_obj->stock_code['value'] ="";

}
	$prod_obj->prod_id['value']="";
	/*$prod_obj = set_values($prod_obj,"ses",$_SESSION['ses_temp_product_obj']);
	
	$size = explode("-",$prod_obj->size['value']);
		$size1 = $size[0];
		$size2 = $size[1];
		$size3 = $size[2];
	
	
	
	if(isset($_SESSION['ses_temp_product_obj']['size1']))
		$size1 =$_SESSION['ses_temp_product_obj']['size1'];
	if(isset($_SESSION['ses_temp_product_obj']['size2']))
		$size2 =$_SESSION['ses_temp_product_obj']['size2'];
	 if(isset($_SESSION['ses_temp_product_obj']['size3']))
		$size3 =$_SESSION['ses_temp_product_obj']['size3'];*/
}
//print_r($_SESSION['ses_temp_product_obj']);
if($prod_obj->prod_id['value'] >0)
$dis_str = "readonly";
?>

<table width="85%" border="0" cellspacing="0" cellpadding="2" align="center">
  <form action="" method="post" enctype="multipart/form-data" name="<?php echo $prod_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $prod_obj->frm_name; ?>);">
<?php

//echo $prod_obj->frame_validation_script();

?>
    <tr> 
      <td>

<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr class="maincontentheading"> 
            <td height="29" colspan="4" align='center' class='whitefont_header'> 
              <?php echo "Products Details"; ?></td>
          </tr>
          <tr valign="top">
            <td class="postaddcontent"><span class="whitefont">Model No</span><span class="starcolor">*</span></td>
            <td><input type="text" name="model_no" value="<?php echo stripslashes($prod_obj->model_no['value']); ?>" maxlength="200" class="lengthy_txtfld" <?php echo $dis_str ;?>>            </td>
            <td width="15%" align="center"><span class="whitefont">Brand</span></td>
            <td width="40%"><input type="text" name="brand" value="<?php echo stripslashes($prod_obj->brand['value']); ?>" maxlength="200" class="lengthy_txtfld" ></td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td><span class="whitefont">Color Code</span><span class="starcolor">*</span></td>
            <td colspan="3"><input type="text" name="color_code" value="<?php echo stripslashes($prod_obj->color_code['value']); ?>" maxlength="200" class="lengthy_txtfld" <?php echo $dis_str ;?>/>            </td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td><span class="whitefont">Sizes</span><span class="starcolor">*</span></td>
            <td><input type="text" name="size1" value="<?php echo stripslashes($size1); ?>" style="width:40px;" onfocus="set_values1();" onblur="set_values1();" onkeypress="set_values1();" onmouseout="set_values1();" <?php echo $dis_str ;?>/>&nbsp;-&nbsp;<input type="text" name="size2" value="<?php echo stripslashes($size2); ?>" style="width:40px;" onfocus="set_values2();" onblur="set_values2();" onkeypress="set_values2();" onmouseout="set_values2();" <?php echo $dis_str ;?>/>&nbsp;-&nbsp;<input type="text" name="size3" value="<?php echo stripslashes($size3); ?>" style="width:42px;" onfocus="set_values3();" onblur="set_values3();" onkeypress="set_values3();" onmouseout="set_values3();" <?php echo $dis_str ;?>/>            </td>
            <td align="center"><img src="../images/check.jpg" style="border:0px;" onclick="get_dynamic_dropdown('check_status','../ajax_content7.php','required=check_prod&model='+window.document.<?php echo $prod_obj->frm_name; ?>.model_no.value+'&size1='+window.document.<?php echo $prod_obj->frm_name; ?>.size1.value+'&size2='+window.document.<?php echo $prod_obj->frm_name; ?>.size2.value+'&size3='+window.document.<?php echo $prod_obj->frm_name; ?>.size3.value+'&color_code='+window.document.<?php echo $prod_obj->frm_name; ?>.color_code.value);"/></td>
            <td></td>
          </tr>
          <tr valign="top">
            <td colspan="4" class="postaddcontent"><hr style="height:2px;" color="#666666"/></td>
          </tr>
          <tr valign="top">
          <td colspan="4"><span id="check_status">
            <table width="100%">
          <tr>
            <td width="26%" class="postaddcontent"><font class="whitefont">Stock Code</font></td>
            <td width="74%" colspan="3"><input type="text" name="stock_code" value="<?php echo stripslashes($prod_obj->stock_code['value']); ?>" readonly=""  style="width:120px;"/></td>
          </tr>
          </table></span></td></tr>
          <tr valign="top"> 
            <td width="27%" class="postaddcontent"><span class="whitefont">Frame Type</span><span class="starcolor">*</span></td>
            <td><?php
				  
				  $frame_dd_name = "frame_type";
				  
				  $select_option = $prod_obj->frame_type['value'];
				  
				  $frma_default_selection = false;
				
				  
				  if(file_exists("../includes/frame_dropdown.php"))
				  
				  	require_once("../includes/frame_dropdown.php");
					
				else
				
				  	require_once("includes/frame_dropdown.php");
				  
				  ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td><span class="whitefont">Color</span><span class="starcolor">*</span><br /><span class="starcolor">Must select at least 1.(Max.3)</span></td>
            <td colspan="3" align="left"><?php require_once("../forms/admin/color_list_frm.php");?></td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td colspan="4" height="5px"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Gender/Style</span><span class="starcolor">*</span><br /><span class="starcolor">Must select at least 1.(Max.3)</span></td>
            <td colspan="3" align="left"><?php require_once("../forms/admin/gender_list_frm.php");?></td>
          </tr>
           <tr valign="top" class="postaddcontent">
            <td colspan="4" height="5px">&nbsp;</td>
          </tr>
          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont">Material</span><span class="starcolor">*</span><br /><span class="starcolor">Must select at least 1.(Max.5)</span></td>
            <td colspan="3" align="left"><?php require_once("../forms/admin/material_list_frm.php");?></td>
          </tr>

          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont">Spring Loaded</span><span class="starcolor">*</span></td>
            <td colspan="3"><input type="radio" name="sprin_loaded" class="checkbox_cls" value="1" <?php echo($prod_obj->sprin_loaded['value'] !=0)?"checked":"";?>/>&nbsp;<span class="whitefont">YES</span>&nbsp;&nbsp;&nbsp;<input class="checkbox_cls" type="radio" name="sprin_loaded" value="0" <?php echo($prod_obj->sprin_loaded['value'] ==0)?"checked":"";?>/>&nbsp;<span class="whitefont">NO</span></td>
          </tr>
          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont">Measurements(mm)</span><span class="starcolor">*</span></td>
            <td colspan="3"><table width="85%" align="left">
            <tr>
              <td colspan="6" height="4px;">&nbsp;</td>
              </tr>
            <tr>
              <td width="15%" align="center"><span class="whitefont">Total Width</span></td>
              <td width="16%" align="center"><span class="whitefont">Lens Depth</span></td>
              <td width="17%" align="center"><span class="whitefont">Diameter</span></td>
              <td width="19%" align="center"><span class="whitefont">Bridge Distance</span></td>
              <td align="center"><span class="whitefont">Arm Length</span></td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6" height="4px;">&nbsp;</td>
              </tr>
            <tr><td align="center"><input type="text" name="t_width" value="<?php echo stripslashes($measurments[0]); ?>" style="width:40px;" /></td>
              <td align="center"><input type="text" name="l_depth" value="<?php echo stripslashes($measurments[1]); ?>" style="width:40px;" /></td>
              <td align="center"><span id="dia"><input type="text" name="dia" value="<?php echo stripslashes($size1); ?>" style="width:40px;" readonly /></span></td>
              <td align="center"><span id="b_dist"><input type="text" name="b_dist" value="<?php echo stripslashes($size2); ?>" style="width:40px;" readonly/></span></td>
              <td width="17%" align="center"><span id="a_length"><input type="text" name="a_length" value="<?php echo stripslashes($size3); ?>" style="width:40px;"  readonly /></span></td>
              <td width="16%" align="center">&nbsp;</td>
            </tr></table></td>
          </tr>
          
          <?php if($GLOBALS['site_config']['require_product_discount'] == 1) { ?>
          <script language="JavaScript">
		  chk_discount = 1;
		  </script>
          
          <?php } ?>
          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont"> Price (US)</span><span class="starcolor">*</span></td>
            <td colspan="3"><input type="text" name="price" value="<?php echo stripslashes($prod_obj->price['value']); ?>" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);" > 
              &nbsp;($) </td>
          </tr>
         
          <?php if($prod_obj->prod_id['value'] >0) {?>
          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont">Available Quantity</span> &nbsp;:&nbsp;<font class="price"><span id="quantity"><?php  
								
								$buyed = "";									
								$order_qry = "select prod_quantity from order_details where prod_id='".$prod_obj->prod_id['value']."'";
								$order_res = $GLOBALS['db_con_obj']->execute_sql($order_qry);
								while($order_data = mysql_fetch_object($order_res[0]))
								{
								    $buyed = $buyed + $order_data->prod_quantity;
								}
								
							  echo $remaining = $prod_obj->stocks_available['value'] - $buyed;?><input type="hidden" name="stocks_available" value="<?php echo stripslashes($prod_obj->stocks_available['value']); ?>" /></span></font></td>
            <td width="18%"><input type="text" name="temp_amount" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);"/> </td>
            <td colspan="2"><select name="quantity_action" onchange="get_dynamic_dropdown('quantity','../ajax_content7.php','required=set_avalible&frm_fld_name=currency&selected_val='+this.value+'&temp_amount='+window.document.<?php echo $prod_obj->frm_name; ?>.temp_amount.value+'&stocks_available='+window.document.<?php echo $prod_obj->frm_name; ?>.stocks_available.value+'&prod_id='+window.document.<?php echo $prod_obj->frm_name; ?>.prod_id.value);">
            	<option value="">Select</option>
              <option value="add">Add Stock</option>
              <option value="remove">Remove Stock</option>
            </select></td>
          </tr>
          <?php } 
		  else
		  {?>
          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont">Quantity</span><span class="starcolor">*</span></td>
            <td colspan="3"><input type="text" name="stocks_available" value="<?php echo stripslashes($prod_obj->stocks_available['value']); ?>" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);" ></td>
          </tr>
          <?php 
		  }if($prod_obj->prod_id['value'] >0 && 1==2) { ?>
          <tr valign="top">
            <td class="postaddcontent" colspan="4" align="center"><span class="starcolor"><em>If you want to update the product quantity add your quantity with total number of prducts</em></span></td>
          </tr>
          <?php  }?>
          
          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont">Product Image</span></td>
            <td colspan="3"><input type="file" name="prod_med_image"> <?php echo display_view_delete_links($prod_obj, "prod_med_image"); ?></td>
          </tr>
          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont">More Image</span></td>
            <td colspan="3"><input type="file" name="large_picture"> <?php echo display_view_delete_links($prod_obj, "large_picture"); ?></td>
          </tr>
          <?php if(1==2) { ?>
          <tr valign="top"> 
            <td class="postaddcontent"><span class="whitefont">Product Weight</span><span class="starcolor">*</span></td>
            <td colspan="3"><input type="text" name="prod_weight" value="<?php echo stripslashes($prod_obj->prod_weight['value']); ?>" onfocus="setbool(frm_obj.boolcheck, '1')" onblur="setbool(frm_obj.boolcheck, '0')" onkeypress="check_float_value(this.value)" > 
              &nbsp;(ounces)</td>
          </tr>
          
          <?php 
		  }
		  
		  if($GLOBALS['site_config']['parent_child_option'] == 1 && (($make_parent == 1 && $prod_obj->prod_parent_id['value'] == 0) || ($prod_obj->prod_parent_id['value'] > 0) || ($prod_obj->prod_parent_id['value'] < 0 && $submit_action != "add"))) 
		  { 
		  
		  $options = array();
		  if($edit == 1 && $prod_obj->prod_parent_id['value'] != 0)
		  {
		  	
			$attr_arr = explode("|#|", $prod_obj->product_attributes['value']);

			if($prod_obj->prod_parent_id['value'] == -1 && $children_product != 1)
			{

				foreach($attr_arr as $key => $value)
				{
					if(strlen(trim($value)) > 0)
					$options[$key] = $prod_attr_obj->frame_attribute_types_asdropdown(0,$value);
				}
				
				$temp_options = $prod_attr_obj->frame_attribute_types_asdropdown();
				  
				for($i = count($options); $i < $GLOBALS['site_config']['prod_attribute_count']; $i++)
		
					$options[$i] = $temp_options;
						
			}
			else
			{
				
				if($prod_obj->prod_parent_id['value'] == -1 && $children_product == 1)
				{
					$prod_obj->prod_parent_id['value'] = $_SESSION['ses_selected_prnt_prod'];
					$prod_obj->prod_id['value'] = "";
				}
				
				$attr = $prod_obj->fetch_field($prod_obj->cls_tbl, "product_attributes", "prod_id = '" . $prod_obj->prod_parent_id['value'] . "'");
				
				$attr_parr = explode("|#|", $attr);

				foreach($attr_arr as $key => $value)
				{
					if(strlen(trim($value)) > 0)
					$options[$key] = $prod_attr_obj->frame_attribute_types_asdropdown($attr_parr[$key],$value);
				}

			}
			
		  }
		  else
		  {
	  		  
			  if($make_parent == 1 && $prod_obj->prod_parent_id['value'] == 0)
			  $prod_obj->prod_parent_id['value'] = -1;
		  
			  $temp_options = $prod_attr_obj->frame_attribute_types_asdropdown();
			  
			  for($i = 0; $i < $GLOBALS['site_config']['prod_attribute_count']; $i++)
	
					$options[$i] = $temp_options;
					
		  }
		  for($i = 0; $i < count($options); $i++)
		  {
		  
		  ?>
          
          <?php if($i == (count($options) - 1) && $submit_action != "mkprnt" && $children_product != 1) { ?>
          
          <?php 
		  
		  }
		  
		  }

		  } //if($GLOBALS['site_config']['parent_child_option'] == 1 && $make_parent == 1)
		  
		  ?>
          
          <?php if(1==2) {?>
          
          <?php } ?>
          
          <tr valign="top">
            <td class="postaddcontent">Description</td>
            <td colspan="3"><textarea name="description" cols="60" rows="6"><?php echo stripslashes($prod_obj->description['value']);?></textarea></td>
          </tr>
          <tr valign="top"> 
            <td class="postaddcontent">Product Status</td>
            <td colspan="3"><select name="prod_status">
                <option value="1">Active</option>
                <option value="0" <?php echo (stripslashes($prod_obj->prod_status['value']) == "0")?"selected":""; ?>>In-Active</option>
              </select></td>
          </tr><?php if(1==2) { ?>
          
          
          <?php
		  }
		 
		  ?>
          
         
          <tr valign="top" class="postaddcontent"> 
            <td colspan="4"><div align="center"> 
                <input type="hidden" value="0" name="boolcheck">
				<input type="hidden" name="color_id" value="">
                <!-- for numeric field script validations -->
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
                <input type="hidden" name="prod_id" value="<?php echo $prod_obj->prod_id['value']; ?>">
                <input type="hidden" name="date_entered" value="<?php echo (strlen($prod_obj->date_entered['value']) > 0)?$prod_obj->date_entered['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="prod_parent_id" value="<?php echo $prod_obj->prod_parent_id['value']; ?>">
				<input type="hidden" name="check_cat" value="<?php echo $prod_obj->category_id['value']; ?>" />
				<input type="hidden" name="pdf_file_size" value="<?php echo $prod_obj->book_file['value']; ?>" />
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="4"> <input align="absmiddle" style="border:0px;" type="image"  src="../images/save_clear.jpg" name="Submit" value="Submit"> &nbsp;&nbsp;<input align="absmiddle" style="border:0px;" type="image" onclick="window.document.<?php echo $prod_obj->frm_name; ?>.submit_action.value='model_color';" src="../images/save_model.jpg" name="Submit" value="Submit">&nbsp;&nbsp;<input align="absmiddle" style="border:0px;" type="image" onclick="window.document.<?php echo $prod_obj->frm_name; ?>.submit_action.value='size';" src="../images/save_size.jpg" name="Submit" value="Submit"><!--
              &nbsp;&nbsp;&nbsp;&nbsp;<img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $prod_obj->frm_name; ?>.reset();"> -->            </td>
          </tr>
          <tr> 
            <td colspan="4" height="8px"> </td>
          </tr>
        </table>	  
	  </td>
    </tr> 
</form>	
  </table>
  <script language="JavaScript">
var frm_obj = eval("window.document." + '<?php echo $prod_obj->frm_name; ?>');
var frm_name = window.document.<?php echo $prod_obj->frm_name; ?>;

function set_values1()
{
	frm_name.dia.value = frm_name.size1.value;
}
function set_values2()
{
	frm_name.b_dist.value = frm_name.size2.value;
}
function set_values3()
{
	frm_name.a_length.value = frm_name.size3.value;
}
</script>
