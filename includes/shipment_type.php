<?php

//$ctry_res = $db_con_obj->fetch_flds("country", "countryid,countryname", "2=2");
$ctry_res = $db_con_obj->fetch_flds("shippingmethod", "sm_id,name", "1=1");


?>

<select name="<?php echo $ctry_dd_name; ?>">
<?php if(!$ctry_default_selection) { ?>
<option value="">Select Shipping</option>
<?php } 

while($ctry_data = mysql_fetch_object($ctry_res[0]))
{

?>
<option value="<?php echo $ctry_data->sm_id; ?>" <?php echo ($select_option == $ctry_data->sm_id)?"selected":""; ?>><?php echo $ctry_data->name; ?></option>
<?php 

} 

?>
</select>