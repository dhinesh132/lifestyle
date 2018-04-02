<?php
$from_page = "admin";
require_once("../includes/admin_code_header.php");

?>
<?php require_once("../includes/inside_head_tag.php"); ?>
<body >
<div id="wrapper">
<div id="header">
    <div id="head_lt">
    <!--Logo Start from Here--><span class="slogan"> &nbsp;&nbsp;<?php echo $GLOBALS['site_config']['company_name']; ?> administration suite</span>
    <!--Logo end  Here-->
    </div>
	
</div>
<?php if($_SESSION['ses_admin_id'] > 0) { ?>
<div class="menubg">
        <div class="nav">
            <ul id="navigation">
                <li class="" onMouseOut="this.className=''" onMouseOver="this.className='hov'"><a href="javascript:void(0)">Content & Masthead</a>
                <div class="sub">
						<ul>
                        <li>
							<a href="static_pages.php">Page Content (CMS)</a>
						</li> 
                        <li>
							<a href="banner_master.php">Masthead Images</a>
						</li> 
                      
						</ul>
					</div>
                </li>
              
                 <li class="" onMouseOut="this.className=''" onMouseOver="this.className='hov'"><a href="javascript:void(0)">Manage Products</a>
                <div class="sub">
						<ul>
                        <li>
							<a href="types.php">Manage Types</a>
						</li>                        
                         <li>
							<a href="materials.php">Manage Materials</a>
						</li>
                        <li>
							<a href="functions.php">Manage Functions</a>
						</li>                        
                         <li>
							<a href="products.php">Manage Products</a>
						 </li>
                        <li>
							<a href="authors.php">Manage Authors</a>
						</li>
                         <li>
							<a href="groups.php">Manage Product Groups</a>
						</li>
                         <li>
							<a href="publications.php">Manage Publications</a>
						</li>
						</ul>
					</div>
                </li>
                <li class="" onMouseOut="this.className=''" onMouseOver="this.className='hov'"><a href="customers.php?submit_action=clear">Manage Customers</a></li>
                <li class="" onMouseOut="this.className=''" onMouseOver="this.className='hov'"><a href="javascript:void(0)">Extra Modules</a>
                
                <div class="sub">
						<ul>
                        	<li>
								<a href="promotions.php">Promo Codes</a>
							</li> 
                            <li>
								<a href="promotion_banner.php">Promotions</a>
							</li>
                           <!--	<li>
								<a href="latest_news.php">Latest News</a>
							</li>-->
                             <li>
								<a href="subscriber.php">Subscriber</a>
							</li> 
                            <li>
								<a href="search_options.php">Search options</a>
							</li> 
                            <!--<li>
								<a href="blogs.php">Blog</a>
							</li> 
                             <li>
								<a href="consultations.php">Consultations</a>
							</li> 
                           <li>
								<a href="subscriber.php">Subscriber</a>
							</li> 
                             <li>
								<a href="prod_qty_notify.php">User informed about product QTY</a>
							</li> 
                             <li>
								<a href="minimum_qty_products.php">Minimum quantity products</a>
							</li>-->
                           
						</ul>
					</div>
                </li>
              <!--  <li class="" onMouseOut="this.className=''" onMouseOver="this.className='hov'"><a href="event_gallery.php">Manage Gallery</a></li>-->
                 <li class="" onMouseOut="this.className=''" onMouseOver="this.className='hov'"><a href="javascript:void(0)">Reports</a>
                   <div class="sub">
						<ul>
                        	<li>
								<a href="orders.php?submit_action=clear">Sales Orders</a>
							</li> 
                            
						</ul>
					</div>
                 </li>
				<li onMouseOut="this.className=''" onMouseOver="this.className='hov'" class=""><a href="javascript:void(0)">Settings</a>
					<div class="sub">
						<ul>
                        	<li>
								<a href="subadmin_settings.php">Site Configuration</a>
							</li> 
                            <li>
								<a href="payment_settings.php">Shopping cart Configuration</a>
							</li> 
                            <li>
								<a href="shipping_settings.php">Shipping Costs</a>
							</li> 
                             <li>
								<a href="shipping_details.php">Delivery Cost</a>
							</li> 
                           
							 <li>
								<a href="admin.php?submit_action1=change">Change Password</a>
							</li> 
						</ul>
					</div>
				</li>		
              	
			</ul>
        </div>
        <div class="logout"><a href="logout.php"><img src="../images/logout.gif"></a></div>
</div>
<?php } ?>
<div id="container"> 

<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
  
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td height="500" width="<?php echo ($_SESSION['ses_admin_id'] > 0)?"100%":"80%"; ?>" align="center" style=""><?php
	
		
	$tarr = explode("?", basename($_SERVER['REQUEST_URI']));
	
	if($tarr[0] == "email_box_select.php")
	{
		unset($_SESSION['ses_email_box_selection']);
	}
	
	if($tarr) {
	echo "<h2 style='color: #2b3d55;'><br>" . stripslashes($page_inner_titles[$tarr[0]]) . "</h2>";
	}
	
	
	?>