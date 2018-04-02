<script src="<?php echo $GLOBALS['site_config']['site_path']; ?>scripts/ajax.js" type="text/javascript"></script>
<script language="javascript">

function check_validate() 
{
	if(form.submit_action.value !="save_base")
	{
	error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";
	check_empty(form.elements["lenstype_id"].name,"Lens type should not be empty !");
	check_empty(form.elements["lens_no"].name,"Lens no should not be empty !");
	check_empty(form.elements["base_price"].name,"Base selling price should not be empty !");
	}
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
	
	$res = $lens_obj->fetch_record($edit_id);
	$lens_obj = set_values($lens_obj, "db", $res[0]);
	

}


if(isset($_SESSION['ses_lens_product_obj']) && is_array($_SESSION['ses_lens_product_obj']))
{
	$lens_obj = set_values($lens_obj,"ses",$_SESSION['ses_lens_product_obj']);
	
	
}

?>

<table width="85%" border="0" cellspacing="0" cellpadding="2" align="center">
  <form action="" method="post" enctype="multipart/form-data" name="<?php echo $lens_obj->frm_name; ?>" onSubmit="return check_form(window.document.<?php echo $lens_obj->frm_name; ?>);">
    <tr> 
      <td>

<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr class="maincontentheading"> 
            <td height="29" colspan="4" align='center' class='whitefont_header'> 
              <?php echo "Products Details"; ?></td>
          </tr>
          <tr valign="top">
            <td class="postaddcontent"><span class="whitefont">Lens Type</span><span class="starcolor">*</span></td>
            <td width="13%"><?php
				  
				  $lens_dd_name = "lenstype_id";
				  
				  $select_option = $lens_obj->lenstype_id['value'];
				  
				  $lens_default_selection = false;
				
				  
				  if(file_exists("../includes/lenstype_dropdown.php"))
				  
				  	require_once("../includes/lenstype_dropdown.php");
					
				else
				
				  	require_once("includes/lenstype_dropdown.php");
				  
				  ?>            </td>
            <td width="12%" align="center"><span class="whitefont">Lens No</span></td>
            <td width="54%"><input type="text" name="lens_no" value="<?php echo stripslashes($lens_obj->lens_no['value']); ?>" maxlength="200" class="lengthy_txtfld" ></td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td width="21%"><span class="whitefont">Lens Description</span></td>
            <td colspan="3"><textarea name="lens_desc"  cols="75" rows="4"><?php echo stripslashes($lens_obj->lens_desc['value']); ?></textarea></td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td width="21%"><span class="whitefont">Base Selling Price (US$)</span><span class="starcolor">*</span></td>
            <td colspan="3"><input type="text" name="base_price" value="<?php echo stripslashes($lens_obj->base_price['value']); ?>" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);" > </td>
          </tr>
          <tr valign="top">
            <td colspan="4" class="postaddcontent" align="center">
            Additional Price for extra strength(US$)
            <hr style="height:2px;" color="#666666"/></td>
          </tr>
           <tr valign="top"> 
            <td colspan="4" class="postaddcontent">
            <table width="100%" cellpadding="0" cellspacing="0">
            <tr><td width="47%"><table width="100%" class="tableborder_new">
              <tr>
                <td colspan="2" align="center"><h5><u>SPH Values</u></h5></td>
              </tr>
              <tr><td width="44%"><span class="whitefont">Total RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><select name="sph_to" >
				<?php for($b=0;$b <=20;$b=$b +.25) 	{	
               ?>
				<option value="<?php echo format_number($b); ?>" <?php echo ($lens_obj->sph_to['value'] ==format_number($b))?"selected":"";?>><?php echo "+".format_number($b); ?></option>
				<?php } ?>
</select>&nbsp;<span class="whitefont">To</span>&nbsp;<select name="sph_from" >
				<?php for($a=0;$a >= -20.00;$a=$a -.25) 	{	?>
				<option value="<?php echo format_number($a); ?>" <?php echo ($lens_obj->sph_from['value'] ==format_number($a))?"selected":"";?>><?php echo format_number($a); ?></option>
				<?php } ?>
