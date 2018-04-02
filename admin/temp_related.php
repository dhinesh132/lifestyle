<?php

require_once("admin_header.php"); 

$_SESSION['ses_rel_frame_id'] = $_REQUEST['frame_id'];

header("location:frame_len_referense.php");

exit();

?>
