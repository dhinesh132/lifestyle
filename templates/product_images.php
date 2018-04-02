<?php $prod_pic =$GLOBALS['site_config']['site_path'].$prod_obj->attachment_path.$data->Image; ?>
<div class="prod-photo-blk">
<div class="main-prod-img">  
         <a href='<?php echo $prod_pic; ?>' class = 'cloud-zoom' id='zoom1' style="position: relative; display: block;" rel="position:'inside',showTitle:false,adjustX:-4,adjustY:-4"><img src="<?php echo $prod_pic; ?>" alt="<?php echo $data->Name;?>" title="<?php echo $data->Name;?>"></a>
			</div>
		<div class="zoom-desc">
			<h3></h3>       
			<p>
            <?php 
		  	$count =1;
			$gallery_res = $GLOBALS['db_con_obj']->fetch_flds($gallery_obj->cls_tbl,"*","ProdId='".$data->Id."' and Status=1  order by DisplayOrder desc limit 0,5"); 
			if($gallery_res[1] >0) { ?>
          <div class="prod-thubs w-clearfix">
          <?php
			while($gallery_data = mysql_fetch_object($gallery_res[0])){
				$more_pic =$gallery_obj->attachment_path.$gallery_data->SmallImage;	
				$large_pic =$gallery_obj->attachment_path.$gallery_data->Picture;
			?>
            <div class="prod-item-out">
                <a href='../<?php echo $large_pic;?>' class='prod-thumb-item w-inline-block cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '../<?php echo $large_pic;?>' "><img class="zoom-tiny-image" src="../<?php echo $more_pic;?>" alt = "<?php echo $gallery_data->EnTitle?>"/></a>
             	</div>
        
			<?php } ?>
			
			</div>
            <?php } ?>
	</div>
 </div>