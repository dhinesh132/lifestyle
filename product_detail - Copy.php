<?php
$form_detail ="1";
$spl_doc_title = "Products";
require_once("header.php"); 
require_once("classes/products.class.php");
require_once("classes/shipping_settings.class.php");
require_once("classes/cart.class.php");
require_once("classes/prod_qty_notify.class.php");
$cart_obj = new cart();
$ship_obj =new shipping_settings();
$prod_obj = new products();
$notify_obj = new prod_qty_notify();

$res = $prod_obj->fetch_record($_REQUEST['prod_id']);

if($res[1]<=0){
	header("location:index.php");
	exit;
}

$data = mysql_fetch_object($res[0]);
if($data->ProdType==2){
	$bredcruburl = "publication_lists.php";
	$BreadCrumb = PUBLICATION; 
}
else{
	$bredcruburl = "product_lists.php";
    $BreadCrumb = PRODUCTSBREADCRUMB;
}

$submit_action = $_REQUEST['submit_action'];
$zoom = $_REQUEST['zoom'];
//print_r($_REQUEST);
//$GLOBALS['site_config']['debug'] =1;
switch ($submit_action)
{
	case "addtocart":		
		$cart_obj->add_product($cart_obj);		
		header("location:basket.php");
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

?>

<script type="text/javascript" src="mega_zoom/swfobject.js"></script>
 <div id="content">
 <?php 
 require_once("includes/breadcrumbs.php");
 
 				$img_path = $prod_obj->attachment_path . $data->Image;
				 
				if(file_exists($img_path) && is_file($img_path))
		  			$disp_img = $img_path;
				else
					$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
 ?>
    <div id="product-detail">
            <div class="left">
            <?php if($zoom==1){ ?>
              <div class="product-detail" id="megazoom"><img src="phpthump/phpThumb.php?src=../<?php echo $disp_img; ?>&w=530&h=430&q=75" border="0" alt="<?php echo display_field_value($data,"Name");?>" title="<?php echo display_field_value($data,"Name");?>"></div>
              <p><img src="images/zoom.png" alt="" /> <a href="product_detail.php?prod_id=<?php echo $data->Id?>"><?php echo ZOOM ?></a>
			  <?php
			  if(strlen($data->Video) >0){?>
			   | <a href="#"><?php echo VIEWVIDEO ?></a><?php } ?>
               </p>
              <?php } else {?>
              <div class="product-detail" ><img src="phpthump/phpThumb.php?src=../<?php echo $disp_img; ?>&w=530&h=430&q=75" border="0" alt="<?php echo display_field_value($data,"Name");?>" title="<?php echo display_field_value($data,"Name");?>"></div>
              
                    <p><img src="images/zoom.png" alt="" /> <a href="product_detail.php?prod_id=<?php echo $data->Id?>&zoom=1"><?php echo ZOOM ?></a>
                    <?php
			  if(strlen($data->Video) >0){?>
			   | <a href="#"><?php echo VIEWVIDEO ?></a><?php } ?></p>
                    <?php }?>
                </div>
                
                <div class="right">
                <?php require_once("includes/error_message.php");?>
                    <h1><?php echo display_field_value($data,"Name");?></h1><br />
                    <?php if($data->Price <=0){?>
                    <em>SGD <?php echo $data->Price;?> <br /><br />*Item is currently unavailable</em>
                    <?php } else {?>
                    <em>SGD <?php echo $data->Price;?></em>
                    <?php }?>
                    <br /><br />
                    <?php
					if($data->ProdType==2){
						$res = $GLOBALS['db_con_obj']->fetch_flds("authors","EnName,ChName","AuthId=".$data->AuthorId);
						$author = mysql_fetch_object($res[0]);
						$authorName=  display_field_value($author,"Name");
					 	echo LANGBY." : ".$authorName;
					}
					else
					 echo display_field_value($data,"ShortDesc");?><br /><br />
                   
                    
                    <div class="domtab">
                        <ul class="domtabs">
                            <li ><a href="#description"><?php echo DESCRIPTION?></a></li>
                            <li style="width:60px"><a href="#info"><?php echo INFO?></a></li>
                            <li style="margin-left:0"><a href="#shippingcalc"><?php echo SHIPPING?></a></li>
                         </ul>
                         
                    <div class="news" style="height:200px; width:400px; overflow-x: auto;"> 
                      <p  id="description">
                         <?php echo display_field_value($data,"LongDesc");?>
                      </p>
                      
                    </div>
      
                    <div class="events" style="height:200px; width:400px; overflow-x: auto;">
                      <p id="info"> <?php echo display_field_value($data,"Info");?></p>
                      
                    </div>
                    
                    <div>
                      <p id="shipping">
                      <?php include("includes/shippingtable.php")?>
                    </div>
             </div> <!--domtab-->
             	<script language="javascript" type="text/jscript">
				function check_validate()
				{
					 check_empty(form.elements["quantity"].name,"Please select Quantity!");
				}
			     </script>

             	<form name="addcart" id="addcart" action="" enctype="multipart/form-data" method="post" onSubmit="">
                        <table>
                        <tr><td>
                       <select class="select" title="Select one" name="quantity">
                            <option value=""><?php echo SELECTQUANTITY?>: </option>
                            <?php 
							$prod_qty = ProductQuantity($data->Id);
							if($prod_qty <=10)
								$totQty = $prod_qty;
							else
							    $totQty = 10;
							for($qty=1;$qty<=$totQty;$qty++){?>
                            <option value="<?php echo $qty; ?>"><?php echo $qty; ?></option>
                            <?php }?>
                        </select></td>
                        
                        <td>
                        <?php
						$report =0; 
						if($prod_qty <=0)
						    $report = 1;
						else if($data->Price <=0)
							$report = 1;
							 
						if($report ==1 && $_SESSION['ses_customer_id']){?>
                        <input type="hidden" name="submit_action" value="inform_qty">
                        <a href="javascript:void(0)" onclick="$('#addcart').submit();" style="margin-left:10px; color:#FFFFFF" class="cart_gradient-btn"><img src="images/white-arrow.png" alt="" style=" margin-right:2px"/><?php echo REPORT ?></a>
                        <?php } else if($report ==1){?>
                        <a href="#login-box" class="login-window orage_gradient-btn" onclick='$( "#prodId" ).val(<?php echo $data->Id;?>);' style="margin-left:10px; color:#FFFFFF"><img src="images/white-arrow.png" alt="" style=" margin-right:2px"/><?php echo LOGIN ?></a>
                        <?php }else {?>
                             <input type="hidden" name="submit_action" value="addtocart">
                            <a href="javascript:void(0)" onclick="if(check_form(window.document.addcart)){$('#addcart').submit();};" style="margin-left:10px; color:#FFFFFF" class="cart_gradient-btn"><img src="images/white-arrow.png" alt="" style=" margin-right:2px"/><?php echo ADDCART ?></a>
                            <?php }?>
                        </td></tr>
                        </table>
                            <input type="hidden" value="<?php echo $data->Id; ?>" name="prod_id">
                            <input type="hidden" name="realQty" value="<?php echo $data->Quantity; ?>">
                            <input type="hidden" name="Id" value="<?php echo $data->Id; ?>">
                            <input type="hidden" value="0" name="boolcheck">
						</form>
                       <br />
              <script type="text/javascript">
				var swf = new SWFObject("mega_zoom/megazoom.swf", "megazoom", "530", "430", "7.0.22", "#FFFFFF", true)
				swf.addParam("base", "./");
				swf.addParam("scale", "noscale");
				swf.addParam("salign", "lt");
				swf.addParam("wmode", "transparent");
				swf.addVariable("contentWidth", "530")
				swf.addVariable("contentHeight", "430")
				swf.addVariable("imageUrl", "<?php echo $disp_img; ?>");
				swf.addVariable("imageButton","false");
				swf.addVariable("zoomMax", "100");
				swf.addVariable("zoomStep","10");
				swf.addVariable("zoomStart","10");
				swf.addVariable("navigator","true");
				swf.addVariable("navigatorSize","60");
				swf.addVariable("navigatorMode","3");
				swf.write("megazoom")
			</script>
                       
                       
             
          </div>  <!--right-->     
             
          </div>
          <?php
		   	include("forms/recommend_product.php");
		   ?>  
     </div>

<?php 

require_once("footer.php"); 

?>
