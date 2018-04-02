<?php
$hid_action = "search";
$hid_action1 = "clear";
if(!empty($_SESSION['ses_mrkpaid']))
{
unset($_SESSION['ses_mrkpaid']);
frame_notices("Selected orders has been marked as Paid !!", "greenfont");
}
 if(!empty($_SESSION['ses_mrkship']))
{
unset($_SESSION['ses_mrkship']);
frame_notices("Selected orders has been marked as Shipped !!", "greenfont");
}

?>
<script language="JavaScript" src="../components/calendar/calendar2.js"></script>
<script language="JavaScript">
	
	/*function check_order_selection(obj,ord_st)
	{
		if(ord_st == 1 && obj.checked)
			obj.checked = false;
	}*/
	
	function check_order_selection(obj,ord_st)
	{
		if(ord_st == 1 && obj.checked)
		{
			//obj.checked = false;
		}
		var hid_obj = null;
		var pending_ord = 0;
		var paid_ord = 0;
		var ship_ord = 0;
		var c=0;var cc=0;
		for(i=0; i < window.document.order_search_frm.elements.length; i++)
		{
			//alert(window.document.order_search_frm.elements[i].name);
			if(window.document.order_search_frm.elements[i].name == "ordnum[]")
			{
				hid_obj = window.document.getElementById("ord_st" + window.document.order_search_frm.elements[i].value);
				
				if(window.document.order_search_frm.elements[i].checked && hid_obj.value == 1)
				{
					paid_ord++;
				 }	
				else if(window.document.order_search_frm.elements[i].checked && hid_obj.value == 0)
				{
					pending_ord++;
				 }	
				else if(window.document.order_search_frm.elements[i].checked && hid_obj.value == 2)
				{
					ship_ord++;	
				 }	
				
			}
		}
		/*alert("Pending Orders :" + pending_ord);
		alert("Paid Orders :" + paid_ord);
		alert("Shipping Orders :" + ship_ord);*/
		
		if(window.document.order_search_frm.order_status.value == "order_master.order_status='0'")
		{
		var paid_but_obj = window.document.getElementById('paid_button');
		var pend_ord_but_obj = window.document.getElementById('pending_orders');
		}
		else if(window.document.order_search_frm.order_status.value == "order_master.order_status='1'")
		{
		var paid_but_obj1 = window.document.getElementById('paid_button1');
		var paid_ord_but_obj = window.document.getElementById('paid_orders');
		}
		else
		{
		var paid_but_obj1 = window.document.getElementById('paid_button1');
		var paid_ord_but_obj = window.document.getElementById('paid_orders');
		var paid_but_obj = window.document.getElementById('paid_button');
		var pend_ord_but_obj = window.document.getElementById('pending_orders');
		}
		var del_ord_but_obj = window.document.getElementById('del_all_order_button');
		
		if((pending_ord > 0 && paid_ord > 0	&& ship_ord > 0) || (pending_ord > 0 && paid_ord > 0) || (pending_ord > 0 && ship_ord > 0) || (paid_ord > 0	&& ship_ord > 0))
		{
		  paid_but_obj.className = 'hidelayer';
		  pend_ord_but_obj.className = 'showlayer';
		  paid_but_obj1.className = 'hidelayer';
		  paid_ord_but_obj.className = 'showlayer';
		}
		else
		{
		if(pending_ord > 0)
		{
		  if(window.document.order_search_frm.order_status.value == "order_master.order_status='0'")
		  {	
		  paid_but_obj.className = 'showlayer';
		  }
		  else if(window.document.order_search_frm.order_status.value == "order_master.order_status='1'")
		  {
		  paid_but_obj1.className = 'hidelayer'; 
		  paid_ord_but_obj.className = 'hidelayer';
		  }
		  else
			{
			paid_but_obj.className = 'showlayer';
			paid_but_obj1.className = 'hidelayer'; 
		  	paid_ord_but_obj.className = 'showlayer';
			}	
		 //del_ord_but_obj.className = 'hidelayer';
		}
		else if(paid_ord > 0)
		{
			if(window.document.order_search_frm.order_status.value == "order_master.order_status='0'")
		  	{	
			paid_but_obj.className = 'hidelayer';
			pend_ord_but_obj.className = 'hidelayer';
			}
			 else if(window.document.order_search_frm.order_status.value == "order_master.order_status='1'")
		  	{
			paid_but_obj1.className = 'showlayer';
			}
			else
			{
			paid_but_obj.className = 'hidelayer';
			pend_ord_but_obj.className = 'showlayer';
			paid_but_obj1.className = 'showlayer';
			}	
			
			//del_ord_but_obj.className = 'showlayer';
		}
		else if(ship_ord > 0)
		{
		  if(window.document.order_search_frm.order_status.value == "order_master.order_status='0'")
		  {		
		  paid_but_obj.className = 'hidelayer';
		  pend_ord_but_obj.className = 'hidelayer';
		  }
		  else if(window.document.order_search_frm.order_status.value == "order_master.order_status='1'")
		  {
		  paid_but_obj1.className = 'hidelayer';
		  paid_ord_but_obj.className = 'hidelayer';
		  }
		  else
			{
			 paid_but_obj.className = 'hidelayer';
		  	 pend_ord_but_obj.className = 'showlayer';
			 paid_but_obj1.className = 'hidelayer';
		  	 paid_ord_but_obj.className = 'showlayer';
			}	  
		  //del_ord_but_obj.className = 'showlayer';
		}
		else
		{
			if(window.document.order_search_frm.order_status.value == "order_master.order_status='0'")
		  	{	
			paid_but_obj.className = 'showlayer';
			pend_ord_but_obj.className = 'showlayer';
			}
			else if(window.document.order_search_frm.order_status.value == "order_master.order_status='1'")
		    {
			paid_but_obj1.className = 'showlayer';
			paid_ord_but_obj.className = 'showlayer';
			}
			else
			{
			paid_but_obj.className = 'showlayer';
			pend_ord_but_obj.className = 'showlayer';
			paid_but_obj1.className = 'showlayer';
			paid_ord_but_obj.className = 'showlayer';
			}
			//del_ord_but_obj.className = 'showlayer';
			
		    
		}
		}
		
	}
	
	
	function setbool(vv)
    {
	    window.document.order_search_frm.boolcheck.value=vv;
	}

    function showvalue1(gt)
    {
		var dgt=2;
	    var isNetscape = false;
	    if (navigator.appName == "Netscape")
	    {
	        isNetscape = true;
	        document.captureEvents(Event.KEYPRESS);
	    }
	    document.onkeypress=CheckKeyPress;

	    function CheckKeyPress(evt)
	    {
	        var myKeycode = isNetscape ? evt.which : window.event.keyCode;

	        if ((isNetscape) && (myKeycode == 0)) return true;

	        if (myKeycode > 47 && myKeycode < 58 || myKeycode==8)
	        {

	            if (window.document.order_search_frm.boolcheck.value=="0")
	            {
	                return true;
	            }
	            else
	            {
	                if ((dgt == 0) && (myKeycode == 46))
	                {
	                	return false;
	                }

	                if (gt.indexOf(".") > 0)
	                {
	                    if (myKeycode == 46)
	                    	return false;

	                    if (myKeycode == 8)
	                    	return true;

	                    if ((gt.length -   gt.indexOf(".")) > dgt)
	                    {
	                        return false;
	                    }
	                }
	                return true;
	            }
	        }
	        else
	        {
	            if(window.document.order_search_frm.boolcheck.value=="1")
	            {
	                return false;
	            }
	            else
	            {
	                return true;
	            }
	        }
	    }
}


