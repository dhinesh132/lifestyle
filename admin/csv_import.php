<?php 

require_once("admin_header.php"); 

require_once("../classes/product_master.class.php");


$prod_obj = new product_master();



$display_what = "detail_frm";



if($_REQUEST['submit_upload']=="upload")

{


 if($_REQUEST['import_csv']=="product")

 {

 
 $rd_pg =1;

 if (!file_exists("../uploads/csv_files/csv_product.csv"))

	{

	frame_notices("Please upload respective csv file and then try importing data !!","redfont"); 

	}

	else

	{


	$r=0;		

	$handle = fopen("../uploads/csv_files/csv_product.csv", "r");

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)

	 {

		$num = count($data);

		 if($r!=0)

		{
			$prod_id  = $data[0];

		  	$prod_name  = $data[1];
			          
			$prod_desc  = $data[2];               
			                
			$prod_status   = $data[3]; 
			                
			$prod_our_price = $data[4]; 
			          
			$prod_normal_price = $data[5];         
			             
			$prod_weight  = 	$data[6];        
                            
			$author    =	$data[7]; 
			                  
			$published_by   =	$data[8]; 
			             
			$isbn_no     =	$data[9];                  
	        
			$is_book_of_week  =	$data[10];              
			           
			$min_orders      =	$data[11];  
			           
			$max_orders     =	$data[12];  
			            
			$rating        =	$data[13];      
			         
			$stocks_available  =	$data[14];  
			      
			$editor_choice =	$data[15];   
			
	  	   $date_entered	=	date("Y-m-d H:i:s");

		   $date_modified	=	date("Y-m-d H:i:s");

	
		  $q = "select prod_id from  product_master  where prod_id = '" . $prod_id . "' order by prod_id";

	
		  $gselect = $cselect=$GLOBALS['db_con_obj']->execute_sql($q);

	
		  $row = mysql_fetch_array($gselect[0],MYSQL_ASSOC);
	  

		  if($row['prod_id'] == $prod_id)

			{	  

	 $qry = "update product_master set prod_name  = '".wrap_values($prod_name)."', prod_desc  = '".wrap_values($prod_name)."', prod_status   = '".wrap_values($prod_status)."', prod_our_price = '".wrap_values($prod_our_price)."', prod_normal_price = '".wrap_values($prod_normal_price)."',  prod_weight  = '".wrap_values($prod_weight)."', author    =	'".wrap_values($author)."', published_by   =	'".wrap_values($published_by)."', isbn_no     =	'".wrap_values($isbn_no)."', is_book_of_week  =	'".wrap_values($is_book_of_week)."'  min_orders      =	'".wrap_values($min_orders)."' max_orders     =	'".wrap_values($max_orders)."' rating =	'".wrap_values($max_orders)."', stocks_available  =	'".wrap_values($stocks_available)."',  editor_choice =	'".wrap_values($editor_choice)."', date_entered	=	'".date_entered."', date_modified = '".$date_modified."',  where prod_id = '" . $prod_id . "' order by prod_id";

	    $GLOBALS['db_con_obj']->execute_sql($qry,"update");

	}

	else

	{


		$qry = "insert into product_master  (prod_name, prod_desc,prod_status,prod_our_price,prod_normal_price, prod_weight,author, published_by,isbn_no ,is_book_of_week, min_orders,max_orders,rating, stocks_available,editor_choice,date_entered,date_modified) values ('".wrap_values($prod_name)."','".wrap_values($prod_name)."'    , '".wrap_values($prod_status)."'  , '".wrap_values($prod_our_price)."'  , '".wrap_values($prod_normal_price)."'   , '".wrap_values($prod_weight)."'     ,	'".wrap_values($author)."'   ,	'".wrap_values($published_by)."'     ,	'".wrap_values($isbn_no)."'   ,	'".wrap_values($is_book_of_week)."'        ,	'".wrap_values($min_orders)."'      ,	'".wrap_values($max_orders)."'  ,	'".wrap_values($max_orders)."'  ,	'".wrap_values($stocks_available)."'   ,	'".wrap_values($editor_choice)."' ,	'".$date_entered."','".$date_modified."')";

				

	$GLOBALS['db_con_obj']->execute_sql($qry,"insert");	

	}

	}

	

	$r++;

	}

	

	 fclose($handle);

	 frame_notices("Successfully imported in table !!","greenfont"); 

	 }

 }

 
}

echo $_REQUEST['submit_upload'];

if($rd_pg == 1)

{

	header("location:csv_import.php");

	exit();

}



?>





<table <?php echo $inner_table_param; ?> align="center">

  <tr>

    <td>

<?php

	

require_once("../includes/error_message.php");



switch ($display_what)

{

	

	case "detail_frm":

		require_once("../forms/admin/courses_csv_import_frm.php"); 

		break;



	/*case "list_frm";

		require_once("../forms/admin/product_master_list_frm.php"); 

		break;



	case "preview_frm";

		require_once("../forms/admin/product_master_preview_frm.php"); 

		break;*/

		



} //end switch



?>

	</td>

  </tr>

</table>





<?php 



require_once("admin_footer.php"); 



?>