</select></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="image" src="../images/save.jpg" style="border:0;" onclick="window.document.<?php echo $lens_obj->frm_name; ?>.submit_action.value='save_base';"/></td></tr>
              <tr>
                <td colspan="2" height="5px;"><hr size="0" /></td>
                </tr>
                <tr>
                  <td width="44%"><span class="whitefont">Rangewithin Base Price(+)</span><span class="starcolor"> *</span></td>
                  <td width="56%">0.00&nbsp;<span class="whitefont">To</span>&nbsp;
                    <select name="sph_base_pasitive" >
				<?php
				 /*if($lens_obj->sph_to['value'] !="")
				 $evalue = $lens_obj->sph_to['value'];
				 else
				 $evalue =20;*/
				 for($e=0;$e <=$lens_obj->sph_to['value'];$e=$e +.25) 	{	?>
				<option value="<?php echo format_number($e); ?>" <?php echo ($lens_obj->sph_base_pasitive['value'] ==format_number($e))?"selected":"";?>><?php echo format_number($e); ?></option>
				<?php } ?>
</select></td></tr>
 <tr>
                  <td width="44%"><span class="whitefont">Rangewithin Base Price(-)</span><span class="starcolor"> *</span></td>
                  <td width="56%">0.00&nbsp;<span class="whitefont">To</span>&nbsp;
                    <select name="sph_base_negative" >
				<?php
				/*if($lens_obj->sph_to['value'] !="")
				 $evalue = $lens_obj->sph_to['value'];
				 else
				 $evalue =20;*/
				 for($f=0;$f >=$lens_obj->sph_from['value'];$f=$f -.25) 	{	?>
				<option value="<?php echo format_number($f); ?>" <?php echo ($lens_obj->sph_base_negative['value'] ==format_number($f))?"selected":"";?>><?php echo format_number($f); ?></option>
				<?php } ?>
</select></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="image" src="../images/save.jpg" style="border:0;" onclick="window.document.<?php echo $lens_obj->frm_name; ?>.submit_action.value='save_base';"/></td></tr>
              <tr>
                <td colspan="2" height="5px;"><hr size="0" /></td>
                </tr>
              
              <tr>
                <td colspan="2" align="center"><h6>(+)@@ Range/Price</h6></td>
              </tr>
               <tr><td width="44%"><span class="whitefont">RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><span id="atataplus"><select name="sph_atat_pasi1" onchange="get_dynamic_dropdown('atataplus1','../ajax_content3.php','required=select_value1&fld_name=sph_at_pasi&end_limit='+this.value+'&start_limit=<?php echo $lens_obj->sph_base_pasitive['value'];?>');" >
				<?php 
				$val1 = $lens_obj->sph_at_pasi['value']+.25;
				for($h=$lens_obj->sph_base_pasitive['value'];$h <=$lens_obj->sph_to['value'];$h=$h +.25) 	{	?>
				<option value="<?php echo format_number($h); ?>" <?php echo ($val1  ==format_number($h))?"selected":"";?>><?php echo format_number($h); ?></option>
				<?php } ?>
</select></span>&nbsp;<span class="whitefont">To</span>&nbsp;<select name="sph_atat_pasi" >
				<?php for($i=$lens_obj->sph_to['value'];$i<=$lens_obj->sph_to['value'];$i=$i +.25) 	{	?>
				<option value="<?php echo format_number($i); ?>" <?php echo ($lens_obj->sph_atat_pasi['value'] ==format_number($i))?"selected":"";?>><?php echo format_number($i); ?></option>
				<?php } ?>
