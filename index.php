<?php 
$from_page = "index";
require_once("header.php"); 
require_once("classes/banner_master.class.php");
require_once("classes/promotion_banner.class.php");
$ban_obj = new banner_master();
$promo_obj = new promotion_banner();
?>

<div data-delay="6000" data-animation="slide" data-autoplay="1" data-duration="500" data-infinite="1" class="mainslider w-slider">
        <div class="w-slider-mask">
        <?php 
		$ban_res = $GLOBALS['db_con_obj']->fetch_flds($ban_obj->cls_tbl,"*","ban_status=1 order by display_order desc");
		while($ban_data = mysql_fetch_object($ban_res[0])){
			$banner_image = display_field_value($ban_data,"Banimage");
			$image_path = $ban_obj->attachment_path.$banner_image;
		?>
        
          <div class="slide1 w-slide">
          <a href="<?php echo $ban_data->ban_link ?>" ><img src="<?php echo $image_path?>" sizes="(max-width: 479px) 100vw, (max-width: 767px) 95vw, 96vw" class="slider-img"></a></div>
          <?php } ?>
        </div>
        <div class="w-hidden-main w-hidden-medium w-hidden-small w-hidden-tiny w-slider-arrow-left">
          <div class="w-icon-slider-left"></div>
        </div>
        <div class="w-hidden-main w-hidden-medium w-hidden-small w-hidden-tiny w-slider-arrow-right">
          <div class="w-icon-slider-right"></div>
        </div>
        <div class="slider-nav w-round w-slider-nav"></div>
      </div>
      
      
      
      <?php require_once(dirname(__FILE__) . '/templates/home_products.php'); ?>
      
      <div class="promoblk w-clearfix">
       <?php 
	   $banner = 0;
		  
		$ban_res = $GLOBALS['db_con_obj']->fetch_flds($promo_obj->cls_tbl,"*","Status=1 order by Id desc limit 0,2");
		while($ban_data = mysql_fetch_object($ban_res[0])){
			$banner_image =$ban_data->BanImage;
			$image_path = $promo_obj->attachment_path.$banner_image;
			if($banner == 0){
			   	$class = "half1";
				$banner = 1;
			}
			else {
				$banner = 0;
				$class = "half2";
		}
		?>
        <div class="<?php echo $class;?>"> <a class="promo-item w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'] ?>promotion/<?php echo $ban_data->UniqueKey ?>"><img class="promoimg" src="<?php echo $image_path?>" title="<?php echo display_field_value($ban_data,"Title"); ?>"></a></div>
         <?php 
		}
		?>
       
      </div>
      
    
<?php

require_once("footer.php"); 

?>