<?php 

require_once("header.php"); 

?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td><?php 
	
	
	require_once("paypal_pro/php-sdk/samples/DoDirectPayment.php"); 
	
	
	?></td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>