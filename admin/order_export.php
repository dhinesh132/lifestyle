<?php
    include("admin_db_connection.php");
    $header='';
	$data ='';
	$action = $_REQUEST['action'];
	if($action =='export'){
		$condition ="1=1 ";
		
			
		if($_REQUEST['repYear'] >2010 && $_REQUEST['repMonth'] >0 && $_REQUEST['repDay'] >0){
			$from_date = strtotime($_REQUEST['repYear']."-".$_REQUEST['repMonth']."-".$_REQUEST['repDay']." 00:00:00");
			$condition .= "and UNIX_TIMESTAMP(m.date_entered) >= '".$from_date."' ";
			
		}
		else{
			$lastmonth = strtotime(date("Y-m-d H:i:s",mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))));
			$condition .= "and UNIX_TIMESTAMP(m.date_entered) >= '".$lastmonth."' ";
		}
			
		if($_REQUEST['repYear1'] >2010 && $_REQUEST['repMonth1'] >0 && $_REQUEST['repDay1'] >0){
			$to_date = strtotime($_REQUEST['repYear1']."-".$_REQUEST['repMonth1']."-".$_REQUEST['repDay1']." 23:59:59");
			$condition .= "and UNIX_TIMESTAMP(m.date_entered) <= '".$to_date."' ";
		}
		
		if(isset($_REQUEST['order_status']) && $_REQUEST['order_status'] !=''){
			
			$condition .= "and m.order_status = '".$_REQUEST['order_status']."' ";
		}
		
			
   $sql = "SELECT m.order_id,m.bill_fname,m.bill_lname,m.bill_ads1,m.bill_ads2,m.bill_unit,m.bill_building,m.bill_city, m.bill_state ,m.bill_country,m.bill_zip ,m.bill_mobile ,m.bill_email , d.prod_name,d.prod_quantity,d.prod_unit_price,d.Weight FROM  order_master as m, order_details as d WHERE m.order_id = d.order_id and ".$condition." order by m.order_id asc";
	
	
	
    $rec = mysql_query($sql) or die (mysql_error());
    
    $num_fields = mysql_num_fields($rec);
    
   $header .="Invoice Id ,First Name, Last Name, Block, Address, Unit, Building, City, State,Country, Zip /Postal Code, Mobile, Email, Item, Quantity, Unit Price ($),Weight".",";
    
    while($row = mysql_fetch_row($rec))
    {
        $line = '';
        foreach($row as $key => $value)
        {  
		                                
            if((!isset($value)) || ($value == ""))
            {
                $value = ",";
            }
            else
            {
                $value = str_replace( ',' , '' , $value );
				$value = $value . ",";
            }
            $line .= $value;
        }
		
		 //$line .= "SGD, Paypal / Credit Card, Paypal";
		 
        $data .= trim( $line ) . "\n";
    }
    
	
    $data = str_replace("\r" , "" , $data);
	
	
    
    if ($data == "")
    {
        $data = "\n No Record Found!\n";                        
    }
    
	
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=orderslist.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n $data";
	}
?>