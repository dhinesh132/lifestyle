
<?php

$res = $db_con_obj->fetch_flds("productattributes", "attr_id,parent_id,attr_name", "parent_id='" . $val . "'");
$attr_name = $db_con_obj->fetch_field("productattributes", "attr_name" , "attr_id='" .$val . "'");


?>
<tr><td>
<font class="desc_lable">Select&nbsp;<?php echo str_replace(" ", "&nbsp;", $attr_name); ?> </font>
</td>
<td>

 
<select name="<?php echo $attr_dd_name; ?>" id="<?php echo $attr_dd_id; ?>" onChange="set_price();">
  <?php if(!$ctry_default_selection) { ?>
  
  <option  value="" selected >Select a <?php echo $attr_name; ?></option>
  <?php } 

while($attr_data = mysql_fetch_object($res[0]))
{

?>
  <option value="<?php echo $attr_data->attr_id; ?>" <?php echo ($select_option == $attr_data->parent_id)?"selected":""; ?>><?php echo $attr_data->attr_name; ?></option>
  <?php 

} 

?>
</select>
</td>
</tr>
