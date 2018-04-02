<?php
$page = "prod-details";
$form_detail ="1";
$spl_doc_title = "Products";
require_once("header.php"); 
require_once("classes/products.class.php");
require_once("classes/shipping_settings.class.php");
require_once("classes/cart.class.php");
require_once("classes/prod_qty_notify.class.php");
//require_once("classes/temp_cart.class.php"); 
require_once(dirname(__FILE__) . '/classes/product_images.class.php');

$cart_obj = new cart();
$ship_obj =new shipping_settings();
$prod_obj = new products();
$notify_obj = new prod_qty_notify();
//$temp_cart = new temp_cart();
//$temp_cart->delete_temp_cart();
$gallery_obj = new product_images();
//$GLOBALS['site_config']['debug'] =1;
$res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl,"*","UniqueKey='".$key."' and ProdStatus=1  order by DisplayOrder"); 


//$data = mysql_fetch_object($res[0]);

//print_r($prod_data);
//$res = $prod_obj->fetch_record($_REQUEST['prod_id']);
if($res[1]<=0){
	header("location:index.php");
	exit;
}
$data = mysql_fetch_object($res[0]);





$product_id = $_REQUEST['prod_id'];

$dis_res = $GLOBALS['db_con_obj']->fetch_flds("promotion_banner","Id,Discount,Type","concat(',',ItemId,',') Like '%,".trim($data->Id).",%' and Discount >0 and Status=1");
if($dis_res[1] >0){
	$dis_data =mysql_fetch_object($dis_res[0]);
}

if($data->ProdType==2){
	$bredcruburl = $GLOBALS['site_config']['site_path']."publications";
	$BreadCrumb = PUBLICATION; 
}
else{
	$fun_res = $GLOBALS['db_con_obj']->fetch_flds('functions','UniqueKey','FunId in ('.$data->Function.')'); 
					 $function ='';
					 while($fun_data = mysql_fetch_object($fun_res[0])){
						$function = $fun_data->UniqueKey;
						break;
					 } 
	$bredcruburl = $GLOBALS['site_config']['site_path']."emblems/".$function;
    $BreadCrumb = "Products";
}

$submit_action = $_REQUEST['submit_action'];
$zoom = $_REQUEST['zoom'];
//print_r($_REQUEST);
//$GLOBALS['site_config']['debug'] =1;
switch ($submit_action)
{
	case "addtocart":		
		$cart_obj->add_product($cart_obj);	
		$redirect_url = $GLOBALS['site_config']['site_path']."cart";
		header("location:$redirect_url");
		exit();	
	break;
	
	case "inform_qty":
		$notify_obj->UserId['save_todb']='true';
		$notify_obj->ProdId['save_todb']='true';
		$notify_obj->EmailStatus['save_todb']='true';
		$notify_obj->date_entered['save_todb']='true';
		$notify_obj->UserId['value']=$_SESSION['ses_customer_id'];
		$notify_obj->ProdId['value']=$_REQUEST['prod_id'];
		$notify_obj->EmailStatus['value']=0;
		$notify_obj->date_entered['value']=date("Y-m-d H:i:s");
		$notify_obj->insert();
		header("location:product_detail.php?prod_id=".$_REQUEST['prod_id']);
		exit();	
	break;
	
}

