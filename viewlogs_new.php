<?php

require_once("includes/code_header.php");

?><html>
<head>
 <title>
  ::: View Logs :::
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
	
	window.document.form1.reportdate.value=window.document.form1.repYear.value+window.document.form1.repMonth.value+window.document.form1.repDay.value;
	window.document.form1.reportdate1.value=window.document.form1.repYear1.value+window.document.form1.repMonth1.value+window.document.form1.repDay1.value;
    return true;
} 
</script>
<body>
 
<?php

 
$yrstr="";
for ($i=2000;$i<=2050;$i++) {
    if ($yrstr=="") {
	if ($i == date("Y"))
	    $yrstr="<option value='$i' selected>$i</option>";
	else
	    $yrstr="<option value='$i'>$i</option>";
    }
    else {
	if ($i == date("Y"))
	    $yrstr=$yrstr."<option value='$i' selected>$i</option>";
	else
	    $yrstr=$yrstr."<option value='$i'>$i</option>";
    }
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
            <td colspan=2 align='center'><input type='button' name="clear" value='Clear' onClick="window.document.form1.submit_action.value='Clear';window.document.form1.submit()"> &nbsp;&nbsp;<input type='submit' name="search" value='Search' onClick="window.document.form1.submit_action.value='Show'">
			<input type="hidden" name="submit_action"></td>
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
	
<script>
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
</script>
 </td>
</tr>
<?php
//echo $_REQUEST["submit"];
// if(isset($_REQUEST["submit_action"]) && $_REQUEST["submit_action"]!="" && strtolower($_REQUEST["submit_action"])=="Show")
if(isset($_REQUEST["submit_action"]) && $_REQUEST["submit_action"]!="" && $_REQUEST["submit_action"]=="Show")
 {
 
    if(isset($_REQUEST["reportdate"]) && $_REQUEST["reportdate"]!="" )
	{
	  $rep_date=$_REQUEST["reportdate"];
	}  
	 echo "<script>window.document.form1.repDay.value='$_REQUEST[repDay]';
	 window.document.form1.repMonth.value='$_REQUEST[repMonth]';
	 window.document.form1.repYear.value='$_REQUEST[repYear]';</script>";
	 
    if(isset($_REQUEST["reportdate"]) && $_REQUEST["reportdate"]!="" )
	{
	  $rep_date1=$_REQUEST["reportdate1"];
	}  
	 echo "<script>window.document.form1.repDay1.value='$_REQUEST[repDay1]';
	 window.document.form1.repMonth1.value='$_REQUEST[repMonth1]';
	 window.document.form1.repYear1.value='$_REQUEST[repYear1]';</script>";
 }

	$rep_date=date(Ymd); 
	$rep_date1=date(Ymd); 
 
readlogdir("log",$rep_date,"find","Error Logs On Frontend", $rep_date1);
echo "<hr size='0'>";
readlogdir("admin/log",$rep_date,"find","Error Logs On Admin Section", $rep_date1);
	 
 
 function  readlogdir($dirname="log",$repdate="",$status="all",$log_lable="",$repdate1="")
 { 
  // Open a known directory, and proceed to read its contents

	$dir = $dirname;
	$rep_date=$repdate;
	$rep_date1=$repdate1;
	if (is_dir($dir)) { ?>
	   <table cellpadding="4" cellspacing="2" width="80%" border=0 align="center" class="borderline">
		<tr>
		  <td colspan=3 align="center">
			<font class="formlabel"><h4><?php echo $log_lable ;?></h4></font>
		  </td>
		</tr>
<?php	
		if ($dh = opendir($dir)) {
		   $i=0;
			echo "<tr>";
			while (($file = readdir($dh)) !== false)
			{ 
				   $filter=0;
				   if($status!="all")
				   {
					   
					    //$pos1 = strpos($file,$rep_date);
						if($file != "." && $file != "..")
						{
						
						$fl_name = $dirname . "/" . $file;
						$fil_dt = date ("Ymd", filemtime($fl_name));
							   
					   if($fil_dt >= $rep_date && $fil_dt <= $rep_date1)
					   {
						 $filter=1;
					   }
					   }
				   }
				   else
				   {
				     $filter=1;
				   }
				  if($file!="." && $file!=".." && $filter==1)
				  {
					if($i==3)
					{
					  $i=0;
					  echo "</tr><tr>";
					}	
					 $con_file=$dirname."/".$file;		
					//echo "<td><a class='log_link' href='openlogfile.php?filename=$con_file' target='_blank'>$file</a></td>";
					echo "<td><a class='log_link' href='$con_file' target='_blank'>$file</a></td>";
					$i++;
					
				  }
			 }
			echo "</tr>";
			closedir($dh);
			if($i==0)
			{
			  echo "<td><br><center><font class='redfont'>No log files available in $dir directory...</font></center></td>";
			}
		} 
		else
		{
		  echo "<td><br><center><font class='redfont'>Could not open $dir directory...</font></center></td>";
		}
		 ?>
       </table>
<?php  }
       else
	   { 
	     echo "<br><center><font class='redfont'>$dir is not a directory...</font></center>";
	   }
 }
 
?>
</table>
</body>
</html>


 