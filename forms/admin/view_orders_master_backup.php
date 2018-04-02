<?php
$hid_action = "search";
$hid_action1 = "clear";

?>
<script language="JavaScript" src="../components/calendar/calendar2.js"></script>
<script language="JavaScript">
	
	function check_order_selection(obj,ord_st)
	{
		if(ord_st == 1 && obj.checked)
			obj.checked = false;
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
<form name="order_search_frm" method="post" action="orders_master_backup.php" onSubmit="return check_orderform(window.document.order_search_frm);">

  <table  align=center cellpadding=5 cellspacing=0 width="100%" class="tableborder_new">
    <tr class="maincontentheading"> 
      <td align="center"><font class="buyerfont">Orders History</font></td>
    </tr>
    <tr> 
      <td><table align="center" border="0" cellspacing="3" cellpadding="3">
          <tr valign="top"> 
            <td width="104" align="right"><font class="whitefont">Status:</font></td>
            <td width="353"> <select name="order_status">
			<option value="">Show All Orders</option>
                <option value="order_master_backup.order_status='0'" <?php echo (stripslashes($_SESSION['ses_ord_bac_srch']['order_status']) == "order_master_backup.order_status='0'")?"selected":""; ?>>Payment Pending</option>
				<option value="order_master_backup.order_status='1'" <?php echo (stripslashes($_SESSION['ses_ord_bac_srch']['order_status']) == "order_master_backup.order_status='1'")?"selected":""; ?>>Paid,Payment Pending</option>
				<option value="order_master_backup.order_status='2'" <?php echo (stripslashes($_SESSION['ses_ord_bac_srch']['order_status']) == "order_master_backup.order_status='2'")?"selected":""; ?>>Shipped</option>
                
              </select></td>
          </tr>
          <tr valign="top"> 
            <td align="right"><span class="whitefont">Order&nbsp;Date:</font></td>
            <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr valign="top"> 
                  <td width="10"><span class="whitefont">from&nbsp;</font></td>
                  <td> 
				  <?php
				  if (1==2)
				  {
				  		
	  
 				  $mth_name = "repMonth";
				  $mth_val = "";
				  
				  $dt_name = "repDay";
				  $dt_val = "";

				  $yr_name = "repYear";
				  $yr_val = "";
				  
				  $popup_name = "selcal";
				  $popup_frmname = "cust_search_frm";
				  
				  if(file_exists("../includes/"))
				  	
					include("../includes/date_field.php");
					
				  else
				  
				    include("includes/date_field.php");	 
					} 
	  ?>
				  
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
                  <td><span class="whitefont">to&nbsp;</font></td>
                  <td> 
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
						window.document.order_search_frm.repMonth.value ='<?php echo $_SESSION['ses_ord_bac_srch']['repMonth']; ?>';
						window.document.order_search_frm.repMonth1.value ='<?php echo $_SESSION['ses_ord_bac_srch']['repMonth1']; ?>';
						window.document.order_search_frm.repDay.value ='<?php echo $_SESSION['ses_ord_bac_srch']['repDay']; ?>';; 
						window.document.order_search_frm.repDay1.value ='<?php echo $_SESSION['ses_ord_bac_srch']['repDay1']; ?>';
						window.document.order_search_frm.repYear.value ='<?php echo $_SESSION['ses_ord_bac_srch']['repYear']; ?>';; 
						window.document.order_search_frm.repYear1.value ='<?php echo $_SESSION['ses_ord_bac_srch']['repYear1']; ?>';
						</script> </td>
          </tr>
          <tr valign="top"> 
            <td align="right"><span class="whitefont">Order&nbsp;Number:</font></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr valign="top"> 
                  <td width="10"><span class="whitefont">from&nbsp;</font></td>
                  <td style="padding-top: 0px;"> 
                    <input type="text" name="start_order_num" value="<?php echo stripslashes($_SESSION['ses_ord_bac_srch']['start_order_num']); ?>" onfocus="setbool('1')" onblur="setbool('0')" onkeypress="showvalue1(this.value)" style="height:16px;"></td>
                </tr>
                <tr valign="bottom"> 
                  <td height="20"><span class="whitefont">to&nbsp;</font></td>
                  <td> 
                    <input type="text" name="end_order_num" value="<?php echo stripslashes($_SESSION['ses_ord_bac_srch']['end_order_num']); ?>" onfocus="setbool('1')" onblur="setbool('0')" onkeypress="showvalue1(this.value)" style="height:16px;"><input type="hidden" value="0" name="boolcheck"></td>
                </tr>
              </table></td>
          </tr>
          <tr valign="top"> 
            <td align="right"><span class="whitefont">Filter:</font></td>
            <td><select name="filter_column">
                <option value="cust_firstname" <?php echo ($_SESSION['ses_ord_bac_srch']['filter_column'] == "customer_master.cust_firstname")?"selected":""; ?>>Customer First Name</option>
                <option value="customer_master.cust_lastname" <?php echo ($_SESSION['ses_ord_bac_srch']['filter_column'] == "customer_master.cust_lastname")?"selected":""; ?>>Customer Last Name</option>
              </select> <select name="filter_srch_typ">
                <option value="= '#val#'" <?php echo (stripslashes($_SESSION['ses_ord_bac_srch']['filter_srch_typ']) == "= '#val#'")?"selected":""; ?>>equals</option>
                <option value="like '%#val#%'" <?php echo (stripslashes($_SESSION['ses_ord_bac_srch']['filter_srch_typ']) == "like '%#val#%'")?"selected":""; ?>>contains</option>
              </select> <input type="text" name="filter_srch_val" value="<?php echo stripslashes($_SESSION['ses_ord_bac_srch']['filter_srch_val']); ?>"></td>
          </tr>
          <tr valign="top"> 
            <td align="right"><span class="whitefont">Sort&nbsp;By:</font></td>
            <td><select name="sort_column">
                <option value='<?php echo "order_master_backup.date_entered asc"; ?>' <?php echo ($_SESSION['ses_ord_bac_srch']['sort_column'] == "order_master_backup.date_entered asc")?"selected":""; ?>>Order Date Ascending</option>
				<option value='<?php echo "order_master_backup.date_entered desc"; ?>' <?php echo ($_SESSION['ses_ord_bac_srch']['sort_column'] == "order_master_backup.date_entered desc")?"selected":""; ?>>Order Date Descending</option>
                <option value='<?php echo "customer_master.cust_firstname asc"; ?>' <?php echo ($_SESSION['ses_ord_bac_srch']['sort_column'] == "customer_master.cust_firstname asc")?"selected":""; ?>>First Name Ascending</option>
				<option value='<?php echo "customer_master.cust_firstname desc"; ?>' <?php echo ($_SESSION['ses_ord_bac_srch']['sort_column'] == "customer_master.cust_firstname desc")?"selected":""; ?>> First Name Descending</option>
                <option value='<?php echo "customer_master.cust_lastname asc";?>' <?php echo ($_SESSION['ses_ord_bac_srch']['sort_column'] == "customer_master.cust_lastname asc")?"selected":""; ?>>Last Name Ascending</option>
				<option value='<?php echo "customer_master.cust_lastname desc";?>' <?php echo($_SESSION['ses_ord_bac_srch']['sort_column'] == "customer_master.cust_lastname desc")?"selected":""; ?>>Last Name Descending</option>
              </select> 
			  <?php if (1==2) { ?><select name="sort_order">
                <option value="asc" <?php echo ($_SESSION['ses_ord_bac_srch']['sort_order'] == "asc")?"selected":""; ?>>Ascending</option>
                <option value="desc" <?php echo ($_SESSION['ses_ord_bac_srch']['sort_order'] == "desc")?"selected":""; ?>>Descending</option> 
              </select><?php }?></td>
          </tr>
          <tr valign="top"> 
		  <td><a href="orders_master_backup.php?submit_action=clear"> <img border="0" src="../images/clear.jpg"  name="clear" value="Clear"></a>
		  <input type="hidden" name="submit_action1"></td>
		 
            <td align="right"><input type="image" src="../images/search12.gif"  name="search" value="Search" onclick="form.submit_action.value='search'" /></td>
            <td width="72" align="right"><input type="hidden" name="submit_action" >			</td>		 
          </tr>
        </table></td>
    </tr>
    
	   
  </table>
  <?php
  if(!empty($_SESSION['ses_ord_bac_qry']))
	 	 $qry1 = $_SESSION['ses_ord_bac_qry'];
			
		else 
		$qry1 = "select concat(customer_master.cust_firstname,'&nbsp;',customer_master.cust_lastname) as cust_name, order_master_backup.order_id, order_master_backup.date_entered, order_master_backup.order_status, customer_master.cust_firstname, customer_master.cust_lastname from order_master_backup, customer_master where 1 = 1 and order_master_backup.user_id = customer_master.cust_id";
	//$qry1 = "select order_id, date_entered, order_status, ship_email from order_master_backup where 1 = 1";
 
  
  $paging_cls = new paging($qry1);
  if($paging_cls->num_of_rows > 0)
  {
  ?><table align="center">
  <tr align="center" > <td class=""><font class='starfont'><strong><?php echo $paging_cls->num_of_rows." orders match search criteria"  ?></strong></font> </td></tr></table>
  <?php
  }
  ?>
  <table align="center" cellpadding="4" cellspacing="0" width="100%" class="tableborder_new">
    <tr class="maincontentheading"> 
      <td width="10%"><font class='buyerfont'>Select</font></td>
      <td width="10%"><font class='buyerfont'>Order&nbsp;#</font></td>
      <td width="30%"><font class='buyerfont'>Date</font></td>
      <td width="40%"><font class='buyerfont'>Customer Name </font></td>
      <td width="10%"><font class='buyerfont'>Status</font></td>
      <td width="10%"><font class='buyerfont'>Action</font></td>
    </tr>
    <?php
   
	 
	  
				
		$paging_cls = new paging($qry1);
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
      <td><input type="checkbox" name="ordnum[]" value="<?php echo $data->order_id; ?>"> 
      </td>
      <td><a  class='blue_link' href="#" onClick="popup_window('invoice_backup.php?order_id=<?php echo $data->order_id; ?>',400,650,'yes','yes');"> 
        <?php
	  
	  echo $data->order_id;
	 		 ?>
        </a> </td>
      <td> 
        <?php
	  echo $data->date_entered;
	  	  	?>
      </td>
      <td> 
        <?php
	  echo $data->cust_name;
	  		?>
      </td>
      <td nowrap> 
        <?php
	  if($data->order_status ==0)
	  echo "Payment pending";
	  else if($data->order_status==1)
	  echo "Paid,Shipment Pending";
	  else
	  echo "Shipped";
	  ?>
      </td>
      <td nowrap><a href="#"><img src="../images/icon_delete.gif" border=0 onclick="delete_record('submit_action=delete&order_id=<?php echo $data->order_id; ?>')" alt="Delete"></a></td>
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
      <td height="27" colspan="6" algin='center'> <font class='redfont'>No records 
        found.</font></td>
    </tr>
    <?php
}