var dtCh= "-";
var minYear=1900;
var maxYear=2100;
var err = 0;
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
    var startdate=window.document.order_search_frm.repYear.value + "-" + window.document.order_search_frm.repMonth.value + "-" + window.document.order_search_frm.repDay.value;
    var enddate=window.document.order_search_frm.repYear1.value + "-" + window.document.order_search_frm.repMonth1.value + "-" + window.document.order_search_frm.repDay1.value;
	
    var tstartdate=window.document.order_search_frm.repYear.value + window.document.order_search_frm.repMonth.value + window.document.order_search_frm.repDay.value;
    var tenddate=window.document.order_search_frm.repYear1.value + window.document.order_search_frm.repMonth1.value + window.document.order_search_frm.repDay1.value;
	
	if(enddate.length > 2 || startdate.length > 2)
	{
     if (startdate=="")
	{
			alert("Select From Date");
			return false;
    }
	//alert(startdate);
   // alert(isDate(startdate));
    if (isDate(startdate)==false){
        alert("Select Valid From Date and From date should not be empty !!");
        return false;
    }
     if (enddate=="")
	{
			alert("Select To Date");
			return false;
    }
   // alert(isDate(startdate));
    if (isDate(enddate)==false){
        alert("Select Valid To Date and To date should not be empty !!");
        return false;
    }
	
	if(Math.abs(tstartdate) > Math.abs(tenddate)){
        alert("To date should be greater than from date !!");
        return false;
    }
	
	//window.document.order_search_frm.reportdate.value=window.document.order_search_frm.repMonth.value+window.document.order_search_frm.repDay.value+window.document.order_search_frm.repYear.value;
	//window.document.order_search_frm.reportdate.value=window.document.order_search_frm.repYear.value+"-"+window.document.order_search_frm.repMonth.value+"-"+window.document.order_search_frm.repDay.value;
	window.document.order_search_frm.reportdate.value=startdate;
	window.document.order_search_frm.reportdate1.value=enddate;
	}
	else
	{
		window.document.order_search_frm.reportdate.value='';
		window.document.order_search_frm.reportdate1.value='';
	}
    return true;
} 

function check_orderform(frmobj)
{
	var dc = frmobj;
    error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";
	var bool = true;

	if(!validate())
		bool = false;
	
	if(bool && (dc.start_order_num.value.length > 0 || dc.end_order_num.value.length > 0))
	{
		if(dc.start_order_num.value.length <= 0 || dc.end_order_num.value.length <= 0)
		{
			alert("To search with order number you need to enter both from and to order numbers.\nTo search for a particular order enter same number in both the fields.");
			bool = false;
		}
		else
		{
			if(parseInt(dc.start_order_num.value) > parseInt(dc.end_order_num.value))
			{
				alert("To order number should be greater than the from order number.");
				bool = false;
			}
		}
	}
	
	return bool;

}

</script>
<?php



$calendar="../components/calendar/cal.gif";
$yrstr="";
for ($i=2000;$i<=2050;$i++) 
{
    //$sel_txt = ($i == date("Y"))?"selected":"";
	$yrstr = $yrstr . "<option value='$i'>$i</option>";
}

