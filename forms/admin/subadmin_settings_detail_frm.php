<?php 



$hid_action = "save";



?>

<script language="JavaScript">

function check_validate()
{

	error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";  

	check_empty(form.elements["site_path"].name,"Website path should not be empty !!");
	Check_website(form.elements["site_path"].name,"Enter a valid web url, web url should start with http:// or https://!!");
	check_empty(form.elements["download_path"].name,"Download path should not be empty !!");
	Check_website(form.elements["download_path"].name,"Enter a valid Download url, Download url should start with http:// or https://!!");
	check_empty(form.elements["company_name"].name,"Company name should not be empty !!");
	check_empty(form.elements["company_address"].name,"Company address should not be empty !!");
	check_empty(form.elements["company_phone"].name,"Company phone number should not be empty !!");
	check_empty(form.elements["company_fax"].name,"Company fax number should not be empty !!");
	check_email(form.elements["admin_email"].name,"Admin email should not be empty !!");
	//check_email(form.elements["cc_email"].name,"CC email should not be empty !!");
	//check_email(form.elements["bcc_email"].name,"Bcc email should not be empty !!");
	check_empty(form.elements["date_format"].name,"Default date format for the company should not be empty !!");
	check_empty(form.elements["database_server"].name,"Database server name should not be empty !!");
	check_empty(form.elements["database_username"].name,"Database username should not be empty !!");
	//check_empty(form.elements["database_password"].name,"Database password should not be empty !!");
	check_empty(form.elements["database_name"].name,"Database name should not be empty !!");
	check_empty(form.elements["img_files_allowed_ext"].name,"Image extensions should not be empty, \n   By default these extensions were allowed for image uploading in the site !!");
	check_empty(form.elements["files_allowed_ext"].name,"File extensions should not be empty, \n   By default these extensions were allowed for file uploading in the site !!");
	check_empty(form.elements["files_allowed_size"].name,"Maximum file size for the attachments (images/files) should not be empty,\n   Mention in bytes !!");
	check_empty(form.elements["files_allowed_h"].name,"Height for the images should not be empty,\n   Mention in pixels, By default this dimension is taken !!");
	check_empty(form.elements["files_allowed_w"].name,"Width for the images should not be empty,\n   Mention in pixels, By default this dimension is taken !!");
	/*check_empty(form.elements["max_book_size"].name,"PDF file size should not be empty !!");

	check_empty(form.elements["use_pearmail"].name,"Using pear mail should not be empty, It is a boolean value which should be set either to 0 or 1 !!");
	if(form.elements["use_pearmail"].value != 1 && form.elements["use_pearmail"].value != 0)
	{
		error = true;
		error_message += "* Using pear mail should contain either 1 or 0 !!";
	}
	//check_empty(form.elements["description_length"].name,"Length of book description to be displayed in the product list page on user section !!"); */
	
	check_empty(form.elements["price1"].name,"Price1 should not be empty !!");
	check_empty(form.elements["price2"].name,"Price2 should not be empty !!");
	check_empty(form.elements["price3"].name,"Price3 should not be empty !!");
	check_empty(form.elements["price4"].name,"Price4 should not be empty !!");
	check_empty(form.elements["noofnews"].name,"Number of news count should not be empty !!");

}

</script>
<div class="whitebox mtop15">
  <table width="95%" border="0" cellspacing="0" cellpadding="2" align="center">

<form name="settings_frm" method="post" action="" onSubmit="return check_form(window.document.settings_frm);">


    <tr valign="top"> 

      <td>



