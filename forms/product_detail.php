<?php
$form_detail ="1";
require_once("header.php"); 
require_once("classes/product_master.class.php");
require_once("classes/your_review.class.php");

require_once("classes/cart.class.php");
$cart_obj = new cart();

$prod_obj = new product_master();

$rev_obj = new your_review();

$res = $prod_obj->fetch_record($_REQUEST['prod_id']);

$data = mysql_fetch_object($res[0]);
$category_name = $GLOBALS['db_con_obj']->fetch_field("productcategory","cat_name ","category_id='".$data->category_id."'");

//$qty_in_hand = $prod_obj->get_product_available_quantity($_REQUEST['prod_id']);
$display_days = $GLOBALS['site_config']['product_display_days'];
$end_date = date("Y-m-d", mktime(0,0,0,date("m",strtotime($data->disp_start_dt)),date("d",strtotime($data->disp_start_dt)) + $display_days,date("Y",strtotime($data->disp_start_dt))));

$can_display = 0;

if(date("Y-m-d") <= $end_date && $qty_in_hand > 0)
$can_display = 1;


$product_id = $_REQUEST['prod_id'];

$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "save":
		$pid = $_REQUEST['prod_id'];
		$id = $_REQUEST['id'];
		$customer_id = $_SESSION['ses_customer_id'];
		$res = $rev_obj->fetch_flds($rev_obj->cls_tbl, "*", "user_id ='".$customer_id."' and prod_id = '" . $pid . "'");
		if($res[1] ==0)
		{
		$rev_obj->insert();
		}
		else
		$rev_obj->update($id);		
		header("location:product_detail.php?prod_id=$pid");
		exit();			
		break;
	case"lens_type":
	unset($_SESSION['ses_product_obj']);
		foreach($_REQUEST as $k => $v)
		$_SESSION['ses_product_obj'][$k] = $v;
		
		header("location:product_detail.php?prod_id=".$_SESSION['ses_product_obj']['prod_id']);
		exit();	
	break;
	
	case "color_choice":
	unset($_SESSION['ses_product_obj']);
	foreach($_REQUEST as $k => $v)
		$_SESSION['ses_product_obj'][$k] = $v;
		
		header("location:product_detail.php?prod_id=".$_REQUEST['color_choice']);
		exit();
	break;
	
	case "size_choice":
	unset($_SESSION['ses_product_obj']);
			foreach($_REQUEST as $k => $v)
			$_SESSION['ses_product_obj'][$k] = $v;
			
			header("location:product_detail.php?prod_id=".$_REQUEST['size']);
			exit();
	break;
	
	case "addtocart":
		foreach($_REQUEST as $k =>$v)
		$_SESSION['ses_cart_items1'][$k] = $v;
		$cart_obj->add_product($cart_obj);
		header("location:basket.php");
		exit();	
		break;
	case "refresh_form":
	
		echo "hai";
		exit;
		
	break;

}

?>
<style type="text/css">
/* tab styles start */
.ddoverlap{
border-bottom: 1px solid #bbb8a9;
width:154px;

}

.ddoverlap ul{
padding: 0;
margin: 0;
font: bold 90% default;
list-style-type: none;

}

.ddoverlap li{
display: inline;
margin: 0;

}

.ddoverlap li a{
padding: 3px 7px;
text-decoration: none;
padding-right: 22px; /*extra right padding to account for curved right edge of tab image*/
color: #000000;
background:transparent url(images/righttabdefault.gif) 100% 1px no-repeat; /*give illusion of shifting 1px down vertically*/
border-left: 1px solid #dbdbd5;
position: relative;
float: left;
margin-left: -20px; /*shift tabs 20px to the left so they overlap*/
left: 20px;
}

.ddoverlap li a:visited{
color: #000000;
}

.ddoverlap li a:hover{
text-decoration: underline;
color: #555555;
}

.ddoverlap li.selectedtab a{ /*selected tab style*/
color: black;
z-index: 100; /*higher z-index so selected tab is topmost*/
top: 1px; /*Shift tab 1px down so the border beneath it is covered*/
background:  transparent url(images/righttabselected.gif) 100% 0 no-repeat;
}