</select></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="text" value="<?php echo $lens_obj->sph_atat_pasi_price['value']; ?>" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);" name="sph_atat_pasi_price" style="width:70px;"/></td></tr>
              <tr>
                <tr>
                <td colspan="2" align="center"><h6>(+)@ Range/Price</h6></td>
              </tr>
               <tr><td width="44%"><span class="whitefont">RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><select name="sph_at_pasi1" >
				<?php for($j=$lens_obj->sph_base_pasitive['value'];$j <=$lens_obj->sph_base_pasitive['value'];$j=$j +.25) 	{	?>
				<option value="<?php echo format_number($j); ?>" ><?php echo format_number($j); ?></option>
				<?php } ?>
</select>&nbsp;<span class="whitefont">To</span>&nbsp;<span id="atataplus1"><select name="sph_at_pasi" onchange="get_dynamic_dropdown('atataplus','../ajax_content3.php','required=select_value&fld_name=sph_at_pasi1&start_limit='+this.value+'&end_limit=<?php echo $lens_obj->sph_to['value'];?>');">
				<?php for($k=$lens_obj->sph_base_pasitive['value'];$k <=$lens_obj->sph_to['value'];$k=$k +.25) 	{	?>
				<option value="<?php echo format_number($k); ?>" <?php echo ($lens_obj->sph_at_pasi['value'] ==format_number($k))?"selected":"";?>><?php echo format_number($k); ?></option>
				<?php } ?>
</select></span></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="text" name="sph_at_pasi_price" style="width:70px;" value="<?php echo stripslashes($lens_obj->sph_at_pasi_price['value']); ?>" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);"/></td></tr>
               <tr>
               <td colspan="2" align="center" ><span class="whitefont"><hr />RX(0.00)<hr /></span></td>
              </tr>
              <tr>
              <td colspan="2" align="center"><h6>(-)@ Range/Price</h6></td>
              </tr>
               <tr><td width="44%"><span class="whitefont">RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><select name="sph_at_naga1" >
				<?php for($n=$lens_obj->sph_base_negative['value'];$n >= $lens_obj->sph_base_negative['value'];$n=$n -.25) 	{	?>
				<option value="<?php echo format_number($n); ?>" ><?php echo format_number($n); ?></option>
				<?php } ?>
</select>&nbsp;<span class="whitefont">To</span>&nbsp;
<span id="atatanaga"><select name="sph_at_naga" onchange="get_dynamic_dropdown('atatanaga1','../ajax_content3.php','required=select_value1&fld_name=sph_at_naga1&end_limit='+this.value+'&start_limit=<?php echo $lens_obj->sph_base_pasitive['value'];?>');" >
  <?php for($o=$lens_obj->sph_base_negative['value'];$o >= $lens_obj->sph_from['value'];$o=$o -.25) 	{	?>
  <option value="<?php echo format_number($o); ?>" <?php echo ($lens_obj->sph_at_naga['value'] ==format_number($o))?"selected":"";?>><?php echo format_number($o); ?></option>
  <?php } ?>
</select></span></td>
               </tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="text" name="sph_at_naga_price" value="<?php echo stripslashes($lens_obj->sph_at_naga_price['value']); ?>" style="width:70px;" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);"/></td></tr>
              <tr>
                <tr>
                <td colspan="2" align="center"><h6>(-)@@ Range/Price</h6></td>
              </tr>
               <tr><td width="44%"><span class="whitefont">RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><span id="atatanaga1"><select name="sph_atat_naga1" onchange="get_dynamic_dropdown('atatanaga','../ajax_content3.php','required=select_value2&fld_name=sph_at_naga&end_limit='+this.value+'&start_limit=<?php echo $lens_obj->sph_from['value'];?>');">
				<?php 
				$val3 = $lens_obj->sph_at_naga['value']-.25;
				for($p=$lens_obj->sph_base_negative['value'];$p >= $lens_obj->sph_from['value'];$p=$p -.25) 	{	?>
				<option value="<?php echo format_number($p); ?>" <?php echo ($val3 ==format_number($p))?"selected":"";?>><?php echo format_number($p); ?></option>
				<?php } ?>
