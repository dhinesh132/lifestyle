 <style type="text/css">
/* tab styles start */
.ddoverlap{
border-bottom: 1px solid #bbb8a9;
}

.ddoverlap ul{
padding: 0;
margin: 0;
font: bold 90% default;
list-style-type: none;
}

.ddoverlap li{
display: inline;
margin: 0;
}

.ddoverlap li a{
padding: 3px 7px;
text-decoration: none;
padding-right: 32px; /*extra right padding to account for curved right edge of tab image*/
color: #000000;
background:transparent url(images/righttabdefault.gif) 100% 1px no-repeat; /*give illusion of shifting 1px down vertically*/
border-left: 1px solid #dbdbd5;
position: relative;

float: left;
margin-left: -20px; /*shift tabs 20px to the left so they overlap*/
left: 20px;
}

.ddoverlap li a:visited{
color: #000000;
}

.ddoverlap li a:hover{
text-decoration: underline;
color: #555555;
}

.ddoverlap li.selectedtab a{ /*selected tab style*/
color: black;
z-index: 100; /*higher z-index so selected tab is topmost*/
top: 1px; /*Shift tab 1px down so the border beneath it is covered*/
background:  transparent url(images/righttabselected.gif) 100% 0 no-repeat;
}

.ddoverlap li.selectedtab a:hover{
text-decoration: none;
color: #555555;
}
</style>



<?php 

$_SESSION['ses_continue_url'] = $_SERVER['REQUEST_URI'];
 
	$qry = "select " . $prod_obj->cls_tbl . ".* from " . $prod_obj->cls_tbl . ", " . $prodrefcat_obj->cls_tbl . " where " . $prod_obj->cls_tbl . ".prod_id = " . $prodrefcat_obj->cls_tbl . ".product_id and " . $prodrefcat_obj->cls_tbl . ".category_id = '" . $category_id . "' group by " . $prod_obj->cls_tbl . ".prod_id and " . $prod_obj->cls_tbl . ".prod_id = '" . $_REQUEST['prod_id'] . "' order by prod_name asc";

$res = $prod_obj->fetch_record($_REQUEST['prod_id']);

