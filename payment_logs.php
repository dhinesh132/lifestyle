<?php

require_once("includes/code_header.php");

	
if(isset($_REQUEST["submit_action"]) && $_REQUEST["submit_action"]!="" && strtolower($_REQUEST["submit_action"])=="clear")
 {
  $_SESSION['ses_pay_status'] = "";
  $yrstr=="";
  unset($_SESSION['ses_log_srch_vars']);
  unset($_SESSION['ses_pay_status']);
  unset($_SESSION['ses_plog_srch_qry']);
	header("location:payment_logs.php");
	exit();
 }

if($_REQUEST['submit_action'] == "Show")
{
	foreach($_REQUEST as $key => $value)
	$_SESSION['ses_log_srch_vars'][$key] = $value;
    
if(isset($_REQUEST["payment_status"]) && $_REQUEST["payment_status"]!="" )
	{
	  $_SESSION['ses_pay_status'] = $_REQUEST["payment_status"];
	}
	else
	{
	 $_SESSION['ses_pay_status'] = "";
	}

	if(isset($_SESSION['ses_log_srch_vars']["reportdate"]) && $_SESSION['ses_log_srch_vars']["reportdate"]!="" )
	{
	  $rep_date=$_SESSION['ses_log_srch_vars']["reportdate"];
	}  
	 
    if(isset($_SESSION['ses_log_srch_vars']["reportdate"]) && $_SESSION['ses_log_srch_vars']["reportdate"]!="" )
	{
	  $rep_date1 = $_SESSION['ses_log_srch_vars']["reportdate1"];
	}
	
		
	if(isset($_SESSION["ses_reportdate"]) && $_SESSION["ses_reportdate"]!="" )
	{
	  $rep_date = stripslashes($_SESSION["ses_reportdate"]);
	}
	if(isset($_SESSION["ses_reportdate1"]) && $_SESSION["ses_reportdate1"]!="" )
	{
	  $rep_date1 = stripslashes($_SESSION["ses_reportdate1"]);
	}
	if(isset($_SESSION['ses_pay_status']) && $_SESSION['ses_pay_status']!="" )
	{
	  $payment_status= " "."and " . stripslashes($_SESSION['ses_pay_status']);
	}
	
	$qry = "select * from paymentlog, order_master where paymentlog.order_id = order_master.order_id and  paymentlog.date_entered >= '" . $rep_date . " 00:00:00' and paymentlog.date_entered <= '" . $rep_date1 . " 23:59:59'".$payment_status." order by paymentlog.date_entered desc";
	
	$_SESSION['ses_plog_srch_qry'] = $qry;
	
	header("location:payment_logs.php");
	exit();
}

?>
<?php
//echo $_REQUEST["submit"];
		
 $script_str = "<script language='javascript'>window.document.form1.repDay.value='" . $_SESSION['ses_log_srch_vars'][repDay] . "';
 window.document.form1.repMonth.value='" . $_SESSION['ses_log_srch_vars'][repMonth] . "';
 window.document.form1.repYear.value='" . $_SESSION['ses_log_srch_vars'][repYear] . "';</script>";
 
 $script_str .= "<script language='javascript'>window.document.form1.repDay1.value='" . $_SESSION['ses_log_srch_vars'][repDay1] . "';
 window.document.form1.repMonth1.value='" . $_SESSION['ses_log_srch_vars'][repMonth1] . "';
 window.document.form1.repYear1.value='" . $_SESSION['ses_log_srch_vars'][repYear1] . "';</script>";


if(strlen(trim($_SESSION['ses_plog_srch_qry'])) > 0)
	$qry = trim($_SESSION['ses_plog_srch_qry']);
else
	$qry = "select * from paymentlog order by plog_id desc";

//echo $qry . "<hr>";

?>
<html>
<head>
 <title>
  ::: View Payment Logs :::
 </title>
  <link href="style/styles.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" src="scripts/calendar2.js"></script>
<script>
var dtCh= "-";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
    var i;
    for (i = 0; i < s.length; i++){
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
    var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
    // February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
    for (var i = 1; i <= n; i++) {
        this[i] = 31
        if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
        if (i==2) {this[i] = 29}
   }
   return this
}