?>
  </table>
  
  <?php 
if(1 == 1 || !empty($_SESSION['ses_ord_bac_qry']))
{
?>

<table width="100%">
<tr> <td width="10%" align="left"><a href="#"><img border="0" align="absmiddle" src="../images/checkall.jpg" onClick="javascript:check_all();"></a></td>
 <td <?php if(empty($_SESSION['ses_ord_bac_srch']['order_status'])){?> colspan="4" width="90%" <?php }?> align="left"><a href="#"><img border="0" align="absmiddle" src="../images/uncheckall.jpg" onClick="javascript:uncheck_all();"></a></td>
 <td align="right"><a href="#"><img border="0" align="absmiddle" src="../images/delete.jpg" onClick="javascript:markasdelete();"></a></td>
</tr>
 </table>
 
 <?php
 }
 ?>
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



</form>
<script language="JavaScript">
function check_all()
{
	for(i=0; i < window.document.order_search_frm.elements.length; i++)
	{
		//alert(window.document.order_search_frm.elements[i].name);
		if(window.document.order_search_frm.elements[i].name == "ordnum[]")
		{
			window.document.order_search_frm.elements[i].checked = true;
		}
	}
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

function markasdelete()
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
	if(confirm('Are you sure to delete this all orders?\n(Ok=yes, Cancel=No)'))
		 { 
		  window.document.order_search_frm.action='orders_master_backup.php'; 
		  window.document.order_search_frm.submit_action.value='mrkdel'; 
		  window.document.order_search_frm.submit();
		   } 
		}
	  	 { 
	  	 return false;
	   	 }
}

function delete_record(url)
{ 
 doyou = confirm("Do you want to delete this order (OK = Yes   Cancel = No)");
 if (doyou == true)
 {
 	  window.location.href="<?php echo $product_page_url; ?>?" + url;
 }
}

</script>
