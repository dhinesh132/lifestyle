<?php
require_once("classes/product_master.class.php");

$prod_obj = new product_master();
?>
<p><font class="desc_cat"><?php echo $cat_heirarchy; ?></font></p>
<form name="search_frm" action="" method="post" >

<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" >
							                  <tr>
                    <td width="14" id="t_left2"></td>
                    <td width="712" id="t_middle2"></td>
                    <td width="10" id="t_right2"></td>
                  </tr>

                            <tr>
							<td id="left2">&nbsp;</td>
                              <td bgcolor="#FFFFFF" valign="top">
<table width="100%" cellpadding="0" cellspacing="0" align="center" >
<tr>
  <td height="5" colspan="6" valign="top" ></td>
  </tr>
 
 <tr>
  <td colspan="2" valign="top" align="center"><font class="heading">Further Filter by:</font>&nbsp;</td>
  <td width="15%" valign="top" class="content"></td>
  <td width="15%" valign="top" class="content"></td>
  <td colspan="2" valign="top" class="content"></td>
 </tr> <tr >
  <td colspan="2" height="25" valign="top" align="right">Frame Type</td>
  <td width="15%" valign="top" class="content">
  <?php	  $frame_dd_name = "frame_type";
				  
				  $select_option = $_SESSION['ses_temp_search_obj']['frame_type'];
				  
				  $frma_default_selection = false;
				
				  
				  if(file_exists("../includes/frame_dropdown.php"))
				  
				  	require_once("../includes/frame_dropdown.php");
					
				else
				
				  	require_once("includes/frame_dropdown.php");
				  
				  ?></td>
  <td width="15%" valign="top" class="content"></td>
  <td colspan="2" valign="top" class="content"></td>
 </tr>
 <tr>
   <td valign="top" height="25" class="content" align="right">&nbsp;</td>
   <td valign="top" align="right">Material&nbsp;</td>
   <td colspan="3" valign="top" ><?php	  $mat_dd_name = "mat_type";
				  
				  $select_option = $_SESSION['ses_temp_search_obj']['mat_type'];
				  
				  $frma_default_selection = false;
				
				  
				  if(file_exists("../includes/mat_dropdown.php"))
				  
				  	require_once("../includes/mat_dropdown.php");
					
				else
				
				  	require_once("includes/mat_dropdown.php");
				  
				  ?></td>
   <td valign="top" class="content">&nbsp;</td>
 </tr>
 <tr>
  <td width="13%" height="25" valign="top" class="content" align="right">&nbsp;</td>
  <td width="23%" valign="top" align="right">Color&nbsp;</td>
  <td width="15%" valign="top" ><?php $color_dd_name = "color";
				  
				  $select_option = $_SESSION['ses_temp_search_obj']['color'];				  
				  $gen_default_selection = false;
				$text = "Color 1";
				  
				  if(file_exists("../includes/color_dropdown.php"))
				  
				  	include("../includes/color_dropdown.php");
					
				else
				
				  	include("includes/color_dropdown.php");
				  
				  ?></td>
  <td width="15%" valign="top" class="content"><?php if(1==2) {	  $color_dd_name = "color1";
				  
				  $select_option = $_SESSION['ses_temp_search_obj']['color1'];
				  
				  $gen_default_selection = false;
				  $text = "Color 2";
				
				  
				  if(file_exists("../includes/color_dropdown.php"))
				  
				  	include("../includes/color_dropdown.php");
					
				else
				
				  	include("includes/color_dropdown.php");
				  
				 } ?></td>
  <td width="16%" valign="top" class="content"><?php if(1==2) {  $color_dd_name = "color2";
				  
				  $select_option = $_SESSION['ses_temp_search_obj']['color2'];
				  
				  $gen_default_selection = false;
				  
				  $text = "Color 3";
				
				  
				  if(file_exists("../includes/color_dropdown.php"))
				  
				  	include("../includes/color_dropdown.php");
					
				else
				
				  	include("includes/color_dropdown.php");
				  }
				  ?></td>
  <td width="18%" valign="top" class="content"></td>
 </tr>
 <tr>
   <td valign="top" class="content" height="25" align="right">&nbsp;</td>
   <td valign="top" align="right">Price Range&nbsp;</td>
   <td colspan="3" valign="top" ><input type="text" style="width:45px;" name="from_price" value="<?php echo $_SESSION['ses_temp_search_obj']['from_price'] ?>" />     &nbsp;&nbsp; to &nbsp;&nbsp; <input type="text" style="width:45px;" name="to_price" value="<?php echo $_SESSION['ses_temp_search_obj']['to_price'] ?>" /></td><td valign="top" class="content">&nbsp;</td>
 </tr>
 <tr>
   <td valign="top" class="content" align="right" height="25">&nbsp;</td>
   <td valign="top" align="right">Genter/Style &nbsp;</td>
   <td valign="top" ><input type="checkbox" name="gen1" value="1" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['gen1'] >0) {?> checked="checked"<?php }?> />&nbsp;Mens</td>
   <td valign="top" class="content"><input type="checkbox" name="gen2" value="2" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['gen2'] >0) {?> checked="checked"<?php }?>/>&nbsp;Ladies</td>
   <td valign="top" class="content"><input type="checkbox" name="gen3" value="3" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['gen3'] >0) {?> checked="checked"<?php }?>/>&nbsp;Children</td>
   <td valign="top" class="content">&nbsp;</td>
 </tr>
 <tr>
   <td valign="top" class="content" align="right" height="25">&nbsp; </td>
   <td valign="top" align="right">Types of Glasses&nbsp;</td>
  
  <td valign="top" ><input type="checkbox" name="type1" value="1" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['type1'] >0) {?> checked="checked"<?php }?> />&nbsp;Distance</td>
   <td valign="top" class="content"><input type="checkbox" name="type2" value="2" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['type2'] >0) {?> checked="checked"<?php }?>/>&nbsp;Reading</td>
   <td valign="top" class="content"><input type="checkbox" name="type3" value="3" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['type3'] >0) {?> checked="checked"<?php }?>/>&nbsp;Distance & Reading</td>
  <td valign="top" ><input type="image" src="images/go.gif" border="0" /></td></tr>
 <tr>
  <td height="5" colspan="6" valign="top" ><input type="hidden" name="submit_action" value="search" /></td>
  </tr>
  </table>
  </td><td id="right2">&nbsp;</td>
                            </tr>
							<tr>
                    <td id="b_left2"></td>
                    <td id="b_middle2"></td>
                    <td id="b_right2"></td>
                  </tr>
                          </table>
</form>