function isDate(dtStr){
    var m1;
    var m2;
    var m3;
    var daysInMonth = DaysArray(12)
    var pos1=dtStr.indexOf(dtCh)
    var pos2=dtStr.indexOf(dtCh,pos1+1)
    var strYear=dtStr.substring(0,pos1)
    var strMonth=dtStr.substring(pos1+1,pos2)
    var strDay=dtStr.substring(pos2+1)

    strYr=strYear
    if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
    if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
    for (var i = 1; i <= 3; i++) {
        if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
    }
    month=parseInt(strMonth)
    day=parseInt(strDay)
    year=parseInt(strYr)
    if (pos1==-1 || pos2==-1){
        return false
    }
    if (strMonth.length<1 || month<1 || month>12){
        return false
    }
    if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
        return false
    }
    if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
         return false
    }
    if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
        return false
    }
    return true
}
   

function validate() {
    var startdate=window.document.form1.repYear.value + "-" + window.document.form1.repMonth.value + "-" + window.document.form1.repDay.value;
    var enddate=window.document.form1.repYear1.value + "-" + window.document.form1.repMonth1.value + "-" + window.document.form1.repDay1.value;
     if (startdate=="")
	{
			alert("Select Date");
			return false;
    }
   // alert(isDate(startdate));
    if (isDate(startdate)==false){
        alert("Select valid from date");
        return false;
    }

    if (isDate(enddate)==false){
        alert("Select valid to date");
        return false;
    }
	
	if(Math.abs(enddate) < Math.abs(startdate))
	{
		alert("Select a future date for the to date");
		return false;
	}
	
	window.document.form1.reportdate.value=window.document.form1.repYear.value+"-"+window.document.form1.repMonth.value+"-"+window.document.form1.repDay.value;
	window.document.form1.reportdate1.value=window.document.form1.repYear1.value+"-"+window.document.form1.repMonth1.value+"-"+window.document.form1.repDay1.value;
    return true;
} 
</script>
<body>
 
<?php

 
$yrstr="";
for ($i=2000;$i<=2050;$i++) {

	$yrstr=$yrstr."<option value='$i'>$i</option>";

}
?>

<table cellpadding="4" cellspacing="2" width="80%" border=0 align="center" class="borderline">
<tr>
    <td colspan="2" align="center"><?php require_once("log_menu.php"); ?></td>
</tr>
<tr class="heading" height="30px">
  <td colspan=3 align="center">
    <font class="whitefont">View Logs</font>
  </td>
</tr>
<tr>
 <td colspan="3" align="center">
 <form name="form1" method="post" action="" onsubmit="return validate()">
        <table cellpadding=2 cellspacing=2 border=0 width=60%>
          <tr> 
            <td height=10px colspan="2"></td>
          </tr>
          <tr> 
            <td width="35%" align="right"> <font class='formlabel'>&nbsp;From 
              Date</font> </td>
            <td width="79%">&nbsp; <select name="repMonth">
                <option value=""></option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select> <select name="repDay">
                <option value=""></option>
                <option value="01">1</option>
                <option value="02">2</option>
                <option value="03">3</option>
                <option value="04">4</option>
                <option value="05">5</option>
                <option value="06">6</option>
                <option value="07">7</option>
                <option value="08">8</option>
                <option value="09">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              </select> <select name="repYear">
                <option value=""></option>
                <?php echo "$yrstr"; ?></select> <a href="javascript:selcal.popup();"><img src="images/cal.gif" width="16" height="16" border="0"></a> 
              <input type="hidden" name='reportdate'> </td>
          </tr>
          <tr> 
            <td align="right"><font class='formlabel'>&nbsp;To Date</font> </td>
            <td>&nbsp; 
              <select name="repMonth1">
                <option value=""></option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select> <select name="repDay1">
                <option value=""></option>
                <option value="01">1</option>
                <option value="02">2</option>
                <option value="03">3</option>
                <option value="04">4</option>
                <option value="05">5</option>
                <option value="06">6</option>
                <option value="07">7</option>
                <option value="08">8</option>
                <option value="09">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
              </select> <select name="repYear1">
                <option value=""></option>
                <?php echo "$yrstr"; ?></select> <a href="javascript:selcal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0"></a> 
              <input type="hidden" name='reportdate1'> </td>
          </tr>
		  <tr>
		  <td align="right"> <font class='formlabel'>Payment Status </font></td>
		  <td>&nbsp; <select name="payment_status">
			<option value="">Show All</option>
                <option value="order_master.order_status='0'"<?php echo (stripslashes($_SESSION['ses_pay_status']) == "order_master.order_status='0'")?"selected":""; ?>>Pending Orders</option>
				<option value="order_master.order_status='1'" <?php echo (stripslashes($_SESSION['ses_pay_status']) == "order_master.order_status='1'")?"selected":""; ?>>Paid Orders</option>
                
              </select> </td>
		  </tr>
          <tr> 
            <td colspan=2 align='center'><input type='button' name="Clear" value="Clear"onClick="window.document.form1.submit_action.value='Clear'; window.document.form1.submit();">&nbsp;&nbsp;
			<input type='submit' name="Search" value="Search" onClick="window.document.form1.submit_action.value='Show'"></td>
			<input type="hidden" name="submit_action">
          </tr>
        </table>
	</form>
	<script language="JavaScript">
    var selcal = new calendar2(document.forms['form1'].elements['repMonth'],document.forms['form1'].elements['repDay'],document.forms['form1'].elements['repYear']);
    selcal.year_scroll = true;
    selcal.time_comp = false;
    
	var selcal1 = new calendar2(document.forms['form1'].elements['repMonth1'],document.forms['form1'].elements['repDay1'],document.forms['form1'].elements['repYear1']);
    selcal1.year_scroll = true;
    selcal1.time_comp = false;
	
    </script>  
	<?php echo $script_str; ?>
