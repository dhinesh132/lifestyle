
<?
require_once("classes/connections.class.php");
$con_db = new database_manipulation();

$cust_id=$_REQUEST["cust_id"];

?>


<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Model No</td>
    <td>Brand</td>
    <td>Size</td>
    <td>Stock Code</td>
    <td>Price</td>
    <td>Color</td>
    <td>Material</td>
    <td>Lens Depth</td>
    <td>Description</td>
  </tr>
  
  <?
$order_qry=mysql_query(select * from order_master where user_id='$cust_id');
while($fetch_order_qry=mysql_fetch_array($order_qry))
{
	$order_id=$fetch_order_qry["order_id"];
	$order_details_qry=mysql_query("SELECT * FROM order_details WHERE order_id=$order_id");
	while($fetch_order_details=mysql_fetch_array($order_details_qry))
		{

			$prod_id=$fetch_order_details["prod_id"];
		
			$product_qry=mysql_query("SELECT * FROM product_master where prod_id='$prod_id'");
			while($fetch_product=mysql_fetch_array($product_qry))
			{
				$model_no  =$fetch_product["model_no"];
				$size	   =$fetch_product["size"];
				$brand	   =$fetch_product["brand"];
				$color_code=$fetch_product["color_code"];
				$stock_code=$fetch_product["stock_code"];
				$price	   =$fetch_product["price"];
				$depth	   =$fetch_product["lens_depth"];
				$description=$fetch_product["description"];
  			
			
  ?>
  <tr>
    <td><?=$model_no?></td>
    <td><?=$brand?></td>
    <td><?=$size?></td>
    <td><?=$stock_code?></td>
    <td><?=$price?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$depth?></td>
    <td><?=$description?></td>
  </tr>
  	<?
			}
		}	
	}
	?>
</table>
