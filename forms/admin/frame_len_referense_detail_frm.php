<script language="javascript">
    function check_validate() {
        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  
		
        //check_empty(form.elements["rp_name"].name,"Related group name should not be empty");
		
		 var prdst="";        
		 for(z = 0; z <form.prodlist2.options.length; z++) {
			 if (prdst=="") {
				 prdst=form.prodlist2.options[z].value
			 }
			 else {
				 prdst=prdst + "," + form.prodlist2.options[z].value
			 }
		 }
		 
		 if(form.prodlist2.options.length <= 1)
		 {
		 	error = true;
			error_message += "* Select atleast two products to create a related group";
		 }
		 
		 form.products.value=prdst;
      
	  }
	 
	 
	 function selectcheckbox()
	 {
	 
	 	if(window.document.relprod_detail_frm.newsprod.checked)
		 window.document.relprod_detail_frm.temp_check.value = 'check';
		else
		 window.document.relprod_detail_frm.temp_check.value = 'uncheck';
		 
		 
		window.document.relprod_detail_frm.submit_action.disabled = true; 
        window.document.relprod_detail_frm.submit();    
	 
	 } 
	
	function catsubmit(sc)
    {
	
        //window.document.relprod_detail_frm.action='newsletter_product.php?selected_prod=yes';
		window.document.relprod_detail_frm.manipulate.value = 'yes'; 
		window.document.relprod_detail_frm.temp_check.value = 'check';
		window.document.relprod_detail_frm.submit_action.disabled = true; 

		 var prdst="";        
		 for(z = 0; z <window.document.relprod_detail_frm.prodlist2.options.length; z++) {
			 if (prdst == "") {
				 prdst = window.document.relprod_detail_frm.prodlist2.options[z].value;
			 }
			 else {
				 prdst = prdst + "," + window.document.relprod_detail_frm.prodlist2.options[z].value;
			 }
		 }

		window.document.relprod_detail_frm.products.value=prdst; 
		window.document.relprod_detail_frm.submit_action.disabled = true;
        window.document.relprod_detail_frm.submit();    
    }
	
	
	
	function move(fbox, tbox) {
    //fbox=form.cmplist1
    //tbox=form.cmplist2

    if (fbox.value != "") {
        var arrFbox = new Array();
        var arrTbox = new Array();
        var arrLookup = new Array();
        var i;
        for (i = 0; i < tbox.options.length; i++) {
            arrLookup[tbox.options[i].text] = tbox.options[i].value;
            arrTbox[i] = tbox.options[i].text;
        }
        var fLength = 0;
        var tLength = arrTbox.length;
        var setcheck;
        var setcheck2;
        setcheck="";
        setcheck2="";

        for(z = 0; z < tbox.options.length; z++) {
            if (tbox.options[z].text==fbox.options[fbox.selectedIndex].text) {
                setcheck="true";
                break;
            }
            else {
                setcheck="";
            }
        }

        for(i = 0; i < fbox.options.length; i++) {
            arrLookup[fbox.options[i].text] = fbox.options[i].value;
            if (fbox.options[i].selected && fbox.options[i].value != "") {
                if (setcheck==""){
                    arrTbox[tLength] = fbox.options[i].text;
                }
                tLength++;
            }
            else {
                arrFbox[fLength] = fbox.options[i].text;
                fLength++;
            }
        }

        arrFbox.sort();
        arrTbox.sort();
        fbox.length = 0;
        tbox.length = 0;
        var c;
        for(c = 0; c < arrFbox.length; c++) {
            var no = new Option();
            no.value = arrLookup[arrFbox[c]];
            no.text = arrFbox[c];
            fbox[c] = no;
        }
        for(c = 0; c < arrTbox.length; c++) {
            var no = new Option();
            no.value = arrLookup[arrTbox[c]];

            no.text = arrTbox[c];
            tbox[c] = no;
        }
    }
}

 function moveAll() 
                {
				 if (window.document.relprod_detail_frm.ck.checked == true) 
				 	{
					for (i = 0; i <  window.document.relprod_detail_frm.prodlist1.options.length; ) 
						   {
							window.document.relprod_detail_frm.prodlist1.selectedIndex = window.document.relprod_detail_frm.prodlist1.options[i];
							move(window.document.relprod_detail_frm.prodlist1,window.document.relprod_detail_frm.prodlist2);
						 }
					 }
				else 
					  {
						for (i = 0; i <  window.document.relprod_detail_frm.prodlist2.options.length; ) 
						   {
							window.document.relprod_detail_frm.prodlist2.selectedIndex = window.document.relprod_detail_frm.prodlist2.options[i];
							move(window.document.relprod_detail_frm.prodlist2,window.document.relprod_detail_frm.prodlist1);
							}
					}

				}
	
</script>
<?php 
//$GLOBALS['site_config']['debug'] = 1;
$hid_action = "save";

if( $edit_id > 0 )
{
	
	//$res = $relprod_obj->fetch_record($edit_id);
	//$relprod_obj = set_values($relprod_obj, "db", $res[0]);
	$res = $GLOBALS['db_con_obj']->fetch_flds("frame_len_referense","frame_id,len_id","frame_id='".$edit_id."'");
	$relprod_obj = mysql_fetch_object($res[0]);
	

}


if( 1==2 && isset($_SESSION['ses_temp_relprod_obj']) && is_array($_SESSION['ses_temp_relprod_obj']))
{
	$relprod_obj = set_values($relprod_obj,"ses",$_SESSION['ses_temp_relprod_obj']);
}


