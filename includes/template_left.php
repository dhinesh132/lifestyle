<?php 
if($page_data->parent_id >0){
	$menu_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style","Id =".$page_data->parent_id);
	$menu_data = mysql_fetch_object($menu_res[0]); 
	$left_sub_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style","menu_type=4 and parent_id =".$page_data->parent_id."  and display_status=1 order by display_order"); 
	
	
?>
<div class="left">
        	<h1><?php echo display_field_value($menu_data,"Title");?></h1>
            <div class="products">
            	<ul>
                <?php 
				while($left_sub_data = mysql_fetch_object($left_sub_res[0])){
			    ?>
                 <a href="<?php echo $left_sub_data->page_link;?>"><li><?php echo display_field_value($left_sub_data,"Title");?></li></a>
                 <?php } ?>
                </ul>
            </div><br /><br />
</div>
<?php } else  { ?>
<div class="left" >
        	<h1><?php echo PRODUCTS?></h1>
            <div class="products">
            	<ul>
                <?php
				$str='';;
				$fun_res = $db_con_obj->fetch_flds("functions", "FunId,EnName,ChName", "FunStatus =1 order by DisplayOrder desc"); 
				while($fun_data = mysql_fetch_object($fun_res[0])){
				?>
                <a href="product_lists.php?fun=<?php echo $fun_data->FunId; ?>"><li><?php echo $fun_data->EnName;?></li></a>
                
                <?php
				/*if(in_array($fun_data->FunId,$_SESSION['ses_temp_search_obj']['functions'])){
					$checked = 'checked="checked"';
				}
				else {
					$checked ='';
				}
				$str .= '<li><input type="checkbox" name="functions[]" value="'.$fun_fltr_data->FunId.'" onclick="$(\'#filtr_products\').submit();" '.$checked.'>'.display_field_value($fun_data,"Name").'</li>';*/
				} 
				?>
                	
                </ul>
            </div><br /><br />
            <?php if($spl_doc_title == "Products" && $BreadCrumb !='Publications'){ ?>
            <div class="sbrown-bg">
            <form name="filtr_products" id="filtr_products" action="product_lists.php" method="post">
            	<div class="title-bar"><?php echo FILTERPRODUCTSBY?></div>
                <div class="lightbrown-bg">
                <h2><?php echo FUNCTIONS?></h2><br />
                <ul>
                 <?php
				 //echo $str;
				$fun_fltr_res = $db_con_obj->fetch_flds("functions", "FunId,EnName,ChName", "FunStatus =1 order by DisplayOrder desc"); 
				while($fun_fltr_data = mysql_fetch_object($fun_fltr_res[0])){
				?>
                <li><input type="checkbox" name="functions[]" value="<?php echo $fun_fltr_data->FunId?>" onclick="$('#filtr_products').submit();" <?php if(in_array($fun_fltr_data->FunId,$_SESSION['ses_temp_search_obj']['functions'])){?> checked="checked"<?php }?>><?php echo $fun_fltr_data->EnName;?></li>
                <?php
				}
				?>
                
                </ul>
                </div>
             
                <div class="lightbrown-bg">
                <h2><?php echo MATERIAL?></h2><br />
                <ul>
                <?php
				$mat_res = $db_con_obj->fetch_flds("materials", "MatId,EnName,ChName", "MatStatus =1 order by DisplayOrder desc"); 
				while($mat_data = mysql_fetch_object($mat_res[0])){
				?>
                <li><input type="checkbox" name="materials[]" value="<?php echo $mat_data->MatId?>"   onclick="$('#filtr_products').submit();" <?php if(in_array($mat_data->MatId,$_SESSION['ses_temp_search_obj']['materials'])){?> checked="checked"<?php }?>><?php echo $mat_data->EnName;?></li>
                <?php
				}
				?>
                </ul>
                </div>
                
                <div class="lightbrown-bg">
                <h2><?php echo TYPE?></h2><br />
                <ul>
                <?php
				$type_res = $db_con_obj->fetch_flds("types", "TypeId,EnName,ChName", "TypeStatus =1 order by DisplayOrder asc"); 
				while($type_data = mysql_fetch_object($type_res[0])){
				?>
                <li><input type="checkbox" name="types[]"  value="<?php echo $type_data->TypeId?>" onclick="$('#filtr_products').submit();" <?php if(in_array($type_data->TypeId,$_SESSION['ses_temp_search_obj']['types'])){?> checked="checked"<?php }?> ><?php echo $type_data->EnName;?></li>
                <?php
				}
				?>
                
                </ul>
                </div>
              
                <?php 
				if(isset($_SESSION['ses_temp_search_obj']['PriceFrom']))
					$startPrice = $_SESSION['ses_temp_search_obj']['PriceFrom'];
				else
				    $startPrice = 0;
				if(isset($_SESSION['ses_temp_search_obj']['PriceTo']))
					$endPrice = $_SESSION['ses_temp_search_obj']['PriceTo'];
				else
				    $endPrice = 2000;
				?>
                <link rel="stylesheet" href="style/jquery.ui.all.css">               
				<script src="js/jquery.ui.core.js"></script>
                <script src="js/jquery.ui.widget.js"></script>
                <script src="js/jquery.ui.mouse.js"></script>
                <script src="js/jquery.ui.slider.js"></script>
				<link rel="stylesheet" href="style/demos.css">
                <script>
				$(function() {
					$( "#slider-range" ).slider({
						range: true,
						min: 0,
						max: 2000,
						values: [ <?php echo $startPrice?>, <?php echo $endPrice?>],
						slide: function( event, ui ) {
							$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
							$( "#startPrice" ).html(ui.values[ 0 ]);
							$( "#endPrice" ).html(ui.values[ 1 ]);
							$( "#PriceFrom" ).val(ui.values[ 0 ]);
							$( "#PriceTo" ).val(ui.values[ 1 ]);
						}
					});
					$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
						" - $" + $( "#slider-range" ).slider( "values", 1 ) );
						$( "#startPrice" ).html($( "#slider-range" ).slider( "values", 0 ));
						$( "#endPrice" ).html($( "#slider-range" ).slider( "values", 1 ));
						$( "#PriceFrom" ).val($( "#slider-range" ).slider( "values", 0 ));
						$( "#PriceTo" ).val($( "#slider-range" ).slider( "values", 1 ));
				});
				</script>
                <div class="lightbrown-bg">
                	<h2><?php echo PRICE?></h2><br />                   
                    <div class="brown-box">  
                    <div id="slider-range" onMouseUp="$('#filtr_products').submit();"></div>                  	
						<input type="hidden" id="amount" name="price" />
                        <table width="225px">
                        	<tr>
                            	<td width="50%">SGD <input type="hidden" id="PriceFrom" name="PriceFrom"  /><span id="startPrice"> <?php echo $startPrice?></span></td>
                                <td align="right" width="50%">SGD <input type="hidden" id="PriceTo" name="PriceTo"  /><span id="endPrice"><?php echo $endPrice?></span></td>
                            </tr>
                        </table>
                     </div>
                </div>
                
                <input type="hidden" name="submit_action" value="search" />
               </form> 
            </div>  
             
            <?php }?>
        </div>
        <?php }?>