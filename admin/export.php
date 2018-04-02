<?php
require_once("admin_db_connection.php");
    $header='';
	$data ='';
	$action = $_REQUEST['action'];
	if($action =='export'){
		$condition ="1=1 ";
		
		if($_REQUEST['gender'] >0)
			$condition .= "and gender =".$_REQUEST['gender']." ";
		
		if($_REQUEST['age_limit'] >0)
			$condition .= "and age_limit =".$_REQUEST['age_limit']." ";
			
		if($_REQUEST['repYear'] >2010 && $_REQUEST['repMonth'] >0 && $_REQUEST['repDay'] >0){
			$from_date = strtotime($_REQUEST['repYear']."-".$_REQUEST['repMonth']."-".$_REQUEST['repDay']." 00:00:00");
			$condition .= "and UNIX_TIMESTAMP(date_entered) >= '".$from_date."' ";
			
		}
		else{
			$lastmonth = strtotime(date("Y-m-d H:i:s",mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))));
			$condition .= "and UNIX_TIMESTAMP(date_entered) >= '".$lastmonth."' ";
		}
			
		if($_REQUEST['repYear1'] >2010 && $_REQUEST['repMonth1'] >0 && $_REQUEST['repDay1'] >0){
			$to_date = strtotime($_REQUEST['repYear1']."-".$_REQUEST['repMonth1']."-".$_REQUEST['repDay1']." 23:59:59");
			$condition .= "and UNIX_TIMESTAMP(date_entered) <= '".$to_date."' ";
		}
			
			
   echo  $sql = "SELECT id,gender,age_limit,tot_score,price,date_entered,sub_name,sub_email,answers FROM subscriber_list WHERE ".$condition." order by id asc";
	
	
	
    $rec = mysql_query($sql) or die (mysql_error());
	
    exit;
    $num_fields = mysql_num_fields($rec);
    
   $header .="Id,Gender,Age limit,Score,Price,Created,Name,Email,Answer 1,Answer 2,Answer 3,Answer 4,Answer 5".",";
    
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
				if($key ==1 && $value ==1){
					$value = "Male";
				}
				else if($key ==1 && $value ==2){
					$value = "Female";
					
				}
				
				if($key ==2 && $value ==1){
					$value = "below 13";
				}
				else if($key ==2 && $value ==2){
					$value = "Above 13";
					
				}
				
				if($key ==8 && $value !=''){
					 $answer='';
					 $explods = explode("=(",$value);
					 $ques_ans_points = substr($explods[1],0,-2);
					 $ques_ans_points_unique = explode(";",$ques_ans_points);
					 foreach($ques_ans_points_unique as $key =>$val){
						$result = explode(":",$val);
						$ques_sql =  "SELECT id,question FROM questions WHERE id =".$result[0];
						$ques_res = mysql_query($ques_sql);
						$ques_data=mysql_fetch_object($ques_res);
						$ans_sql ="SELECT id,answer FROM answers WHERE id =".$result[1];
						$ans_res = mysql_query($ans_sql);
						$ans_data=mysql_fetch_object($ans_res);
						$answer .= str_replace(","," ",$ques_data->question)."? ".str_replace(","," ",$ans_data->answer). ","; 							 
					}
					$value =$answer;
				}
				
				
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
    header("Content-Disposition: attachment; filename=reports.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$data";
	}
?>