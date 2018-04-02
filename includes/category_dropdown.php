<script language="javascript">
function display_hint(obj)
{
	var o = window.document.getElementById('hintid');

	if(obj.value.length > 0)
		o.innerHTML = "<br>" + cat_hint_arr[obj.value];
	else
		o.innerHTML = "";
	
}
</script>
<?php

$category_res = $GLOBALS['db_con_obj']->fetch_flds("category_master", "cat_id,cat_name,cat_desc", "parent_id = '0' and cat_status='1' order by parent_id asc, display_order asc, cat_name asc");

if(strlen($display_fld) <= 0)
$display_fld = "cat_id";

$script_str = "<script language='javascript'>";
$script_str .= "var cat_hint_arr = new Array();\n";

?>
<select name="<?php echo $cat_dd_name; ?>" <?php echo stripslashes($category_dd_script_txt); ?>>
<?php if(!$cat_default_selection) { ?>
<option value="">Select a Category</option>
<?php } 

while($cat_data = mysql_fetch_object($category_res[0]))
{

$script_str .= "cat_hint_arr[" . $cat_data->cat_id . "] = \"" . trim($cat_data->cat_desc) . "\";\n";

?>
<optgroup label="<?php echo stripslashes($cat_data->cat_name); ?>">
<?php 

$inner_category_res = $GLOBALS['db_con_obj']->fetch_flds("category_master", "cat_id,cat_name,cat_desc,parent_id", "parent_id = '" . $cat_data->cat_id . "' and cat_status='1' order by parent_id asc, display_order asc, cat_name asc");

while($inner_cat_data = mysql_fetch_object($inner_category_res[0]))
{

?>
<option value="<?php echo $inner_cat_data->$display_fld; ?>" <?php echo ($select_option == $inner_cat_data->$display_fld)?"selected":""; ?>><?php echo stripslashes($inner_cat_data->cat_name); ?></option>
<?php 
}

?>
</optgroup>
<?php

} 

?>
</select>
<?php

$script_str .= "</script><span id='hintid' class='hintfont'></span>";

echo $script_str;

?>
