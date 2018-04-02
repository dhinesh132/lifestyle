<div class="producfilter">
        <div class="homecat-tab w-tabs" data-duration-in="300" data-duration-out="100">
          <div class="hometabs w-tab-menu">
          <?php $group_res = $db_con_obj->fetch_flds("groups", "*", "GroupStatus =1 order by DisplayOrder DESC"); 
		  while($group_data = mysql_fetch_object($group_res[0])){?>
            <a class="home-tablink w--current w-inline-block w-tab-link" data-w-tab="<?php echo $group_data->UniqueKey;?>">
              <div class="tabtext"><?php echo display_field_value($group_data,"Name");?></div>
            </a>
           <?php } ?>
          </div>          
          <div class="w-tab-content">
           <?php $group_res = $db_con_obj->fetch_flds("groups", "*", "GroupStatus =1 order by DisplayOrder DESC"); 
		  	while($group_data = mysql_fetch_object($group_res[0])){?>
            <div class="w--tab-active w-tab-pane" data-w-tab="<?php echo $group_data->UniqueKey;?>">
              <div class="home-prod-con">
              <?php 
			  //$GLOBALS['site_config']['debug']=1;
			  $prod_res = $db_con_obj->fetch_flds($prod_obj->cls_tbl,"Id, EnName,Price,Quantity,Types,Material,Function,ProdStatus,Image,UniqueKey,EnShortDesc","concat(',',Groups,',') Like '%,".trim($group_data->GroupId).",%' and  concat(',',Function,',') Like '%,".trim($fun_data->FunId).",%'  order by DisplayOrder desc");
			  while($prod_data = mysql_fetch_object($prod_res[0])){
				  
				  $dis_res = $GLOBALS['db_con_obj']->fetch_flds("promotion_banner","Id,Discount,Type","concat(',',ItemId,',') Like '%,".trim($prod_data->Id).",%' and Discount >0 and Status=1");
				  if($dis_res[1] >0){
				  $dis_data =mysql_fetch_object($dis_res[0]);
				  }
				$med_img_path = $prod_obj->attachment_path . $prod_data->Image;
				 
				if(file_exists($med_img_path) && is_file($med_img_path))
		  			$disp_img = $med_img_path;
				else
					$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
			  ?>
                <div class="prod-item" data-ix="pop-up-left">
                  <div class="pop-left" data-ix="soft-hide-and-stay">
                    <div class="pop prod-thumb-name"><?php echo trim_text($prod_data->EnName,15);?></div>
                    <div class="pop-price">
                      <div class="pop price">$<?php echo format_number(product_price($prod_data->Id,$prod_data->Price)); ?></div>
                      <?php if($dis_res[1] >0){ ?>
                      <div class="dis pop price">$<?php echo stripslashes($prod_data->Price); ?></div>
                      <?php } ?>
                    </div>
                    <div class="pop-info-blk">
                      <p class="pop prod-thumb-name"><strong>Function</strong>: </p><?php
					   $fun_str  ='';
	 $fun_res = $GLOBALS['db_con_obj']->fetch_flds('functions','EnName','FunId in ('.$prod_data->Function.')'); 
	 while($fun_prod_data = mysql_fetch_object($fun_res[0])){
		 $fun_str .= $fun_prod_data->EnName.", ";
	 }  echo substr($fun_str,0,-2)?><br><br><?php echo trim_text($prod_data->EnShortDesc,30)?></p>
                    </div>
                    <div class="popbtns"><!--<a class="popbtn-item w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'];?>product/<?php echo $prod_data->UniqueKey?>"><img src="<?php echo $GLOBALS['site_config']['site_path'];?>images/cart-icon.png" width="22"></a>-->
                    <a class="popbtn-item w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'];?>product/<?php echo $prod_data->UniqueKey?>"><img src="<?php echo $GLOBALS['site_config']['site_path'];?>images/info.png" width="23"></a></div>
                  </div>
                  <div class="prod-img-con"><img class="prom-img" src="<?php echo $GLOBALS['site_config']['site_path'];?><?php echo $disp_img;?>" alt="<?php echo display_field_value($prod_data,"Name");?>">
                   <?php if($dis_res[1] >0){ ?>
                    <div class="percent-con">
                      <div class="percent"><?php echo display_promo($dis_data->Discount,$dis_data->Type) ?></div>
                    </div>
                    <?php } ?>
                  </div>
                  <div class="prod-info-blk">
                    <div class="prod-price-blk">
                      <div class="price">$<?php echo format_number(product_price($prod_data->Id,$prod_data->Price)); ?></div>
                        <?php if($dis_res[1] >0){ ?>
                      <div class="discount price">$<?php echo stripslashes($prod_data->Price); ?></div>
                      <?php } ?>
                    </div>
                    <div class="prod-thumb-name"><?php echo display_field_value($prod_data,"Name");?></div>
                  </div>
                </div>
                <?php } ?>
                
              </div>
            </div>
            <?php } ?>       
            
            
          </div>
        </div>
      </div>