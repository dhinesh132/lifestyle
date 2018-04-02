
<?
include("connection_db.php");
dbConnect();
$cust_id=$_REQUEST["cust_id"];

?>
<link href="../style/styles.css" rel="stylesheet" type="text/css" />




<p><p>
<p>
<p>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <table width="100%"   cellspacing="1" cellpadding="5" bgcolor="#A4B5FA" align="center" >
    <tr>
      <td><font class='buyerfont'>Model No</font></td>
      <td><font class='buyerfont'>Frame Name</font></td>
      <td><font class='buyerfont'>Brand</font></td>
      <td><font class='buyerfont'>Size</font></td>
      <td><font class='buyerfont'>Stock Code</font></td>
      <td><font class='buyerfont'>Price</font></td>
      <td><font class='buyerfont'>Color</font></td>
      <td><font class='buyerfont'>Material</font></td>
    </tr>
    <?
$order_qry=mysql_query("select * from order_master where user_id='$cust_id'");
while($fetch_order_qry=mysql_fetch_array($order_qry))
{

	$order_id=$fetch_order_qry["order_id"];
	?>
    <tr bgcolor="#FFFFFF" class="normaltext">
      <td colspan="8" ><strong><font color="#FF00FF">&nbsp;&nbsp;Order No:
            <?=$order_id?></font>
      </strong></td>
    </tr>
    <?
	$order_details_qry=mysql_query("SELECT * FROM order_details WHERE order_id=$order_id");
	
	while($fetch_order_details=mysql_fetch_array($order_details_qry))
		{

			$prod_id=$fetch_order_details["prod_id"];
			//echo "SELECT * FROM product_master where prod_id=78";
			$product_qry=mysql_query("SELECT * FROM product_master where prod_id='$prod_id'");
			$num_product=mysql_num_rows($product_qry);
			if($num_product>0)
			{
				$flag=1;
			}
			if($flag==1)
			{
			while($fetch_product=mysql_fetch_array($product_qry))
				{
						$model_no  =$fetch_product["model_no"];
						$size	   =$fetch_product["size"];
						$brand	   =$fetch_product["brand"];
						$color_code=$fetch_product["color_code"];
						$stock_code=$fetch_product["stock_code"];
						$price	   =$fetch_product["price"];
						$depth	   =$fetch_product["lens_depth"];
						$description=$fetch_product["description"];
						$frame_type=$fetch_product["frame_type"];
						
						// for displaying frame Name
						$sql_frame=mysql_query("SELECT * FROM frame_master WHERE frame_id='$frame_type'");
						while($fetch_frame=mysql_fetch_array($sql_frame))
						{
						$frame_name=$fetch_frame["frame_name"];
						
						}
				
				// for displaying material name
				 
  			
			
  ?>
    <tr bgcolor="#FFFFFF" class="normaltext">
      <td><?=$model_no?></td>
      <td><?=$frame_name?></td>
      <td><?=$brand?></td>
      <td><?=$size?></td>
      <td><?=$stock_code?></td>
      <td><?=$price?></td>
      <td><?=$color_code?></td>
      <?
    $material=$fetch_product["mat_id"];
	
		
				$material1=explode(",",$material);
				//print_r($material1);
				 ?>
				 <td>
				 <?
				 	$cnt=1;
					for($i=0;$i< count($material1);$i++)
					{
						$mat_name1="";
					
					//echo "SELECT * FROM material_master where mat_id= '$material1[$i]'";
					$mat_id1=mysql_query("SELECT * FROM material_master where mat_id='$material1[$i]'");
					while($fetch_mat=mysql_fetch_array($mat_id1))
						{
						
							$mat_name=$fetch_mat["mat_name"];
							if($cnt==1)
								$mat_name1=	$mat_name;	
							else
							{
								$mat_name1=	$mat_name1.",".$mat_name;
							
							}
							
							
							
						}	
						//break;
						$cnt++;
						echo $mat_name1;
						
					}
				?>      </td>
    </tr>
    
    <?
			}
		 }
		}	// end of if loop
	}
	?>
    <tr bgcolor="#FFFFFF">
      <td colspan="8" align="center"><font color="#FF0000"><? if ($flag!=1){?>No Products Found<? }?></font></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
<p>
<p>
