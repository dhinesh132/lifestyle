<?php if(count($_SESSION['ses_recent_visited']) >0){?>
  <div class="recent-blk">
          <div class="side-title">Recently Viewed Products</div>
          <?php 
		  krsort($_SESSION['ses_recent_visited']);
		  foreach($_SESSION['ses_recent_visited'] as $k =>$val){ 
		  //$GLOBALS['site_config']['debug'] =1;
		  	$recent_res = $GLOBALS['db_con_obj']->fetch_flds($prod_obj->cls_tbl,"*","Id=".$val." and ProdStatus=1 ");
		  	$recent_data = mysql_fetch_object($recent_res[0]);
		  	$prod_pic =$GLOBALS['site_config']['site_path'].$prod_obj->attachment_path.$recent_data->Image;	
			$link = $GLOBALS['site_config']['site_path']."prod/".$recent_data->UniqueKey;
		  ?>
          <div class="recent-item">
            <a class="recent-item-in w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'];?>product/<?php echo $recent_data->UniqueKey?>">
              <div class="recent-img"><img src="<?php echo $prod_pic?>" alt="<?php echo $recent_data->Name?>"></div>
              <div class="recent-info">
                <div><?php echo $recent_data->EnName?></div>
                <div class="recent-price">$<?php echo format_number(product_price($recent_data->Id,$recent_data->Price)); ?></div>
              </div>
            </a>
          </div>
          
          <?php if($k==5)
		  break;
		  } ?>
        </div>
  <?php } ?>
  
  