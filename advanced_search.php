<?php 
require_once("header.php"); 
require_once("classes/product_master.class.php");
require_once("classes/category_master.class.php");

if(isset($_REQUEST['search_id']))
{
 	unset($_SESSION['ses_search_cont']);
	unset($_SESSION['ses_temp_search_obj']);
	
	header("location:advanced_search.php");
	exit();
	
}

$prod_obj = new product_master();
$prodcat_obj = new category_master();

$cat_id = $_REQUEST['cat_id'];


$cat_res= $GLOBALS['db_con_obj']->fetch_flds($prodcat_obj->cls_tbl,"parent_id,cat_name","cat_id='".$cat_id."'");

$cat_data = mysql_fetch_object($cat_res[0]);

 $cat_name = $cat_data->cat_name;
 $parent_id = $cat_data->parent_id;
 
 $submit_action = $_REQUEST['submit_action'];

$display_what = "list_frm";

switch ($submit_action)
{
	case "search":
			$color ="";
			$cont = "";
			unset($_SESSION['ses_temp_search_obj']);
			
			if($_REQUEST['frame_type'] >0)
				$cont = " and frame_type='".$_REQUEST['frame_type']."' ";
			if($_REQUEST['mat_type'] >0)
				$cont .= " and concat(',',mat_id,',') like '%,".$_REQUEST['mat_type'].",%' ";
			if($_REQUEST['gen_type'] >0)
				$cont .= " and concat(',',gen_id,',') like '%,".$_REQUEST['gen_type'].",%' ";
				
			/******************  Color search  START******************************/

			if($_REQUEST['color'] >0)
				$cont .= "and concat(',',color_id,',') like '%,".$_REQUEST['color'].",%' ";
			if($_REQUEST['color1'] >0)
				{
				if($_REQUEST['color'] >0)
				$cont .= "or concat(',',color_id,',') like '%,".$_REQUEST['color1'].",%' ";
				else
				$cont .= "and concat(',',color_id,',') like '%,".$_REQUEST['color1'].",%' ";
				}
			if($_REQUEST['color2'] >0)
				{
				if($_REQUEST['color'] >0 || $_REQUEST['color1'])
				$cont .= "or concat(',',color_id,',') like '%,".$_REQUEST['color2'].",%' ";
				else
				$cont .= "and concat(',',color_id,',') like '%,".$_REQUEST['color2'].",%' ";
				}
			  /******************  Color search  END******************************/
			  
			  /******************  Price search  START******************************/
			if($_REQUEST['from_price'] >0 || $_REQUEST['to_price'])
				{
				if($_REQUEST['from_price'] >0)
					$from_price = $_REQUEST['from_price'];
				else
					$from_price = $_REQUEST['to_price'];	
				
				if($_REQUEST['to_price'] >0)
					$to_price = $_REQUEST['to_price'];
				else
					$to_price = $_REQUEST['from_price'];
				
				$cont .= "and price  between ".$from_price." and ".$to_price." ";
				}
				
			/******************  Price search  END******************************/

			  
			  
			 /******************  Gneter/Style search  START******************************/
			if($_REQUEST['gen1'] >0)
				$cont .= "and concat(',',gen_id,',') like '%,".$_REQUEST['gen1'].",%' ";
			if($_REQUEST['gen2'] >0)
				{
				if($_REQUEST['gen1'] >0)
				$cont .= "or concat(',',gen_id,',') like '%,".$_REQUEST['gen2'].",%' ";
				else
				$cont .= "and concat(',',gen_id,',') like '%,".$_REQUEST['gen2'].",%' ";
				}
			if($_REQUEST['gen3'] >0)
				{
				if($_REQUEST['gen1'] >0 || $_REQUEST['gen2'])
				$cont .= "or concat(',',gen_id,',') like '%,".$_REQUEST['gen3'].",%' ";
				else
				$cont .= "and concat(',',gen_id,',') like '%,".$_REQUEST['gen3'].",%' ";
				}
				
			/******************  Gneter/Style search  END******************************/
			
			/******************  Type search  START******************************/
			if($_REQUEST['type3'] >0)
				{
				$cont .= "and lens_depth > 24";
				}
				
			/******************  Type search  END******************************/

			
			$_SESSION['ses_search_cont'] =$cont; 
			
			foreach($_REQUEST as $ky => $vl)
			$_SESSION['ses_temp_search_obj'][$ky] = $vl;
			
		
			header("location:advanced_search.php");
			exit();
		
	 break;
	
}



?>
<table <?php echo $inner_table_param; ?>>
  <tr>
    <td valign="top"><?php
	
	require_once("includes/error_message.php");
	
	require_once("forms/category_list_frm1.php");
	require_once("forms/product_list_frm.php");
	
	?></td>
  </tr>
</table>
<?php 

require_once("footer.php"); 

?>