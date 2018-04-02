<?php 
$from_page = "inner";
$template =1;
require_once(dirname(__FILE__) . '/header.php'); 

require_once(dirname(__FILE__) . '/classes/promotion_banner.class.php');
require_once(dirname(__FILE__) . '/classes/static_pages.class.php');
$page_obj = new static_pages();
$promo_obj = new promotion_banner();
$key = $_REQUEST['key'];

$page_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","*","UniqueKey='".$key."' and display_status=1");
$page_data = mysql_fetch_object($page_res[0]);
	
$banner_img = $GLOBALS['site_config']['site_path'].$pages_obj->attachment_path.$page_data->banner_image;

$page_img = $GLOBALS['site_config']['site_path'].$pages_obj->attachment_path.$page_data->page_image;
?>
<div class="breadcrumb"><a href="#" class="breadlink">HOME</a> / <?php echo display_field_value($page_data,"Title");?></div>
      <div class="pagetitle">
        <div><?php echo display_field_value($page_data,"Title");?></div>
      </div>
      <div class="content-col w-clearfix">
     
        <?php if($key =="Promotions") {?>        
        <div class="promotionsblk">
        <?php 
	   $banner = 0;
		  
		$ban_res = $GLOBALS['db_con_obj']->fetch_flds($promo_obj->cls_tbl,"*","Status=1 order by Id desc ");
		while($ban_data = mysql_fetch_object($ban_res[0])){
			$banner_image =$ban_data->BigBanImage;
			$image_path = $GLOBALS['site_config']['site_path'].$promo_obj->attachment_path.$banner_image;
		?>
         <a class="promo-item w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'] ?>promotion/<?php echo $ban_data->UniqueKey ?>">
        <img class="promo-item-img"  src="<?php echo $image_path?>" >
        </a>
        <?php } ?>
        
        </div>
        
        <?php } else if($page_data->parent_id >0){?>
         <?php 
	 
		   if($page_data->parent_id >0){
	   ?>
        <div class="cont-menu">
          <div class="page-side-menu">
           <?php 
			
			$left_sub_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style,UniqueKey","menu_type=4 and parent_id =".$page_data->parent_id."  and display_status=1 order by display_order"); 			
				while($left_sub_data = mysql_fetch_object($left_sub_res[0])){
			    ?>
                  <a class="side-menu-item w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'];?>index/<?php echo $left_sub_data->UniqueKey;?>">
              		<div><?php echo display_field_value($left_sub_data,"Title");?></div>
            	  </a>
               <?php } ?>
           
          </div>
        </div>
        <?php } ?>
        <div class="cont-wrap">
           <?php echo DisplayFieldValue($page_data,"Content",$_SESSION['ses_lang']);?>
        </div>
        <?php } else {?>
        <div class="page-content"> <?php echo DisplayFieldValue($page_data,"Content",$_SESSION['ses_lang']);?></div>
        <?php } ?>
      </div>
     
      
      
  <?php 



require_once(dirname(__FILE__) . '/footer.php'); 



?>