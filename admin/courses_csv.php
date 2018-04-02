<?php require_once("admin_header.php");
require_once("../classes/courses.class.php");
$courses_obj = new courses();
$display_what = "detail_frm";
if($_REQUEST['submit_upload']=="upload")
	{
	
	$file_name2=$_FILES['upload_product_csv']['name'];
	$file_type2=$_FILES['upload_product_csv']['type'];
	$size2 = $_FILES['upload_product_csv']['size'];
	
	if(strlen(trim($file_name2))>0) 
		{ 
		
		if($file_type2=="application/vnd.ms-excel")
		{ $tupload=1;
		}
		else
		{
		$tupload=0;
		} 
		} 
	else{$tupload=2;
	}
	
	
	if($tupload==1)
	{
	$upload_dir = "../uploads/csv_files/";
	$upload_file = $_FILES['upload_product_csv']['name'];
	$upload_file1 = "csv_product.csv";
	$cpfile=date("YmdHis")."_".$upload_file1;
	$cpfile = "../uploads/csv_files/backup_csvfiles/".$cpfile;
	if(file_exists($upload_dir.$upload_file1)){copy($upload_dir.$upload_file1,$cpfile);
	}if(file_exists($upload_file)){rename( $upload_file1,$upload_file);
	}
	$upload_path=$upload_dir.$upload_file1;
	if(move_uploaded_file($_FILES['upload_product_csv']["tmp_name"],$upload_path))
	{$rd_pg=1;
	frame_notices("Successfully file uploaded !!","greenfont");
	}
	} 
	else{if(strlen(trim($file_name2))>0)
	{$rd_pg=1;
	frame_notices("Please upload only csv files !!","redfont");
	}
	}
}
if($rd_pg == 1)
{
header("location:courses_csv.php");
}
?>
<table <?php echo $inner_table_param; ?> align="center">
<tr>
<td>
<?php require_once("../includes/error_message.php");
switch ($display_what)
{
case "detail_frm":
require_once("../forms/admin/courses_csv_frm.php");
 break;
} ?>
 </td>
 </tr>
 </table>
 <?php require_once("admin_footer.php"); ?>