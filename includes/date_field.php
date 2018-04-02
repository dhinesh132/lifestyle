<table border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td><select name="<?php echo $mth_name; ?>">
        <option value="">MM</option>
        <?php 
				  
				  for($i=1; $i <= 12; $i++) 
				  { 
				  
				  if(strlen($i) <= 1)
				  	$save_val = "0" . $i;
				  else
				  	$save_val = $i;
				  ?>
        <option value="<?php echo $save_val; ?>" <?php echo ($save_val == $mth_val)?"selected":""; ?>><?php echo $save_val; ?></option>
        <?php
				  }
				  ?>
      </select></td>
    <td> <select name="<?php echo $dt_name; ?>">
        <option value="">DD</option>
        <?php 
				  
				  for($i=1; $i <= 31; $i++) 
				  { 
				  
				  if(strlen($i) <= 1)
				  	$save_val = "0" . $i;
				  else
				  	$save_val = $i
				  ?>
        <option value="<?php echo $save_val; ?>" <?php echo ($save_val == $dt_val)?"selected":""; ?>><?php echo $save_val; ?></option>
        <?php
				  }
				  ?>
      </select></td>
    <td> <select name="<?php echo $yr_name; ?>">
        <option value="">YYYY</option>
        <?php 
				  
				  for($i=2006; $i <= 2010; $i++) 
				  { 
				  
				  $save_val = $i;
				  ?>
        <option value="<?php echo $save_val; ?>" <?php echo ($save_val == $yr_val)?"selected":""; ?>><?php echo $save_val; ?></option>
        <?php
				  }
				  ?>
      </select></td>
    <td><a href="javascript:<?php echo $popup_name; ?>.popup();"><img src="<?php echo $img_pth; ?>images/cal.gif" width="16" height="16" border="0"></a></td>
  </tr>
</table>
<script language="JavaScript">
    var <?php echo $popup_name; ?> = new calendar2(document.forms['<?php echo $popup_frmname; ?>'].elements['<?php echo $mth_name; ?>'],document.forms['<?php echo $popup_frmname; ?>'].elements['<?php echo $dt_name; ?>'],document.forms['<?php echo $popup_frmname; ?>'].elements['<?php echo $yr_name; ?>']);
    <?php echo $popup_name; ?>.year_scroll = true;
    <?php echo $popup_name; ?>.time_comp = false;
</script>
