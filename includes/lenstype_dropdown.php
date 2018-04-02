<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("lense_master", "len_id,len_name", "len_status='1' order by len_id asc");

?>
<select name="<?php echo $lens_dd_name; ?>" >
<?php if(!$lens_default_selection) { ?>
<option value="">Select a Lens Type</option>
<?php } 

while($inner_cat_data = mysql_fetch_object($category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->len_id; ?>" <?php echo ($select_option == $inner_cat_data->len_id)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->len_name); ?></option>
<?php 
}

?>
</select>

