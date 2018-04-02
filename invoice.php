<?php 
$spl_doc_title ="cart";
require_once("header.php"); 
$BreadCrumb = INVOICEBREADCRUMB;
require_once("classes/order_master.class.php");
require_once("classes/products.class.php");
$ord_m_obj = new order_master();
$ord_d_obj = new order_details();
$prod_obj = new products();


$order_id = $_REQUEST['order_id'];
$master_res = $ord_m_obj->fetch_record($_REQUEST['order_id']);
$detail_res = $ord_d_obj->fetch_flds("order_details","*", "order_id = '" . $_REQUEST['order_id'] . "'");

$master_data = mysql_fetch_object($master_res[0]);

if(isset($_SESSION['ses_customer_id'])) {
	if($master_data->user_id !=$_SESSION['ses_customer_id']){
		$redirect_url = "myaccount.php";	
		header("location:$redirect_url");
		exit();	
	}
}
else
{	$redirect_url = "cust_login.php";	
	header("location:$redirect_url");
	exit();	
}

$paymeth = $master_data->pay_method;

?>
  <?php  require_once("templates/breadcrumbs.php"); ?>
      <div class="pagetitle">
        <div>Invoice</div>
      </div>
      <div class="carttable w-clearfix">
       <?php	
		require_once(dirname(__FILE__) . '/includes/error_message.php');
		?>
        <div class="cart-table-con">
          <div class="invoice-info">
            <div class="invoice-info-blk w-clearfix">
              <div class="invoice-col1">
                <p><?php	
			   echo trim(stripslashes($GLOBALS['site_config']['company_name'])) . "<br>";
			   echo nl2br(stripslashes($GLOBALS['site_config']['company_address'])) . "<br>";
			  ?>
              <?php if($master_data->ship_country ==189 && 1==2){?>
              GST REG <?php echo $GLOBALS['site_config']['gst_reg_no'];
			  }
			  ?></p>
              </div>
              <div class="invoice-col2">
                <p><strong>Invoice Number:</strong>&nbsp;<?php
		  if(strlen($order_id ) <4){
			$len = strlen($order_id )+1;
			for($i=$len; $i<=4;$i++){
				$str .= "0";
			}
			}
			else
			$str='';
			//echo $str;
			$barcodeval = $str.$order_id ;

			$barcodeval = date("Ymd",strtotime($master_data->date_entered)).$barcodeval;
		   echo $barcodeval; ?>&nbsp;<br><strong>Date:</strong>&nbsp;<?php echo convert_date($master_data->date_entered); ?>&nbsp;<br><strong>Status:</strong>&nbsp;<span class="green"><?php 
			//echo $master_data->order_status;
			switch($master_data->order_status)
			{
			
				case 0:
					echo "Not Paid";
					break;
				
				case 1:
					echo "Paid, Shipment Pending";
					break;
				
				case 2:
					echo "Shipped";
					if(strlen($master_data->ship_tracking_number)>0)
					echo "<br> Tracking No: ".$master_data->ship_tracking_number;
					break;
				
			}; 
			
			?></span></p>
              </div>
            </div>
            <div class="invoice-info-blk w-clearfix">
              <div class="invoice-col1">
                <p><strong>Bill To:</strong><br><?php  
		  
		  	 echo stripslashes($master_data->bill_fname)." ".stripslashes($master_data->bill_lname) . "<br>";
              echo stripslashes($master_data->bill_ads1).", ".stripslashes($master_data->bill_ads2) . ",<br>";
			   if(strlen(trim($master_data->bill_unit)) > 0)
			   echo stripslashes($master_data->bill_unit) . ", ";
			  if(strlen(trim($master_data->bill_building)) > 0)
              	echo stripslashes($master_data->bill_building) . ",<br>";
              else
			  echo ",<br>";
			  echo stripslashes($master_data->bill_city).", ";
			  if(strlen(trim($master_data->bill_state)) > 0)	
              	echo stripslashes($master_data->bill_state).",<br>";
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->bill_country . "'");
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry . ", " . $master_data->bill_zip);?>.<br /> 
			  <?php 
			  echo "Email :". $master_data->bill_email."<br>";
			  echo "Mobile :". $master_data->bill_mobile."<br>";
			  if(strlen($master_data->bill_landline) >0)
			  echo "Landline :". $master_data->bill_landline."<br>";
			  ?></p>
              </div>
              <div class="invoice-col2">
                <p><strong>SHIP TO (IF DIFFERENT ADDRESS)</strong><br><?php  
		  
		  	 echo stripslashes($master_data->ship_fname) ." ".stripslashes($master_data->ship_lname) ."<br>";
              echo stripslashes($master_data->ship_ads1).", ".stripslashes($master_data->ship_ads2) . ",<br>";
			   if(strlen(trim($master_data->ship_unit)) > 0)
			   echo stripslashes($master_data->ship_unit) . ", ";
			  if(strlen(trim($master_data->ship_building)) > 0)
              	echo stripslashes($master_data->ship_building) . ",<br>";
              else
			  echo ",<br>";
			  echo stripslashes($master_data->ship_city).", ";  
			   if(strlen(trim($master_data->ship_state)) > 0)	
			  		echo stripslashes($master_data->ship_state).",<br>";
			  
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $master_data->ship_country . "'");
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry . ", " . $master_data->ship_zip);  ?>.<br />
			  <?php 
			  echo "Email :". $master_data->ship_email."<br>";
			  echo "Mobile :". $master_data->ship_mobile."<br>";
			  if(strlen($master_data->ship_landline) >0)
			  echo "Landline :". $master_data->ship_landline."<br>";
			 ?><span class="green"></span></p>
              </div>
            </div>
          </div>
          <div class="cart-table-blk">
            <div class="cart-row title">
              <div class="cartcol1"><img class="blnkimg" src="images/Rectangle-33.jpg"></div>
              <div class="cartcol2">
                <div>Product Details</div>
              </div>
              <div class="cartcol3">
                <div>Unit Price</div>
              </div>
              <div class="cartcol4">
                <div>Qty</div>
              </div>
              <div class="cartcol5">
                <div>Total</div>
              </div>
            </div>
             <?php 
		if($detail_res[1] >0){
			while($ord_dets_data = mysql_fetch_object($detail_res[0])) { 
			
			$prod_res = $GLOBALS['db_con_obj']->fetch_flds("products","EnName,ChName,Image,Weight","Id='".$ord_dets_data->prod_id."'");
			$prod_data = mysql_fetch_object($prod_res[0]);
			
			
			$file_path = $prod_obj->attachment_path . $prod_data->Image;
			if(file_exists($file_path) && is_file($file_path))
		  		$disp_img = $file_path;
			else
				$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
			?>
            <div class="cart-row">
              <div class="cartcol1"><img class="cartthumb" src="<?php echo $GLOBALS['site_config']['site_path']; ?><?php echo $disp_img; ?>"></div>
              <div class="cartcol2">
                <div class="cart-table-label">Product Details</div>
                <div><?php echo display_field_value($prod_data,"Name");?>
                <?php echo $var['prod_name']; ?>
                <?php if($ord_dets_data->size >0) {
				echo "<div>Size: ".$GLOBALS['db_con_obj']->fetch_field('product_sizes','EnTitle','Id ='.$ord_dets_data->size) ."</div>"; 
				} ?>
                <?php if($ord_dets_data->colour >0) {
				echo "<div>Colour : ".$GLOBALS['db_con_obj']->fetch_field('product_colours','EnTitle','Id ='.$ord_dets_data->colour)."</div>"; 
				} ?></div>
              </div>
              <div class="cartcol3">
                <div class="cart-table-label">Unit price</div>
                <div>$ <?php echo $ord_dets_data->prod_unit_price; ?></div>
              </div>
              <div class="cartcol4">
                <div class="cart-table-label">quantity</div>
                <div><?php echo $ord_dets_data->prod_quantity?></div>
              </div>
              <div class="cartcol5">
                <div class="cart-table-label">total</div>
                <div>$ <?php  $ext_price = format_number($ord_dets_data->prod_unit_price * $ord_dets_data->prod_quantity);
									  echo $ext_price; 
									  $sub_total += $ext_price ?></div>
              </div>
            </div>
             <?php 
		  $tot_quantity = $tot_quantity+$var['prod_quantity'];
		  }//end foreach
		}
		?>
            
            
          </div>
          <div class="sub-totalblk">
            <div class="newsubtotalblk">
              <div class="subrow">
                <div class="sublabel">
                  <div>Sub-Total (GST Incl.)</div>
                </div>
                <div class="subtotalnew">
                  <div>$ <?php echo format_number($sub_total); ?></div>
                </div>
              </div>
               <?php if($master_data->ship_country !=189){?>
               <div class="subrow">
                <div class="sublabel">
                  <div>GST <?php echo $GLOBALS['site_config']['gst_percentage']?>% </div>
                </div>
                <div class="subtotalnew">
                  <div>- $ <?php echo format_number($master_data->tax_collected); ?></div>
                </div>
              </div>
              <?php } ?>
              <div class="subrow">
                <div class="sublabel">
                  <div>Shipping Cost</div>
                </div>
                <div class="subtotalnew">
                  <div>$ <?php echo format_number($master_data->shipping_cost); ?></div>
                </div>
              </div>
              <div class="subrow">
                <div class="sublabel total">
                  <div class="totaltext">Total Cost</div>
                   <?php if($master_data->ship_country ==189){?>
                  <div class="gsttext">Inclusive of GST <?php echo $GLOBALS['site_config']['gst_percentage']?>% ($<?php echo format_number($master_data->tax_collected); ?>)</div>
                  <?php } ?>
                </div>
                <div class="subtotalnew total">
                  <div class="totaltext">$ <?php echo format_number($master_data->payable_amount); ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php require_once(dirname(__FILE__) . '/templates/recently_viewed.php'); ?>
      </div>
    

<?php 
	require_once("footer.php"); 

?>