<table width="88%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
       
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Website Path</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="site_path" value="<?php echo stripslashes($GLOBALS['site_config']['site_path']); ?>" class="mediumtxtbox">            </td>
          </tr>
		<tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Download Path</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="download_path" value="<?php echo stripslashes($GLOBALS['site_config']['download_path']); ?>" class="mediumtxtbox">            </td>
          </tr>          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Company Name</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="company_name" value="<?php echo stripslashes($GLOBALS['site_config']['company_name']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Company Address</span><span class="starcolor">*</span></td>
            <td><textarea name="company_address" cols="35" rows="4" class="mediumtxtbox"><?php echo stripslashes($GLOBALS['site_config']['company_address']); ?></textarea></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Company Phone</span><span class="starcolor">*</span></td>
            <td><input type="text" name="company_phone" value="<?php echo stripslashes($GLOBALS['site_config']['company_phone']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Company Fax</span><span class="starcolor">*</span></td>
            <td><input type="text" name="company_fax" value="<?php echo stripslashes($GLOBALS['site_config']['company_fax']); ?>" class="mediumtxtbox"></td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Admin Email id</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="admin_email" value="<?php echo stripslashes($GLOBALS['site_config']['admin_email']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Youtube URL</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="youtube_URL" value="<?php echo stripslashes($GLOBALS['site_config']['youtube_URL']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">CarbonCopy Email id</span></td>
            <td width="50%"> <input type="text" name="cc_email" value="<?php echo stripslashes($GLOBALS['site_config']['cc_email']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Blind Carboncopy Email id</span></td>
            <td width="50%"> <input type="text" name="bcc_email" value="<?php echo stripslashes($GLOBALS['site_config']['bcc_email']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Date Format</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="date_format" value="<?php echo stripslashes($GLOBALS['site_config']['date_format']); ?>" class="mediumtxtbox">            </td>
          </tr>
           <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Website Title</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="site_title" value="<?php echo stripslashes($GLOBALS['site_config']['site_title']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Database Server Name</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="database_server" value="<?php echo stripslashes($GLOBALS['site_config']['database_server']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Database Username</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="database_username" value="<?php echo stripslashes($GLOBALS['site_config']['database_username']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Database Password</span></td>
            <td width="50%"> <input type="text" name="database_password" value="<?php echo stripslashes($GLOBALS['site_config']['database_password']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Database Name</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="database_name" value="<?php echo stripslashes($GLOBALS['site_config']['database_name']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Minimum Quqntity for notification</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="notify_min_prod_qty" value="<?php echo stripslashes($GLOBALS['site_config']['notify_min_prod_qty']); ?>" class="mediumtxtbox">
             count</td></tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Image File Types</span><span class="starcolor">*</span></td>
            <td> <input type="text" name="img_files_allowed_ext" value="<?php echo stripslashes($GLOBALS['site_config']['img_files_allowed_ext']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td><span class="whitefont">Other File Types</span><span class="starcolor">*</span></td>
            <td> <input type="text" name="files_allowed_ext" value="<?php echo stripslashes($GLOBALS['site_config']['files_allowed_ext']); ?>" class="mediumtxtbox">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">File Size</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="files_allowed_size" value="<?php echo stripslashes($GLOBALS['site_config']['files_allowed_size']); ?>" class="mediumtxtbox">
              (bytes) </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">File Height</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="files_allowed_h" value="<?php echo stripslashes($GLOBALS['site_config']['files_allowed_h']); ?>" class="mediumtxtbox">
              (px) </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">File Width</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="files_allowed_w" value="<?php echo stripslashes($GLOBALS['site_config']['files_allowed_w']); ?>" class="mediumtxtbox">
              (px) </td>
          </tr>
		  <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Price1</span><span class="starcolor"><strong>(To search product by user)</strong>*</span></td>
            <td width="50%"> <input type="text" name="price1" value="<?php echo stripslashes($GLOBALS['site_config']['price1']); ?>" class="mediumtxtbox">
             USD</td>
          </tr>
		  <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Price2</span><span class="starcolor"><strong>(To search product by user)</strong>*</span></td>
            <td width="50%"> <input type="text" name="price2" value="<?php echo stripslashes($GLOBALS['site_config']['price2']); ?>" class="mediumtxtbox">
             USD</td>
          </tr>
		  <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Price3</span><span class="starcolor"><strong>(To search product by user)</strong>*</span></td>
            <td width="50%"> <input type="text" name="price3" value="<?php echo stripslashes($GLOBALS['site_config']['price3']); ?>" class="mediumtxtbox">
             USD</td>
          </tr>
		  <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Price4</span><span class="starcolor"><strong>(To search product by user)</strong>*</span></td>
            <td width="50%"> <input type="text" name="price4" value="<?php echo stripslashes($GLOBALS['site_config']['price4']); ?>" class="mediumtxtbox">
             USD</td></tr>
		<tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">No.of.News to display</span><span class="starcolor"><strong>(User section)</strong>*</span></td>
            <td width="50%"> <input type="text" name="noofnews" value="<?php echo stripslashes($GLOBALS['site_config']['noofnews']); ?>" class="mediumtxtbox">
             numbers</td></tr>
		<tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Product Weight for shipping</span><span class="starcolor"><strong>(User section)</strong>*</span></td>
            <td width="50%"> <input type="text" name="prod_weight" value="<?php echo stripslashes($GLOBALS['site_config']['prod_weight']); ?>" class="mediumtxtbox">
             g</td></tr>
          <?php if(1==2) {?>
          <tr valign="top" class="postaddcontent">
            <td>eBook Category ID<span class="starcolor">*</span> (for download Pdf file)</td>
            <td><input type="text" name="ebook_cat" value="<?php echo stripslashes($GLOBALS['site_config']['ebook_cat']); ?>" class="mediumtxtbox"/></td>
          </tr>
          <tr valign="top" class="postaddcontent">
            <td>Book Size<span class="starcolor">*</span> (Pdf file size)</td>
            <td><input type="text" name="max_book_size" value="<?php echo stripslashes($GLOBALS['site_config']['max_book_size']); ?>">
              (Kb) </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Mailing Host</span></td>
            <td width="50%"> <input type="text" name="smtp_host" value="<?php echo stripslashes($GLOBALS['site_config']['smtp_host']); ?>">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Mailing Username</span></td>
            <td width="50%"> <input type="text" name="smtp_username" value="<?php echo stripslashes($GLOBALS['site_config']['smtp_username']); ?>">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Mailing Password</span></td>
            <td width="50%"> <input type="text" name="smtp_password" value="<?php echo stripslashes($GLOBALS['site_config']['smtp_password']); ?>">            </td>
          </tr>
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">PearMail</span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="use_pearmail" value="<?php echo stripslashes($GLOBALS['site_config']['use_pearmail']); ?>">
              (0 - normal mail function, 1 - Pear mail function)</td>
          </tr>
          <!-- Product Related Informations -->
          <tr valign="top" class="postaddcontent"> 
            <td width="50%"><span class="whitefont">Book Description Length (User 
              Section) </span><span class="starcolor">*</span></td>
            <td width="50%"> <input type="text" name="description_length" value="<?php echo stripslashes($GLOBALS['site_config']['description_length']); ?>">            </td>
          </tr>
          <?php }?>
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
</div>
