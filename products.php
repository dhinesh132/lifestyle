<?php 

require_once("header.php"); 

require_once("classes/product_master.class.php");
require_once("classes/productrefcategory.class.php");
require_once("classes/productcategory.class.php");
require_once("classes/productattributes.class.php");
require_once("classes/related_products.class.php"); 

$prod_obj = new product_master();
$prodrefcat_obj = new productrefcategory();
$prodcat_obj = new productcategory();
$prodattr_obj = new productattributes();
$relprod_obj = new related_products();

?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td><?php
	
	
	require_once("forms/product_list_frm.php");
	
	
	?></td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>