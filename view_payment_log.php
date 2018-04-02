<?php

require_once("includes/code_header.php");


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
	
	window.document.form1.reportdate.value=window.document.form1.repYear.value+window.document.form1.repMonth.value+window.document.form1.repDay.value;
	window.document.form1.reportdate1.value=window.document.form1.repYear1.value+window.document.form1.repMonth1.value+window.document.form1.repDay1.value;
    return true;
} 
</script>
<body>
<table border="0" cellpadding="3" cellspacing="1" width="90%"><tr><td>
<?php

if($_REQUEST['purp'] == "req")
	$fld_name = "sent_values";
else
	$fld_name = "received_values";

echo $GLOBALS['db_con_obj']->fetch_field("paymentlog",$fld_name,"plog_id = '" . $_REQUEST['plid'] . "'");

?>
</td></tr></table>
</body>
</html>


 