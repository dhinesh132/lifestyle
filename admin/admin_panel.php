<?php
$frm_page = "admin_panel";
require_once("admin_header.php"); 

$temp_admin_id = $_SESSION['ses_admin_id'];
$temp_admin_priority = $_SESSION['ses_admin_priority'];
$temp_admin_password = $_SESSION['ses_admin_password'];
$temp_ses_admin_access_level = $_SESSION['ses_admin_access_level'];
$temp_msg_str = $_SESSION['ses_msg_str'];
$temp_msg_cls_str = $_SESSION['ses_msg_cls_str'];


session_unset();

frame_notices($temp_msg_str,$temp_msg_cls_str);

$_SESSION['ses_admin_id'] = $temp_admin_id;
$_SESSION['ses_admin_priority'] = $temp_admin_priority;
$_SESSION['ses_admin_password'] = $temp_admin_password;
$_SESSION['ses_admin_access_level'] = $temp_ses_admin_access_level;

?>


<table <?php echo $inner_table_param; ?>>
 <tr align="center">
	<td> <font class="redfont">Admin Control Panel Links</font></td>
 </tr>
 <tr>
  <td height=5px>
  </td>
 </tr>
  <tr>
    <td>
<?php require_once("../includes/error_message.php"); ?>
      <!-- <table width=95% cellpadding="2" cellspacing="2"  border=0 align="center">
	     <tr>
		   <td>
		      <a href="customers.php" class="top_menu_link">Manage Users</a>
			  &nbsp;&nbsp;<a class="top_menu_link">|</a>
		      &nbsp;&nbsp;<a href="admin.php" class="top_menu_link">Manage Admins</a>
			  &nbsp;&nbsp;<a class="top_menu_link">|</a>
		      &nbsp;&nbsp;<a href="store.php" class="top_menu_link">Manage Stores</a>
			  &nbsp;&nbsp;<a class="top_menu_link">|</a>
		      &nbsp;&nbsp;<a href="emp.php" class="top_menu_link">Manage Employees</a>
			  &nbsp;&nbsp;<a class="top_menu_link">|</a>
		      &nbsp;&nbsp;<a href="category.php" class="top_menu_link">Manage Category</a>
		      &nbsp;&nbsp;<a class="top_menu_link">|</a>
		   </td>
		 </tr>
		 <tr>
		   <td>
		       <a href="subcategory.php" class="top_menu_link">Manage Sub Category</a>
		      &nbsp;&nbsp;<a class="top_menu_link">|</a>			  
              &nbsp;&nbsp;<a href="product_supplier_master.php" class="top_menu_link">Manage Suppliers</a>
		      &nbsp;&nbsp;<a class="top_menu_link">|</a>			  
              &nbsp;&nbsp;<a href="country.php" class="top_menu_link">Manage Countries</a>
		      &nbsp;&nbsp;<a class="top_menu_link">|</a>			  
              &nbsp;&nbsp;<a href="state.php" class="top_menu_link">Manage States</a>
		      &nbsp;&nbsp;<a class="top_menu_link">|</a>			  

		   </td>
		 </tr>
	   </table>
       <br>
<br> -->
	<?php  

if(file_exists("classes/admin.class.php"))
	require_once("classes/admin.class.php");
