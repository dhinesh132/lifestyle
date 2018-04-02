<?php
require_once(dirname(__FILE__) . '/includes/code_header.php');
require_once(dirname(__FILE__) . '/includes/top_header.php');
require_once(dirname(__FILE__) . '/classes/products.class.php');
$prod_obj = new products();

if($from_page == "index")
	$key = "home";
else
	$key = $_REQUEST['key'];
?>
  <style>
.radio-input:checked + label {
    background: #00a3ad;
    color: #fff
}
</style>
</head>
<body class="body">
<div class="topsection">
    <div class="top-strip">
      <div class="maincon strip">
        <div class="top-con"><a class="top-conlink" href="#"><?php echo $GLOBALS['site_config']['company_phone'];?></a><a class="top-conlink" href="#"><?php echo $GLOBALS['site_config']['admin_email'];?></a><a class="w-hidden-medium w-hidden-small w-hidden-tiny w-inline-block youtube-link" target="_blank" href="<?php echo stripslashes($GLOBALS['site_config']['youtube_URL']); ?>"><img src="<?php echo $GLOBALS['site_config']['site_path'];?>images/youtube-logo.png" width="36"></a></div>
        <div class="minilinkscon w-hidden-main"><a class="minilink-item mob" href="#">Home</a>
        <?php if($_SESSION['ses_customer_id']=="") {?><a class="minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>login">Log in</a><a class="last minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>account/create">Sign up</a><?php } else if($_SESSION['ses_customer_id']>2) {?><a class="minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>myaccount">Myaccount</a><a class="last minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>logout">Logout</a> <?php }?></div>
      </div>
    </div>
    <div class="maincon topnav">
      <div class="mainnav w-nav" data-animation="default" data-collapse="medium" data-duration="400">
        <div class="navcon w-container"><a class="brand w-nav-brand" href="<?php echo $GLOBALS['site_config']['site_path'];?>"><img src="<?php echo $GLOBALS['site_config']['site_path'];?>images/emblems-logo.png"></a>
          <nav class="nav-menu w-nav-menu" role="navigation">
           <?php require_once(dirname(__FILE__) . '/templates/search_options.php'); ?>
            
         
              <?php 
				$menu_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style,UniqueKey","(menu_type=3 or menu_type=1) and display_status=1 order by display_order");
    		while($menu_data = mysql_fetch_object($menu_res[0])){
				
				if($curentFile == $menu_data->page_link){
					$selectedId= "selected";
					$fnt_clr ="";
				}
				else {
				   $selectedId= "nav_text";
				   $fnt_clr ="";
				}
				
				if($menu_data->Id ==4)
				   $li_width="width:auto; ";
				 else
				    $li_width = "";  
					$sub_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style,UniqueKey","menu_type=4 and parent_id =".$menu_data->Id."  and display_status=1 order by display_order"); 
				?>
              
           
            <?php 
				if($menu_data->Id ==2) {
                 $fun_res = $db_con_obj->fetch_flds("functions", "*", "FunStatus =1 order by DisplayOrder DESC"); 				 
				 ?>
            <div class="nav-drop w-dropdown" data-delay="0" data-hover="1">
              <div class="nav-link-toggle w-dropdown-toggle">
                <div>emblems</div>
                <div class="drop-icon w-icon-dropdown-toggle"></div>
              </div>
              <nav class="droplist w-dropdown-list">
              			<?php while($fun_data = mysql_fetch_object($fun_res[0])){?>
                        <a class="droplink w-dropdown-link" href="<?php echo $GLOBALS['site_config']['site_path'];?>emblems/<?php echo $fun_data->UniqueKey;?>"><?php echo display_field_value($fun_data,"Name");?></a>
						<?php } ?>
              </nav>
            </div>
            <?php } 
				else if($menu_data->Id ==3) {		 
				 ?>
           <div class="nav-drop w-dropdown" data-delay="0" data-hover="1">
              <div class="nav-link-toggle w-dropdown-toggle">
                <a class="navlinks" style="text-decoration:none" href="<?php echo $GLOBALS['site_config']['site_path'];?>publications"><div><?php echo display_field_value($menu_data,"Title");?></div></a>
                <div class="drop-icon w-icon-dropdown-toggle"></div>
              </div>
              <nav class="droplist w-dropdown-list"></nav>
            </div>
            <?php } 
			 else if($sub_res[1] >0){?>
             <div class="nav-drop w-dropdown" data-delay="0" data-hover="1">
              <div class="nav-link-toggle w-dropdown-toggle">
                <div><?php echo display_field_value($menu_data,"Title");?></div>
                <div class="drop-icon w-icon-dropdown-toggle"></div>
              </div>
              <nav class="droplist w-dropdown-list">
               <?php while($sub_data = mysql_fetch_object($sub_res[0])){?>
              		<a class="droplink w-dropdown-link" href="<?php echo $GLOBALS['site_config']['site_path'];?>index/<?php echo $sub_data->UniqueKey;?>"><?php echo display_field_value($sub_data,"Title");?></a>
               <?php } ?>
              </nav>
            </div>
            <?php } else {?>              
             <div class="nav-drop w-dropdown" data-delay="0" data-hover="1">
              <div class="nav-link-toggle w-dropdown-toggle">
                <a  class="navlinks" style="text-decoration:none" href="<?php echo $GLOBALS['site_config']['site_path'];?>index/<?php echo $menu_data->UniqueKey;?>"><div><?php echo display_field_value($menu_data,"Title");?></div></a>
                <div class="drop-icon w-icon-dropdown-toggle"></div>
              </div>
              <nav class="droplist w-dropdown-list"></nav>
            </div>
            <?php } 
			} ?>
            
            <div class="w-hidden-main yourube-blk"><a class="w-inline-block youtube-link" href="https://www.youtube.com/user/wayonnet" target="_blank"><img src="<?php echo $GLOBALS['site_config']['site_path'];?>images/youtube-logo.png" width="36"></a></div>
          </nav>
          <div class="menubtn w-nav-button" >
            <div class="w-icon-nav-menu" style="margin-top:15px;"></div>
          </div>
          <div class="cart-blk mobile w-hidden-main"><a class="cart-blk-in w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'];?>cart"><img class="canticon-img" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/cart-icon-main.png" width="20"><?php if(isset($_SESSION['ses_cart_items']) && count($_SESSION['ses_cart_items']) >0){?><div class="cartnum"><div><?php echo count($_SESSION['ses_cart_items']);?></div></div><?php } ?></a></div>
        </div>
      </div>
      <div class="main-cat-links">
        <a class="group-link-item w-inline-block" href="http://www.wayfengshui.com/">
          <div>Group</div>
        </a>
        <a class="consultancy group-link-item w-inline-block" href="http://www.wayfengshui.com/consultancy" target="_blank">
          <div>consultancy</div>
        </a>
        <a class="aca group-link-item w-inline-block" href="http://www.wayfengshui.com/academy" target="_blank">
          <div>academy</div>
        </a>
      </div>
    </div>
  </div>
<div class="body-section">
    <div class="maincon">