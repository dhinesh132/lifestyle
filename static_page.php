<?php 

require_once("header.php"); 
require_once("classes/static_pages.class.php"); 

$sp_obj = new static_pages();
 
$static_pg_id = $_REQUEST['static_pg_id'];

$sp_res = $sp_obj->fetch_record($static_pg_id, 1);

$sp_data = mysql_fetch_object($sp_res[0]);

if($sp_res[1] <= 0)
{
	header("location:index.php");
	exit();
}



?><table <?php echo $inner_table_param; ?>>
  <tr>
    <td style="padding-left:20px;padding-right:10px"><?php require_once("includes/error_message.php"); ?><p><?php 
	$content = stripslashes(str_replace("#title#", $sp_data->page_title,$sp_data->page_content)); 
	echo str_replace("../"," ",$content);?></p></td>
  </tr>
</table><?php 

require_once("footer.php"); 

?>