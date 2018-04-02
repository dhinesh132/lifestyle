<?php
if($step ==1){
	$step1_css ="active" ;
	$step2_css ="";
	$step3_css ="";
}
else if($step ==2){
	$step1_css ="" ;
	$step2_css ="active";
	$step3_css ="";
}else {
	$step1_css ="" ;
	$step2_css ="";
	$step3_css ="active";
}
?>
<div class="cartprogress">
            <div class="<?php echo $step1_css;?> progress-item">
              <div class="progress-in">
                <div class="<?php echo $step1_css;?> cart-cir">
                  <div>1</div>
                </div>
                <div class="cart-item-text">Cart Items</div>
              </div>
            </div>
            <div class="<?php echo $step2_css;?> progress-item">
              <div class="progress-in">
                <div class="<?php echo $step2_css;?> cart-cir">
                  <div>2</div>
                </div>
                <div class="cart-item-text">Shipping &amp; Billing Info</div>
              </div>
            </div>
            <div class="<?php echo $step3_css;?> last progress-item">
              <div class="progress-in">
                <div class="<?php echo $step3_css;?> cart-cir">
                  <div>3</div>
                </div>
                <div class="cart-item-text">Confirmation</div>
              </div>
            </div>
          </div>