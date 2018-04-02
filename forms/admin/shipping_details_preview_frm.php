<?php 
require_once("../classes/shipping_details.class.php");

 $id = $_REQUEST['id'];
$shipping_obj = new shipping_details();
	$res = $shipping_obj->fetch_record($id);
	$shipping_obj = set_values($shipping_obj, "db", $res[0]);

?>
<table width="95%" border="0" cellspacing="0" cellpadding="2" align="center">
    <tr> 
      <td>
<fieldset class="tableborder_new"><legend class="maincontentheading">Shipping Details</legend>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" >
 <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Weight</span></td>
    <td> <?php echo stripslashes($shipping_obj->Weight['value']); ?> kg
    </td>
  </tr>
  <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone A Countries</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneACountry['value']); ?> 
    </td>
  </tr>
  <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone A Cost</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneAPrice['value']); ?> 
    </td>
  </tr>
  <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone B Countries</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneBCountry['value']); ?> 
    </td>
  </tr>
  <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone B Cost</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneBPrice['value']); ?> 
    </td>
  </tr>
   <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone C Countries</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneCCountry['value']); ?> 
    </td>
  </tr>
  <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone C Cost</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneCPrice['value']); ?> 
    </td>
  </tr>
    <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone D Countries</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneDCountry['value']); ?> 
    </td>
  </tr>
  <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone D Cost</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneDPrice['value']); ?> 
    </td>
  </tr>
    <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone E Countries</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneECountry['value']); ?> 
    </td>
  </tr>
  <tr valign="top" class=""> 
    <td width="50%"><span class="whitefont">Zone E Cost</span></td>
    <td> <?php echo stripslashes($shipping_obj->ZoneEPrice['value']); ?> 
    </td>
  </tr>
  <tr> 
    <td align="center" colspan="2"> <a href="#"><img  border="0" align="absmiddle" src="../images/close.jpg" onClick="window.close();"> </a>
    </td>
  </tr>
  <tr> 
    <td colspan="2" height="8px"> </td>
  </tr>
</table>	  
</fieldset>	  
	  </td>
    </tr> 
  </table>

