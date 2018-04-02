<?php
 
require_once("includes/code_header.php");



require_once("includes/inside_head_tag.php");

$action1 = $_REQUEST['price'];

switch($action1)
{
case "yes":
	$price1 = $_REQUEST['price1'];
	$price2 = $_REQUEST['price2'];
	header("location:product_lists.php?price1=$price1&price2=$price2");
	exit;
	
break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to our site!</title>
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="niceforms.js"></script>


</head>
<script language="JavaScript">

function check_validate1()
{
	check_empty(form.elements["price1"].name,"From price should not be empty !!");
	
	check_empty(form.elements["price2"].name,"To price should not be empty !!");
	
	/*if(form.price1.value > form.price1.value)
	{
		error = true;
		error_message += "* To price should be greater then from price !!";
	} */
}
</script>
<body>
<table id="total" width="1001" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding:0px 0px 0px 1px" height="600" valign="top"><table width="980" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#e1e7fe">
      <tr>
        <td height="158" valign="bottom" bgcolor="#FFFFFF" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table id="topmenu" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="39" id="logbar" ><?php if(isset($_SESSION['ses_cust_id'])){?><a href="cust_login.php">Log-in</a>  |  <a href="cust_register.php">Register</a><?php } else {?><a href="cust_login.php" style="padding-right:20px;"><b>Logout</b></a><?php } ?></td>
                </tr>
                <tr>
                  <td height="47" id="menutop"><table width="766" border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" width="78"><a href="index.php">Home</a></td>
                      <td width="224" align="center"><a href="#">Order / Shipping Information</a></td>
                      <td width="178" align="center"><a href="#">Eyewear Information</a></td>
                      <td width="103" align="center"><a href="#">Contact Us</a></td>
                      <td width="183" align="center"><a href="basket.php">View Cart / Check Out</a></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="228" valign="top" height="700"><!--side bar starts--><table height="537" width="216" border="0" align="right" cellpadding="0" cellspacing="0">
              
              <tr>
                <td height="192" valign="top"><!--side menu starts--><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="6%"><img src="images/sid_left.jpg" width="12" height="52" /></td>
                        <td width="89%" background="images/sid_middle.jpg"><span class="sidhead">Browse Frames by<br />
                          PRICE CATEGORY</span></td>
                        <td width="5%"><img src="images/sid_right.jpg" width="12" height="52" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="224"  border="0" align="center" cellpadding="0" cellspacing="0" id="sidebar">
                      <tr>
                        <td width="224"><a href="product_lists.php?price=18" title="$18 Frames">US$<?php echo $GLOBALS['site_config']['price1'];?> Frames</a></td>
                      </tr>
                      <tr>
                        <td><a href="product_lists.php?price=28" title="$28 Frames">US$<?php echo $GLOBALS['site_config']['price2'];?> Frames</a></td>
                      </tr>
                      <tr>
                        <td><a href="product_lists.php?price=38" title="$38 Frames">US$<?php echo $GLOBALS['site_config']['price3'];?> Frames</a></td>
                      </tr>
					   <tr>
                        <td><a href="product_lists.php?price=48" title="$48 Frames">US$<?php echo $GLOBALS['site_config']['price4'];?> Frames</a></td>
                      </tr>
					  <form name="price" action="" method="post" onSubmit="return check_form1(window.document.price);">
					  <tr>
                        <td valign="middle"><a href="#">Price &nbsp; <input type="text" name="price1" style="width:25px;height:14px;" />&nbsp;To &nbsp;<input type="text" name="price2" style="width:25px; height:14px;"/>&nbsp;&nbsp;<input align="absmiddle" type="image" onclick="document.price.price.value='yes';" src="images/go.gif" width="40" height="18" border="0" /><input type="hidden" name="price" /></a></td>
                      </tr>
					  </form>
                         <tr>
                        <td id="sidebar_bottom"></td>
                      </tr>               
                  </table></td>
                  </tr>
                  
                </table>
                  <!--side menu box ends here--></td>
              </tr>
              
              <tr>
                <td height="147" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="6%"><img src="images/sid_left.jpg" width="12" height="52" /></td>
                          <td width="89%" background="images/sid_middle.jpg"><span class="sidhead">Browse Frames by<br />
                            FRAME TYPE </span></td>
                          <td width="5%"><img src="images/sid_right.jpg" width="12" height="52" /></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table  border="0" align="center" cellpadding="0" cellspacing="0" id="sidebar">
                        <tr>
                          <td><a href="product_lists.php?frame_id=1" title="Full Frame">Full Frame</a></td>
                        </tr>
                        <tr>
                          <td><a href="product_lists.php?frame_id=2" title="Half Frame">Half Frame</a></td>
                        </tr>
                        <tr>
                          <td><a href="product_lists.php?frame_id=3" title="Frameless">Frameless</a></td>
                        </tr>
                        <tr>
                          <td id="sidebar_bottom"></td>
                        </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              
              <tr>
                <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="6%"><img src="images/sid_left.jpg" width="12" height="52" /></td>
                          <td width="89%" background="images/sid_middle.jpg"><span class="sidhead">Browse Frames by</span></td>
                          <td width="5%"><img src="images/sid_right.jpg" width="12" height="52" /></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table  border="0" align="center" cellpadding="0" cellspacing="0" id="sidebar">
                        <tr>
                          <td><a href="advanced_search.php" title="Advance Search">Advance Search</a></td>
                        </tr>
                        <tr>
                          <td><a href="#" title="NEW ARRIVAL">NEW ARRIVAL</a></td>
                        </tr>
                        
                        <tr>
                          <td id="sidebar_bottom"></td>
                        </tr>
                    </table></td>
                  </tr>
				  
				  <?php
				  if($form_detail==1)
				  {
				  $h = "620px";
				  $w = "120px";
				  }
				  else
				  {
				  $h = "620px";
				  $w = "160px";
				  }
require_once("classes/news_master.class.php");

$news_limit = $GLOBALS['site_config']['noofnews'];
if($news_limit <0)
 $news_limit =4;
 
 $news_qry = "select heading, news from news_master where status =1 order by date_modified desc limit 0,$news_limit";

$news_res = $GLOBALS['db_con_obj']->execute_sql($news_qry);



$news="";

while($news_data = mysql_fetch_object($news_res[0]))
{
	$news .= "<span class='cont_6'><strong>".$news_data->heading."</strong><br></span>";
	$news .="&nbsp;&nbsp;&nbsp;<span class='cont_6'>".$news_data->news."</span><br><br>";
	

}
?>
				
				  <tr><td height="20px;"></td></tr>
				  <tr><td><div 
align="center"> <marquee width="200" bgcolor="#ffffff" height="200px;" scrollamount="2" 
direction="up" loop="true" width="35%"> <center> 
<font color="#ffffff"><?php echo $news; ?></font> </center> </marquee></div></td></tr>
<tr><td height="20px;"></td></tr>

                </table></td>
              </tr>
            </table>
              <!--sidebar ends--></td>
            <td width="752" valign="top"><!--content starts here-->
              <!--content ends here-->
 