if($data = mysql_fetch_object($res[0]))
{

?>


<?php
$cat_heirarchy1 = $prodcat_obj->frame_category_heirarchy($data->category_id);
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
          <tr> 
            <!-- product name -->
            <td align="center" height="30"> <font class="productlink2_new"><?php echo stripslashes($data->prod_name); ?></font> 
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
		  
		  $big_img_path = $prod_obj->attachment_path . $data->prod_big_image;
		  $large_img_path = $prod_obj->attachment_path . $data->prod_large_image;
		  
		if(file_exists($big_img_path) && is_file($big_img_path))
		  	$disp_img = $big_img_path;
		else
			$disp_img = $prod_obj->attachment_path . 'default_large_prod.jpg';
		  
		  if(file_exists($large_img_path) && is_file($large_img_path))
		  list($width, $height, $param) = getimagesize($large_img_path);
		  
		  if(file_exists($disp_img) && is_file($disp_img))
		  list($disp_width, $disp_height, $disp_param) = getimagesize($disp_img);
		  
		  $url = "popimg.php?img1=$large_img_path";
		  
		  ?><div align="justify"> 
                    <!-- image -->
                    
                    <div><table align="left"><tr><td><a href="javascript:popup_window('<?php echo $url; ?>', <?php echo ($height + 60); ?>, <?php echo ($width + 40); ?>,'yes','yes');"><img src="<?php echo $disp_img; ?>" border="0" alt="<?php echo stripslashes($data->prod_name); ?>" align="left"></a></td></tr><tr><td>
					<a href="javascript:void(0);" onClick="popup_window('<?php echo $url; ?>', <?php echo ($height + 60); ?>, <?php echo ($width + 40); ?>,'yes','yes');"><font class="black_hint_font">Click 
                    Image to view Enlarge Image</font></a></td></tr></table>
					</div>
                   
                <p><font class="subtitles">By : </font> <em> 
                <?php 
				   $author_name=$GLOBALS[db_con_obj]->fetch_field("author","name","id='" .$data->author. "'");
				 
				    echo $author_name;
				    ?>
                </em><br>
                <font class="subtitles">Published By :</font> <em><?php echo stripslashes($data->published_by); ?></em></p>
				<p>&nbsp;<font class="subtitles">Retail&nbsp;Price&nbsp;:&nbsp;</font> 
                  <span class="product_price" id="rtpr"><?php echo "$ " . $data->prod_rt_price ?></span>&nbsp;&nbsp; 
                  <input name="image" align="absmiddle" type="image" style="border: 0px;" src="templates/godess/images/button_add_to_cart1.gif" alt="Add to cart" border="0">
                </p><p><?php echo nl2br(stripslashes($data->prod_desc)); ?></p>
              </div>
              <table cellpadding="2" cellspacing="0" width=98% border=0>
                <!-- Select Box1 -->
                <?php
				  $attribute_cnt = 0;
				  if(strlen(trim($data->product_attributes)) > 0)
				  {
				  $ctry_dd_name = "parent_id";
				  $nof_attr=$data->product_attributes;
				  $pieces = explode("|#|", $nof_attr);
				  $n=count($pieces);
				 		  					  
				  $select_option = $prod_obj->parent_id['value'];
				  
				  $category_default_selection = false;
				  
				  foreach($pieces as $ky => $val)
				  {

				 	$attr_dd_name = "prod_attribute" . $attribute_cnt;
				 
				 	$attr_dd_id = $attr_dd_name;
				 
				 	$attribute_cnt++;
				  
				  if(file_exists("../includes/properties_dropdown.php"))
				  
				  	include("../includes/properties_dropdown.php");
					
				  else
				
				  	include("includes/properties_dropdown.php");
					
				 }
				 
				 }
				 
				 if($attribute_cnt > 0)
				 {
				  ?>
                <script language="JavaScript">
				  has_attr = 1;
				  </script>
                <?php } ?>
                <!-- Price -->
                <tr id="ws_pr" class="<?php echo ($data->prod_ws_price <= 0)?"hidelayer":"showlayer"; ?>"> 
                  <!-- wholesale Price -->
                  <td colspan="2"> <font class="desc_lable">Wholesale&nbsp;Price</font> 
                  </td>
                  <td nowrap> <span class="product_price" id="wspr"><?php echo "$ " . $data->prod_ws_price; ?></span> 
                  </td>
                </tr>
                <!-- Price -->
                <?php if($GLOBALS['site_config']['require_product_discount'] == 1) { ?>
                <script language="JavaScript">
				  prod_individual_discount = 1;
				  </script>
                <?php if($data->prod_discount_val != 0 && $data->dis_st_dt <= date("Y-m-d") && $data->dis_end_dt >= date("Y-m-d") && $data->prod_parent_id != -1) { ?>
                <tr> 
                  <!-- if Discount -->
                  <td colspan="2"> <font class="desc_lable">Discount</font> </td>
                  <td nowrap> <font class="product_price"> 
                    <?php 
					  
					  if($data->prod_discount_val == -1)
					  	echo "Free Shipping";
					  else
					  	echo $data->prod_discount_val . " " . $data->prod_discount_typ; 
					  
					  
					  ?>
                    </font> </td>
                </tr>
                <!-- discount -->
                <?php 
				  
				  } 
				  
				  if($data->prod_parent_id == -1)
				  {
				  ?>
                <tr id="attrdisc_row" class="hidelayer"> 
                  <!-- if Discount -->
                  <td colspan="2"> <font class="desc_lable">Discount</font> </td>
                  <td nowrap> <span class="product_price" id="attr_discount"></span> 
                  </td>
                </tr>
                <!-- discount -->
                <?php } ?>
                <?php } ?>
                <?php if(1==2) { ?>
                <tr> 
                  <!-- if weight is needed -->
                  <td colspan="2"> <font class="desc_lable">Weight</font> </td>
                  <td nowrap> <span class="product_price" id="prwt"><?php echo $data->prod_weight . " (ounces)"; ?></span> 
                  </td>
                </tr>
                <!-- weight -->
                <?php } ?>
                <?php if(1==2) { ?>
                <tr> 
                  <td colspan="2"> <font class="desc_lable">Quantity</font> </td>
                  <td nowrap> <font class="product_price"> 
                    <input type="text" name="quantity" style="width : 50px;" value="1" onfocus="setbool(frm_obj.boolcheck,'1');" onblur="setbool(frm_obj.boolcheck,'0');" onkeypress="check_integer_value(this.value);">
                    </font> </td>
                </tr>
                <?php } ?>
                <tr> 
                  <td colspan="3" height=5></td>
                </tr>
                <!-- brake -->
                <?php
				  $satus=$data->prod_status;
				  
				  if($satus==1)
				  {
				  
				  $attr_val_res = $db_con_obj->fetch_flds($prod_obj->cls_tbl, "prod_rt_price,prod_ws_price,product_attributes,prod_weight,dis_st_dt,dis_end_dt,prod_discount_val,prod_discount_typ", "prod_parent_id = '" . $data->prod_id . "'");
				  
				  $exist_attr = "|#|";
				  $attr_price = "|#|";
				  $attr_disc = "|#|";
				  $attr_wt = "|#|";
				  
				  while($attr_val_data = mysql_fetch_object($attr_val_res[0]))
				  {
				  	
					$exist_attr .= $attr_val_data->product_attributes . "|#|-|#|";
					$attr_price .= $attr_val_data->prod_rt_price . "|#|" . $attr_val_data->prod_ws_price . "|#|-|#|";
					$attr_wt .= $attr_val_data->prod_weight . "|#|-|#|";
					
					if($attr_val_data->prod_discount_val == -1 && ($attr_val_data->dis_st_dt <= date("Y-m-d") && date("Y-m-d") <= $attr_val_data->dis_end_dt))
						$attr_disc .= "Free Shipping|#|-|#|";
					else if($attr_val_data->prod_discount_val > 0 && ($attr_val_data->dis_st_dt <= date("Y-m-d") && date("Y-m-d") <= $attr_val_data->dis_end_dt))
					{
						$attr_disc .= $attr_val_data->prod_discount_val . " " . $attr_val_data->prod_discount_typ . "|#|-|#|";
				  	}
					else
					{
						$attr_disc .= "Not Applicable|#|-|#|";
					}
					
				  }
				  
				  $exist_attr .= "|#|";
				  $attr_price .= "|#|";
				  $attr_wt .= "|#|";
				  
				  ?>
                <tr> 
                  <!-- Buy now button-->
                  <td colspan="3" align="center" valign="middle"> <input type="hidden" name="attribute_cnt" value="<?php echo $attribute_cnt; ?>"> 
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
				
				$allow_download = 0;

				$chk_res1 = $GLOBALS['db_con_obj']->fetch_flds("order_details", "prod_id, detail_id", "order_id = '" . $_REQUEST['ord_id'] . "' and prod_id = '" . $data->prod_id . "' and download_status = '0'");
				
				if($chk_res1[1] > 0)
				{//this book can be downloaded for the order

					$chk_res2 = $GLOBALS['db_con_obj']->fetch_flds("order_master", "user_id,dwn_link_status","order_id = '" . $_REQUEST['ord_id'] . "'");
					
					$chk_data2 = mysql_fetch_object($chk_res2[0]);
					
					//check whether the logged in user can download this book...
					$cust_status = ($chk_data2->user_id == $_SESSION['ses_customer_id'])?1:0;
					if($cust_status == 1)
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

							$qry = "select prod_id from order_details where order_id = '" . $order_id . "' and download_status = '0' and order_id = '" .$book_id . "' and prod_id not in (" . implode(",", $GLOBALS['consultations_prod_id']) . ")";
							$res = $GLOBALS['db_con_obj']->execute_sql($qry);
							
							while($dwn_data = mysql_fetch_object($res[0]))
							{
								$normal_str	= $normal_str . "-" . $dwn_data->prod_id;
							}
							
							$final_str = $download_prefix . $normal_str;
							$encrypt_str = md5($final_str);

							$download_link = "download_register.php";
							
							$_SESSION['ses_download_vars']['arg'] = $encrypt_str;
							$_SESSION['ses_download_vars']['bkid'] = $order_id;
							
							$_SESSION['ses_download_login'] = 1;
						}
						
					}
				
				}
				
				if($allow_download == 1)
				{
				
				?>
                <tr> 
                  <td colspan="3" align="center" valign="middle"><a href="<?php echo $download_link; ?>">Select 
                    this link to download your ebook !!</a></td>
                </tr>
                <?php
				 }
				 else
				 {
							unset($_SESSION['ses_download_vars']['arg']);
							unset($_SESSION['ses_download_vars']['bkid']);
							unset($_SESSION['ses_download_login']);
							unset($_SESSION['ses_download_book_id'][$data->prod_id]);
				 }
				 
				 
				  }
				  else
				  {
				  ?>
                <tr> 
                  <td colspan="3" align="center" height="30"> <font class="desc_prodhead"><?php echo "Currently Out Of Stock"; ?></font> 
                  </td>
                </tr>
                <?php
				  }
				  
				  ?>
              </table></td>
          </tr>
          <?php
		
		$chk_qry = "select products from " . $relprod_obj->cls_tbl . " where products like '" . $data->prod_id . ",%'  || products like '%," . $data->prod_id . "' || products like '%," . $data->prod_id . ",%'";
		
		$chk_res = $GLOBALS['db_con_obj']->execute_sql($chk_qry);
		
		if($chk_res[1] > 0)
		{
		  
		  ?>
          <tr> 
            <td align="left"><strong><u>Related eBooks</u></strong></td>
          </tr>
          <tr> 
            <td align="left">
              <?php require_once("forms/relproduct_short_list_frm.php"); ?>
            </td>
          </tr>
          <?php
		  
		  }
		  
		  ?>
          <tr> 
            <!-- Tab-->
            <td align="center"> <a name="tabs"></a> <table border="0" align="left" cellpadding="0" cellspacing="0">
                <tr> 
                  <td class="ddoverlap"  width="100%"> 
                    <?php if (1==2){ ?>
                    <li id="editor_rev_tb"><a href="#tabs" onClick="show_tab('editor_disp_rev_tab','editor_rev_tb');">Editor's 
                      Review </a></li>
                    <?php
					  }
					  ?>
                    <li id="sel_usr_rev_tb"><a href="#tabs" onClick="show_tab('usr_rev_tab','sel_usr_rev_tb');">User 
                      Reviews</a></li>
                    <?php if($_SESSION['ses_customer_id'] > 0) { ?>
                    <li id="sel_ur_rev_tb"><a href="#tabs" onClick="show_tab('ur_rev_tab','sel_ur_rev_tb');">Your 
                      Review </a></li>
                    <?php } ?>
                  </td>
                </tr>
                <?php
				  if(1==2) {
				  ?>
                <!-- Buy now button-->
                <tr> 
                  <td colspan="2" height=5px></td>
                </tr>
                <!-- brake -->
                <tr> 
                  <!-- Send page to Friend-->
                  <td colspan="2" align="center"> <a href='email_url.php?prod_id=<?php echo $data->prod_id; ?>' class="desc_link" target="_blank">Send 
                    Page to Friend</a> </td>
                </tr>
                <!-- end page to Friend-->
                <?php } ?>
              </table></td>
            <!-- SIZE -->
          </tr>
        </table></td>
      <!-- whole -->
    </tr>
  </form>
  <tr class="hidelayer" id="ur_rev_tab"> 
    <td>
      <?php
	$customer_id = $_SESSION['ses_customer_id'];
	 
	$res = $rev_obj->fetch_flds($rev_obj->cls_tbl, "*", "user_id ='".$customer_id."' and prod_id = '" .$data->prod_id . "'");
	$rev_data=mysql_fetch_object($res[0]);
		
	require_once("forms/your_review_frm.php");
	?>
    </td>
  </tr>
  <tr class="hidelayer" id="usr_rev_tab"> 
    <td>
      <?php
	
	
	include("forms/user_review.php");
	if($_SESSION['ses_customer_id'] <= 0)
	echo "<p><a href='cust_login.php'>Click here</a> to login and post your review !!</p>";
	?>
    </td>
  </tr>