</select></span>&nbsp;<span class="whitefont">To</span>&nbsp;<select name="sph_atat_naga" >
				<?php for($q=$lens_obj->sph_from['value'];$q >=$lens_obj->sph_from['value'];$q=$q -.25) 	{	?>
				<option value="<?php echo format_number($q); ?>" <?php echo ($lens_obj->sph_atat_naga['value'] ==format_number($q))?"selected":"";?>><?php echo format_number($q); ?></option>
				<?php } ?>
</select></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="text" name="sph_atat_naga_price" value="<?php echo stripslashes($lens_obj->sph_atat_naga_price['value']); ?>" style="width:70px;" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);"/></td>
              </tr>
              <tr>
              </table></td><td width="6%">&nbsp;</td><td width="47%"><table width="100%" class="tableborder_new">
              <tr>
                <td colspan="2" align="center"><h5><u>CYL Values</u></h5></td>
              </tr>
              <tr><td width="44%"><span class="whitefont">Total RX Range</span><span class="starcolor">*</span></td>
                <td width="56%"><select name="cyl_to" >
				<?php for($d=0;$d <=20;$d=$d +.25) 	{	?>
				<option value="<?php echo format_number($d); ?>" <?php echo ($lens_obj->cyl_to['value'] ==format_number($d))?"selected":"";?>><?php echo "+".format_number($d); ?></option>
				<?php } ?>
</select>                  &nbsp;<span class="whitefont">To</span>&nbsp;
                  <select name="cyl_from" >
                  <?php for($c=0;$c >= -20.00;$c=$c -.25) 	{	?>
                  <option value="<?php echo format_number($c); ?>" <?php echo ($lens_obj->cyl_from['value'] ==format_number($c))?"selected":"";?>><?php echo format_number($c); ?></option>
                  <?php } ?>
                </select></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="image" src="../images/save.jpg" style="border:0;" onclick="window.document.<?php echo $lens_obj->frm_name; ?>.submit_action.value='save_base';"/></td></tr>
              <tr>
                <td colspan="2" height="5px;"><hr size="0" /></td>
                </tr>
                <tr>
                  <td width="44%"><span class="whitefont">Rangewithin Base Price(+)</span><span class="starcolor"> *</span></td>
                  <td width="56%">0.00&nbsp;<span class="whitefont">To</span>&nbsp;
                    <select name="cyl_base_pasitive" >
				<?php for($g=0;$g <=$lens_obj->cyl_to['value'];$g=$g +.25) 	{	?>
				<option value="<?php echo format_number($g); ?>" <?php echo ($lens_obj->cyl_base_pasitive['value'] ==format_number($g))?"selected":"";?>><?php echo format_number($g); ?></option>
				<?php } ?>
</select></td></tr>
 <tr>
                  <td width="44%"><span class="whitefont">Rangewithin Base Price(-)</span><span class="starcolor"> *</span></td>
                  <td width="56%">0.00&nbsp;<span class="whitefont">To</span>&nbsp;
                    <select name="cyl_base_negative" >
				<?php for($r=0;$r >= $lens_obj->cyl_from['value'];$r=$r -.25) 	{	?>
				<option value="<?php echo format_number($r); ?>" <?php echo ($lens_obj->cyl_base_negative['value'] ==format_number($r))?"selected":"";?>><?php echo format_number($r); ?></option>
				<?php } ?>
</select></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="image" src="../images/save.jpg" style="border:0;" onclick="window.document.<?php echo $lens_obj->frm_name; ?>.submit_action.value='save_base';"/></td></tr>
              <tr>
                <td colspan="2" height="5px;"><hr size="0" /></td>
                </tr>
              
              <tr>
                <td colspan="2" align="center"><h6>(+)@@ Range/Price</h6></td>
              </tr>
               <tr><td width="44%"><span class="whitefont">RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><span id="cylatataplus"><select name="cyl_atat_pasi1" onchange="get_dynamic_dropdown('atataplus2','../ajax_content3.php','required=select_value1&fld_name=cyl_at_pasi&end_limit='+this.value+'&start_limit=<?php echo $lens_obj->sph_base_pasitive['value'];?>');" >
				<?php 
				$val2 = $lens_obj->cyl_at_pasi['value']+.25;
				for($s=$lens_obj->cyl_base_pasitive['value'];$s <= $lens_obj->cyl_to['value'];$s=$s +.25) 	{	?>
				<option value="<?php echo format_number($s); ?>" <?php echo ($val2 ==format_number($s))?"selected":"";?>><?php echo format_number($s); ?></option>
				<?php } ?>