<!-- <script>
	var myDate = new Date();
	var mmm = myDate.getMonth()+1;
	var ttmm = "00" + mmm;
	var tmmm = ttmm.substring(ttmm.length-2,ttmm.length);
	
	window.document.form1.repMonth.value=tmmm;
	window.document.form1.repMonth1.value=tmmm;
	 
	
	var mmm = myDate.getDate();
	var ttmm = "00" + mmm;
	var tmmm = ttmm.substring(ttmm.length-2,ttmm.length);
	
	window.document.form1.repDay.value=tmmm; 
	window.document.form1.repDay1.value=tmmm; 
</script> -->
 </td>
</tr>
</table>
<table width="95%" border="0" cellspacing="0" cellpadding="3" align="center" class="tableborder_new">
  <tr class="maincontentheading" height=25px> 
    <td width="10%">Log id</td>
    <td width="15%">Order id</td>
    <td width="15%">Payment Method</td>
    <td width="15%">View Payment Informations</td>
    <td width="15%">View Gateway Response</td>
    <td width="15%">Order Status</td>
    <td width="15%">Processed Date</td>
  </tr>
  <?php
  
 

$paging_cls = new paging($qry);

for($i=$paging_cls->start_index;$i<$paging_cls->end_index;$i++)
{
  if(mysql_data_seek($paging_cls->resultset,$i))
  {
  	$data = mysql_fetch_object($paging_cls->resultset);  
  }
  else
  {
  	unset($data);
  }
  
  if(isset($data))
  {
 if(file_exists("../includes/admin_alternate_color.php"))
  include("../includes/admin_alternate_color.php");
  else
  include("includes/admin_alternate_color.php");

?>
  <tr <?php echo $row_bg_color; ?>  height=30px> 
    <td> 
      <?php
	
	 echo stripslashes($data->plog_id); 
	 
	 ?>
    </td>
    <td><a href="log_invoice.php?order_id=<?php echo stripslashes($data->order_id); ?>" target="_blank"> 
      <?php
	
	 echo stripslashes($data->order_id); 
	 
	 ?>
      </a></td>
    <td> 
      <?php
	 
	 echo stripslashes($data->pay_method);

	 ?>
    </td>
    <td><a href="view_payment_log.php?plid=<?php echo $data->plog_id; ?>&purp=req" target="_blank">View</a></td>
    <td><a href="view_payment_log.php?plid=<?php echo $data->plog_id; ?>&purp=resp" target="_blank">View</a> 
    </td>
    <td>
	<?php
	if($data->order_status == 1)
	echo "Paid Order";
	else
	echo "Pending Order";
	
	?>
	</td>
    <td> 
      <?php
	 echo convert_date($data->date_entered);
	 	 
	 ?>
    </td>
  </tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="7" algin='center'> <font class='redfont'>No payment logs found.</font></td>
  </tr>
  <?php

}

?>
</table>
<br>
<table cellpadding="0" cellspacing=0 border="0" width="100%"> 
 
  <tr>
	  <td height=5px>
	  </td>
  </tr>
  <tr> 
    <td align="center" width="33%"> 
      <?php
	
	
$paging_cls->print_prev();


	
	
	?>
    </td>
    <td colspan="3" align="center" width="34%"> 
      <?php
	
$paging_cls->print_numbered_links();

$paging_cls->print_pages_of();

	
	?>
    </td>
    <td align="center" width="33%"> 
      <?php
	
	$paging_cls->print_next();

	
	?>
    </td>
  </tr>
</table>


</body>
</html>


 