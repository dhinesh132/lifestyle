<?php require_once("includes/code_header.php"); ?>
<html>
<head><title><?php echo stripslashes($GLOBALS['site_config']['company_name']); ?></title></head><body leftmargin="0" rightmargin="0" topmargin="10" bottommargin="0"><?php
  $imgval1=$_GET['img1'];

  if(file_exists($imgval1) && is_file($imgval1))
  {
  
  ?>
    <center><img src="<?=$imgval1;?>" border=0></center><br>
  <?php
  }
  else
  {
   echo "<font style='text-decoration:none;font-weight:bolder;font-size:13px'>No Image Available.</font>";
  }
?>
<center>
<a href="javascript:self.close()" style='text-decoration:none;font-weight:bolder;font-size:13px'>Close Window</a>
</center></body></html>