<script language="JavaScript">
function confirm_delete(item_ky)
{
	if(confirm('Are you sure to delete this item from the cart?\n(Ok = Yes, Cancel = No)'))
	window.location.href = "cart_process.php?submit_action=deletecart&del_key=" + item_ky;
}


</script>

<div class="cart-table-blk">
            <div class="cart-row title">
              <div class="cartcol1"><img class="blnkimg" src="images/Rectangle-33.jpg"></div>
              <div class="cartcol2">
                <div>Product Details</div>
              </div>
              <div class="cartcol2 weight">
                <div>Weight</div>
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
             
              <?php if($from_page == "basket") { ?><div class="catcol6"> <img class="blnkimg" src="<?php echo $GLOBALS['site_config']['site_path'] ?>images/Rectangle-33.jpg"> </div>
             <?php } ?>
            </div>
            <?php 
			//print_r($_SESSION['ses_cart_items']);
			if(is_array($_SESSION['ses_cart_items']))
			{
			
			$amount = 0;
			$weight = 0;
			//******************** changed 03022007
			$temp_tax_con=0;
			$tot_quantity =0;
			//************************************
			foreach($_SESSION['ses_cart_items'] as $k => $crt_obj) 
			{ 
			//$var = get_object_vars($crt_obj);
			$var = $crt_obj;
			
			//echo $var['prod_unit_price'];
			//echo $var['prod_quantity'];
			
			$temp_amount = format_number(round($var['prod_unit_price'] * $var['prod_quantity'], 2));
			if($var['Weight'] <=0)
				$temp_weight = format_number($GLOBALS['site_config']['prod_weight'] * $var['prod_quantity'], 3);
			else
				$temp_weight = format_number($var['Weight'] * $var['prod_quantity'], 3);
			$amount += $temp_amount;
			$weight += $temp_weight;
			//print_r($var);
			//******************** changed 03022007
			
			$prod_id = ($var['prod_prnt_id'] > 0)?$var['prod_prnt_id']:$var['prod_id'];
			require_once("classes/cart.class.php");
			$cart_class_obj = new cart();
			$a=$cart_class_obj->salestax($prod_id,$temp_amount);
			$temp_tax_con += $a;
			
			
			//*********************************
			//$res = $prod_obj->fetch_field($prod_obj->cls_tbl,"prod_med_image",$prod_obj->primary_fld . " = '" . $prod_id . "'");
			//$data = mysql_fetch_object($res[0]);
			
			$file_path = $var['prod_thumb_path'];
			
			if(file_exists($file_path) && is_file($file_path))
		  		$disp_img = $file_path;
			else
				$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
			?>
            <div class="cart-row">
              <div class="cartcol1"><img class="cartthumb" src="<?php echo $GLOBALS['site_config']['site_path'].$disp_img; ?>"></div>
              <div class="cartcol2">
                <div class="cart-table-label">Product Details</div>
                <div><?php echo $var['prod_name']; ?>
                <?php if($var['size'] >0) {
				echo "<div>Size: ".$GLOBALS['db_con_obj']->fetch_field('product_sizes','EnTitle','Id ='.$var['size']) ."</div>"; 
				} ?>
                <?php if($var['colour'] >0) {
				echo "<div>Colour : ".$GLOBALS['db_con_obj']->fetch_field('product_colours','EnTitle','Id ='.$var['size'])."</div>"; 
				} ?></div>
              </div>
              <div class="cartcol2 weight">
                <div class="cart-table-label">Product Details</div>
                <div><?php echo $var['Weight']; ?> Kg</div>
              </div>
              <div class="cartcol3">
                <div class="cart-table-label">Unit price</div>
                <div>$ <?php echo stripslashes($var['prod_unit_price']); ?></div>
              </div>
              <div class="cartcol4" style="clear:both">
                <div class="cart-table-label">quantity</div>
                <div><?php if($from_page == "basket") { ?><input type="text" class="n-field w-input" onchange="$('#cart_frm').submit();" name="quantity<?php echo $k?>" value="<?php echo $var['prod_quantity'] ?>" ><?php } else {?> <?php echo $var['prod_quantity'] ?><?php }?></div>
              </div> 
              <div class="cartcol5">
                <div class="cart-table-label">total</div>
                <div>$ <?php echo stripslashes($temp_amount); ?></div>
              </div>
              
              <?php if($from_page == "basket") { ?><div class="catcol6"><a href="#" onclick="confirm_delete('<?php echo $k; ?>')"><img src="images/remove.jpg" width="14"></a></div><?php } ?>
              
            </div>
            <?php 
		  $tot_quantity = $tot_quantity+$var['prod_quantity'];
		  }//end foreach
		  
		  }//end if(is_array($_SESSION['ses_cart']))
		  
		  if(count($_SESSION['ses_cart_items']) <= 0)
		  {
		  ?>
          
            <div class="cart-row">
             Cart is empty
            </div>
           <?php } ?>
            
          </div>
          
