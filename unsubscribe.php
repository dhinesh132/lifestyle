<?php 

require_once("header.php"); 
require_once("classes/nl_subscriber.class.php"); 

$nlsub_obj = new nl_subscriber();

$typ = $_REQUEST['utyp'];
$usrid = $_REQUEST['usr_id'];
$usreml = $_REQUEST['usr_eml'];

$nlsub_obj->unsubscribe_user($typ, $usrid, $usreml);

?>


<table <?php echo $inner_table_param; ?>>
  <tr>
    <td><?php

	require_once("includes/error_message.php");
	
	?></td>
  </tr>
</table>


<?php 

require_once("footer.php"); 

?>