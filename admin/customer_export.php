<?php
require_once("admin_db_connection.php");
    $header='';
	$data ='';
	$action = $_REQUEST['action'];
	if($action =='export'){
		$condition ="1=1 ";
		
			
		if($_REQUEST['repYear'] >2010 && $_REQUEST['repMonth'] >0 && $_REQUEST['repDay'] >0){
			$from_date = strtotime($_REQUEST['repYear']."-".$_REQUEST['repMonth']."-".$_REQUEST['repDay']." 00:00:00");
			$condition .= "and UNIX_TIMESTAMP(cust_create_datetime ) >= '".$from_date."' ";
			
		}
		else{
			$lastmonth = strtotime(date("Y-m-d H:i:s",mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))));
			$condition .= "and UNIX_TIMESTAMP(cust_create_datetime ) >= '".$lastmonth."' ";
		}
			
		if($_REQUEST['repYear1'] >2010 && $_REQUEST['repMonth1'] >0 && $_REQUEST['repDay1'] >0){
			$to_date = strtotime($_REQUEST['repYear1']."-".$_REQUEST['repMonth1']."-".$_REQUEST['repDay1']." 23:59:59");
			$condition .= "and UNIX_TIMESTAMP(cust_create_datetime ) <= '".$to_date."' ";
		}
			
		
			
    $sql = "SELECT cust_firstname , cust_lastname , cust_chinesename , cust_address1 , cust_address2 , cust_unit , cust_building ,cust_city , cust_state , cust_zip, cust_country ,  	cust_phone ,  cust_email, cust_dob , cust_income , cust_profession FROM  customer_master WHERE ".$condition." order by cust_id asc";
	
	
    $rec = mysql_query($sql) or die (mysql_error());
    
    $num_fields = mysql_num_fields($rec);
    
   $header .="First Name, Last Name, Chinese Name, Block No, Street Name, Unit No, Building, City, State, Zip/ Postal Cose, Country, Phone,Email, Date of Birth, Income Level, Profession".",";
    
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
        $data .= trim( $line ) . "\n";
    }
    
    $data = str_replace("\r" , "" , $data);
    
    if ($data == "")
    {
        $data = "\n No Record Found!\n";                        
    }
    
	
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=customerlist.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$data";
	}
?>