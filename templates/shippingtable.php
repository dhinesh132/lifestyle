<style>
td{
  padding: 5px;
}
</style>
<?php
$settings_res = $GLOBALS['db_con_obj']->fetch_flds("shipping_settings","*","id=1");
$settings_data = mysql_fetch_object($settings_res[0]);

$ship_res = $GLOBALS['db_con_obj']->fetch_flds("shipping_details","*","1=1 order By WeightTo ASC");
?>
<table width="100%" border="1" cellpadding="5" bordercolor="#eee">
<tbody>
  <tr>
    <td height="15px" ><strong>Weight</strong></td>
    <td >Courier (SG)</td>
    <td >MAL/BRU</td>
    <td >Asia</td>
    <td >AUS/JPN/NZ</td>
    <td >Worldwide</td>
  </tr>
 <?php
 while($ship_data = mysql_fetch_object($ship_res[0])){
 ?>
 <tr>
    <td><?php echo format_number($ship_data->WeightFrom,1)."-". format_number($ship_data->WeightTo,2);?>Kg</td>
    <td><?php echo format_number($ship_data->ZoneAPrice,2)?></td>
    <td><?php echo format_number($ship_data->ZoneBPrice,2)?></td>
    <td><?php echo format_number($ship_data->ZoneCPrice,2)?></td>
    <td><?php echo format_number($ship_data->ZoneDPrice,2)?></td>
    <td><?php echo format_number($ship_data->ZoneEPrice,2)?></td>
  </tr>
 <?php
 }?>
  <tr>
    <td>Additional 1 Kg</td>
    <td><?php echo format_number($settings_data->ZoneAPrice,2)?></td>
    <td><?php echo format_number($settings_data->ZoneBPrice,2)?></td>
    <td><?php echo format_number($settings_data->ZoneCPrice,2)?></td>
    <td><?php echo format_number($settings_data->ZoneDPrice,2)?></td>
    <td><?php echo format_number($settings_data->ZoneEPrice,2)?></td>
  </tr>
  </tbody>
</table>