?>
<div align="center" class="whitebox mtop15">
<form name="order_search_frm" method="post" action="" onSubmit="return check_orderform(window.document.order_search_frm);">

  <table  align="center" cellpadding="5" cellspacing="0" width="100%" class="listing">
    <tr class="maincontentheading"> 
      <th align="center"><font class="buyerfont">Search Orders</font></th>
    </tr>
    <tr> 
      <td><table align="center" border="0" cellspacing="3" width="50%" cellpadding="3">
          <tr valign="top"> 
            <td  align="right" style="border-bottom:0px;"><font class="whitefont">Status:</font></td>
            <td style="border-bottom:0px;"> <select name="order_status" class="mediumtxtbox">
			<option value="">Show All Orders</option>
                <option value="order_master.order_status='0'" <?php echo (stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='0'")?"selected":""; ?>>Payment Pending</option>
				<option value="order_master.order_status='1'" <?php echo (stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='1'")?"selected":""; ?>>Paid,Shipment Pending</option>
				<option value="order_master.order_status='2'" <?php echo (stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='2'")?"selected":""; ?>>Shipped</option>
                
            </select></td>
          </tr>
          <tr valign="top"> 
            <td align="right"><font class="whitefont">Order&nbsp;Date:</font></td>
            <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr valign="top"> 
                  <td width="10" style="border-bottom:0px;"><font class="whitefont">from&nbsp;</font></td>
                  <td style="border-bottom:0px;"> 
				 
				  
                   <select name="repMonth">
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
                      <?php echo "$yrstr"; ?></select> <a href="javascript:selcal.popup();"><img src=<?php echo $calendar; ?> width="16" height="16" border="0" align="absmiddle"></a> 
                    &nbsp; <input type="hidden" name='reportdate' > </td>
                </tr>
                <tr valign="top"> 
                  <td style="border-bottom:0px;"><font class="whitefont">to&nbsp;</font></td>
                  <td style="border-bottom:0px;"> 
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
                      <?php echo "$yrstr"; ?></select> <a href="javascript:selcal1.popup();"><img src= <?php echo $calendar; ?> width="16" height="16" border="0" align="absmiddle"></a> 
                    <input type="hidden" name='reportdate1'> </td>
                </tr>
              </table>
              <script language="JavaScript">
						var selcal = new calendar2(window.document.forms['order_search_frm'].elements['repMonth'],window.document.forms['order_search_frm'].elements['repDay'],window.document.forms['order_search_frm'].elements['repYear']);
						selcal.year_scroll = true;
						selcal.time_comp = false;
						
						var selcal1 = new calendar2(window.document.forms['order_search_frm'].elements['repMonth1'],window.document.forms['order_search_frm'].elements['repDay1'],window.document.forms['order_search_frm'].elements['repYear1']);
						selcal1.year_scroll = true;
						selcal1.time_comp = false;

						</script> <script>
						/*
						var myDate = new Date();
						var mmm = myDate.getMonth()+1;
						var ttmm = "00" + mmm;
						var tmmm = ttmm.substring(ttmm.length-2,ttmm.length);
						
						window.document.order_search_frm.repMonth.value=tmmm;
						window.document.order_search_frm.repMonth1.value=tmmm;
						
						
						var mmm = myDate.getDate();
						var ttmm = "00" + mmm;
						var tmmm = ttmm.substring(ttmm.length-2,ttmm.length);
						
						window.document.order_search_frm.repDay.value=tmmm; 
						window.document.order_search_frm.repDay1.value=tmmm; 
						*/
						window.document.order_search_frm.repMonth.value ='<?php echo $_SESSION['ses_ord_srch_vars']['repMonth']; ?>';
						window.document.order_search_frm.repMonth1.value ='<?php echo $_SESSION['ses_ord_srch_vars']['repMonth1']; ?>';
						window.document.order_search_frm.repDay.value ='<?php echo $_SESSION['ses_ord_srch_vars']['repDay']; ?>';; 
						window.document.order_search_frm.repDay1.value ='<?php echo $_SESSION['ses_ord_srch_vars']['repDay1']; ?>';
						window.document.order_search_frm.repYear.value ='<?php echo $_SESSION['ses_ord_srch_vars']['repYear']; ?>';; 
						window.document.order_search_frm.repYear1.value ='<?php echo $_SESSION['ses_ord_srch_vars']['repYear1']; ?>';
						</script> </td>
          </tr>
          <tr valign="top"> 
            <td align="right"><font class="whitefont">Order&nbsp;Number:</font></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr valign="top"> 
                  <td width="10" style="border-bottom:0px;"><font class="whitefont">from&nbsp;</font></td>
                  <td style="border-bottom:0px;"> 
                    <input type="text" name="start_order_num" value="<?php echo stripslashes($_SESSION['ses_ord_srch_vars']['start_order_num']); ?>" onfocus="setbool('1')" onblur="setbool('0')" onkeypress="showvalue1(this.value)" style="height:16px;" class="mediumtxtbox"></td>
                </tr>
                <tr valign="bottom"> 
                  <td height="20" style="border-bottom:0px;"><font class="whitefont">to&nbsp;</font></td>
                  <td style="border-bottom:0px;"> 
                    <input type="text" name="end_order_num" value="<?php echo stripslashes($_SESSION['ses_ord_srch_vars']['end_order_num']); ?>" onfocus="setbool('1')" onblur="setbool('0')" onkeypress="showvalue1(this.value)" style="height:16px;" class="mediumtxtbox"><input type="hidden" value="0" name="boolcheck" class="mediumtxtbox"></td>
                </tr>
              </table></td>
          </tr>
          <tr valign="top"> 
            <td align="right"><font class="whitefont">Filter:</font></td>
            <td><select name="filter_column" class="mediumtxtbox">
                <option value="cust_firstname" <?php echo ($_SESSION['ses_ord_srch_vars']['filter_column'] == "customer_master.cust_firstname")?"selected":""; ?>>Customer First Name</option>
                <option value="customer_master.cust_lastname" <?php echo ($_SESSION['ses_ord_srch_vars']['filter_column'] == "customer_master.cust_lastname")?"selected":""; ?>>Customer Last Name</option>
              </select> <select name="filter_srch_typ" class="mediumtxtbox">
                <option value="= '#val#'" <?php echo (stripslashes($_SESSION['ses_ord_srch_vars']['filter_srch_typ']) == "= '#val#'")?"selected":""; ?>>equals</option>
                <option value="like '%#val#%'" <?php echo (stripslashes($_SESSION['ses_ord_srch_vars']['filter_srch_typ']) == "like '%#val#%'")?"selected":""; ?>>contains</option>
              </select> <input type="text" name="filter_srch_val" value="<?php echo stripslashes($_SESSION['ses_ord_srch_vars']['filter_srch_val']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top"> 
            <td align="right" style="border-bottom:0px;"><font class="whitefont">Sort&nbsp;By:</font></td>
            <td style="border-bottom:0px;"><select name="sort_column" class="mediumtxtbox">
                <option value='<?php echo "order_master.date_entered asc"; ?>' <?php echo ($_SESSION['ses_ord_srch_vars']['sort_column'] == "order_master.date_entered asc")?"selected":""; ?>>Order Date Ascending</option>
				<option value='<?php echo "order_master.date_entered desc"; ?>' <?php echo ($_SESSION['ses_ord_srch_vars']['sort_column'] == "order_master.date_entered desc")?"selected":""; ?>>Order Date Descending</option>
                <option value='<?php echo "customer_master.cust_firstname asc"; ?>' <?php echo ($_SESSION['ses_ord_srch_vars']['sort_column'] == "customer_master.cust_firstname asc")?"selected":""; ?>>First Name Ascending</option>
				<option value='<?php echo "customer_master.cust_firstname desc"; ?>' <?php echo ($_SESSION['ses_ord_srch_vars']['sort_column'] == "customer_master.cust_firstname desc")?"selected":""; ?>> First Name Descending</option>
                <option value='<?php echo "customer_master.cust_lastname asc";?>' <?php echo ($_SESSION['ses_ord_srch_vars']['sort_column'] == "customer_master.cust_lastname asc")?"selected":""; ?>>Last Name Ascending</option>
				<option value='<?php echo "customer_master.cust_lastname desc";?>' <?php echo($_SESSION['ses_ord_srch_vars']['sort_column'] == "customer_master.cust_lastname desc")?"selected":""; ?>>Last Name Descending</option>
              </select> 
			 </td>
          </tr>
          <tr valign="top"> 
		  <td style="border-bottom:0px;"><a href="orders.php?submit_action=clear"> <img border="0" src="../images/clear.jpg"  name="clear" value="Clear"></a>
		  <input type="hidden" name="submit_action1"></td>
		 
            <td align="right" style="border-bottom:0px;"><input type="image" src="../images/search12.gif"  name="search" value="Search" onclick="form.submit_action.value='search'" /></td>
            <td width="61" align="right" style="border-bottom:0px;"><input type="hidden" name="submit_action" >			</td>		 
          </tr>
        </table></td>
    </tr>
    
	   
  </table>
   </div>
 <br />
  <?php
  $preview_url = 0;
  $export_url="../forms/admin/order_list_export_frm.php";
  ?>
  <table width="90%" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr > 
    <td align="right"><div align="right" class="pagination"><a class='blue_link'  href="#" onclick="popup_window('basedesign_nh.php?submit_action=preview&id=1&url=<?php echo $export_url; ?>',400,700,'yes','yes')";>Export Data</a></div></td></tr></table>
    
    <div align="center" class="whitebox mtop15">
 
 
  <?php
  //echo $_SESSION['ses_ord_srch_qry'];
  
  if($_REQUEST['page'] =="home")
	{
		/*$qry1 = "select concat(buyer_master.buyer_firstname,'&nbsp;',buyer_master.buyer_lastname) as buyer_name,  order_master.order_id, order_master.date_entered, order_master.order_status, buyer_master.buyer_firstname, buyer_master.buyer_lastname,order_master.user_id,concat(order_master.bill_fname,' ',order_master.bill_lname) as bill_name,concat(order_master.ship_fname,'&nbsp;',order_master.ship_lname) as ship_name from order_master, buyer_master where 1 = 1 and (order_master.user_id = buyer_master.buyer_id or order_master.user_id = '-1')"; */
		
		$qry1 = "select concat(customer_master.cust_firstname,'&nbsp;',customer_master.cust_lastname) as cust_name, order_master.order_id, order_master.date_entered, order_master.order_status, order_master.payable_amount, customer_master.cust_firstname, customer_master.cust_lastname from order_master, customer_master where 1 = 1 and order_master.user_id = customer_master.cust_id order by order_master.date_entered desc";
				 
		/*$qry_con = $qry1." and order_master.order_status = '".$_REQUEST['order_status']."' group by order_master.order_id desc";  
		$qry1 = $qry_con; */
		if(!empty($_SESSION['ses_ord_srch_qry']))
	 
	 	 $qry1 = $_SESSION['ses_ord_srch_qry'];
		
  }
  else if(!empty($_SESSION['ses_ord_srch_qry']))
	 
	 	$qry1 = $_SESSION['ses_ord_srch_qry'];
			
	else 
	  
	  	 /*$qry1 = "select concat(buyer_master.buyer_firstname,'&nbsp;',buyer_master.buyer_lastname) as buyer_name,  order_master.order_id, order_master.date_entered, order_master.order_status, buyer_master.buyer_firstname, buyer_master.buyer_lastname,order_master.user_id,concat(order_master.bill_fname,' ',order_master.bill_lname) as bill_name,concat(order_master.ship_fname,'&nbsp;',order_master.ship_lname) as ship_name from order_master, buyer_master where 1 = 1 and (order_master.user_id = buyer_master.buyer_id or order_master.user_id = '-1') group by order_master.order_id order by order_master.date_entered desc";*/
		 
		 $qry1 = "select concat(customer_master.cust_firstname,'&nbsp;',customer_master.cust_lastname) as cust_name, order_master.order_id, order_master.date_entered, order_master.order_status, order_master.payable_amount, customer_master.cust_firstname, customer_master.cust_lastname from order_master, customer_master where 1 = 1 and order_master.user_id = customer_master.cust_id order by order_master.date_entered desc";
		
		//echo $qry1;
   	
	
  $paging_cls = new paging($qry1);

  if($paging_cls->num_of_rows > 0)
  {
  ?><table align="center">
  <tr align="center" > <td class=""><font class='starfont'><strong><?php echo $paging_cls->num_of_rows." orders match search criteria"  ?></strong></font> </td></tr></table>
  <?php
  }
  ?>
  <table width="90%" border="0" cellspacing="0" cellpadding="3" align="center" class="listing">
 <tbody>
  <tr class="maincontentheading" height=25px>  
      <th width="7%"><font class='buyerfont'>Select</font></th>
      <th width="7%"><font class='buyerfont'>Order&nbsp;#</font></th>
      <th width="22%" align="center"><font class='buyerfont'>Date</font></th>
      <th width="17%"><font class='buyerfont'>Customer Name</font></th>
      <th width="20%" align="center"><font class='buyerfont'>Amount($)</font></th>
      <th width="13%"><font class='buyerfont'>Status</font></th>
      <th width="14%"><font class='buyerfont'>Action</font></th>
    </tr>
    <?php
   
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
      <td><input type="checkbox" name="ordnum[]" value="<?php echo $data->order_id; ?>" onClick="check_order_selection(this,'<?php echo $data->order_status; ?>');"> 
        <input type="hidden" id="ord_st<?php echo $data->order_id; ?>" value="<?php echo $data->order_status; ?>">      </td>
      <td><a  class='blue_link' href="#" onclick="popup_window('invoice.php?order_id=<?php echo $data->order_id; ?>',700,750,'yes','yes');">
        <?php
	  
	  echo $data->order_id;
	 		 ?>
      </a></td>
      <td> 
        <?php
	  echo $data->date_entered;
	  	  	?>      </td>
      <td> 
       <?php
	  echo  $ord_d_obj->fetch_field("order_master","concat(bill_fname,'&nbsp;',bill_lname) as bill_name", "order_id = '" . $data->order_id . "'");
	  		?>       </td>
	  <td align="center"> 
        <?php
	  echo $data->payable_amount;
	  		?>      </td>
      <td nowrap> 
        <?php
	  if($data->order_status ==0)
	  	echo "Payment pending";
	  else if($data->order_status==1)	 
		echo "Paid, Shipment Pending";
	  else
	  	echo "Shipped";
	  ?>      </td>
      <td nowrap><a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&<?php echo $ser_obj->primary_fld;?>=<?php echo $data->order_id; ?>')" alt="Delete"></a>&nbsp;&nbsp;<a href="orders.php?submit_action=update_status&order_id=<?php echo stripslashes($data->order_id); ?>"><img src="../images/icon_config.gif" border=0 title="Insert Shipping tracking code" alt="Insert Shipping tracking code"></a></td>
    </tr>
    <?php
		  }
		  }
		  ?>
    <?php	 
		  
if($paging_cls->num_of_rows <= 0)

{

?>
    <tr> 
      <td colspan="7" algin='center'> <font class='redfont'>No records found.</font></td>
    </tr>
    <?php
}

?>
  </table>
  
  <?php 
if($paging_cls->num_of_rows <> 0)
{
//echo "Request variable:".stripslashes($_REQUEST['order_status']);
?>
  <?php 
  if(!empty($_SESSION['ses_ord_srch_qry']))
  {
     if(empty($_SESSION['ses_ord_srch_vars']['order_status']))
	  {
  ?>
  		
  <table width="100%">
    <tr> 
	  <td align="center"><table cellpadding="0" cellspacing="0" border="0" ><tr><td><a href="javascript:check_all1();" id="pending_orders"><img align="absmiddle" src="../images/buttons/checkallpendingorders.jpg" border="0" hspace="3"></a></td><td><a href="javascript:check_all2();" id="paid_orders"><img align="absmiddle" src="../images/buttons/checkallpaidorders.jpg" border="0" hspace="3"></a></td><td><a href="javascript:check_all_delete();"><img align="absmiddle" src="../images/buttons/checkallfordelete.jpg" border="0" hspace="3"></a></td><td><a href="javascript:uncheck_all();"><img align="absmiddle" src="../images/buttons/uncheckall.jpg" border="0" hspace="3"></a></td></tr></table></td>
     
    <tr>
       <td align="center" width="100%">
	   <table width="60%" border="0" cellpadding="0" cellspacing="0">
          <tr><td width="33%" align="center"><a href="#" id="paid_button"><img align="absmiddle" src="../images/buttons/markaspaid.jpg" onclick="javascript:markaspaid();" border="0" hspace="3" /></a></td>
          <td width="33%" align="center"><a href="#" id="paid_button1"><img align="absmiddle" src="../images/buttons/markasship.jpg" onClick="javascript:markasshipped();" border="0"></a></td>
          <td width="33%" align="center"><a href="#" id="del_all_order_button"><img align="absmiddle" src="../images/buttons/deleteselectedorders.jpg" onclick="javascript:delete_selected_orders();" border="0" hspace="3" /></a></td>
          </tr></table></td>
	   
	 </tr> 
 		 
    </tr>
  </table>
      <?php } else {?>
    
  <table width="100%">
    <tr> 
	   <td align="center"><table cellpadding="0" cellspacing="3" border="0" ><tr><td><?php if(stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='0'" && !empty($_SESSION['ses_ord_srch_vars']['order_status'])) {?><a href="javascript:check_all_1();" id="pending_orders"><img align="absmiddle" src="../images/buttons/checkallpendingorders.jpg" border="0" hspace="3"></a><?php } ?></td><td><?php if(stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='1'" && !empty($_SESSION['ses_ord_srch_vars']['order_status'])) { ?><a href="javascript:check_all_2();" id="paid_orders"><img align="absmiddle" src="../images/buttons/checkallpaidorders.jpg" border="0" hspace="3"></a><?php } ?></td><td><a href="javascript:check_all_delete_1();"><img align="absmiddle" src="../images/buttons/checkallfordelete.jpg" border="0" hspace="3"></a></td><td><a href="javascript:uncheck_all();"><img align="absmiddle" src="../images/buttons/uncheckall.jpg" border="0" hspace="3"></a></td><?php if(stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='2'" && !empty($_SESSION['ses_ord_srch_vars']['order_status'])){?><td><a href="#" id="del_all_order_button"><img align="absmiddle" src="../images/buttons/deleteselectedorders.jpg" onclick="javascript:delete_selected_orders();" border="0" hspace="3" /></a></td><?php } ?></tr></table></td>
     
    <tr>
	   <td align="center"> 
	   <table cellspacing="3" cellpadding="0" border="0" ><tr>
       <td><?php if(stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='0'" && !empty($_SESSION['ses_ord_srch_vars']['order_status'])){?><a href="#" id="paid_button"><img align="absmiddle" src="../images/buttons/markaspaid.jpg" onclick="javascript:markaspaid();" border="0" hspace="3" /></a><?php } ?></td>
	   <td><?php if(stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='1'" && !empty($_SESSION['ses_ord_srch_vars']['order_status'])){?><a href="#" id="paid_button1"><img align="absmiddle" src="../images/buttons/markasship.jpg" onClick="javascript:markasshipped();" border="0"></a><?php }?></td>
	    <?php if(stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) <> "order_master.order_status='2'" && !empty($_SESSION['ses_ord_srch_vars']['order_status'])){?><td><a href="#" id="del_all_order_button"><img align="absmiddle" src="../images/buttons/deleteselectedorders.jpg" onclick="javascript:delete_selected_orders();" border="0" hspace="3" /></a></td><?php } ?>
		</tr>
		</table>
		</td>
	   </tr> 
 
    </tr>
  </table>
  <?php } } else {
      if(isset($_REQUEST['page'])) { ?>
	  
  <table width="100%" align="center">
    <tr> 
	   <td align="center"><table cellpadding="0" cellspacing="0" border="0" ><tr><td><?php if(stripslashes($_REQUEST['order_status']) == "0") {?><a href="javascript:check_all_1();" id="pending_orders"><img align="absmiddle" src="../images/buttons/checkallpendingorders.jpg" border="0" hspace="3"></a><?php } ?></td><td><?php if(stripslashes($_REQUEST['order_status']) == "1") { ?><a href="javascript:check_all_2();" id="paid_orders"><img align="absmiddle" src="../images/buttons/checkallpaidorders.jpg" border="0" hspace="3"></a><?php } ?></td><td><a href="javascript:check_all_delete_1();"><img align="absmiddle" src="../images/buttons/checkallfordelete.jpg" border="0" hspace="3"></a></td><td><a href="javascript:uncheck_all();"><img align="absmiddle" src="../images/buttons/uncheckall.jpg" border="0" hspace="3"></a></td></tr></table></td><?php if(stripslashes($_REQUEST['order_status']) == "2") {?><td><a href="#" id="del_all_order_button"><img align="absmiddle" src="../images/buttons/deleteselectedorders.jpg" onclick="javascript:delete_selected_orders();" border="0" hspace="3" /></a></td><?php } ?></tr>
    <tr>
       <td align="center"><table cellspacing="0" cellpadding="0" border="0" ><tr>
       <td><?php if(stripslashes($_REQUEST['order_status']) == "0"){?><a href="#" id="paid_button"><img align="absmiddle" src="../images/buttons/markaspaid.jpg" onclick="javascript:markaspaid();" border="0" hspace="3" /></a><?php } ?></td>
	   <td align="right" colspan="3"><?php if(stripslashes($_REQUEST['order_status']) == "1"){?><a href="#" id="paid_button1"><img align="absmiddle" src="../images/buttons/markasship.jpg" onClick="javascript:markasshipped();" border="0"></a><?php }?></td><?php if(stripslashes($_REQUEST['order_status']) <> "2") {?> <td><a href="#" id="del_all_order_button"><img align="absmiddle" src="../images/buttons/deleteselectedorders.jpg" onclick="javascript:delete_selected_orders();" border="0" hspace="3" /></a></td><?php } ?></tr></table></td></tr> 
 
    </tr>
  </table>
	  <?php } else {?>
  <table width="100%">
    <tr> 
	  <td align="center"><table cellpadding="0" cellspacing="0" border="0" ><tr><td><a href="javascript:check_all1();" id="pending_orders"><img align="absmiddle" src="../images/buttons/checkallpendingorders.jpg" border="0" hspace="3"></a></td><td><a href="javascript:check_all2();" id="paid_orders"><img align="absmiddle" src="../images/buttons/checkallpaidorders.jpg" border="0" hspace="3"></a></td><td><a href="javascript:check_all_delete();"><img align="absmiddle" src="../images/buttons/checkallfordelete.jpg" border="0" hspace="3"></a></td><td><a href="javascript:uncheck_all();"><img align="absmiddle" src="../images/buttons/uncheckall.jpg" border="0" hspace="3"></a></td></tr></table></td>
     
    <tr>
       <td align="center" width="100%">
	   <table width="60%" border="0" cellpadding="0" cellspacing="0">
          <tr><td width="33%" align="center"><a href="#" id="paid_button"><img align="absmiddle" src="../images/buttons/markaspaid.jpg" onclick="javascript:markaspaid();" border="0" hspace="3" /></a></td>
          <td width="33%" align="center"><a href="#" id="paid_button1"><img align="absmiddle" src="../images/buttons/markasship.jpg" onClick="javascript:markasshipped();" border="0"></a></td>
          <td width="33%" align="center"><a href="#" id="del_all_order_button"><img align="absmiddle" src="../images/buttons/deleteselectedorders.jpg" onclick="javascript:delete_selected_orders();" border="0" hspace="3" /></a></td>
          </tr></table></td>
	   
	 </tr> 
 		 
    </tr>
  </table>
 
 <?php }
  }
 }
 ?>
  
  
  
  
<?php 
if(1 == 2 && !empty($_SESSION['ses_ord_srch_qry']))
{
?>

  <table width="100%">
    <tr> 
      <td width="10%" align="left"><a href="#"><img align="absmiddle" src="../images/checkall.jpg" onClick="javascript:check_all();" border="0"></a></td>
      <td <?php if(empty($_SESSION['ses_ord_srch_vars']['order_status'])){?> colspan="4" width="90%" <?php }?> align="left"><a href="#"><img align="absmiddle" src="../images/uncheckall.jpg" onClick="javascript:uncheck_all();" border="0"></a></td>
      <?php if(1==2) {?><td align="right" width="80%"><input type="button"  name="delete " value="Delete All Orders" onClick="javascript:check_all_for_delete();"></td> <?php }?>
      <?php
 if(1==1 || stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='0'")
	{
 ?>
      <td align="right" colspan="3" width="80%"><a href="#"><img align="absmiddle" src="../images/markaspaid.jpg" onClick="javascript:markaspaid();" border="0"></a></td>
      <?php
 }
 if(stripslashes($_SESSION['ses_ord_srch_vars']['order_status']) == "order_master.order_status='1'")
	{
 ?>
      <td align="right" colspan="3" width="80%"><a href="#"><img align="absmiddle" src="../images/markaspaid.jpg" onClick="javascript:markasshipped();" border="0"></a></td>
      <?php
 }
 ?>
    </tr>
  </table>
 
 <?php
 }
 ?>
<br>

<table width="60%" cellspacing="0" cellpadding="4" border="0">
<tbody><tr>
	<td width="" align="left" style="font-size:12px;">
		<?php $paging_cls->print_pages_of();?>	</td>
	<td align="right">
		<div class="pagination">
                <?php 
				$paging_cls->print_prev();
				$paging_cls->print_numbered_links();
				$paging_cls->print_next();?>
        </div>
	</td>
</tr>
</tbody></table>



</form>
</div>
<script language="JavaScript">
function check_all()
{
	var hid_obj = null;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			hid_obj = window.document.getElementById("ord_st" + window.document.order_search_frm.elements[i].value);
			if(hid_obj.value == 0)
			window.document.order_search_frm.elements[i].checked = true;
			else if(hid_obj.value == 1)
			window.document.order_search_frm.elements[i].checked = true;
		}
	}
	
	var paid_but_obj = window.document.getElementById('paid_button');
	var del_ord_but_obj = window.document.getElementById('del_all_order_button');
	
	paid_but_obj.className = 'showlayer';

	del_ord_but_obj.className = 'showlayer';
}

function uncheck_all()
{
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			window.document.order_search_frm.elements[i].checked = false;
		}
	}
	
	
}
function markaspaid()
{
var del_process = 0;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			if(window.document.order_search_frm.elements[i].checked == true)
			{
				del_process = 1;
				break;
			}
		}
	}
	
	if(del_process == 0)
	{
		alert("Select atleast one orders to be Paid !!");
	}
	else
	{
	if(confirm('Are you sure to mark the selected orders as paid?\n(Ok=yes, Cancel=No)'))
		  { 
		  window.document.order_search_frm.action='orders.php'; 
		  window.document.order_search_frm.submit_action.value='mrkpaid'; 
		  window.document.order_search_frm.submit();
		   } 
	  	 { 
	  	 return false;
	   	 }
	}
}

