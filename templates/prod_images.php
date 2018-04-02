<?php $prod_pic =$GLOBALS['site_config']['site_path'].$prod_obj->attachment_path.$data->Image; ?>
<div class="prod-photo-blk">
          <div class="main-prod-img"><img class="prod-big-img" src="<?php echo $prod_pic ?>" alt="<?php echo $data->Name;?>" title="<?php echo $data->Name;?>"></div>
          
          <div class="prod-thubs w-clearfix">
            <div class="prod-item-out"><a class="prod-thumb-item w-inline-block" href="#"><img class="thumb-umg" sizes="(max-width: 479px) 100vw, (max-width: 767px) 22vw, 11vw" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/phpThumb_generated_thumbnail3.jpg" ></a></div>
            <div class="prod-item-out"><a class="prod-thumb-item w-inline-block" href="#"><img class="thumb-umg" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/main-prod-img-long.jpg"></a></div>
            <div class="prod-item-out"><a class="prod-thumb-item w-inline-block" href="#"><img class="thumb-umg" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/long-img.jpg"></a></div>
            <div class="prod-item-out"><a class="prod-thumb-item w-inline-block" href="#"><img class="thumb-umg" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/main-prod-img.jpg"></a></div>
          </div>
        </div>