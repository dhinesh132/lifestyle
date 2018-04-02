<div class="related-products">
        <div class="section-title">
          <div class="title-textblk">Related products</div>
        </div>
        <div class="related-slider">
          <div class="prod-slider w-slider" data-animation="slide" data-duration="500" data-infinite="1">
            <div class="prod-slidemask w-slider-mask">
             <?php
				//$GLOBALS['site_config']['debug'] =1;
				if($data->ProdType==2){
					$rec_con .="AuthorId=".$data->AuthorId;			
					
					
				}
				else if($data->ProdType==1){
					if(isset($data->Function) && $data->Function !=''){
						$rec_function = explode(",",$data->Function);
						
						$rec_con =" (";
						foreach($rec_function as $rid =>$rval){
							$rec_con .=" CONCAT(',',Function,',') like '%".$rval."%' or";
						}
						$rec_con = substr($rec_con,0,-2);
						$rec_con .=" )";					
						
					}
					else{
						$rec_con ="1=1";	
					}
				}
			 $recomend_qry  = "select Id,EnName,ChName,Image,Price,Quantity,EnShortDesc,ChShortDesc,UniqueKey,EnShortDesc,Function from products where ProdStatus = '1' and Id !=".$data->Id." and ".$rec_con." order by RAND() limit 0,5 ";
				 $recomend_res = $GLOBALS['db_con_obj']->execute_sql($recomend_qry,"select");
				 while($recomend_data = mysql_fetch_object($recomend_res[0])){
					 
			    $dis_res = $GLOBALS['db_con_obj']->fetch_flds("promotion_banner","Id,Discount,Type","concat(',',ItemId,',') Like '%,".trim($recomend_data->Id).",%' and Discount >0 and Status=1");
				  if($dis_res[1] >0){
				  $dis_data =mysql_fetch_object($dis_res[0]);
				  }
				  
					$detail_link = "product_detail.php?prod_id=" . $recomend_data->Id;
				
				 	$med_img_path = $prod_obj->attachment_path . $recomend_data->Image;
				 
					if(file_exists($med_img_path) && is_file($med_img_path))
						$disp_img = $med_img_path;
					else
						$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
				?>
                 <div class="prodslide w-slide prod-item" data-ix="pop-up-left">
             
                  <div class="pop-left" data-ix="soft-hide-and-stay">
                    <div class="pop prod-thumb-name"><?php echo trim_text($recomend_data->EnName,15);?></div>
                    <div class="pop-price">
                      <div class="pop price">$<?php echo format_number(product_price($recomend_data->Id,$recomend_data->Price)); ?></div>
                      <?php if($dis_res[1] >0){ ?>
                      <div class="dis pop price">$<?php echo stripslashes($recomend_data->Price); ?></div>
                      <?php } ?>
                    </div>
                    <div class="pop-info-blk">
                       <p class="pop prod-thumb-name"><strong>Function</strong>: </p><?php $fun_str  ='';
	 $fun_res = $GLOBALS['db_con_obj']->fetch_flds('functions','EnName','FunId in ('.$recomend_data->Function.')'); 
	 while($fun_recomend_data = mysql_fetch_object($fun_res[0])){
		 $fun_str .= $fun_recomend_data->EnName.", ";
	 }  echo substr($fun_str,0,-2)?><br><br><?php echo trim_text($recomend_data->EnShortDesc,30)?></p>
                    </div>
                    <div class="popbtns"><!--<a class="popbtn-item w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path'];?>product/<?php echo $recomend_data->UniqueKey?>"><img src="<?php echo $GLOBALS['site_config']['site_path'];?>images/cart-icon.png" width="22"></a>--><a class="popbtn-item w-inline-block" href="<?php echo $GLOBALS['site_config']['site_path']."product/".$recomend_data->UniqueKey;?>"><img src="<?php echo $GLOBALS['site_config']['site_path'];?>images/info.png" width="23"></a></div>
                  </div>
                  <div class="prod-img-con"><a href="<?php echo $GLOBALS['site_config']['site_path']."product/".$recomend_data->UniqueKey;?>" ><img class="prom-img" src="<?php echo $GLOBALS['site_config']['site_path'].$disp_img;?>" alt="<?php echo display_field_value($recomend_data,"Name");?>"></a>
                   <?php if($dis_res[1] >0){ ?>
                    <div class="percent-con">
                      <div class="percent"><?php echo display_promo($dis_data->Discount,$dis_data->Type) ?></div>
                    </div>
                    <?php } ?>
                  </div>
                  <div class="prod-info-blk">
                    <div class="prod-price-blk">
                      <div class="price">$<?php echo format_number(product_price($recomend_data->Id,$recomend_data->Price)); ?></div>
                        <?php if($dis_res[1] >0){ ?>
                      <div class="discount price">$<?php echo stripslashes($recomend_data->Price); ?></div>
                      <?php } ?>
                    </div>
                    <div class="prod-thumb-name"><?php echo display_field_value($recomend_data,"Name");?></div>
                  </div>
               
                </div>
               <?php }?>
              
            </div>
            <div class="left prod-arrows w-slider-arrow-left">
              <div class="w-icon-slider-left"></div>
            </div>
            <div class="prod-arrows right w-slider-arrow-right">
              <div class="w-icon-slider-right"></div>
            </div>
            <div class="slide-navi w-hidden-main w-hidden-medium w-hidden-small w-hidden-tiny w-round w-slider-nav w-slider-nav-invert"></div>
          </div>
        </div>
      </div>
      

            
            