function markasshipped()
{
	var del_process = 0;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			if(window.document.order_search_frm.elements[i].checked == true)
			{
				del_process = 1;
				break;
			}
		}
	}
	
	if(del_process == 0)
	{
		alert("Select atleast one orders to be Ship !!");
	}
	else
	{
	if(confirm('Are you sure to mark the selected orders as shipped?\n(Ok=yes, Cancel=No)'))
		  { 
		  window.document.order_search_frm.action='orders.php';
		  window.document.order_search_frm.submit_action.value='mrkship'; 
		  window.document.order_search_frm.submit();
		   } 
		   
	  	 { 
	   return false;
	    }
	 }	
}

function check_all_for_delete()
{
if(confirm('Are you sure to want delete all orders?\n(Ok=yes, Cancel=No)'))
{
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			window.document.order_search_frm.elements[i].checked = true;
			window.document.order_search_frm.action='orders.php'; 
		  	window.document.order_search_frm.submit_action.value='mrkasdelete'; 
		 	window.document.order_search_frm.submit();
		}
	}
}
}

function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this order? (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $product_page_url; ?>?" + url;
 }
}


function check_all_delete()
{
	var hid_obj = null;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
/*
			hid_obj = window.document.getElementById("ord_st" + window.document.order_search_frm.elements[i].value);
			
			if(hid_obj.value == 0)
*/
			window.document.order_search_frm.elements[i].checked = true;

		}
	}
	

	var paid_but_obj = window.document.getElementById('paid_button');
	var paid_but_obj1 = window.document.getElementById('paid_button1');
	var del_ord_but_obj = window.document.getElementById('del_all_order_button');
	
	paid_but_obj.className = 'hidelayer';
	paid_but_obj1.className = 'hidelayer';
	del_ord_but_obj.className = 'showlayer';
}

