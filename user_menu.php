<?php
	$customer_details = $GLOBALS['db_con_obj']->fetch_flds("customer_master", "cust_firstname,cust_lastname","cust_id = '" . $_SESSION['ses_customer_id'] . "'");

	$customer_data = mysql_fetch_object($customer_details[0]);

?>
<table width="100%"><tr>
<td>
<table border="0" cellspacing="5" cellpadding="3" align="right">
  <tr align="center"> 
    <td nowrap><a href="cust_edit_details.php" class="link">My Profile</a></td>
    <td nowrap>||</td>
    <td nowrap><a href="cust_orders.php" class="link">My Orders</a></td>
    <!--<td>||</td>
    <td nowrap><a href="user_pending_books.php">Books to Download</a></td>
    <td>||</td>
    <td nowrap><a href="logout.php">Logout</a></td>-->
  </tr>
</table>
</td></tr></table>
