<?php

if($alternate_clr_ctr <= 0)
	$alternate_clr_ctr = 1;
else
	$alternate_clr_ctr++;

if(($alternate_clr_ctr%2) == 1)
 	$row_bg_color = "bgcolor='#E8E9EA'";
 else
  	$row_bg_color = "bgcolor='#CCCCCC'";

?>