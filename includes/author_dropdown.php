<?php

//$ctry_res = $db_con_obj->fetch_flds("country", "countryid,countryname", "2=2");
$ctry_res = $db_con_obj->fetch_flds("author", "id,name", "1=1");


?>
<select name="<?php echo $ctry_dd_name; ?>" <?php echo $cls_name; ?> <?php echo $script_txt; ?>>
<?php if(!$ctry_default_selection) { ?>
<option value="">Select Author</option>
<?php } 

while($ctry_data = mysql_fetch_object($ctry_res[0]))
{

?>
<option value="<?php echo $ctry_data->id; ?>" <?php echo ($select_option == $ctry_data->id)?"selected":""; ?>><?php echo $ctry_data->name; ?></option>
<?php 

} 

?>
</select>