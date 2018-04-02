<?php

$category_res = $GLOBALS['db_con_obj']->fetch_field("frame_len_referense", "len_id", "frame_id='".$frame_id."' ");


?>
<select name="<?php echo $lens_dd_name; ?>" onchange="submit_frm();">
<?php if(!$lens_default_selection) { ?>
<option value="">Select Lens Type</option>
<?php } 


$lens_type = explode(",",$category_res);

foreach($lens_type as $key => $val)
{

$lens_res = $GLOBALS['db_con_obj']->fetch_flds("lense_master", "len_name,len_id", "len_id='".$val."' ");

$lens_data = mysql_fetch_object($lens_res[0])
?>
<option value="<?php echo $lens_data->len_id; ?>" <?php echo ($select_option == $lens_data->len_id)?"selected":""; ?>><?php echo stripslashes($lens_data->len_name); ?></option>
<?php 
}

?>
</select>

