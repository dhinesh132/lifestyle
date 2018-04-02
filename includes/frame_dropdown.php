<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("frame_master", "frame_id,frame_name", "frame_status='1' order by frame_id asc");

?>
<select name="<?php echo $frame_dd_name; ?>" <?php echo stripslashes($category_dd_script_txt); ?>>
<?php if(!$frma_default_selection) { ?>
<option value="">Select a Frame Type</option>
<?php } 

while($inner_cat_data = mysql_fetch_object($category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->frame_id; ?>" <?php echo ($select_option == $inner_cat_data->frame_id)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->frame_name); ?></option>
<?php 
}

?>
</select>