if(!in_array($data->Id,$_SESSION['ses_recent_visited'])){
	$_SESSION['ses_recent_visited'][] =  $data->Id;
}
?>

   <?php require_once(dirname(__FILE__) . '/templates/breadcrumbs.php'); ?>  
  
      <div class="product-blk w-clearfix">
       <?php require_once(dirname(__FILE__) . '/templates/product_images.php'); ?>  
        
        <div class="prod-main-info">
          <div class="prod-big-name"><?php echo display_field_value($data,"Name");?></div>
           <?php //require_once(dirname(__FILE__) . '/templates/prod_stars.php'); ?>  
          <div class="spacer"></div>
          <div class="prod-section-title"><strong>Description:</strong> <?php echo $data->EnShortDesc; ?></div>
            <?php if($data->ProdType==1){ ?>
          <p class="prod-des"><strong>Function:</strong> <?php $fun_res = $GLOBALS['db_con_obj']->fetch_flds('functions','EnName','FunId in ('.$data->Function.')'); 
					 $function ='';
					 while($fun_data = mysql_fetch_object($fun_res[0])){
						$function .= $fun_data->EnName.", ";
					 } 
					 echo substr($function,0,-2);
					 ?><br><br><strong>Type:</strong>
					 <?php 
					  $type='';
					 $typs_res = $GLOBALS['db_con_obj']->fetch_flds('types','EnName','TypeId in ('.$data->Types.')'); 
					 while($typs_data = mysql_fetch_object($typs_res[0])){
						 $type .=$typs_data->EnName.", ";
					 } 
					 echo substr($type,0,-2);
					 ?><br><br>
                     
                     <?php } ?>All prices are inclusive of GST.</p>
          <div class="spacer"></div>
          <div class="main-price" id="price-box">
            <div class="price-main">SGD <?php echo format_number(product_price($data->Id,$data->Price)); ?></div>
            <?php if($dis_res[1] >0){ ?>
            <div class="disc price-main">SGD <?php echo stripslashes($data->Price); ?></div>
            <?php } ?>
          </div>
          <?php if($dis_res[1] >0){ ?>
         <div class=" mainprod percent " style=" background-color: #df1995;"><?php echo display_promo($dis_data->Discount,$dis_data->Type) ?></div>
          <?php } ?>
          <div class="prodform-blk ">
            <form data-name="Email Form 4" id="email-form-4" name="email-form-4" method="post">
            <?php
			  $colour_res = $GLOBALS['db_con_obj']->fetch_flds('product_colours','Id,EnTitle','ProdId ='.$data->Id); 
			  if($colour_res[1] >0){
			  ?>
              <div class="prod-section-title">color: <span class="red"></span></div>
              <select class="color-drop w-select" data-name="Colors" id="Colors" name="Colors">
              
                <option value="">Select one...</option>
                <?php  while($colour_data = mysql_fetch_object($colour_res[0])){?>
                <option value="<?php echo $colour_data->Id?>"><?php echo $colour_data->EnTitle?></option>
               <?php } ?>
                </select>
              <div class="spacer"></div>
                 <?php
				 } else {?>
                 <input type="hidden" name="Colors" id="Colors" value="0"  />
				 <?php } ?>
                 <?php 
				  $size_res = $GLOBALS['db_con_obj']->fetch_flds('product_sizes','Price,Id,EnTitle','ProdId ='.$data->Id.' order by DisplayOrder'); 
				  if( $size_res[1] >0){
				  ?>
              <div class="prod-section-title">size: <span class="red"></span></div>
              <div class="size-select">
                <ul class="w-list-unstyled">
              <?php 
			      $radio ='checked="checked"'; 
				  while($size_data = mysql_fetch_object($size_res[0])){
					  
				  $price = $size_data->Price;
				  //if($size_data->Price;)
				  ?>
                  <li class="size-bullets">
                    <div class="radiobtn-blk w-radio"><input class="radio-input w-hidden-main w-hidden-medium w-hidden-small w-hidden-tiny w-radio-input" data-name="sizes" id="<?php echo $size_data->EnTitle?>" name="sizes" type="radio" value="<?php echo $size_data->Id?>" onclick="get_dynamic_dropdown('price-box', '../ajax_content.php', 'required=prod-price&prod=<?php echo $data->Id?>&price=<?php echo $price;?>&size=<?php echo $size_data->Id;?>')" <?php echo $radio ?>>
                    <label class="size-label w-form-label" for="<?php echo $size_data->EnTitle?>"><?php echo $size_data->EnTitle?></label></div>
                  </li>
                  <?php  $radio =''; } ?>
                </ul>
              </div>
              <div class="spacer"></div>
             <?php
				 } else {?>
                 <input type="hidden" name="sizes" id="sizes" value="0"  />
				 <?php } ?>
               <?php if($data->ProdType==2){
						$res = $GLOBALS['db_con_obj']->fetch_flds("authors","EnName,ChName","AuthId=".$data->AuthorId);
						$author = mysql_fetch_object($res[0]);
						$authorName=  display_field_value($author,"Name"); ?>
              <div class="prod-section-title"><strong>Author: </strong><span class="red"></span></div>
              <?php echo $authorName ?>
              <div class="spacer"></div>
              <?php } ?>
                <?php if($data->Quantity >0){ ?>
              <div class="prod-section-title">quantity: <span class="red"></span></div>
              <div class="quantity-block">
              <a class="link-block minus w-inline-block" href="#" onclick="PacDecQty($('#quantity').val());"><img class="image" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/minus.png" width="25"></a>
              <input class="q-filed w-input" data-name="quantity" id="quantity" maxlength="256" name="quantity" type="text" value="1">
              <a class="link-block plus w-inline-block" href="#" onclick="PacIncQty($('#quantity').val())"><img class="image" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/plus.png" width="25"></a>
              </div>
              <div class="cart-buttonas"><input class="buynow-btn w-button" data-wait="Please wait..." type="submit" value="Buy now »" >
              <input class="add-cart-btn w-button" type="button" value="Add to cart" onclick="get_dynamic_dropdown('addtocart', '../ajax_content.php', 'required=add-to-cart&prod=<?php echo $data->Id?>&qty='+$('#quantity').val()+'&Colors='+$('#Colors').val()+'&size='+$('input[name=sizes]:checked').val()); $('#addtocart').focus()">
              <input type="hidden" name="submit_action" value="addtocart">
               <input type="hidden" value="<?php echo $data->Id; ?>" name="prod_id">
               <input type="hidden" name="realQty" value="<?php echo $data->Quantity; ?>">
               <input type="hidden" name="Id" value="<?php echo $data->Id; ?>">
               <input type="hidden" value="0" name="boolcheck"></div>
               <?php } else { ?>
               <div class="main-price" id="price-box">
            	<input class="update-cart-btn w-button" type="button" value="Out of Stock"  />
                </div>
            <?php }?>
            </form>
           <div id="addtocart"></div>
          </div>
        </div>
      </div>
      <div class="description-tab-blk">
        <div class="w-tabs" data-duration-in="300" data-duration-out="100">
          <div class="w-tab-menu">
            <a class="prodinfo-tab-links w--current w-inline-block w-tab-link" data-w-tab="Description">
              <div>Description</div>
            </a>
            <a class="prodinfo-tab-links w-inline-block w-tab-link" data-w-tab="Info">
              <div>Info</div>
            </a>
            <a class="prodinfo-tab-links w-inline-block w-tab-link" data-w-tab="Shipping">
              <div>Shipping</div>
            </a>
          </div>
          <div class="w-tab-content">
            <div class="tabpan-des w--tab-active w-tab-pane" data-w-tab="Description">
              <?php echo display_field_value($data,"LongDesc");?>
            </div>
            <div class="tabpan-des w-tab-pane" data-w-tab="Info">
             <?php echo display_field_value($data,"Info");?>
            </div>
            <div class="tabpan-des w-tab-pane" data-w-tab="Shipping">
              <div class="tableembed w-embed">
               <?php require_once(dirname(__FILE__) . '/templates/shippingtable.php')?>
               
              </div>
            </div>
          </div>
        </div>
      </div>
       <?php 
	   require_once(dirname(__FILE__) . '/templates/recommend_product.php');
	   ?>  
      
    


<?php 

require_once("footer.php"); 

?>