</select></span>&nbsp;<span class="whitefont">To</span>&nbsp;<select name="cyl_atat_pasi" >
				<?php for($t=$lens_obj->cyl_to['value'];$t <= $lens_obj->cyl_to['value'];$t=$t +.25) 	{	?>
				<option value="<?php echo format_number($t); ?>" <?php echo ($lens_obj->cyl_atat_pasi['value'] ==format_number($t))?"selected":"";?>><?php echo format_number($t); ?></option>
				<?php } ?>
</select></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="text" name="cyl_atat_pasi_price" value="<?php echo stripslashes($lens_obj->cyl_atat_pasi_price['value']); ?>" style="width:70px;" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);"/></td></tr>
              <tr>
                <tr>
                <td colspan="2" align="center"><h6>(+)@ Range/Price</h6></td>
              </tr>
               <tr><td width="44%"><span class="whitefont">RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><select name="cyl_at_pasi1" >
				<?php for($u=$lens_obj->cyl_base_pasitive['value'];$u <=$lens_obj->cyl_base_pasitive['value'];$u=$u +.25) 	{	?>
				<option value="<?php echo format_number($u); ?>" ><?php echo format_number($u); ?></option>
				<?php } ?>
</select>&nbsp;<span class="whitefont">To</span>&nbsp;<span id="atataplus2"><select name="cyl_at_pasi" onchange="get_dynamic_dropdown('cylatataplus','../ajax_content3.php','required=select_value&fld_name=cyl_at_pasi1&start_limit='+this.value+'&end_limit=<?php echo $lens_obj->cyl_to['value'];?>');">
				<?php for($v=$lens_obj->cyl_base_pasitive['value'];$v <=$lens_obj->cyl_to['value'];$v=$v +.25) 	{	?>
				<option value="<?php echo format_number($v); ?>" <?php echo ($lens_obj->cyl_at_pasi['value'] ==format_number($v))?"selected":"";?>><?php echo format_number($v); ?></option>
				<?php } ?>
</select></span></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="text" value="<?php echo stripslashes($lens_obj->cyl_at_pasi_price['value']); ?>" name="cyl_at_pasi_price" style="width:70px;" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);"/></td></tr>
               <tr>
               <td colspan="2" align="center" ><span class="whitefont"><hr />RX(0.00)<hr /></span></td>
              </tr>
              <tr>
              <td colspan="2" align="center"><h6>(-)@ Range/Price</h6></td>
              </tr>
               <tr><td width="44%"><span class="whitefont">RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><select name="cyl_at_naga1" >
				<?php for($w=$lens_obj->cyl_base_negative['value'];$w >= $lens_obj->cyl_base_negative['value'];$w=$w -.25) 	{	?>
				<option value="<?php echo format_number($w); ?>" ><?php echo format_number($w); ?></option>
				<?php } ?>
</select>&nbsp;<span class="whitefont">To</span>&nbsp;<span id="cylatatanaga"><select name="cyl_at_naga" onchange="get_dynamic_dropdown('cylatatanaga1','../ajax_content3.php','required=select_value1&fld_name=cyl_at_naga1&end_limit='+this.value+'&start_limit=<?php echo $lens_obj->sph_base_pasitive['value'];?>');">
				<?php for($x=$lens_obj->cyl_base_negative['value'];$x >=$lens_obj->cyl_from['value'];$x=$x -.25) 	{	?>
				<option value="<?php echo format_number($x); ?>" <?php echo ($lens_obj->cyl_at_naga['value'] ==format_number($x))?"selected":"";?>><?php echo format_number($x); ?></option>
				<?php } ?>