//$relprod_obj = set_values($relprod_obj, "request");

$t_query = "select len_id,len_name from lense_master where len_status =1";

if(strlen(trim($relprod_obj->len_id)) > 0)
$t_query .= " and len_id not in (" . $relprod_obj->len_id . ")";
	
	$t_result=$GLOBALS['db_con_obj']->execute_sql($t_query);
	while ($t_list_row=mysql_fetch_row($t_result[0]))
	 {
	    $tmp_name = ($t_list_row[1]=="")?"none":$t_list_row[1];
		$prod_list .= "<option value='$t_list_row[0]'>".$tmp_name."</option>";
	}

if(strlen(trim($relprod_obj->len_id)) > 0)
	{
		$prdlst2_res = $GLOBALS['db_con_obj']->fetch_flds("lense_master","len_id,len_name","len_id in (" . $relprod_obj->len_id . ")");
		
		$prod_list2 = "";
		
		while($prdlst2_data = mysql_fetch_object($prdlst2_res[0]))
		{
			$prod_list2 .= "<option value='" . $prdlst2_data->len_id . "'>".$prdlst2_data->len_name."</option>";
		}
	}

if($submit_action == "edit" || $_REQUEST['manipulate'] == "yes" || (isset($_SESSION['ses_temp_relprod_obj']) && is_array($_SESSION['ses_temp_relprod_obj'])))
{

	$prods = $relprod_obj->len_id['value'];
	
	if((isset($_SESSION['ses_temp_relprod_obj']) && is_array($_SESSION['ses_temp_relprod_obj']) || $submit_action == "edit") && $_REQUEST['manipulate'] != "yes")
	{
	
		echo $t_query = "select len_id,len_name from lense_master where len_status =1";
		
		if(strlen(trim($relprod_obj->len_id['value'])) > 0)
		$t_query .= " and len_id not in (" . $relprod_obj->len_id . ")";
				
			$t_result=$GLOBALS['db_con_obj']->execute_sql($t_query);
			while ($t_list_row=mysql_fetch_row($t_result[0]))
			 {
				$tmp_name = ($t_list_row[1]=="")?"none":$t_list_row[1];
				$prod_list .= "<option value='$t_list_row[0]'>".$tmp_name."</option>";
			}
	}

if(strlen(trim($prods)) > 0)
	{
		$prdlst2_res = $GLOBALS['db_con_obj']->fetch_flds("lense_master","len_id,len_name","len_id in (" . $prods . ")");
		
		$prod_list2 = "";
		
		while($prdlst2_data = mysql_fetch_object($prdlst2_res[0]))
		{
			$prod_list2 .= "<option value='" . $prdlst2_data->len_id . "'>".$prdlst2_data->len_name."</option>";
		}
	}
}

?>

<table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">
<form name="relprod_detail_frm" method="post" action="" onSubmit="return check_form(window.document.relprod_detail_frm);">
    <tr> 
      <td><table border="0" cellpadding="5" cellspacing="0" align=center class="tableborder_new">
          <tr class="maincontentheading"> 
            <td colspan="2" align="center">Assign Lens Type to Frame</td>
          </tr>
          <tr> 
            <td width="342" align="center"> <font class="whitefont">Frame Type : </font> </td>
            <td width="391"><?php $frame_name = $GLOBALS['db_con_obj']->fetch_field("frame_master","frame_name","frame_id='".$_SESSION['ses_rel_frame_id']."'");
			echo stripslashes($frame_name );?></td>
          </tr>
           
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          
          <tr> 
            <td colspan=2> <table cellpadding=5 cellspacing=0 border=0 width='100%'>
                <tr> 
                  <td align='center'><font class="titletext"><b>List of Lens Type</b></font></td>
                  <td><font class="titletext">&nbsp;</font></td>
                  <td align='center'><font class="titletext"><b>Selected Lens Type</b></font></td>
                </tr>
                <tr> 
                  <td align='center'><select name='prodlist1' size=10 style="width:250px" multiple>
                      <?php echo $prod_list;  ?></select></td>
                  <td width="10px" align="center"><input name="button" type="button" onClick="move(this.form.prodlist1,this.form.prodlist2)" value=">>"> 
                    <br>
                    <br>
                    <br>
                    <input name="button" type="button" onClick="move(this.form.prodlist2,this.form.prodlist1)" value="<<"></td>
                  <td align='center'><select name='prodlist2' size=10 style="width:250px" multiple >
                      <?php echo $prod_list2;  ?> </select></td>
                </tr>
                <tr> 
                  <td colspan=3 align='left'>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='checkbox' name='ck' onClick='javascript: moveAll();'>
                    <font class="titletext">Select / Unselect All</font></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> <input type="hidden" name="products">
            <input type="hidden" name="frame_id" value="<?php echo $_SESSION['ses_rel_frame_id']; ?>">
				   	 <input type="hidden" name="rp_id" value="<?php echo $relprod_obj->rp_id['value']; ?>">
                     <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
					 <input type="hidden" name="manipulate" value="0">
			  <input type="hidden" name="temp_check" value="0">
         </tr>
          <tr> 
            <td align=center colspan=2> <input align="absmiddle" style="border:0px;" type="image" src="../images/submit.jpg" name="Submit" value="Submit">&nbsp;&nbsp;&nbsp;&nbsp;<img align="absmiddle" src="../images/reset.jpg" onClick="window.document.relprod_detail_frm.reset();">            </td>
          </tr>
      </table></td>
    </tr> 
</form>	
  </table>
