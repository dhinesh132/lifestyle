<?php 
require_once("admin_header.php"); 
include("connection_db.php");
dbConnect();

$txtbyfocal  	=$_REQUEST["txtbyfocal"];
$txtmutifocal	=$_REQUEST["txtmutifocal"];
$txtclear		=$_REQUEST["txtclear"];
$txtantiref		=$_REQUEST["txtantiref"];
$txtuvcoating	=$_REQUEST["txtuvcoating"];
 $frmAction		=$_REQUEST["frmAction"];
if($frmAction=='submit')
{
/*	echo "hai";
$select_bif_qry=mysql_query("SELECT * FROM bifocal");
$num_bif_qry=mysql_num_rows($select_bif_qry);
if($num_bif_qry>0)
{
//$lastbif_Id=mysql_insert_id();
while($fetch_lastbif_Id=mysql_fetch_array($select_bif_qry))
{
$lastbif_Id=$fetch_lastbif_Id["bid"];
}
$qry = "UPDATE bifocal SET bprice=$txtbyfocal,mprice=$txtmutifocal where bid=$lastbif_Id";

$update_bif_qry=mysql_query($qry);
}
else
{
$insert_bif_qry=mysql_query("INSERT INTO bifocal(bprice,mprice)VALUES($txtbyfocal,$txtmutifocal)");
}
*/
$select_lens_qry=mysql_query("SELECT * FROM lens_coating_master");
$num_lens_qry=mysql_num_rows($select_lens_qry);
if($num_lens_qry>0)
{
//$lastlens_Id=mysql_insert_id();
while($fetch_lens_Id=mysql_fetch_array($select_lens_qry))
{
$lastlens_Id=$fetch_lens_Id["lcId"];
}
$qry_str = "UPDATE lens_coating_master SET lcClear=$txtclear,lcAntiRef=$txtantiref,lcUv=$txtuvcoating where lcId =$lastlens_Id";

$update_lens_qry=mysql_query($qry_str);
}
else
{
$insert_lens_qry=mysql_query("INSERT INTO lens_coating_master (lcClear,lcAntiRef,lcUv)VALUES($txtclear,$txtantiref,$txtuvcoating)");
}
}
$sel_sql1=mysql_query("SELECT * FROM bifocal");
while($fetch_byfoc=mysql_fetch_array($sel_sql1))
{
$bprice=$fetch_byfoc["bprice"];
$mprice=$fetch_byfoc["mprice"];
}

$sel_sql2=mysql_query("SELECT * FROM lens_coating_master");
while($fetch_lens_coat=mysql_fetch_array($sel_sql2))
{
$lcClear	=$fetch_lens_coat["lcClear"];
$lcAntiRef  =$fetch_lens_coat["lcAntiRef"];
$lcUv       =$fetch_lens_coat["lcUv"];
}




?>


<form name="byfocal_frm" method="post" action="" >
<input type="hidden" name="frmAction" value="submit" />
<table width="75%"  cellspacing="1"  align="center" bgcolor="#A4B5FA">
<tr>
  <td align="center"><font color="#FFFFFF"><strong>Product Settings</strong></font></td>
</tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="5"   align="center" bgcolor="#FFFFFF">
  
  
  <tr>
    <td width="75"><strong>Lens Coating</strong></td>
    <td width="70">&nbsp;</td>
    <td width="42">&nbsp;</td>
    <td width="266">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="starcolor">*</span>Clear</td>
    <td>US$</td>
    <td><input type="text" name="txtclear"  value="<?=$lcClear?>"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="starcolor">*</span>Anti-Reflective</td>
    <td>US$</td>
    <td><input type="text" name="txtantiref"  value="<?=$lcAntiRef?>"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="starcolor">*</span>UV Coating</td>
    <td>US$</td>
    <td><input type="text" name="txtuvcoating"  value="<?=$lcUv?>"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input align="absmiddle" style="border:0px;" type="image"  src="../images//submit.jpg" name="Submit" value="Submit" onclick="return check_validate()"></td>
    <td>&nbsp;</td>
  </tr>
</table></td>
</tr>
</table>
</form>

<script language="JavaScript">

function check_validate()
{
if(document.forms[0].txtbyfocal.value=="")
{
alert("Please enter Byfocal Price");
document.forms[0].txtbyfocal.focus();
return false;
}
if(document.forms[0].txtmutifocal.value=="")
{
alert("Please enter Mutifocal Price");
document.forms[0].txtmutifocal.focus();
return false;
}
if(document.forms[0].txtclear.value=="")
{
alert("Please enter Clear Price");
document.forms[0].txtclear.focus();
return false;
}
if(document.forms[0].txtantiref.value=="")
{
alert("Please enter Anti Reflective Price");
document.forms[0].txtantiref.focus();
return false;
}
if(document.forms[0].txtuvcoating.value=="")
{
alert("Please enter UV Coating Price");
document.forms[0].txtuvcoating.focus();
return false;
}
else
{
document.forms[0].frmAction.value='submit';
return true;
document.forms[0].submit();
}

	
}
</script>
