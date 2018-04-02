<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("gender_master", "gen_id,gen_name", "gen_status='1' order by gen_id asc");

?>
<select name="<?php echo $gen_dd_name; ?>" <?php echo stripslashes($category_dd_script_txt); ?>>
<?php if(!$frma_default_selection) { ?>
<option value="">Select a Gender</option>
<?php } 

while($inner_cat_data = mysql_fetch_object($category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->gen_id; ?>" <?php echo ($select_option == $inner_cat_data->gen_id)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->gen_name); ?></option>
<?php 
}

?>
</select>

