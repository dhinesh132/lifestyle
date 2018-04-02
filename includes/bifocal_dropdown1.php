<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("settings_table", "id,name,amount", "type_id='".$type_id."' order by id asc");

?>
<select name="<?php echo $bifocal_dd_name; ?>" <?php echo stripslashes($category_dd_script_txt); ?> <?php echo $disaple;?>>
<?php if(!$frma_default_selection) { ?>
<option value=""><?php  echo $text;?></option>
<?php } 

while($inner_cat_data = mysql_fetch_object($category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->id; ?>" <?php echo ($select_option == $inner_cat_data->id)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->name); ?></option>
<?php 
}

?>
</select>