.ddoverlap li.selectedtab a:hover{
text-decoration: none;
color: #555555;
}
</style>
<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript" type="text/jscript">
function check_validate()
{

if(form.submit_action.value !="" )
{
if (window.document.product_details.pd.value < 1) {
	doyou = confirm("Do you want to continue with this product PD value is  zero (OK = Yes   Cancel = No)");
	if (doyou == true) {
		error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";
		
		check_empty(form.elements["quantity"].name, "Product quantity should not be empty!!");
		if (window.document.product_details.quantity.value.length > 0 && window.document.product_details.quantity.value == 0) {
			error_message += "* Quantity cannot be zero";
			error = true;
		}
		window.document.product_details.submit_action.value = "addtocart";
	}
	else
	error = true;
}
}
}
</script>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td width="100%">
    <?php require_once("includes/error_message.php"); ?>
<form name="product_details" action="" enctype="multipart/form-data" method="post" onSubmit="return check_form(window.document.product_details);">
 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
							                  <tr>
                    <td width="14" id="t_left2"></td>
                    <td width="712" id="t_middle2"></td>
                    <td width="10" id="t_right2"></td>
                  </tr>

                            <tr>
							<td id="left2">&nbsp;</td>
                              <td bgcolor="#FFFFFF"><table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
                                <tbody>
                                  <tr>
                                    <td width="100%" height="5" colspan="2"></td>
                                  </tr>
                                  <!--  <tr>
	    <td><img src="upload/products/enlarge/long_dress_large1.jpg" border=0></td>
	  </tr> -->
                                  <tr>
                                    <!-- start prod details -->
                                    <td colspan="2" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                          <tr>
                                            <td valign="top" width="20%"><!-- start left -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                  <tbody>
                                                    <tr>
                                                      <!-- start tshirt image  -->
                                                      <td align="center" width="900"><!-- image only -->
                                                      <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tbody>
															<?php 
													$preview_url="forms/available_color_frm.php";
													
													$fpath = $prod_obj->attachment_path.$data->prod_big_image;
													  
													  if(!(file_exists($fpath) && is_file($fpath)))
													  $fpath = $prod_obj->attachment_path."default_detail_prod.gif";
													  
													  $sph_res = $GLOBALS['db_con_obj']->fetch_flds("lens_product","base_price,sph_from,sph_to,cyl_from,cyl_to,sph_at_pasi_price,sph_atat_pasi_price,cyl_at_pasi_price,cyl_atat_pasi_price","lenstype_id='".$_SESSION['ses_product_obj']['lens_type']."'"); 
														$lens_data = mysql_fetch_object($sph_res[0]);
														
														if($lens_data->base_price >0)
														$price_value = $lens_data->base_price;
														else
														$price_value = $data->price;
																		
															?>
                                                              <tr><td width="36%" align="left" ><table  cellpadding="4" cellspacing="0" class="">
                                                                <tr><td align="center" colspan="2" valign="middle" style="padding-left:10px;"><img src="<?php echo $fpath; ?>" border="0" title="<?php echo $data->prod_name;?>" name="<?php echo $data->prod_name;?>"></td></tr>
                                                                <tr>
                                                                  <td height="11" colspan="2" align="left" background="product_detail.php_files/11.htm" ><a class='blue_link' href="#" onClick="popup_window('basedesign_nh.php?submit_action=preview&id=<?php echo stripslashes($data->auto_modelid); ?>&url=<?php echo $preview_url; ?>&list_url=<?php echo $list_url; ?>',320,450,'yes','yes');" >XX of Colours Available</a></td>
                                                                </tr>
                                                                <tr>
                                                                        <td height="11" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Total Price (Frame& Lens): </span></td><td><span class="total_price" id="price"><?php if($price_value > 0 ) echo stripslashes("US$ "  . format_number($price_value));  else echo "N/A"; ?><input type="hidden" name="price" value="<?php echo $price_value; ?>" /></span></td>
                                                                      </tr></table></td>
                                                                <td width="64%" align="left" ><table border="0" cellpadding="0" cellspacing="0" width="497">
                                                                    <tbody>
                                                                      
                                                                      <tr>
                                                                        <td width="223" height="11" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Item #: </span></td>
                                                                        <td width="274"><span class="newsletter"><?php echo stripslashes($data->stock_code); ?></span></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td height="11" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Frame Type </span></td><td><span class="newsletter"><?php echo $GLOBALS['db_con_obj']->fetch_field("frame_master","frame_name","frame_id='".$data->frame_type."'");?></span></td>
                                                                      </tr>
                                                                       <tr>
                                                                        <td height="11" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Material </span></td><td><span class="newsletter"><?php 
	$mat = explode(",",$data->mat_id);
	foreach($mat as $k =>$v)
	echo $mat_list =  $GLOBALS['db_con_obj']->fetch_field("material_master","mat_name","mat_id='".$v."'").", ";
	
	//echo substr($mat_list,0,-1);
	?></span></td>
                                                                      </tr>
                                                                      
                                                                      <tr>
                                                                        <td height="11" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Gender/Style </span></td><td><span class="newsletter"><?php 
	$gen = explode(",",$data->gen_id);
	foreach($gen as $k1 =>$v1)
	echo $GLOBALS['db_con_obj']->fetch_field("gender_master","gen_name","gen_id='".$v1."'").", "
	?></span></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td height="11" align="left" background="product_detail.php_files/11.htm" ><span class="login" >&nbsp;&nbsp;This frame consist of these colors </span></td><td><span class="newsletter"><?php 
	$col = explode(",",$data->color_id);
	foreach($col as $k2 =>$v2)
	echo $GLOBALS['db_con_obj']->fetch_field("color_master","color_name","color_id='".$v2."'").", ";
	?></span></td>
                                                                      </tr>
                                                                       
                                                                       
                                                                        
                                                                      <tr>
                                                                        <!-- prod name -->
                                                                        <td height="2" valign="top"></td>                
                                                                      </tr>
                                                                      
																	  
