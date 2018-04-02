<div class="search-blk-con">
              <div class="search-rel">
                <div class="search-form-wrap ">
                  <form class="search-formform" data-name="Email Form" id="email-form" name="email-form">
                    <div class="search-drop w-dropdown" data-delay="0">
                      <div class="search-drop-tog w-dropdown-toggle">
                        <div class="drop-search-icon w-icon-dropdown-toggle"></div>
                        <div>Search Emblems</div>
                      </div>
                      <nav class="search-dropdiv w-dropdown-list">
                        <div class="search-inside-div">
                          <div class="search-item-name">Popular Keywords</div>
                          <?php 
						  $searc_key_res = $GLOBALS['db_con_obj']->fetch_flds("search_options","*","Status =1 order by EnTitle ");
						  while($searc_key_data = mysql_fetch_object($searc_key_res[0])){
						  ?>
                          <div class="key-con">
                            <div class="search-keyword" data-ix="new-interaction"><?php echo $searc_key_data->EnTitle;?></div>
                            <div class="search-prod-pop w-hidden-tiny" data-ix="search-pop-hide">
                            <?php 
							//$GLOBALS['site_config']['debug'] =1;
							$prod_search_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl,"Id, EnName,Price,Quantity,Types,Material,Function,ProdStatus,Image,UniqueKey","Id in (".$searc_key_data->ItemId.")  order by DisplayOrder desc");
			  while($prod_search_data = mysql_fetch_object($prod_search_res[0])){
				  
				  $prod_search_dis_res = $GLOBALS['db_con_obj']->fetch_flds("promotion_banner","Id,Discount","concat(',',ItemId,',') Like '%,".trim($prod_search_data->Id).",%' and Status=1");
				  $med_img_path = $prod_obj->attachment_path . $prod_search_data->Image;
				 
				if(file_exists($med_img_path) && is_file($med_img_path))
		  			$prod_search_img = $med_img_path;
				else
					$prod_search_img = $prod_obj->attachment_path . 'default_prod.gif';
				  ?>
					
                              <a class="pop-proditem w-clearfix w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'];?>product/<?php echo $prod_data->UniqueKey?>" target="_blank">
                                <div class="pop-prod-imgcon"><img src="<?php echo $GLOBALS['site_config']['site_path'];?><?php echo $prod_search_img;?>"></div>
                                <div class="pop-prod-info">
                                  <p class="prodpop-title"><?php echo display_field_value($prod_search_data,"Name");?></p>
                                  <p class="prod-pop-sub">Function:<?php 
									 $fun_res = $GLOBALS['db_con_obj']->fetch_flds('functions','EnName','FunId in ('.$prod_search_data->Function.')'); 
									 while($fun_prod_data = mysql_fetch_object($fun_res[0])){
										 echo $fun_prod_data->EnName."<br>";
									 } ?></p>
                                  <div class="pop-price-con">
                                    <div class="reg-price-pop">$<?php echo format_number(product_price($prod_search_data->Id,$prod_search_data->Price)); ?></div>
                                    <?php if($prod_search_dis_res[1] >0){ ?>
                                    <div class="disprice-pop">$<?php echo stripslashes($prod_search_data->Price); ?></div>
                                    <?php } ?>
                                  </div>
                                </div>
                              </a>
                             <?php } ?>
                              <!--<a class="view-all-con w-inline-block" href="#">
                                <div class="view-intro">View all results for:</div>
                                <div class="view-cat">Academic</div>
                              </a>-->
                            </div>
                          </div>
                          <?php 
						  } ?>
                        </div>
                      </nav>
                    </div>
                  </form>
               
                </div>
                <div class="minilinkscon w-hidden-medium w-hidden-small w-hidden-tiny">
                <a class="minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_url'];?>">Home</a>
                 <?php if($_SESSION['ses_customer_id']=="") {?>
                <a class="minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>login">Log in</a>
                <a class="last minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>account/create">Sign up</a>
                <?php } else if($_SESSION['ses_customer_id']>2) {?>
                <a class="minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>myaccount">Myaccount</a>
                <a class="last minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>logout">Logout</a>
                <?php } ?></div>
                <div class="cart-blk w-hidden-medium w-hidden-small w-hidden-tiny">
                <a class="cart-blk-in w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'];?>cart">
                <img class="canticon-img" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/cart-icon-main.png" width="20">
                <?php if(isset($_SESSION['ses_cart_items']) && count($_SESSION['ses_cart_items']) >0){?><div class="cartnum"><div><?php echo count($_SESSION['ses_cart_items']);?></div></div><?php } ?>
                </a></div>
              </div>
              <div class="clear"></div>
            </div>