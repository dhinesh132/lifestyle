<div class="brown-bgs">
            	<div class="title-bar"><?php echo MOSTPOLULAR; ?></div>
                <ul>
                <?php
               // "SELECT prod_id, COUNT(*) AS prodcnt FROM order_details GROUP BY prod_id ORDER BY prodcnt DESC";
                
                $popular_qry  = " SELECT prod.Id, prod.EnName, prod.ChName, prod.Image, prod.Price, detail.prod_id , COUNT(detail.prod_id ) AS prodcnt
FROM products AS prod, order_details AS detail WHERE detail.prod_id = prod.Id AND prod.ProdStatus = '1' GROUP BY detail.prod_id ORDER BY prodcnt DESC
LIMIT 0 , 4";
				 $popular_res = $GLOBALS['db_con_obj']->execute_sql($popular_qry,"select");
				 while($popular_data = mysql_fetch_object($popular_res[0])){
					 
					$detail_link = "product_detail.php?prod_id=" . $popular_data->Id;
				
				 	$med_img_path = $prod_obj->attachment_path . $popular_data->Image;
				 
					if(file_exists($med_img_path) && is_file($med_img_path))
						$disp_img = $med_img_path;
					else
						$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
				?>
                	<li>
                    	<div class="product-bg">
                        	<a href="<?php echo $detail_link;?>"><img src="phpthump/phpThumb.php?src=../<?php echo $disp_img; ?>&w=150&h=122&q=75" border="0" alt="<?php echo display_field_value($popular_data,"Name");?>" title="<?php echo display_field_value($popular_data,"Name");?>"></a>
                        </div>
                        <strong><a href="<?php echo $detail_link;?>"><?php echo trim_text(display_field_value($popular_data,"Name"),35);?></a></strong><br />
                        <em>SGD <?php echo $popular_data->Price;?></em>
                    </li>
                    
                    <?php } ?>
                    
                   
                </ul>
            </div>