<?php
		
		
		$display_days = $GLOBALS['site_config']['product_display_days'];
		$end_date = date("Y-m-d", mktime(0,0,0,date("m",strtotime($data->disp_start_dt)),date("d",strtotime($data->disp_start_dt)) + $display_days,date("Y",strtotime($data->disp_start_dt))));
		
		$can_display = 0;
		
		if(date("Y-m-d") <= $end_date && $qty_in_hand > 0)
		$can_display = 1;
		$id_count = substr_count($GLOBALS['site_config']['ebook_cat'],$data->category_id);
		
		?>  
																	 <tr>
																	   <td height="33" colspan="2" align="left"><font class="login"><u>Frame Dimension</u></font></td>
																      </tr>
																	  <tr>
																	   <td height="33" colspan="2" align="left"><table width="100%" align="left">
                        <tr>
              <td width="12%" align="center" nowrap="nowrap"><span class="type">Total Width</span></td>
              <td width="14%" align="center" nowrap="nowrap"><span class="type">Lens Depth</span></td>
              <td width="13%" align="center"><span class="type">Diameter</span></td>
              <td width="17%" align="center" nowrap="nowrap"><span class="type">Bridge Distance</span></td>
              <td align="center" nowrap="nowrap"><span class="type">Arm Length</span></td>
              <td width="30%"  align="center"><span class="type">Available sizes for this frame</span></td>
            </tr>
            <?php 
			$sizes = $data->measurments;
			$measurments = explode("-",$sizes);
			?>
            <tr><td align="center"><input type="text" name="t_width" value="<?php echo stripslashes($measurments[0]); ?>" style="width:40px;" readonly=""/></td>
              <td align="center"><input type="text" name="l_depth" value="<?php echo stripslashes($measurments[1]); ?>" style="width:40px;" readonly=""/></td>
              <td align="center"><span id="dia"><input type="text" name="dia" value="<?php echo stripslashes($measurments[2]); ?>" style="width:40px;" readonly=""/></span></td>
              <td align="center"><span id="b_dist"><input type="text" name="b_dist" value="<?php echo stripslashes($measurments[3]); ?>" style="width:40px;" readonly="" /></span></td>
              <td width="14%" align="center"><span id="a_length">
                <input type="text" name="a_length" value="<?php echo stripslashes($measurments[3]); ?>" style="width:40px;"  readonly=""/></span></td>
				<td><table width="55%" align="center" class="tableborder_list"><tr><td><span class="newsletter"><?php 
				
					$modelid = $data->auto_modelid;
				  	$colorid = $data->auto_colorid;
