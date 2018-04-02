  <?php if(strlen($_SESSION['ses_msg_str']) > 0) { ?>
<div align="center"><span class="<?php echo stripslashes($_SESSION['ses_msg_cls_str']); ?>"><?php echo stripslashes($_SESSION['ses_msg_str']); ?></span></div>
  <?php 
		  
		  $_SESSION['ses_msg_str'] = "";
		  $_SESSION['ses_msg_cls_str'] = "";
		  } 
		  
		  ?>