</select></span></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="text" value="<?php echo stripslashes($lens_obj->cyl_at_naga_price['value']); ?>"  name="cyl_at_naga_price" style="width:70px;" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);"/></td></tr>
              <tr>
                <tr>
                <td colspan="2" align="center"><h6>(-)@@ Range/Price</h6></td>
              </tr>
               <tr><td width="44%"><span class="whitefont">RX Range</span><span class="starcolor">*</span></td>
            <td width="56%"><span id="cylatatanaga1"><select name="cyl_atat_naga1" onchange="get_dynamic_dropdown('cylatatanaga','../ajax_content3.php','required=select_value2&fld_name=cyl_at_naga&end_limit='+this.value+'&start_limit=<?php echo $lens_obj->sph_from['value'];?>');">
				<?php 
				$val4 = $lens_obj->cyl_at_naga['value']-.25;
				for($y=$lens_obj->cyl_base_negative['value'];$y >= $lens_obj->cyl_from['value'];$y=$y -.25) 	{	?>
				<option value="<?php echo format_number($y); ?>" <?php echo ($val4  ==format_number($y))?"selected":"";?>><?php echo format_number($y); ?></option>
				<?php } ?>
</select></span>&nbsp;<span class="whitefont">To</span>&nbsp;<select name="cyl_atat_naga" >
				<?php for($z=$lens_obj->cyl_from['value'];$z >=$lens_obj->cyl_from['value'];$z=$z -.25) 	{	?>
				<option value="<?php echo format_number($z); ?>" <?php echo ($lens_obj->cyl_atat_naga['value'] ==format_number($z))?"selected":"";?>><?php echo format_number($z); ?></option>
				<?php } ?>
</select></td></tr>
              <tr>
                <td colspan="2" height="5px;"></td>
                </tr>
              <tr><td>&nbsp;</td><td align="center"><input type="text" name="cyl_atat_naga_price" value="<?php echo stripslashes($lens_obj->cyl_atat_naga_price['value']); ?>" style="width:70px;" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_float_value(this.value);"/></td>
              </tr>
              <tr>
              </table></td>
            </table></td>
     </tr>
      <tr valign="top"> 
            <td class="postaddcontent">Product Status</td>
            <td colspan="3"><select name="prod_status">
                <option value="1">Active</option>
                <option value="0" <?php echo (stripslashes($lens_obj->prod_status['value']) == "0")?"selected":""; ?>>In-Active</option>
              </select></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td colspan="4"><div align="center"> 
                <input type="hidden" value="0" name="boolcheck">
                <!-- for numeric field script validations -->
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
                <input type="hidden" name="prod_id" value="<?php echo $lens_obj->prod_id['value']; ?>">
                <input type="hidden" name="date_entered" value="<?php echo (strlen($lens_obj->date_entered['value']) > 0)?$lens_obj->date_entered['value']:date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="date_modified" value="<?php echo date("Y-m-d H:i:s"); ?>">
                <input type="hidden" name="prod_parent_id" value="<?php echo $lens_obj->prod_parent_id['value']; ?>">
				<input type="hidden" name="check_cat" value="<?php echo $lens_obj->category_id['value']; ?>" />
				<input type="hidden" name="pdf_file_size" value="<?php echo $lens_obj->book_file['value']; ?>" />
              </div></td>
          </tr>
          <tr> 
            <td align="center" colspan="4"> <input align="absmiddle" style="border:0px;" type="image"  src="../images//submit.jpg" name="Submit" value="Submit"> &nbsp;&nbsp;<img align="absmiddle" src="../images/reset.jpg" onClick="window.document.<?php echo $lens_obj->frm_name; ?>.reset();">            </td>
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
var frm_obj = eval("window.document." + '<?php echo $lens_obj->frm_name; ?>');
var frm_name = window.document.<?php echo $lens_obj->frm_name; ?>;

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