$size_res = $GLOBALS['db_con_obj']->fetch_flds("product_master", "prod_id,size", "auto_modelid='".$modelid."' and auto_colorid='".$colorid."' and prod_status='1' order by prod_id asc");
while($size_data = mysql_fetch_object($size_res[0]))
{
echo $size_data->size."<br>";
}

?></span></td></tr></table></td>
              </tr></table></td>
																      </tr>

																	 
                                                                    </tbody>
                                                                </table></td>
                                                              </tr>
															  <tr><td colspan="2"><hr style="height:1px;" color="#666666"/></td></tr>
                                                              <tr>
                                                                <td height="212" align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="325">
                                                                    <tbody>
																	<tr>
																	   <td height="33" colspan="2" align="left"><font class="login"><u>Frame and Lens selection</u></font></td>
																      </tr>
                                                                      
                                                                      <tr>
                                                                        <td width="158" height="29" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Color Choices </span></td>
                                                                        <td width="166"><span class="newsletter"><?php $color_choice_name = "color_choice";
				  
				  $select_option = $data->prod_id;				  
				  $gen_default_selection = false;
					$modelid = $data->auto_modelid;
				  	//$colorid = $data->auto_colorid;
					$str ='';
				  if(file_exists("../includes/color_choice.php"))
				  
				  	include("../includes/color_choice.php");
					
				else
				
				  	include("includes/color_choice.php");
				  
				  ?></span></td>
                                                                      </tr>
                                                                      <tr>
                                                                        <td height="26" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Size </span></td><td><?php $size_dd_name = "size";
				  
				  $select_option = $data->prod_id;				  
				  $gen_default_selection = false;
					$modelid = $data->auto_modelid;
				  	$colorid = $data->auto_colorid;
				  if(file_exists("../includes/size_dropdown.php"))
				  
				  	include("../includes/size_dropdown.php");
					
				else
				
				  	include("includes/size_dropdown.php");
				  
				  ?></td>
                                                                      </tr>
                                                                       <tr>
                                                                        <td height="33" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;Make my glasses for </span></td><td><span class="newsletter"><span class="newsletter">
                                                                          <?php $bifocal_dd_name = "glass_for";
				  $text ='Select';
				  $select_option = $_SESSION['ses_product_obj']['glass_for'];				  
				  $gen_default_selection = false;
					$type_id = 3;
				  
				  if(file_exists("../includes/bifocal_dropdown1.php"))
				  
				  	include("../includes/bifocal_dropdown1.php");
					
				else
				
				  	include("includes/bifocal_dropdown1.php");
				  
				  ?>
                                                                        </span></span></td>
                                                                      </tr>
																	  <?php 
																	  
																	  if($measurments[1] <25)
																	  $disaple ='disabled="disabled"'; 
																	  
																	  ?>
                                                                      <tr>
                                                                        <td height="30" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Bifocal </span></td>
                                                                        <td><span class="newsletter">
                                                                          <?php $bifocal_dd_name = "bifocal";
				  $text = 'Select bifocal';
				  $select_option = $_SESSION['ses_product_obj']['bifocal'];				  
				  $gen_default_selection = false;
					$type_id = 1;
				  
				  if(file_exists("../includes/bifocal_dropdown.php"))
				  
				  	include("../includes/bifocal_dropdown.php");
					
				else
				
				  	include("includes/bifocal_dropdown.php");
				  
				  ?>
                                                                        </span></td>
                                                                      </tr>
                                                                      
