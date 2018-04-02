<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("color_master", "color_id,color_name", "color_status='1' order by color_id asc");

?>
<select name="<?php echo $color_dd_name; ?>" <?php echo stripslashes($category_dd_script_txt); ?>>
<?php if(!$frma_default_selection) { ?>
<option value="">Select a Color</option>
<?php } 

while($inner_cat_data = mysql_fetch_object($category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->color_id; ?>" <?php echo ($select_option == $inner_cat_data->color_id)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->color_name); ?></option>
<?php 
}

?>
</select>