else if(file_exists("../classes/admin.class.php"))
	require_once("../classes/admin.class.php");

	$adm_obj = new admin();

	$adm_res = $adm_obj->fetch_record($_SESSION['ses_admin_id']);
	
	$adm_data = mysql_fetch_object($adm_res[0]);
	$modules_arr = explode(",", $adm_data->assigned_modules);
	$chk_arr = $GLOBALS['available_modules'];

	if(!in_array("all",$modules_arr))
	{
		$chk_arr = array_intersect($GLOBALS['available_modules'], $modules_arr);
	}
	

	?>
      <table width=95% cellpadding="2" cellspacing="2"  border=0 align="center">
        <tr><?php 
		$for_ctr = 0;
		
		foreach($chk_arr as $key => $val) { 
		
		$for_ctr++;
		
		$url = $val;
		
		if(substr_count($val,"|") > 0)
		{
			$inner_array = explode("|",$val);
			$url = $inner_array[0];
		}
		
		
		?>
		
          <td height="40"><a href="<?php echo $url; ?>" class="top_menu_link"><?php echo $key; ?></a></td>
        
		<?php 
		
		if($for_ctr == 3)
		{
			echo "</tr>";
			$for_ctr = 0;
		}
		
		} ?></tr>
      </table>
	  <?php if(1 == 2) { ?>
      <table width=95% cellpadding="2" cellspacing="2"  border=0 align="center">
        <tr> 
          <td height="40"><strong><u>Configuration</u></strong></td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><a href="settings.php" class="top_menu_link">Manage 
            Configuration</a></td>
          <td height="40"><a href="shipment_settings.php" class="top_menu_link">Shipment 
            Configuration</a></td>
          <td height="40"><a href="payment_settings.php" class="top_menu_link">Payment 
            Configuration</a></td>
          <td height="40"><a href="project_settings.php" class="top_menu_link">Project 
            Configuration</a></td>
        </tr>
        <tr> 
          <td height="40"><strong><u>Staffs &amp; Users</u></strong></td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><a href="admin.php" class="top_menu_link">Manage Admins</a></td>
          <td height="40"><a href="emp.php" class="top_menu_link">Manage Employees</a></td>
          <td height="40"><a href="supplier_master.php" class="top_menu_link">Manage 
            Suppliers</a> </td>
          <td height="40"><a href="customers.php" class="top_menu_link">Manage 
            Users</a> </td>
        </tr>
        <tr> 
          <td height="40"><strong><u>Products</u></strong></td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><a href="topcategory.php" class="top_menu_link">Manage 
            Category</a> </td>
          <td height="40"><a href="productattributes.php" class="top_menu_link">Manage 
            Product Attributes</a></td>
          <td height="40"><a href="product_master.php" class="top_menu_link">Manage 
            Products</a></td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><strong><u>Store &amp; Shopping Cart</u></strong></td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><a href="store.php" class="top_menu_link">Manage Stores</a></td>
          <td height="40"><a href="orders.php" class="top_menu_link">Search Orders</a></td>
          <td height="40"><a href="taxes.php" class="top_menu_link"><br>
            </a></td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr>
          <td height="40"><a href="taxes.php" class="top_menu_link">Manage Country 
            Sales Tax</a></td>
          <td height="40"><a href="tax_state.php" class="top_menu_link">Manage 
            USA State Sales Tax<br>
            </a></td>
          <td height="40"><?php if($GLOBALS['site_config']['require_discount_coupon'] == 1) { ?><a href="dis.php" class="top_menu_link">Manage Discount 
            Coupons</a><?php } ?></td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><strong><u>Others</u></strong></td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><a href="shipping_method.php" class="top_menu_link">Manage 
            Shipping Methods</a></td>
          <td height="40"><a href="country.php" class="top_menu_link">Manage Countries</a></td>
          <td height="40"><a href="state.php" class="top_menu_link">Manage States</a></td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><strong><u>Template</u></strong></td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
          <td height="40">&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><a href="head_foot.php" class="top_menu_link">Manage 
            Header/Footer<br>
            </a></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td height="40" colspan="2"><strong><u>Content Management System</u></strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td height="40"><a href="template_settings.php" class="top_menu_link">Template 
            Configuration<br>
            </a></td>
          <td><a href="templates.php" class="top_menu_link">Manage Template<br>
            </a></td>
          <td><a href="edit_styles.php" class="top_menu_link">Manage Stylesheet<br>
            </a></td>
          <td><a href="staticcontents.php" class="top_menu_link">Manage Static 
            Pages<br>
            </a></td>
        </tr>
        <tr> 
          <td height="40"><a href="menu_settings.php" class="top_menu_link">Menu 
            Configuration<br>
            </a></td>
          <td><a href="menus.php" class="top_menu_link">Manage Menus<br>
            </a></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
	 <?php } ?>
 
	</td>
  </tr>
</table>


<?php 

require_once("admin_footer.php"); 

?>