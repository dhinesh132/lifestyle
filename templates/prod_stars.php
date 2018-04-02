<div class="ratingblk">
    <div class="stars">
    <?php $val = explode(".",$data->admin_star);
	for($i=0;$i<$val[0];$i++){
	?>
    <img class="star-img" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/full-star.png" width="9">
   <?php } if($val[1] >0) {?>
    <img class="star-img" src="<?php echo $GLOBALS['site_config']['site_path'];?>images/half-star.png" width="9">
    <?php } ?>
    
    </div>
    <div class="rating-score"><?php echo $data->admin_star;?></div>
</div>