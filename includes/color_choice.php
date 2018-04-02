<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("product_master", "prod_id,color_code,stock_code", "auto_modelid='".$modelid."'  and prod_status='1' order by prod_id asc");
?>
<select name="<?php echo $color_choice_name; ?>"  onchange="submit_frm1();">
<?php if(!$frma_default_selection) { ?>
<option value="">Select a color</option>
<?php } 

while($inner_cat_data = mysql_fetch_object($category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->prod_id; ?>" <?php echo ($select_option == $inner_cat_data->prod_id)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->stock_code); ?></option>
<?php 
}

?>
</select>

