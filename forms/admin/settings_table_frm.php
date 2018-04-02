<?php 



$hid_action = "save";



?>



	

  <table width="75%" border="0" cellspacing="0" cellpadding="2" align="center">

<form name="settings_frm" method="post" action="">


    <tr valign="top"> 

      <td>



<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'> 
              Settings Information </td>
          </tr>
          
         <tr valign="top" class="postaddcontent">
            <td colspan="2" align="center">BiFocal</td>
          </tr>
          <?php 
		  $qry = $GLOBALS['db_con_obj']->fetch_flds("settings_table","*","type_id='1'");
		  
		  while($data = mysql_fetch_object($qry[0]))
		  {
		  ?>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont"><?php echo stripslashes($data->name);?></span><span class="starcolor">*</span></td>
            <td><input type="text" name="<?php echo $data->id;?>" value="<?php echo $data->amount;?>"></td>
          </tr>
          <?php
		  }
		  ?>
        
          <tr valign="top" class="postaddcontent">
            <td colspan="2" align="center">Lens Coating</td>
          </tr>
          <?php 
		  $qry = $GLOBALS['db_con_obj']->fetch_flds("settings_table","*","type_id='2'");
		  
		  while($data1 = mysql_fetch_object($qry[0]))
		  {
		  ?>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont"><?php echo stripslashes($data1->name);?></span><span class="starcolor">*</span></td>
            <td><input type="text" name="<?php echo $data1->id;?>" value="<?php echo $data1->amount;?>"></td>
          </tr>
          <?php
		  }
		  ?>
          
          <!-- Product Related Informations -->
          
          <tr valign="top" class="postaddcontent"> 
            <td colspan="2"><div align="center"> 
                <input align="absmiddle" style="border:0px;" type="image" src="../images/submit.jpg" name="Submit" value="Submit">
                <input type="hidden" name="submit_action" value="<?php echo $hid_action; ?>">
              </div></td>
          </tr>
        </table>	  

	  </td>

    </tr>

    <tr> 

            <td align="center">



            </td>

    </tr>

</form>	

  </table>

