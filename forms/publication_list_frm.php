<div id="content">   	
 <?php 
 require_once("includes/breadcrumbs.php");
 require_once("includes/template_left.php");
 ?>
        <div class="right">
        	<div class="title-header">
            	<img src="images/publication.jpg" alt="" />
            </div>
            	<h1><?php echo PUBLICATION?></h1><br />
                <?php
				$qry = publication($prod_obj);				 
				 
				if(isset($_SESSION['ses_temp_search_obj']['tot_rec']))
				$rec = $_SESSION['ses_temp_search_obj']['tot_rec'];
				else
				$rec = 24;
				 
				
				 
				$paging_cls = new matrixpaging($qry,$rec,11,4);
				$mat_col_cnt = 0;
				?>
                <form name="filtr_frm" id="filtr_frm" action="" method="post">
                <table width="680px">                
                <tr>
                    <td width="30%"><?php echo PUBLICATIONFOUND?> (<?php echo $paging_cls->num_of_rows;?>)</td>  
                    
                    <td width="70%" align="right">
                    <select class="select" title="Select one" name="auth" onchange="$('#filtr_frm').submit();">
                        <option value="all"> <?php echo ALLAUTHOR;?>:</option>
                       <?php
					    $author_res = $db_con_obj->fetch_flds("authors", "*", "AuthStatus =1 order by DisplayOrder DESC"); 				 
				 ?>
						<?php 
                        while($author_data = mysql_fetch_object($author_res[0])){
                        ?>
                       <option value="<?php echo $author_data->AuthId;?>" <?php if($_SESSION['ses_temp_search_obj']['author']==$author_data->AuthId){?> selected="selected"<?php } ?>><?php echo display_field_value($author_data,"Name");?></option>
                        <?php
                        }
                        ?>
                    </select>
                    
                    <select class="select" title="Select one" name="perPage" onchange="$('#filtr_frm').submit();">
                        <option value=""> <?php echo PERPAGE;?>:</option>
                        <option value="20" <?php if($_SESSION['ses_temp_search_obj']['tot_rec']==20){?> selected="selected"<?php } ?>> 20</option>
                        <option value="40" <?php if($_SESSION['ses_temp_search_obj']['tot_rec']==40){?> selected="selected"<?php } ?>> 40</option>
                        <option value="60" <?php if($_SESSION['ses_temp_search_obj']['tot_rec']==60){?> selected="selected"<?php } ?>> 60</option>
                         <option value="100" <?php if($_SESSION['ses_temp_search_obj']['tot_rec']==100){?> selected="selected"<?php } ?>>100</option>
                    </select>
                    
                    <select class="select" title="Select one" name="sortBy" onchange="$('#filtr_frm').submit();">
                        <option value=""> <?php echo SORTBY;?>:</option>
                        <option value="Name" <?php if($_SESSION['ses_temp_search_obj']['sort_by']=='Name'){?> selected="selected"<?php } ?>> Name</option>
                        <option value="Price" <?php if($_SESSION['ses_temp_search_obj']['sort_by']=='Price'){?> selected="selected"<?php } ?>> Price</option>
                        <option value="Date" <?php if($_SESSION['ses_temp_search_obj']['sort_by']=='Date'){?> selected="selected"<?php } ?>> Date</option>
                    </select>
                    </td>
                    </tr>
                 </table>
                 <input type="hidden" name="submit_action"  value="filter"  />
                 </form>
              <br /><br />
        	   <div id="products">
               <?php
			  for($i=$paging_cls->start_index;$i<$paging_cls->end_index;$i++){
			  if(mysql_data_seek($paging_cls->resultset,$i))
			  {
				$data = mysql_fetch_object($paging_cls->resultset);  
			  }
			  else
			  {
				unset($data);
			  }
			  
			  if(isset($data))
			  {
				$mat_col_cnt++;
			
				$detail_link = "product_detail.php?prod_id=" . $data->Id;
				
				 $med_img_path = $prod_obj->attachment_path . $data->Image;
				 
				if(file_exists($med_img_path) && is_file($med_img_path))
		  			$disp_img = $med_img_path;
				else
					$disp_img = $prod_obj->attachment_path . 'default_prod.gif';
			
			?>
			  <div class="products-list">
					<div class="product-bg">
						  <a href="<?php echo $detail_link;?>"><img src="phpthump/phpThumb.php?src=../<?php echo $disp_img; ?>&w=150&h=122&q=75" border="0" alt="<?php echo display_field_value($data,"Name");?>" title="<?php echo display_field_value($data,"Name");?>"></a>
					 </div>
					<strong><a href="<?php echo $detail_link;?>"><?php echo trim_text(display_field_value($data,"Name"),40);?></a></strong><br />
                    <?php echo LANGBY;?> : <?php 
					$res = $GLOBALS['db_con_obj']->fetch_flds("authors","EnName,ChName","AuthId=".$data->AuthorId);
					$author = mysql_fetch_object($res[0]);
					echo trim_text(display_field_value($author,"Name"),20);
					?><br />
					<em>SGD <?php echo $data->Price;?></em>
			   </div>
			<?php
			} //end if(isset($data
			}
			
			?>
			</div>
		
  		<div align="right">
		<?php
        
        
        if($paging_cls->num_of_rows > 0)
        {        
        $paging_cls->print_prev();
        $paging_cls->print_numbered_links();
        $paging_cls->print_next();
       // $paging_cls->print_pages_of(); 
        
        }
        
        ?> 
        </div>
</div>