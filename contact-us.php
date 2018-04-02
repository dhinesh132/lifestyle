<?php 
$currentUrl = explode("/",$_SERVER["PHP_SELF"]);
$count_res = count($currentUrl)-1;
$curentFile = $currentUrl[$count_res];

$spl_doc_title = "About Us";
require_once("header.php"); 
$BreadCrumb = CONTACTUSBREADCRUMB;
require_once("classes/static_pages.class.php");
$page_obj = new static_pages();

$page_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","*","page_link='".$curentFile."' and display_status=1");
$page_data = mysql_fetch_object($page_res[0]);

$image_path = $page_obj->attachment_path.$page_data->banner_image;
?>

<div id="content">   	
 <?php 
 require_once("includes/breadcrumbs.php");
 require_once("includes/template_left.php");
 ?>
  <div class="right">
  <?php if(file_exists($image_path) && is_file($image_path)) { ?>
        	<div class="title-header">
            	<img src="<?php echo $image_path;?>" alt="" />
            </div>
  <?php } ?>
            	<h1><?php echo display_field_value($page_data,"Title");?></h1><br />
				<table width="680px">                
                <tr>
                    <td width="100%">
					<?php echo display_field_value($page_data,"Content");?>
                    </td>
                  </tr>
                </table>
	</div>

<?php 

require_once("footer.php"); 

?>