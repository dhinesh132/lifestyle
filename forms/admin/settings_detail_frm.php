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
            <td width="50%"><span class="whitefont">Website path</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="site_path" value="<?php echo stripslashes($GLOBALS['site_config']['site_path']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Company Name</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="company_name" value="<?php echo stripslashes($GLOBALS['site_config']['company_name']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Company Address</span><span class="starcolor">*</span></td>
            <td><textarea name="company_address" cols="35" rows="4"><?php echo stripslashes($GLOBALS['site_config']['company_address']); ?></textarea></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Company Phone</span><span class="starcolor">*</span></td>
            <td><input type="text" name="company_phone" value="<?php echo stripslashes($GLOBALS['site_config']['company_phone']); ?>"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Company Fax</span><span class="starcolor">*</span></td>
            <td><input type="text" name="company_fax" value="<?php echo stripslashes($GLOBALS['site_config']['company_fax']); ?>"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Debug Value</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="debug" value="<?php echo stripslashes($GLOBALS['site_config']['debug']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Write Debug Log Value</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="write_debug_log" value="<?php echo stripslashes($GLOBALS['site_config']['write_debug_log']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Admin Email id</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="admin_email" value="<?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">CarbonCopy Email id</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="cc_email" value="<?php echo stripslashes($GLOBALS['site_config']['cc_email']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Blind Carboncopy Email id</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="bcc_email" value="<?php echo stripslashes($GLOBALS['site_config']['bcc_email']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Date Format</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="date_format" value="<?php echo stripslashes($GLOBALS['site_config']['date_format']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Server Name</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="database_server" value="<?php echo stripslashes($GLOBALS['site_config']['database_server']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Username</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="database_username" value="<?php echo stripslashes($GLOBALS['site_config']['database_username']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Password</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="database_password" value="<?php echo stripslashes($GLOBALS['site_config']['database_password']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Database Name</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="database_name" value="<?php echo stripslashes($GLOBALS['site_config']['database_name']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Image File Types</span><span class="starcolor">*</span></td>
            <td> <input type="text" name="img_files_allowed_ext" value="<?php echo stripslashes($GLOBALS['site_config']['img_files_allowed_ext']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Other File Types</span><span class="starcolor">*</span></td>
            <td> <input type="text" name="files_allowed_ext" value="<?php echo stripslashes($GLOBALS['site_config']['files_allowed_ext']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">File Size</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="files_allowed_size" value="<?php echo stripslashes($GLOBALS['site_config']['files_allowed_size']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">File Height</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="files_allowed_h" value="<?php echo stripslashes($GLOBALS['site_config']['files_allowed_h']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">File Width</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="files_allowed_w" value="<?php echo stripslashes($GLOBALS['site_config']['files_allowed_w']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Admin Paging row(s)</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="admin_paging_rows" value="<?php echo stripslashes($GLOBALS['site_config']['admin_paging_rows']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Paging row(s)</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="paging_rows" value="<?php echo stripslashes($GLOBALS['site_config']['paging_rows']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Product Paging Column(s)</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="paging_matrix_cols" value="<?php echo stripslashes($GLOBALS['site_config']['paging_matrix_cols']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Category Paging Column(s)</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="cat_paging_matrix_cols" value="<?php echo stripslashes($GLOBALS['site_config']['cat_paging_matrix_cols']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Admin Priority</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="admin_max_priority" value="<?php echo stripslashes($GLOBALS['site_config']['admin_max_priority']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Mailing Host</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="smtp_host" value="<?php echo stripslashes($GLOBALS['site_config']['smtp_host']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Mailing Username</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="smtp_username" value="<?php echo stripslashes($GLOBALS['site_config']['smtp_username']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Mailing Password</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="smtp_password" value="<?php echo stripslashes($GLOBALS['site_config']['smtp_password']); ?>"> 
            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">PearMail</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="use_pearmail" value="<?php echo stripslashes($GLOBALS['site_config']['use_pearmail']); ?>"> 
            </td>
          </tr>
          <!-- Product Related Informations -->
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Parent Children Relationship</span><span class="starcolor">*</span></td>
            <td><input type="text" name="parent_child_option" value="<?php echo stripslashes($GLOBALS['site_config']['parent_child_option']); ?>"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Product Attribute Count</span><span class="starcolor">*</span></td>
            <td><input type="text" name="prod_attribute_count" value="<?php echo stripslashes($GLOBALS['site_config']['prod_attribute_count']); ?>"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Book Description Length (User 
              Section) </span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="description_length" value="<?php echo stripslashes($GLOBALS['site_config']['description_length']); ?>"> 
            </td>
          </tr>
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

