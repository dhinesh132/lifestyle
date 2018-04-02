<div class="brown-bg">
            	<div class="title-bar"><?php echo FEATUREDPRODUCTS; ?></div>
                  <ul>
                <?php
				$future_qry  = "select Id,EnName,ChName,Image,Price,Quantity,EnShortDesc,ChShortDesc from products where ProdStatus = '1' and IsFeatured =1 order by Modified Desc limit 0,2 ";
				 $future_res = $GLOBALS['db_con_obj']->execute_sql($future_qry,"select");
				 while($future_data = mysql_fetch_object($future_res[0])){
					 
					$detail_link = "product_detail.php?prod_id=" . $future_data->Id;
				
				 	$med_img_path = $prod_obj->attachment_path . $future_data->Image;
				 
					if(file_exists($med_img_path) && is_file($med_img_path))
						$disp_img = $med_img_path;
					else
						$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
				?>
              
                	<li>
                    	<div class="product-bg">
                        	 <a href="<?php echo $detail_link;?>"><img src="phpthump/phpThumb.php?src=../<?php echo $disp_img; ?>&w=150&h=122&q=75" border="0" alt="<?php echo display_field_value($future_data,"Name");?>" title="<?php echo display_field_value($future_data,"Name");?>"></a>
                        </div>
                    </li>
                    
                    <li>
                    	<strong><a href="<?php echo $detail_link;?>" title="<?php echo $future_data?>" ><?php echo trim_text(display_field_value($future_data,"Name"),50);?></a></strong><br />
                        <em>SGD <?php echo $future_data->Price;?></em><br /><br />
                        <?php echo trim_text(display_field_value($future_data,"ShortDesc"),75);?>
                    </li>
                    <?php }?>
                   
                </ul>
            </div>