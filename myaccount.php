<?php 
$spl_doc_title = "Member";
require_once("header.php"); 
$BreadCrumb = "Myaccount"; 
require_once("classes/customers.class.php"); 
require_once("classes/order_master.class.php");
require_once("classes/order_details.class.php"); 
$cust_obj = new customers();
$ord_master_obj = new order_master();
$ord_detail_obj = new order_details();

if(isset($_SESSION['ses_customer_id']) && $_SESSION['ses_customer_id'] >1) {
	$res = $cust_obj->fetch_record($_SESSION['ses_customer_id']);	
	$cust_obj = set_values($cust_obj, "db", $res[0]);
}
else if($_SESSION['ses_customer_id'] ==1) {
	$redirect_url = $GLOBALS['site_config']['site_path'];
	header("location:$redirect_url");
	exit();
}
else
{	$redirect_url = $GLOBALS['site_config']['site_path']."login";
	header("location:$redirect_url");
	exit();	
}

$submit_action = $_REQUEST['submit_action'];

switch ($submit_action)
{

	case "save":			
			$id = $_REQUEST['cust_id'];
			if($id >0) {
				if($cust_obj->update($id))
					$redirect_url = "myaccount.php";
				else
					$redirect_url = "myaccount.php";				
				}			
			header("location:$redirect_url");
			exit();
	break;
	case "update_pwd":			
			$id = $_REQUEST['cust_id'];
			if($id >0) {
				if($cust_obj->update_pwd($id))
					$redirect_url = "myaccount.php";
				else
					$redirect_url = "myaccount.php";				
				}			
			header("location:$redirect_url");
			exit();
	break;
}

?>
<?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>My Account</div>
      </div>
      <div class="carttable w-clearfix">
       <?php	
		require_once(dirname(__FILE__) . '/includes/error_message.php');
		?>
        <div class="cart-table-con">
          <div class="account-info-blk">
            <p><strong>Name:</strong>&nbsp;<?php echo stripslashes($cust_obj->cust_firstname['value']); ?> <?php echo stripslashes($cust_obj->cust_lastname['value']); ?> [<?php echo stripslashes($cust_obj->cust_chinesename['value']); ?>].&nbsp;<a class="textlinks" href="<?php echo $GLOBALS['site_config']['site_path'];?>account/edit">[Edit Info]</a><br><strong>Email:</strong>&nbsp;<?php echo stripslashes($cust_obj->cust_email['value']); ?>&nbsp;<br><strong>Phone:</strong>&nbsp;<?php echo stripslashes($cust_obj->cust_phone['value']); ?>&nbsp;<br><strong>Landline:</strong>&nbsp;<?php echo stripslashes($cust_obj->cust_landline['value']); ?>&nbsp;<br><strong>Address:</strong>&nbsp;<?php echo stripslashes($cust_obj->cust_address1['value']); ?>, <?php echo stripslashes($cust_obj->cust_city['value']); ?> <?php echo stripslashes($cust_obj->cust_state['value']); ?> <?php echo $db_con_obj->fetch_field("country", "countryname", "countryid=".$cust_obj->cust_country['value']); ?> - <?php echo stripslashes($cust_obj->cust_zip['value']); ?><br><br><strong>Password:</strong>&nbsp;******** &nbsp;&nbsp;<a class="textlinks" href="<?php echo $GLOBALS['site_config']['site_path'];?>account/editpassword">[Change Password]</a></p>
          </div>
          <div class="side-title">Transaction History</div>
          <div class="cart-table-blk">
            <div class="cart-row his title">
              <div class="cartcol1 his">
                <div>Date</div>
              </div>
              <div class="cartcol2 his">
                <div>Order Number</div>
              </div>
              <div class="cartcol3 his">
                <div>Total</div>
              </div>
              <div class="cartcol5 his">
                <div>Status</div>
              </div>
              <div class="catcol6 his">
              <div>Invoice
              </div></div>
            </div>
             <?php 
					$order_res = $GLOBALS['db_con_obj']->fetch_flds($ord_master_obj->cls_tbl,"order_id,shipping_cost,payable_amount,order_status,date_entered,ship_tracking_number","user_id=".$_SESSION['ses_customer_id']." ORDER BY order_id DESC ");
					
                    if($order_res[1] >0){
					while($order_data = mysql_fetch_object($order_res[0])){
						$details_res = $GLOBALS['db_con_obj']->fetch_flds($ord_detail_obj->cls_tbl,"*","order_id=".$order_data->order_id);
						$row_span = $details_res[1]+1;
						$new=0;
						if($details_res[1] >0){
						while($detail_data = mysql_fetch_object($details_res[0])){
					?>
            <div class="cart-row his">
              <div class="cartcol1 his">
                <div><?php echo convert_date($order_data->date_entered,"M d, Y"); ?></div>
              </div>
              <div class="cartcol2 his" style="width:35% !important">
                <div class="cart-table-label">order number</div>
                <div><?php
						  if(strlen($order_data->order_id) <4){
							$len = strlen($order_data->order_id)+1;
							$str='';
							for($i=$len; $i<=4;$i++){
								$str .= "0";
							}
							}
							else
							$str='';
							//echo $str;
							$barcodeval = $str.$order_data->order_id;
				
							$barcodeval = date("Ymd",strtotime($order_data->date_entered)).$barcodeval;
								echo $barcodeval; ?></div>
              </div>
              <div class="cartcol3 his">
                <div class="cart-table-label">total</div>
                <div>$ <?php echo $detail_data->prod_unit_price?></div>
              </div>
              <div class="cartcol5 his">
                <div class="cart-table-label">status</div>
                <div><?php 
                            switch($order_data->order_status){			
							case 0:
								echo "Not Paid";
								break;
						
							case 1:
								echo "Paid, Shipment Pending";
								break;
							
							case 2:
								echo "Shipped" ;
								if(strlen($order_data->ship_tracking_number)>0)
								echo "<br> Tracking No: ".$order_data->ship_tracking_number;
								break;                       
                        };                         
                        ?></div>
              </div>
              <div class="catcol6 his">
                <div><a href="<?php echo $GLOBALS['site_config']['site_path'];?>invoice/<?php echo $order_data->order_id;?>" class="view-textlink">VIEW</a></div>
              </div>
            </div>
             <?php
					 $new=1;
                     } 
                     ?>
              <?php } } } else {?>
              <div class="cart-row his">
               <div class="cart-table-label">No order history!</div>
               </div>
               <?php } ?>
            
            
            
          </div>
        </div>
         <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
      </div>
   
 

<?php

require_once("footer.php"); 

?>