</table>

<script language="JavaScript">
var frm_obj = eval("window.document.product_detail_frm");

</script>
<?php
}
else
{
?>
<span class="redfont">Product does not exists.</span>
<?php
}


?>
<script language="JavaScript">
var cust_login = 0;
</script>
<?php
if($_SESSION['ses_customer_id'] > 0)
{
?>
<script language="JavaScript">
cust_login = 1;
</script>
<?php
}
?>
<script language="JavaScript">
prev_tab = '';
prev_sel_tab = '';
function show_tab(tabname,sel_tb)
{
	if(tabname == 'ur_rev_tab' && cust_login == 0)
	{
		window.location.href = 'cust_login.php';
		return false;
	}
	var tabobj = window.document.getElementById(tabname);
	var sel_tabobj = window.document.getElementById(sel_tb);
	
	if(prev_tab.length > 0)
	{
		var prev_tabobj = window.document.getElementById(prev_tab);
		var prev_sel_tabobj = window.document.getElementById(prev_sel_tab);
		prev_tabobj.className = 'hidelayer';
		prev_sel_tabobj.className = '';
	}
	tabobj.className = 'showlayer';
	sel_tabobj.className = 'selectedtab';
	prev_tab = tabname;
	prev_sel_tab = sel_tb;
	
}
show_tab('usr_rev_tab','sel_usr_rev_tb');
</script>


