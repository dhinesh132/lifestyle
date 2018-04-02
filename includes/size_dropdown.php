<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("product_master", "prod_id,size", "auto_modelid='".$modelid."' and auto_colorid='".$colorid."' and prod_status='1' order by prod_id asc");

?>
<select name="<?php echo $size_dd_name; ?>" <?php echo stripslashes($category_dd_script_txt); ?>>
<?php if(!$frma_default_selection) { ?>
<option value="">Select a size</option>
<?php } 

while($inner_cat_data = mysql_fetch_object($category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->prod_id; ?>" <?php echo ($select_option == $inner_cat_data->prod_id)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->size); ?></option>
<?php 
}

?>
</select>

