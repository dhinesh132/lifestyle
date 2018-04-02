<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("material_master", "mat_id,mat_name", "mat_status='1' order by mat_id asc");

?>
<select name="<?php echo $mat_dd_name; ?>" <?php echo stripslashes($category_dd_script_txt); ?>>
<?php if(!$frma_default_selection) { ?>
<option value="">Select a Material</option>
<?php } 

while($inner_cat_data = mysql_fetch_object($category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->mat_id; ?>" <?php echo ($select_option == $inner_cat_data->mat_id)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->mat_name); ?></option>
<?php 
}

?>
</select>