<tr>
                                                                        <td height="27" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Lens Type </span></td>
                                                                        <td><span class="newsletter"><?php $lens_dd_name = "lens_type";
				  
				  $select_option = $_SESSION['ses_product_obj']['lens_type'];				  
				  $gen_default_selection = false;
					$frame_id = $data->frame_type;
					
				  
				  if(file_exists("../includes/lenstype_usersection.php"))
				  
				  	include("../includes/lenstype_usersection.php");
					
				else
				
				  	include("includes/lenstype_usersection.php");
				  
				  ?></span></td>
                                                                      </tr>
																	  <tr>
                                                                        <td height="30" align="left" background="product_detail.php_files/11.htm" ><span class="login">&nbsp;&nbsp;Lens Coating </span></td>
                                                                        <td><span class="newsletter"><?php $bifocal_dd_name = "lenscoating";
				  $disaple ='';
				  $text ='Select Lens Coating';
				  $select_option = $_SESSION['ses_product_obj']['lenscoating'];					  
				  $gen_default_selection = false;
					$type_id = 2;
				  
				  if(file_exists("../includes/bifocal_dropdown.php"))
				  
				  	include("../includes/bifocal_dropdown.php");
					
				else
				
				  	include("includes/bifocal_dropdown.php");
				  
				  ?></span></td>
                                                                      </tr>
                                                                       
                                                                      <tr>
                                                                        <!-- prod name -->
                                                                        <td height="22" valign="top"></td>                
                                                                      </tr>
                                                                      
																	  
<?php
		
		
		$display_days = $GLOBALS['site_config']['product_display_days'];
		$end_date = date("Y-m-d", mktime(0,0,0,date("m",strtotime($data->disp_start_dt)),date("d",strtotime($data->disp_start_dt)) + $display_days,date("Y",strtotime($data->disp_start_dt))));
		
		$can_display = 0;
		
		if(date("Y-m-d") <= $end_date && $qty_in_hand > 0)
		$can_display = 1;
		$id_count = substr_count($GLOBALS['site_config']['ebook_cat'],$data->category_id);
		
		?>  
                                                                    </tbody>
                                                                </table></td>
                                                                <td align="right" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="98%">
                                                                    <tbody>
																	<tr>
																	   <td height="33" colspan="2" align="left"><font class="login"><u>Prescription Details</u></font></td>
																      </tr>
                                                                      
																	  <?php if(1==2) {?>
                                                                       
                                                                      <?php } ?>
                                                                      
																	  <tr>
                                                                        <td width="298" height="30" align="center" background="product_detail.php_files/11.htm" ><font class="prescription"><u>RIGHT EYE</u></font></td>
                                                                        <td width="261" align="center"><font class="prescription"><u>LEFT EYE</u></font></td>
                                                                      </tr>
                                                                       
                                                                      <tr>
                                                                        <!-- prod name -->
                                                                        <td height="22" valign="top"><table width="96%" cellpadding="0" cellspacing="0" class="tableborder_list">
																		<tr><td align="center"><span class="prescription">SPH</span></td><td align="center"><span class="prescription">CYL</span></td><td align="center"><span class="prescription">AXIS</span></td></tr>
																		<?php $lens_type =  $_SESSION['ses_product_obj']['lens_type'];?>
																		<tr><td align="center">
																		<select name="prod_right_sph" style="width:60px;" onchange="get_dynamic_dropdown('price','ajax_content7.php','required=set_price&right_sph='+this.value+'&right_cyl='+window.document.product_details.prod_right_cyl.value+'&left_sph='+window.document.product_details.prod_left_sph.value+'&left_cyl='+window.document.product_details.prod_left_cyl.value+'&lens_type=<?php echo $lens_type;?>');">
																		<?php
																		//$GLOBALS['site_config']['debug'] = 1;
