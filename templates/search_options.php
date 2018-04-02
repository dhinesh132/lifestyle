<div class="search-blk-con">
              <div class="search-rel w-clearfix">
                <div class="search-form-wrap " id="search_area">
                  <form id="email-form" name="email-form" data-name="Email Form" class="search-formform">
                  <span id="AjsearchItems">
                  </span>
                 <input type="text" class="search-input w-input" maxlength="256" name="Search" data-name="Search" placeholder="Search Emblems" id="Search" required="" onkeyup="ajax_search_prod(this.value)" ></form>
                   <script>
			  function ajax_search_prod($v){
				 var str_length =  $('#Search').val().length
				  if(str_length >1){
					  get_dynamic_dropdown('AjsearchItems', '<?php echo $GLOBALS['site_config']['site_path'] ?>ajax_content.php', 'required=ajax_search&string='+$v)
				  }
			  }
			  $("#search_area").mouseleave(function(){
					$('#search_result').hide();
				});
			  
			  </script>
                </div>
              <div class="minilinkscon w-hidden-medium w-hidden-small w-hidden-tiny">
                <a class="minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>">Home</a>
                 <?php if($_SESSION['ses_customer_id']=="") {?>
                <a class="minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>login">Log in</a>
                <a class="last minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>account/create">Sign up</a>
                <?php } else if($_SESSION['ses_customer_id']>1) {?>
                <a class="minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>myaccount">My Account</a>
                <a class="last minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>logout">Logout</a>
                <?php } else {?>
                <a class="minilink-item mob" href="#">Guest User</a>
                <a class="last minilink-item mob" href="<?php echo $GLOBALS['site_config']['site_path'];?>logout">Logout</a>
                <?php } ?></div>
                <div class="cart-blk w-hidden-medium w-hidden-small w-hidden-tiny" id="addtocart"><a href="<?php echo $GLOBALS['site_config']['site_path'];?>cart" class="cart-blk-in w-inline-block"><img src="<?php echo $GLOBALS['site_config']['site_path'];?>images/cart-icon-main.png" width="20" class="canticon-img">
				
				<?php if(isset($_SESSION['ses_cart_items']) && count($_SESSION['ses_cart_items']) >0){?><div class="cartnum"><div><?php echo count($_SESSION['ses_cart_items']);?></div></div><?php } ?></a>
                  
                </div>
                <script>
                $("#addtocart").mouseleave(function(){					
					$('#add-to-cart-message').hide();
				});
			  </script>
              </div>
              <div class="clear"></div>
            </div>
            
            