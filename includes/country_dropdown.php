<?php

//$ctry_res = $db_con_obj->fetch_flds("country", "countryid,countryname", "2=2");
$ctry_res = $db_con_obj->fetch_flds("country", "countryid,countryname", "1=1 and country_status =1 order by countryname asc");


?>
<select name="<?php echo $ctry_dd_name; ?>" id="<?php echo $ctry_dd_id ?>" <?php echo $ctry_styles; ?> <?php echo $script_txt; ?> >
<?php if($ctry_default_selection) { ?>
<option value="">Select a Country</option>
<?php } 

while($ctry_data = mysql_fetch_object($ctry_res[0]))
{

?>
	<option value="<?php echo $ctry_data->countryid; ?>" <?php echo ($select_option == $ctry_data->countryid)?"selected='selected'":""; ?>><?php echo $ctry_data->countryname; ?></option>
<?php 
	
} 

?>
</select>