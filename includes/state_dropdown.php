<?php

$st_res = $db_con_obj->fetch_flds("state", "stateid,state_code,statename", "countryid='222'");

if(strlen($display_fld) <= 0)
$display_fld = "stateid";

?>
<select name="<?php echo $st_dd_name; ?>" style="width:120px">
<?php if(!$st_default_selection) { ?>
<option value="">Select a State</option>
<?php } 

while($st_data = mysql_fetch_object($st_res[0]))
{

?>
<option value="<?php echo $st_data->$display_fld; ?>" <?php echo ($select_option == $st_data->$display_fld)?"selected":""; ?>><?php echo $st_data->statename; ?></option>
<?php 

} 

?>
</select>