$sph_res = $GLOBALS['db_con_obj']->fetch_flds("lens_product","base_price,sph_from,sph_to,cyl_from,cyl_to,sph_at_pasi_price,sph_atat_pasi_price,cyl_at_pasi_price,cyl_atat_pasi_price","lenstype_id='".$_SESSION['ses_product_obj']['lens_type']."'"); 																		$lens_data = mysql_fetch_object($sph_res[0]);
																		for ($a=$lens_data->sph_from; $a<=$lens_data->sph_to;$a=$a +.25)
																		{
																		if($a >0)
																			$sign = "+";
																		else
																			$sign = "";
																		
																		?>
																		<option value="<?php echo format_number($a); ?>" <?php echo (0.00 ==format_number($a))?"selected":"";?>><?php echo $sign.format_number($a); ?></option>
																		<?php
																		}
																		?>
																		</select>
																		
																		</td>
																		  <td align="center"><select name="prod_right_cyl" style="width:60px;" onchange="get_dynamic_dropdown('price','ajax_content7.php','required=set_price&right_sph='+window.document.product_details.prod_right_sph.value+'&right_cyl='+this.value+'&left_sph='+window.document.product_details.prod_left_sph.value+'&left_cyl='+window.document.product_details.prod_left_cyl.value+'&lens_type=<?php echo $lens_type;?>');">
                                                                            <?php
																		for ($a=$lens_data->cyl_from; $a<=$lens_data->cyl_to;$a=$a +.25)
																		{
																		if($a >0)
																			$sign = "+";
																		else
																			$sign = "";
																		?>
                                                                            <option value="<?php echo format_number($a); ?>" <?php echo (0.00==format_number($a))?"selected":"";?>><?php echo $sign.format_number($a); ?></option>
                                                                            <?php
																		}
																		?>
                                                                          </select></td>
																		  <td align="center"><select name="right_axis" style="width:40px;" >
																		<?php
																		for ($a=0; $a<=180;$a++)
																		{
																		?>
																		<option value="<?php echo format_number($a); ?>" <?php echo ($lens_obj->sph_from['value'] ==format_number($a))?"selected":"";?>><?php echo $a; ?></option>
																		<?php
																		}
																		?>
																		</select></td></tr>
																		<tr><td colspan="3" align="center"><span class="prescription">ADD</span></td></tr>
																		<tr><td colspan="3" align="center"><select name="right_add" style="width:60px;" >
																		<?php
																		for ($a=1; $a<4;$a=$a+.5)
																		{
																		?>
																		<option value="<?php echo format_number($a); ?>" <?php echo ($lens_obj->sph_from['value'] ==format_number($a))?"selected":"";?>><?php echo format_number($a); ?></option>
																		<?php
																		}
																		?>
																		</select></td></tr>
																		</table></td>      <td height="22" valign="top"><table width="96%" cellpadding="0" cellspacing="0" class="tableborder_list">
																		<tr><td align="center"><span class="prescription">SPH</span></td><td align="center"><span class="prescription">CYL</span></td><td align="center"><span class="prescription">AXIS</span></td></tr>
																		<tr><td align="center"> <select name="prod_left_sph" style="width:60px;" onchange="get_dynamic_dropdown('price','ajax_content7.php','required=set_price&right_sph='+window.document.product_details.prod_right_sph.value+'&right_cyl='+window.document.product_details.prod_right_sph.value+'&left_sph='+this.value+'&left_cyl='+window.document.product_details.prod_left_cyl.value+'&lens_type=<?php echo $lens_type;?>');">
																		<?php
																		for ($a=$lens_data->sph_from; $a<=$lens_data->sph_to;$a=$a +.25)
																		{
																		if($a >0)
																			$sign = "+";
																		else
																			$sign = "";
																		?>
																		<option value="<?php echo format_number($a); ?>" <?php echo (0.00 ==format_number($a))?"selected":"";?>><?php echo $sign.format_number($a); ?></option>
																		<?php
																		}
																		?>
																		</select></td><td align="center"><select name="prod_left_cyl" style="width:60px;" onchange="get_dynamic_dropdown('price','ajax_content7.php','required=set_price&right_sph='+window.document.product_details.prod_right_sph.value+'&right_cyl='+window.document.product_details.prod_right_sph.value+'&left_sph='+window.document.product_details.prod_left_sph.value+'&left_cyl='+this.value+'&lens_type=<?php echo $lens_type;?>');">
																		<?php
																		for ($a=$lens_data->cyl_from; $a<=$lens_data->cyl_to;$a=$a +.25)
																		{
																		if($a >0)
																			$sign = "+";
																		else
																			$sign = "";
																		?>
																		<option value="<?php echo format_number($a); ?>" <?php echo (0.00 ==format_number($a))?"selected":"";?>><?php echo $sign.format_number($a); ?></option>
																		<?php
																		}
																		?>
																		</select></td><td align="center"><select name="left_axis" style="width:40px;" >
																		<?php
																		for ($a=0; $a<=180;$a++)
																		{
																		?>
																		<option value="<?php echo format_number($a); ?>" <?php echo ($lens_obj->sph_from['value'] ==format_number($a))?"selected":"";?>><?php echo $a; ?></option>
																		<?php
																		}
																		?>
																		</select></td></tr>
																		<tr><td colspan="3" align="center"><span class="prescription">ADD</span></td></tr>
																		<tr><td colspan="3" align="center"><select name="left_add" style="width:60px;" >
																		<?php
																		for ($a=1; $a<4;$a=$a+.5)
																		{
																		?>
																		<option value="<?php echo format_number($a); ?>" <?php echo ($lens_obj->sph_from['value'] ==format_number($a))?"selected":"";?>><?php echo format_number($a); ?></option>
																		<?php
																		}
																		?>
																		</select></td></tr>
																		</table></td>              
                                                                      </tr>
																	  <tr>
																	    <td height="33" colspan="2" align="left">&nbsp;</td></tr>
																	  <tr>
																	    <td height="33" colspan="2" align="left"><table width="98%" cellpadding="0" cellspacing="0" >
																		
																		<tr><td rowspan="3" width="70%" align="left"><span class="login">Note:</span><span class="newsletter">Extra Strength Lenses<br />Depending on the type of lense selected , there will be an extra charges for a range of "SPH" and "CYL" values<br />
																		<span class="prescription" style="padding-left: 20px;"><u>SPH</u></span><br />
																		@  = denotes additional <span class="prescription">US$<?php echo $lens_data->sph_at_pasi_price; ?></span><br />
																		@@ = denotes additional <span class="prescription">US$<?php echo $lens_data->sph_atat_pasi_price; ?></span></span><br />
																		<span class="newsletter" ><span class="prescription" style="padding-left: 20px;"><u>CYL</u></span><br />
																		@  = denotes additional <span class="prescription">US$<?php echo $lens_data->cyl_at_pasi_price; ?></span><br />
																		@@ = denotes additional <span class="prescription">US$<?php echo $lens_data->cyl_atat_pasi_price; ?></span></span></td>
																		<td width="30%" height="44" align="left"><span class="prescription">PD</span><span class="type">(Pupil Distance)</span>&nbsp;&nbsp;<select name="pd" style="width:60px;" >
																		<?php
																		for ($a=0; $a<=80;$a++)
																		{
																		?>
																		<option value="<?php echo format_number($a); ?>" <?php echo ($lens_obj->sph_from['value'] ==format_number($a))?"selected":"";?>><?php echo $a; ?></option>
																		<?php
																		}
																		?>
																		</select></td>
																		</tr>
																		<tr>
																		  <td align="left"><span class="prescription">QTY</span><span class="type">(no.of.pairs)</span>&nbsp;&nbsp;<input type="text" size="10" name="quantity" value="1"   onfocus="setbool(frm_obj.boolcheck, '1')" onblur="setbool(frm_obj.boolcheck, '0')" onkeypress="check_integer_value(this.value)"/></td>
																		  </tr>
																		</table></td>
																      </tr>
																	  
                                                                      
																	  
