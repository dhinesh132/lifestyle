<?php 

require_once("../classes/related_products.class.php");
require_once("../classes/product_master.class.php");
require_once("../classes/productcategory.class.php");

$relprod_obj = new related_products();

$prod_obj = new product_master();
			
$productcategory_obj = new productcategory();

if($edit == 1 && $edit_id > 0)
{
	
	$res = $relprod_obj->fetch_record($edit_id);
	$relprod_obj = set_values($relprod_obj, "db", $res[0]);

}


?>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
  <tr class="maincontentheading"> 
    <td height="29" colspan="2" align='center' class='whitefont_header'> <?php echo stripslashes($relprod_obj->rp_name['value']); ?></td>
  </tr>
  <tr valign="top" > 
    <td width="50%" class="postaddcontent"><span class="whitefont">Group Name</span></td>
    <td width="50%"><?php echo stripslashes($relprod_obj->rp_name['value']); ?> 
    </td>
  </tr>
  <tr valign="top" nowrap> 
    <td class="postaddcontent"><span class="whitefont">Products in this group</span></td>
    <td><?php 
	
	$res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl, "prod_name", "prod_id in (" . $relprod_obj->products['value'] . ")");
	echo "<table border='0' cellpadding='3' cellspacing='1' width='100%'>";
	$cnt = 0;
	while($data = mysql_fetch_object($res[0]))
	{
	$cnt++;
	echo "<tr><td>" . $cnt . ")</td><td nowrap>" . stripslashes($data->prod_name) . "</td></tr>";
	}
	
	echo "</table>";
	
	
	
	?> </td>
  </tr>
  <tr valign="top" > 
    <td class="postaddcontent"><span class="whitefont">Created on</span></td>
    <td> <?php echo convert_date(stripslashes($relprod_obj->date_entered['value']),"m/d/Y h:i:s"); ?> 
    </td>
  </tr>
  <tr valign="top" > 
    <td class="postaddcontent"><span class="whitefont">Modified on</span></td>
    <td> <?php echo convert_date(stripslashes($relprod_obj->date_modified['value']),"m/d/Y h:i:s"); ?> 
    </td>
  </tr>
  <tr> 
    <td align="center" colspan="2"> <img align="absmiddle" src="../templates/godess/images/close.jpg" onClick="window.close();"> 
    </td>
  </tr>
  <tr> 
    <td colspan="2" height="8px"> </td>
  </tr>
</table>
<?php
$temp_window_tilte = stripslashes($relprod_obj->rp_name['value']);
?>	  
 	  
 