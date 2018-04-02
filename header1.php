<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
<link REL="SHORTCUT ICON" HREF="images/favicon_animated.ico">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
require_once("includes/code_header.php");
require_once("includes/top_header.php");
?>
<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/footer.css">
<link rel="stylesheet" href="font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="css/slider/bjqs.css">

<script type="text/javascript" src="js/domtab.js"></script>


</head>
<body>
<div id="container">

<div class="topContactInfo">
    <ul>
        <li><i class="fa fa-phone" aria-hidden="true"></i> +65 6338 3800</li>
        <li><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:lifestyle@wayfengshui.com">lifestyle@wayfengshui.com</a></li>
        <li><a href="https://www.facebook.com/wayfengshui" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
        <li><a href="https://www.youtube.com/user/wayonnet" target="_blank"><img src="images/icon_youtube.jpg" alt=""></a></li>
    </ul>
</div>

<div id="topNav">
    <div class="logoWrap">
        <a href="index.php"><img src="images/emblems-logo.png" alt=""></a>
    </div>

    <div class="rightCont">
        <div class="languageWrap">
            <ul>
                <!--<li><a href="#">ENGLISH</a> | <a href="#">CHINESE</a></li>-->
                <li>
                    <form name="search_frm" action="product_lists.php" method="post" onsubmit="">
                        <?php 
						if(isset($_SESSION['ses_temp_search_obj']['keyword']) && $_SESSION['ses_temp_search_obj']['keyword']!=''){
							$srch_val = $_SESSION['ses_temp_search_obj']['keyword'];
						}
						else{
							$srch_val = SEARCHEMBLEMES;
						}
						?>
                        <input type="text" size="23"  value="<?php echo $srch_val;?>" onclick="if(this.value=='<?php echo SEARCHEMBLEMES;?>')this.value=''" onblur="if(this.value=='')this.value='<?php echo SEARCHEMBLEMES;?>'" name="keyword"/>
                    </form>
                </li>
            </ul>
        </div>

        <div class="topLink">
            <p><a href="index.php">Home</a> | <?php if($_SESSION['ses_customer_id']=="") {?><a href="#login-box" class="login-window"><?php echo LOGIN?></a> | <a href="register.php"><?php echo SIGNUP?></a><?php } else if($_SESSION['ses_customer_id']==2){?><a href="#">Guest User</a> | <a href="logout.php"><?php echo LOGOUT?></a><?php } else {?> <a href="logout.php"><?php echo LOGOUT?></a> | <a href="myaccount.php"><?php echo MYACCOUNT?></a> <?php }?></p>
        </div>

        <div class="navWrap">
            <ul>
                <?php 
				$menu_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style","(menu_type=3 or menu_type=1) and display_status=1 order by display_order");
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
					$sub_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style","menu_type=4 and parent_id =".$menu_data->Id."  and display_status=1 order by display_order"); 
				?>
                <li class="nav_text" style="<?php echo $li_width;?>"><a href="<?php echo $menu_data->page_link;?>"><?php echo display_field_value($menu_data,"Title");?></a>
                <?php 
				if($menu_data->Id ==2) {
                 $fun_res = $db_con_obj->fetch_flds("functions", "*", "FunStatus =1 order by DisplayOrder DESC"); 				 
				 ?>
                  <ul>
						<?php 
                        while($fun_data = mysql_fetch_object($fun_res[0])){
                        ?>
                        <li><a href="product_lists.php?fun=<?php echo $fun_data->FunId;?>"><?php echo display_field_value($fun_data,"Name");?></a></li>
                        <?php
                        }
                        ?>
                        </ul>
                 <?php } 
				 else if($sub_res[1] >0){?> 
                 <ul>
                 <?php
				while($sub_data = mysql_fetch_object($sub_res[0])){
				?>
                        <li><a href="<?php echo $sub_data->page_link;?>"><?php echo display_field_value($sub_data,"Title");?></a></li>
                 <?php } ?>
                  </ul>
                 
                 <?php }?>
                 </li>
                <?php } ?>
                	
                </ul>
        </div>
    </div><!--rightCont-->
</div>