<?php
		
		
		$display_days = $GLOBALS['site_config']['product_display_days'];
		$end_date = date("Y-m-d", mktime(0,0,0,date("m",strtotime($data->disp_start_dt)),date("d",strtotime($data->disp_start_dt)) + $display_days,date("Y",strtotime($data->disp_start_dt))));
		
		$can_display = 0;
		
		if(date("Y-m-d") <= $end_date && $qty_in_hand > 0)
		$can_display = 1;
		$id_count = substr_count($GLOBALS['site_config']['ebook_cat'],$data->category_id);
		
		?>  
                                                                    </tbody>
                                                                </table></td>
                                                              </tr>
                                                            </tbody>
                                                      </table></td>
                                                      <!-- image only -->
                                                    </tr>
                                                    <!-- end tshirt image -->
                                                  </tbody>
                                              </table></td>
                                          </tr>
                                        </tbody>
                                    </table></td>
                                  </tr>
                                  <!-- end prod details -->
                                  
                                   <tr>
                                    <td height="15" colspan="2" align="right"><input src="images/buttons/addtocart.jpg" name="Add to Cart" value="Add to Cart" alt="Add to Cart" style="border:0px;" type="image" /></td>
                                  </tr>
                                  
                                  <tr>
                                    <td height="10" colspan="2" align="center"></td>
                                  </tr>
                                   
                                   <tr>
                                    <td height="10" colspan="2" align="center"></td>
                                  </tr>
                                   <?php	
								   	
									//$GLOBALS['site_config']['debug'] = 1;						
									$rev_res = $GLOBALS['db_con_obj']->fetch_flds($rev_obj->cls_tbl,"*","prod_id='".$_REQUEST['prod_id']."' and status=1");
									
									if($rev_res[1] >0)
									{
																			
									?>
                                   
                                  <?php
								  }
								  ?>
                                  
                                  <tr>
                                    <td height="15" colspan="2"></td>
                                  </tr>
                                </tbody>
                              </table></td>
							  <td id="left2">&nbsp;</td>
                            </tr>
							<tr>
                    <td id="b_left2"></td>
                    <td id="b_middle2"></td>
                    <td id="b_right2"></td>
                  </tr>
                          </table>
                    <input type="hidden" name="submit_action" value="addtocart">
                    <input type="hidden" name="prod_id" value="<?php echo $_REQUEST['prod_id']; ?>">
					<input type="hidden" value="0" name="boolcheck">
