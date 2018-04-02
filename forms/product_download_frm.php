<?php 

$_SESSION['ses_continue_url'] = $_SERVER['REQUEST_URI'];
 
	$qry = "select * from " . $prod_obj->cls_tbl . " where order by prod_name asc";

$res = $prod_obj->fetch_record($_REQUEST['prod_id']);

if($data = mysql_fetch_object($res[0]))
{

			

				
				$allow_download = 0;

				$chk_res1 = $GLOBALS['db_con_obj']->fetch_flds("order_details", "prod_id, detail_id", "order_id = '" . $_REQUEST['ord_id'] . "' and prod_id = '" . $data->prod_id . "' and download_status = '0'");
				
				if($chk_res1[1] > 0)
				{//this book can be downloaded for the order

					$chk_res2 = $GLOBALS['db_con_obj']->fetch_flds("order_master", "user_id,dwn_link_status","order_id = '" . $_REQUEST['ord_id'] . "'");
					
					$chk_data2 = mysql_fetch_object($chk_res2[0]);
					
					//check whether the logged in user can download this book...
					$cust_status = ($chk_data2->user_id == $_SESSION['ses_customer_id'])?1:0;
					if($cust_status == 1 )
					{//this customer can download this book...
						$allow_download = 1;
						//check whether the logged in user has already registered for this book...
						$reg_status = $chk_data2->dwn_link_status;
						
						if($reg_status == 1)
						{
							$chk_data1 = mysql_fetch_object($chk_res1[0]);
							$_SESSION['ses_download_book_id'][$data->prod_id] = $chk_data1->detail_id;
							$download_link = "download_book.php?pid=" . $data->prod_id;
						}
						else
						{
							$order_id = $_REQUEST['ord_id'];
							
							$download_prefix = "download" . $_SESSION['ses_customer_id'] . "-" . $order_id;
							
							$normal_str = "";

							$qry = "select prod_id from order_details where order_id = '" . $order_id . "' and download_status = '0' and prod_id not in (" . implode(",", $GLOBALS['consultations_prod_id']) . ")";
							$res = $GLOBALS['db_con_obj']->execute_sql($qry);
							
							while($dwn_data = mysql_fetch_object($res[0]))
							{
								$normal_str	= $normal_str . "-" . $dwn_data->prod_id;
							}
							
							$final_str = $download_prefix . $normal_str;
							$encrypt_str = md5($final_str);

							$download_link = "download_register.php?submit_action=save";
							
							$_SESSION['ses_download_vars']['arg'] = $encrypt_str;
							$_SESSION['ses_download_vars']['bkid'] = $order_id;
							
							$_SESSION['ses_download_login'] = 1;
						}
						
					}
				
				}


$spl_doc_title = $cat_heirarchy1 . " " . $data->prod_name;
?>
<p><font class="desc_cat"></font></p>
<script language="JavaScript">
var has_attr = 0;

function chk_attributes(frmname,purpose)
{
	var bool = true;
	if(has_attr == 1)
	{
		bool = true;
		var dc = eval('window.document.' + frmname);
		
		var attr_cnt = dc.attribute_cnt.value;

		//var exist_attr = '|#|' + dc.existing_attribute.value + '|#|';
		
		var exist_attr = dc.existing_attribute.value;
		
		var comp_val = '';
		select_attr = 0;
		//alert(attr_cnt);
		for(i = 0; i < attr_cnt; i++)
		{
			select_attr = 0;
			obj_name = "prod_attribute"+i;
			obj = document.getElementById(obj_name);
			
			if(obj != null && obj.value.length > 0)
			{
				comp_val += obj.value + "|#|";
				select_attr = 1;
			}
		}
		
		//alert(comp_val);
		//comp_val = comp_val.substr(0,(comp_val.length) - 3);
		comp_val = '|#|' + comp_val;
		//alert(exist_attr + " - " + comp_val);
		
		if(select_attr == 0)
		{
			if(purpose == 'formsubmitted')
			alert('* Select all product attributes!\n');
			
			bool = false;
		}
		if(exist_attr.indexOf(comp_val) == -1)
		{
			if(purpose == 'formsubmitted')
			alert('* Selected attribute combination does not exists!\n');
			
			bool = false;
		}
	
	}
	
	if(bool && purpose == 'formsubmitted' && (window.document.product_detail_frm.quantity.value.length==0 || window.document.product_detail_frm.quantity.value==0))
	{
	alert("* Quantity field should not be empty");
	bool = false;
	}

	return bool;
}
//has_attr = 1;
var prod_individual_discount = 0;
function set_price()
{

	if(chk_attributes('product_detail_frm','price'))
	{
		rtobj = window.document.getElementById('rtpr');
		wsobj = window.document.getElementById('wspr');
		wtobj = window.document.getElementById('prwt');
		if(prod_individual_discount == 1)
		diobj = window.document.getElementById('attr_discount');
		
		
		var dc = eval('window.document.product_detail_frm');
		
		var attr_cnt = dc.attribute_cnt.value;

		var attr_pr = dc.existing_attribute_price.value;
		
		var attr_wt = dc.attr_wt.value;

		var attr_dis = dc.attr_disc.value;
		
		var exist_attr = dc.existing_attribute.value;
		
		var comp_val = '';
		select_attr = 0;

		for(i = 0; i < attr_cnt; i++)
		{
			select_attr = 0;
			obj_name = "prod_attribute"+i;
			obj = document.getElementById(obj_name);
			
			if(obj != null && obj.value.length > 0)
			{
				comp_val += obj.value + "|#|";
				select_attr = 1;
			}
		}

		comp_val = '|#|' + comp_val;
		
		//alert(attr_wt);
		
		exist_attr_arr = exist_attr.split('-');
		attr_pr_arr = attr_pr.split('-');
		temp_wt = attr_wt.split('-');
		temp_dis = attr_dis.split('-');
		var tdis = '';
		for(j = 0; j < exist_attr_arr.length; j++)
		{
			//alert(exist_attr_arr[j] + ' + ' + attr_pr_arr[j] + ' = ' + comp_val);
			if(comp_val == exist_attr_arr[j])
			{
				temp_pr = attr_pr_arr[j].split('|#|');
				//alert(temp_pr[1] + ' - ' + temp_pr[2]);
				rtobj.innerText = '$ ' + temp_pr[1];
				wsobj.innerText = '$ ' + temp_pr[2];
				
				if(Math.abs(temp_pr[2]) > 0)
				{
					wobj = window.document.getElementById("ws_pr");
					wobj.className = 'showlayer';
				}
				
				wtobj.innerText = temp_wt[j].substring(3,(temp_wt[j].length - 3)) + " (ounces)";

				if(prod_individual_discount == 1)
				{
					tdis = temp_dis[j].substring(3,(temp_dis[j].length - 3));
					if(tdis != "Not Applicable")
					{
						diobj.innerText = temp_dis[j].substring(3,(temp_dis[j].length - 3));
						robj = window.document.getElementById('attrdisc_row');
						robj.className = 'showlayer';
					}
					else
					{
						robj = window.document.getElementById('attrdisc_row');
						robj.className = 'hidelayer';
					}
				}
				break;
			}
			
		} 

	}

}

 


</script>
<table cellpadding="4" cellspacing="0" width="98%" align="center" height=120px border=0>
  <form name="product_detail_frm" method="post" action="cart_process.php" onSubmit="return chk_attributes('product_detail_frm','formsubmitted');">
    <tr> 
      <td valign="top">
        <!-- whole -->
        <table cellpadding="4" cellspacing="0" width=100% height=120px border=0>
          <tr> 
            <td><font class="desc_cat"><?php echo $cat_heirarchy1; ?></font></td>
          </tr>
		  <?php if($reg_status == 1 && $allow_download == 1) { ?>
          <tr> 
            <td align="center" height="30"> <font class="greenfont">Thank you for purchasing ebook from us. Select the download icon and start downloading a copy of your eBook.</font> 
            </td>
          </tr>
		  <?php } else if($allow_download == 1) { ?>
          <tr> 
            <td align="center" height="30"> <font class="greenfont">Thank you for purchasing ebook from us. Kindly register your ebook with us.</font> 
            </td>
          </tr>
		<?php } else if ($cust_status = 1 && $allow_download == 0) { ?>
          <tr> 
            <td align="center" height="30"> <font class="redfont">To download 
              a book for the second time please contact admin at <a href="mailto:<?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?>"><?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?></a></font> 
            </td>
          </tr>
		  <?php } ?>
          <tr> 
            <!-- product name -->
            <td align="left" height="30"> <table width="100%"><tr><td width="42%" align="left"><font class="productlink2_new"><?php echo stripslashes($data->prod_name); ?></font></td></tr>
			<?php 
			if($allow_download == 1)
				{
				
				?>
			<tr>
            <td width="58%" align="left"><a href="<?php echo $download_link; ?>"><img align="absmiddle" type="image" style="border: 0px;" src="images/download_big.gif" alt="Add to cart" border="0"></a></td>
            </tr><?php
				 }
				 ?>
			</table>
            </td>
          </tr>
          <!-- product name -->
          <tr> 
            <td height=15></td>
          </tr>
          <!-- brake -->
          <tr valign="top"> 
            <!-- Middle part -->
            <td align="center"><?php 
		  
		 
		  
		  ?><div align="justify"> 
                    <!-- image -->
                    
                    
                   
                
				
                <?php
				
				if($allow_download == 1)
				{
				
				?>&nbsp; <!--
                  <a href="<?php echo $download_link; ?>"><img align="absmiddle" type="image" style="border: 0px;" src="images/download_big.gif" alt="Add to cart" border="0"></a>-->
               <?php
				 }
				 else
				 {
							unset($_SESSION['ses_download_vars']['arg']);
							unset($_SESSION['ses_download_vars']['bkid']);
							unset($_SESSION['ses_download_login']);
							unset($_SESSION['ses_download_book_id'][$data->prod_id]);
				 }
				
				?>
			    
              </div> 
<table cellpadding="2" cellspacing="0" width=98% border=0>
                <!-- Select Box1 -->
                
               
                <tr> 
                  <td colspan="2" height=5px></td>
                </tr>
                <!-- brake -->
                
                <tr> 
                  <!-- Buy now button-->
                  <td colspan="2" align="center" valign="middle"> 
                    <input type="hidden" name="attribute_cnt" value="<?php echo $attribute_cnt; ?>"> 
                    <input type="hidden" name="existing_attribute" value="<?php echo $exist_attr; ?>"> 
                    <input type="hidden" name="attr_disc" value="<?php echo $attr_disc; ?>"> 
                    <input type="hidden" name="attr_wt" value="<?php echo $attr_wt; ?>"> 
                    <input type="hidden" name="existing_attribute_price" value="<?php echo $attr_price; ?>"> 
                    <input type="hidden" name="submit_action" value="addtocart"> 
                    <input type="hidden" name="is_parent" value="<?php echo $data->prod_parent_id; ?>"> 
                    <input type="hidden" name="prod_id" value="<?php echo $data->prod_id; ?>"> 
                    <input type="hidden" name="quantity" value="1"> <input type="hidden" value="0" name="boolcheck"></td>
                </tr>
                <?php
				 
				 
				  }
				 
				  
				  ?>
              </table></td>
          </tr>
          
        </table></td>
      <!-- whole -->
    </tr>
  </form>
</table>

<script language="JavaScript">
var frm_obj = eval("window.document.product_detail_frm");

</script>