function delete_selected_orders()
{
	
	var del_process = 0;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			if(window.document.order_search_frm.elements[i].checked == true)
			{
				del_process = 1;
				break;
			}
		}
	}
	
	if(del_process == 0)
	{
		alert("Select Orders to be deleted !!");
	}
	else
	{
		 doyou = confirm("Do you want to Delete the selected orders? (OK = Yes   Cancel = No)");
		 if (doyou == true)
		 {
		  	window.document.order_search_frm.submit_action.value='mrkasdelete'; 
		 	window.document.order_search_frm.submit();
		 }
	}
	
}
function check_all1()
{
	var hid_obj = null;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			hid_obj = window.document.getElementById("ord_st" + window.document.order_search_frm.elements[i].value);
			if(hid_obj.value == 0)
			window.document.order_search_frm.elements[i].checked = true;
			else
			window.document.order_search_frm.elements[i].checked = false;
		}
	}
	var paid_but_obj = window.document.getElementById('paid_button');
	var paid_but_obj1 = window.document.getElementById('paid_button1');
	var del_ord_but_obj = window.document.getElementById('del_all_order_button');
	
	paid_but_obj.className = 'showlayer';
	paid_but_obj1.className = 'hidelayer';
	del_ord_but_obj.className = 'showlayer';
}
function check_all2()
{
	var hid_obj = null;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
	
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			hid_obj = window.document.getElementById("ord_st" + window.document.order_search_frm.elements[i].value);
			
			if(hid_obj.value == 1 )
			window.document.order_search_frm.elements[i].checked = true;
			else
			window.document.order_search_frm.elements[i].checked = false;
		}
	}
	
	var paid_but_obj1 = window.document.getElementById('paid_button1');
	var paid_but_obj = window.document.getElementById('paid_button');
	var del_ord_but_obj = window.document.getElementById('del_all_order_button');
	
	paid_but_obj1.className = 'showlayer';
	paid_but_obj.className = 'hidelayer';
	del_ord_but_obj.className = 'showlayer';
}
function search_fun()
{
 document.order_search_frm.submit_action.value='search';
 
}
function check_all_1()
{
	var hid_obj = null;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			hid_obj = window.document.getElementById("ord_st" + window.document.order_search_frm.elements[i].value);
			if(hid_obj.value == 0)
			window.document.order_search_frm.elements[i].checked = true;
			else
			window.document.order_search_frm.elements[i].checked = false;
		}
	}
	
	var paid_but_obj = window.document.getElementById('paid_button');
	var del_ord_but_obj = window.document.getElementById('del_all_order_button');
	
	paid_but_obj.className = 'showlayer';
	del_ord_but_obj.className = 'showlayer';	
	
}
function check_all_2()
{
	var hid_obj = null;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
	
			hid_obj = window.document.getElementById("ord_st" + window.document.order_search_frm.elements[i].value);
			if(hid_obj.value == 1)
			window.document.order_search_frm.elements[i].checked = true;
			else
			window.document.order_search_frm.elements[i].checked = false;
		}
	}
	
	var paid_but_obj1 = window.document.getElementById('paid_button1');
	var del_ord_but_obj = window.document.getElementById('del_all_order_button');
	
	paid_but_obj1.className = 'showlayer';
	del_ord_but_obj.className = 'showlayer';	
}

function check_all_delete_1()
{
  
	var hid_obj = null;
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
/*
			hid_obj = window.document.getElementById("ord_st" + window.document.order_search_frm.elements[i].value);
			
			if(hid_obj.value == 0)
*/
			window.document.order_search_frm.elements[i].checked = true;

		}
	}
	

	if(window.document.order_search_frm.order_status.value == "order_master.order_status='0'")
	{
	var paid_but_obj = window.document.getElementById('paid_button');
	paid_but_obj.className = 'hidelayer';
	}
	else if(window.document.order_search_frm.order_status.value == "order_master.order_status='1'")
	{
	 var paid_but_obj1 = window.document.getElementById('paid_button1');
	 paid_but_obj1.className = 'hidelayer';
	}
	
	var del_ord_but_obj = window.document.getElementById('del_all_order_button');
	del_ord_but_obj.className = 'showlayer';
}
		
</script>