</form><script language="JavaScript">
	
var frm_obj = eval("window.document.product_details");

</script></td>
</tr>

  <?php
		
		$chk_qry = "select products from related_products where prod_id ='" . $data->prod_id . "'";
		
		$chk_res = $GLOBALS['db_con_obj']->execute_sql($chk_qry);
		
		if($chk_res[1] > 0)
		{
		  
		  ?>
           <tr> 
            <td align="left"><hr size="0" style="height:2px;"/></td>
          </tr>
          
          <tr> 
            <td align="left">
              <?php require_once("forms/relproduct_short_list_frm.php"); ?>            </td>
          </tr>
          <?php
		  
		  }
		  
		  ?>
</table>
<script language="JavaScript">
var cust_login = 0;
</script>
<?php
if($_SESSION['ses_customer_id'] > 0)
{
?>
<script language="JavaScript">
cust_login = 1;
</script>
<?php
}
?>
<script language="JavaScript">
prev_tab = '';
prev_sel_tab = '';
function show_tab(tabname,sel_tb)
{
	if(tabname == 'ur_rev_tab' && cust_login == 0)
	{
		window.location.href = 'cust_login.php';
		return false;
	}
	var tabobj = window.document.getElementById(tabname);
	var sel_tabobj = window.document.getElementById(sel_tb);
	
	if(prev_tab.length > 0)
	{
		var prev_tabobj = window.document.getElementById(prev_tab);
		var prev_sel_tabobj = window.document.getElementById(prev_sel_tab);
		prev_tabobj.className = 'hidelayer';
		prev_sel_tabobj.className = '';
	}
	tabobj.className = 'showlayer';
	sel_tabobj.className = 'selectedtab';
	prev_tab = tabname;
	prev_sel_tab = sel_tb;
	
}
function submit_frm()
{

window.document.product_details.submit_action.value ="lens_type";
//window.location.href="product_detail.php";
window.document.product_details.submit();
}
function submit_frm1()
{

window.document.product_details.submit_action.value ="color_choice";
//window.location.href="product_detail.php";
window.document.product_details.submit();
}
function submit_frm2()
{

window.document.product_details.submit_action.value ="size_choice";
//window.location.href="product_detail.php";
window.document.product_details.submit();
}

</script>


<?php 

require_once("footer.php"); 

?>