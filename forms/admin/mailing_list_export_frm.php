 <?php
require_once("../classes/subscriber.class.php");
$sub = new subscriber();

 if($edit == 1 && $edit_id > 0)
{
	
	$res = $sub->fetch_record($edit_id);
	$data = mysql_fetch_object($res[0]);
	$sub = set_values($sub, "db", $res[0]);

}
 ?>
<form action="mailinglist_export.php" method="post" enctype="multipart/form-data" name="export_frm" >
<table width="95%" border="0" cellspacing="0" cellpadding="2" align="center">
    <tr> 
      <td>
<fieldset class="tableborder_new"><legend class="maincontentheading">Filter Exports</legend>
        <table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
	      
         
           <tr valign="top" class="postaddcontent"> 
            <td width="30%"><span class="whitefont">From Date:</span></td>
            <td width="70%"><select name="repMonth">
                      <option value="">Month</option>
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
                      <option value="">Day</option>
                      <?php for($fd=01;$fd<=31;$fd++){
						  if(strlen($fd)<=1)
						    $fd ="0".$fd;
					  ?>
                      <option value="<?=$fd;?>"><?=$fd;?></option>
                      <?php }?>
                    </select> <select name="repYear">
                      <option value="">Year</option>
                      <?php for($fy=date("Y");$fy >=2012;$fy--){?>
                      <option value="<?=$fy;?>"><?=$fy;?></option>
                      <?php }?>
                      </select> &nbsp;<a href="javascript:selcal.popup();"><img width="16" height="16" border="0" align="absmiddle" src="../js/calendar/cal.gif"></a> 
                    &nbsp; <input type="hidden" name="reportdate"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="30%"><span class="whitefont">To Date:</span></td>
            <td width="70%"><select name="repMonth1">
                      <option value="">Month</option>
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
                      <option value="">Day</option>
                     <?php for($td=01;$td<=31;$td++){
						  if(strlen($td)<=1)
						    $td ="0".$td;
							?>
                      <option value="<?=$td;?>"><?=$td;?></option>
                      <?php }?>
                    </select> <select name="repYear1">
                      <option value="">Year</option>
                       <?php for($ty=date("Y");$ty >=2012;$ty--){?>
                      <option value="<?=$ty;?>"><?=$ty;?></option>
                      <?php }?></select> &nbsp;<a href="javascript:selcal1.popup();"><img width="16" height="16" border="0" align="absmiddle" src="../js/calendar/cal.gif"></a> 
                    <input type="hidden" name="reportdate1"> 
                    <script language="JavaScript">
						var selcal = new calendar2(window.document.forms['export_frm'].elements['repMonth'],window.document.forms['export_frm'].elements['repDay'],window.document.forms['export_frm'].elements['repYear']);
						selcal.year_scroll = true;
						selcal.time_comp = false;
						
						var selcal1 = new calendar2(window.document.forms['export_frm'].elements['repMonth1'],window.document.forms['export_frm'].elements['repDay1'],window.document.forms['export_frm'].elements['repYear1']);
						selcal1.year_scroll = true;
						selcal1.time_comp = false;
						
						
						window.document.forms['export_frm'].repMonth.value="<?php echo date("m",mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));?>";
						window.document.forms['export_frm'].repDay.value="<?php echo date("d");?>";
						window.document.forms['export_frm'].repYear.value="<?php echo date("Y");?>"
						window.document.forms['export_frm'].repMonth1.value="<?php echo date("m");?>";
						window.document.forms['export_frm'].repDay1.value="<?php echo date("d");?>";
						window.document.forms['export_frm'].repYear1.value="<?php echo date("Y");?>"
						</script> 
                    </td>
          </tr>
            <tr> 
            <td colspan="2" height="8px" align="center"><input type="submit" name="submit" value="Export" />
            <input type="hidden" name="action" value="export" /></td>
          </tr>  
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
        </table>
</fieldset>	  
	  </td>
    </tr> 
  </table></form>	

<script language="javascript">
frm_obj = window.document.<?php echo $cur_obj->frm_name; ?>;	
</script>