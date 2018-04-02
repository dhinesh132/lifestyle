<?php


class email extends database_manipulation {
	
	
	var $from_email;

	var $to_email;

	var $email_subject;

	var $email_message;

	var $email_log_message;

	var $email_cc;

	var $email_bcc;

	var $headers;
	
	var $email_type;
	
	var $email_sent_status;
	//variables for file attachments..	
	var $file_attachment;
	
	var $attached_files;
	
	var $mime_boundary;
	
	function email()
	{

		$this->from_email = $GLOBALS['site_config']['admin_email'];
		
		$this->email_sent_status = false;
		
		/*$this->to_email = $to_email;

		$this->email_type = $email_typ;

		$this->headers = array();
		
		if($this->email_typ == "text")
			
			$this->headers[] = "Content-Type: text/plain;charset=iso-8859-1";
			
		else
		
			$this->headers[] = "Content-Type: text/html;charset=iso-8859-1";
		

		$this->headers[] .= "Content-Transfer-Encoding: base64";
	
		$this->headers[] .= "From:" . $this->from_email;*/
		//added on 28-04-2007
		if(strlen(trim($GLOBALS['site_config']['cc_email'])) > 0)
		$this->email_cc = array($GLOBALS['site_config']['company_name'] . " <" . $GLOBALS['site_config']['cc_email'] . ">");
		
		if(strlen(trim($GLOBALS['site_config']['bcc_email'])) > 0)
		$this->email_bcc = array($GLOBALS['site_config']['company_name'] . " <" . $GLOBALS['site_config']['bcc_email'] . ">");
		//end
		$this->file_attachment = false;

	}

	/**********************************************************************************************

									Method To Add cc emails.

	***********************************************************************************************/
	//added on 28-04-2007
	function add_ccemail($emails,$mailer_name='')
	{
		$param_array = func_get_args();
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::add_ccemail() - PARAMETER LIST : ', $param_array);
		
		$cc_eml_arr = explode(",", $emails);
		
		if($mailer_name == "")
		{
			foreach($cc_eml_arr as $key => $val)
				$this->email_cc[] = $val;
		}
		else
		{
			$cc_nam_arr = explode(",", $mailer_name);
			$k = 0;
			foreach($cc_eml_arr as $key => $val)
			{
				if($cc_nam_arr[$k] == "")
				$this->email_cc[] = $val;
				else
				$this->email_cc[] = $cc_nam_arr[$k]." <".$val.">";
				$k++;
			}
		}//end	
		$GLOBALS['logger_obj']->debug('<br>METHOD email::add_ccemail() - Return Value : ', $this->email_cc);

	}

	/**********************************************************************************************

									Method To Add bcc emails.

	***********************************************************************************************/
	//added on 28-04-2007
	function add_bccemail($emails,$mailer_name='')
	{
		$param_array = func_get_args();
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::add_bccemail() - PARAMETER LIST : ', $param_array);
		
		$bcc_eml_arr = explode(",", $emails);
		if($mailer_name == "")
		{
			foreach($bcc_eml_arr as $key => $val)
			
				$this->email_bcc[] = $val;
		}
		else
		{
			$bcc_nam_arr = explode(",", $mailer_name);
			$k = 0;
			foreach($bcc_eml_arr as $key => $val)
			{
				if($bcc_nam_arr[$k] == "")
					$this->email_bcc[] = $val;
				else
					$this->email_bcc[] = $bcc_nam_arr[$k]." <".$val.">";
				$k++;
			}//end
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::add_bccemail() - Return Value : ', $this->email_bcc);

	}
	
	/**********************************************************************************************

						Method To frame header informations for the email.

	***********************************************************************************************/
	
	function frame_header($attachment_params="nil")
	{
		$param_array = func_get_args();
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::frame_header() - PARAMETER LIST : ', $param_array);
		
		$this->headers = array();
		
		if($this->email_type == "text")
			
			$this->headers[] = "Content-Type: text/plain;charset=iso-8859-1";
			
		else
		
			$this->headers[] = "Content-Type: text/html;charset=iso-8859-1";
		
		//if attachments are enabled then add headers for the attachment - Start
		if($attachment_params != "nil")
		{
		
		}
		//if attachments are enabled then add headers for the attachment - End
		//commented on 28-04-2007
		//$this->headers[] = "Content-Transfer-Encoding: base64";
		
		//added on 26-04-2007
		$this->headers[] = "Reply-To: ". $this->from_email;
		$this->headers[] = "X-Mailer: PHP/" . phpversion();
		//end
	
		$this->headers[] = "From:" . $this->from_email;
		
		if(is_array($this->email_cc) && strlen(implode(",", $this->email_cc)) > 0)
		{
		
			$this->headers[] = "Cc:" . implode(",", $this->email_cc);
			
		}
		
		if(is_array($this->email_bcc) && strlen(implode(",", $this->email_bcc)) > 0)
		{
		
			$this->headers[] = "Bcc:" . implode(",", $this->email_bcc);
			
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::frame_header() - RETURN VALUE : ', $this->headers);		
	}

	/**********************************************************************************************

									Method To Frame emails content.

	***********************************************************************************************/
	
	function frame_email_body($message_id, $content_vars, $replace_vals)
	{
		$param_array = func_get_args();
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::frame_email_body() - PARAMETER LIST : ', $param_array);
		
		if(count($content_vars) == count($replace_vals))
		{			
			$result = $this->fetch_flds("emails","emails_subject,emails_body,emails_format","emails_id = $message_id");
			
			$records=mysql_fetch_row($result[0]);
			
			$this->email_subject = $records[0];
			
			$this->email_type = $records[2];
			
			//echo $records[1];
			
			$this->email_message = $records[1];
			
			for($i = 0; $i < count($content_vars); $i++)
			{
			
				$this->email_subject = str_replace($content_vars[$i],$replace_vals[$i],$this->email_subject);

				$this->email_message = str_replace($content_vars[$i],$replace_vals[$i],$this->email_message);
				
			}
			$this->email_log_message = $this->email_message;
			//Comment on 27-04-2007
			/*
			if($GLOBALS['site_config']['use_pearmail'] != 1)
			$this->email_message = chunk_split(base64_encode($this->email_message));
			//echo $this->email_message;
			*/
			$GLOBALS['logger_obj']->debug('<br>METHOD email::frame_email_body() - RETURN VALUE : ', $this->email_log_message);
		}
		/*else{	
		echo "not func";	
		}*/

	}

	/**********************************************************************************************

									Method To validate email address.

	***********************************************************************************************/
	
	function email_validation($toemail) 
	{ 
		$param_array = func_get_args();
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::email_validation() - PARAMETER LIST : ', $param_array);
			
		if($_SERVER['REMOTE_ADDR'] != "127.0.0.1")
		{
		
		global $HTTP_HOST; 
		
		$result = array(); 
		
		$result[0]=true; 
		
		$result[1]="$toemail appears to be valid."; 
		/* this regular expression is not allowing some of the domain names like .name etc., so we check for one @ symbol and 
		atleast 1 "." symbol in email id.
		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $toemail)) 
		{ 		
			$result[0]=false; 
			
			$result[1]="$toemail is not properly formatted"; 
			
		}
		*/
		
		//remove the name from the email
		
		$earr = explode("<", $toemail);
		
		if(count($earr) == 2 && strlen(trim($earr[1])) > 0)
			$email = substr(trim($earr[1]),0,-1);
		else
			$email = trim($earr[0]);
		
		$eml_arr = explode("@",$email);
		$result[0]=false; 
		
		$result[1]="$toemail is not properly formatted"; 
		if(count($eml_arr) == 2 && strlen(trim($eml_arr[0])) > 0 && strlen(trim($eml_arr[1])) > 0)
		{
			$domain_arr = explode(".",$eml_arr[1]);
			if(count($domain_arr) > 1 && strlen(trim($domain_arr[0])) > 0 && strlen(trim($domain_arr[1])) > 0)
			{
				$result[0]=true; 
				$result[1]="$toemail appears to be valid."; 
			}
		}
		
		if(1==2)
		{//need not check by communicating to email server...
		
		list ( $username, $domain ) = split ("@",$toemail); 
		
		if (getmxrr($domain, $MXHost))  
		{		
			$connectaddress = $MXHost[0];
		}
		else 
		{		
			$connectaddress = $domain;
		} 
		//echo "Connect address : " . $connectaddress . "<br>";
		//echo "Domain Name : " . $domain . "<br>";
		$connect = fsockopen ( $connectaddress, 25 ); 
		
		if ($connect) 
		{		
			if (ereg("^220", $Out = fgets($connect, 1024))) 
			{ 
			
			   fputs ($connect, "HELO $HTTP_HOST\r\n"); 
			   
			   $out = fgets ( $connect, 1024 ); 
			   
			   $this->from_email = $GLOBALS['site_config']['admin_email'];
			   
			    $from = $this->from_email;
			   
			   fputs ($connect, "MAIL FROM: <{$from}>\r\n"); 
			   
			   $from = fgets ( $connect, 1024 ); 
			   
			   fputs ($connect, "RCPT TO: <{$toemail}>\r\n"); 
			   
			   $to = fgets ($connect, 1024); 
			   
			   fputs ($connect, "QUIT\r\n"); 
			   
			   fclose($connect); 
			   
			   if (!ereg ("^250", $from) || !ereg ( "^250", $to )) 
			   { 
			   
				   $result[0]=false; 
				   
				   $result[1]="Server rejected address"; 
				   
				} 
			} 
			
			else
			{				
				$result[0] = false; 
				
				$result[1] = "No response from server"; 
				
			  } 
			  
		}
		
		else
		{
			$result[0]=false; 
			
			$result[1]="Can not connect E-Mail server."; 
			
			//return $result; 
		} 
		
		}
		
		if(!$result[0])
		{

			$ttext = "";
			$ttext .= "<table border=0 cellpadding=3 cellspacing=1 align=center width=90%>";
			$ttext .= "<tr align=left><td><strong>Error Message</strong></td><td>" . $result[1] . " (" . $toemail . ")" . "</td></tr>";
			$ttext .= "</table>";

			$GLOBALS['logger_obj']->error('<br>METHOD email::email_validation() -  Return Value : ', $ttext,'email');

		}
	}
		$GLOBALS['logger_obj']->debug('<br>METHOD email::email_validation() -  Return Value : ', $result);
		return $result; 
		
	}
	
	/**********************************************************************************************

						Method To send email. If use-pearmail flag in config is set to 1
						then pear mail will be used, else normal mail function will be used

	***********************************************************************************************/
	
	function send_email($toemail,$attach_params="nil")
	{
		$param_array = func_get_args();
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::send_email() - PARAMETER LIST : ', $param_array);
		
		$this->to_email = trim($toemail);

		$ret_val = $this->email_validation($this->to_email);
		
		$mail_sent = $ret_val[0];
		
		$this->frame_header($attach_params);
		
		$this->headers = implode("\r\n", $this->headers);
		
		$cc_eml_st = 1;

		$cclog_txt = "";

		foreach($this->email_cc as $key => $eml)
		{
			$cc_email_status = $this->email_validation($eml);
			if(!$cc_email_status[0])
			{
				$cclog_txt .= "<tr><td>CC email address " . $eml . " is invalid. (" . $cc_email_status[1] . ")</td></tr>";
				$cc_eml_st = 0;
			}
		}

		$bcc_eml_st = 1;

		$bcclog_txt = "";

		foreach($this->email_bcc as $key => $eml)
		{
			$bcc_email_status = $this->email_validation($eml);
			if(!$bcc_email_status[0])
			{
				$bcclog_txt .= "<tr><td>BCC email address " . $eml . " is invalid. (" . $bcc_email_status[1] . ")</td></tr>";
				$bcc_eml_st = 0;
			}
		}
		/*echo "<br><br>TO EMAIL: ";
		print_r($this->to_email);
		echo "<br><br>SUBJECT: ";
		print_r($this->email_subject);
		echo "<br><br>MESSAGE: ";
		print_r($this->email_message);
		echo "<br><br>HEADERS:  ";
		print_r($this->headers);
		exit;*/
		if($mail_sent)
		{
	
			if($GLOBALS['site_config']['use_pearmail'] == 1)
			{
				$pret_val = $this->pear_mail($this->email_subject, $this->email_message, $this->to_email, $this->from_email, implode(",", $this->cc_email), implode(",", $this->bcc_email), $this->email_type);
				
				if($pret_val[0] == 1)
					$mail_sent = true;
				else
					$mail_sent = false;
			}
			else
			{
				mail($this->to_email, $this->email_subject, $this->email_message, $this->headers);
				$mail_sent = true;
				
			}
		}
		
		$ret_val[] = $mail_sent;
	
		$this->email_sent_status = $mail_sent;

		if(!$ret_val[0])
		{
		

			$ttext = "";
			$ttext .= "<table border=0 cellpadding=3 cellspacing=1 align=center width=90%>";
			$ttext .= "<tr align=left><td colspan='2'><strong>Email Details - Following Email has not been delivered.</strong></td></tr>";
			$ttext .= "<tr align=left><td><strong>From Email</strong></td><td>" . $this->from_email . "</td></tr>";
			$ttext .= "<tr align=left><td><strong>To Email</strong></td><td>" . $this->to_email . "</td></tr>";
			$ttext .= "<tr align=left><td><strong>Email Subject</strong></td><td>" . $this->email_subject . "</td></tr>";
			$ttext .= "<tr align=left><td><strong>Email Content</strong></td><td>" . $this->email_log_message . "</td></tr>";
			$ttext .= "<tr align=left><td><strong>Header Informations</strong></td><td>" . $this->headers . "</td></tr>";
			
			if($bcc_eml_st != 1 || $cc_eml_st != 1)
			{

			$ttext .= "<tr align=center><td colspan=2>Additional Informations</td></tr>";

			if($bcc_eml_st != 1)
			$ttext .= "<tr align=center><td colspan=2><table border=0 cellpadding=0 cellspacing=0 width=95%>" . $bcclog_txt . "</table></td></tr>";

			if($cc_eml_st != 1)
			$ttext .= "<tr align=center><td colspan=2><table border=0 cellpadding=0 cellspacing=0 width=95%>" . $cclog_txt . "</table></td></tr>";

			}
			
			//if error occurs in pear mail, we need to log it..
			if($GLOBALS['site_config']['use_pearmail'] == "1")			
			{
			
			$ttext .= "<tr align=center><td colspan=2>Additional Informations</td></tr>";

			$ttext .= "<tr align=center><td colspan=2><table border=0 cellpadding=0 cellspacing=0 width=95%>" . $pret_val[1]->ErrorInfo . "</table></td></tr>";
			
			}

			$ttext .= "</table>";

			$GLOBALS['logger_obj']->error('<br>METHOD email::send_email() -  Value : ', $ttext,'email');
		
		}
		else
		{//email si sent to the to address, but problem in sending emailks to some of the cc/bcc email address.
				
			if($bcc_eml_st != 1 || $cc_eml_st != 1)
			{
			$ttext = "";
			$ttext .= "<table border=0 cellpadding=3 cellspacing=1 align=center width=90%>";

			$ttext .= "<tr align=left><td colspan='2'><strong>Problem in sending cc/bcc emails.</strong></td></tr>";

			if($bcc_eml_st != 1)
			$ttext .= "<tr align=center><td colspan=2><table border=0 cellpadding=0 cellspacing=0 width=95%>" . $bcclog_txt . "</table></td></tr>";

			if($cc_eml_st != 1)
			$ttext .= "<tr align=center><td colspan=2><table border=0 cellpadding=0 cellspacing=0 width=95%>" . $cclog_txt . "</table></td></tr>";
			
			$ttext .= "<tr align=left><td><strong>Email Subject</strong></td><td>" . $this->email_subject . "</td></tr>";
			$ttext .= "<tr align=left><td><strong>Email Content</strong></td><td>" . $this->email_log_message . "</td></tr>";
			$ttext .= "<tr align=left><td><strong>Header Informations</strong></td><td>" . $this->headers . "</td></tr>";

			$ttext .= "</table>";

			$GLOBALS['logger_obj']->error('<br>METHOD email::send_email() -  Value : ', $ttext,'email');
		
			}
			
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD email::send_email() -  Value : ', $this);

		return $mail_sent; 
		
	}
	
	/**********************************************************************************************

								Method To Attach files in the email.

	***********************************************************************************************/
	
	function attach_files($attachment)
	{
		
		$this->file_attachment = true;
		if(file_exists($attachment))
		{
			$this->attached_files[] = $attachment;
			$fileatt = $attachment; // Path to the file                  
			$fileatt_type = "application/octet-stream"; // File Type 
			$start=	strrpos($attachment, '/') == -1 ? strrpos($attachment, '//') : strrpos($attachment, '/')+1;
			$fileatt_name = substr($attachment, $start, strlen($attachment));
	
			$file = fopen($fileatt,'rb'); 
			$data = fread($file,filesize($fileatt)); 
			fclose($file); 
		
			$semi_rand = md5(time()); 
			$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
			$this->headers[] = 	"Content-Type: multipart/mixed;";
			$this->headers[] = 	" boundary=\"{$mime_boundary}\"";
			$this->headers[] =  "MIME-Version: 1.0";
					 
			$this->email_message = "--{$mime_boundary}\n" . 
								   "Content-Type: {$fileatt_type};\n" . 
								   " name=\"{$fileatt_name}\"\n" . 
					  //"Content-Disposition: attachment;\n" . 
					  //" filename=\"{$fileatt_name}\"\n" . 
								   "Content-Transfer-Encoding: base64\n\n" . 
								   $this->email_message . "\n\n" . 
								   "--{$mime_boundary}--\n"; 
		}				 

	}

	/***************************************************************************************************
	
										PEAR MAIL CONCEPT
						
	***************************************************************************************************/
	
   function pear_mail($subject, $mail_txt, $to_email, $from_email, $cc_email="", $bcc_email="", $mail_type="text")
   {   
  //error_reporting(E_ALL);
  //ini_set('display_errors', 1);
// $GLOBALS['site_config']['debug'] =1;
		$param_array = func_get_args();
		
		$GLOBALS['logger_obj']->debug('<br>METHOD email::send_email() - PARAMETER LIST : ', $param_array);
			
			if(file_exists("../classes/class.phpmailer.php"))
			{
				require_once("../classes/class.phpmailer.php");
				require_once("../classes/smtp.class.php");
			}
			else
			{
				require_once("classes/class.phpmailer.php");
				require_once("classes/smtp.class.php");
			}
			
		   
		   $host_name = trim($GLOBALS['site_config']['smtp_host']);
		   $smtp_user = trim($GLOBALS['site_config']['smtp_username']);
		   $smtp_password = trim($GLOBALS['site_config']['smtp_password']);
		   
			$mail_new             = new PHPMailer();
			
			$body             = trim($mail_txt);
			
			$mail_new  ->IsSMTP(); // telling the class to use SMTP
			$mail_new  ->Host       = "mail.wayonnet.com"; // SMTP server
			$mail_new  ->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
													   // 1 = errors and messages
													   // 2 = messages only
			$mail_new  ->SMTPAuth   = trim($GLOBALS['site_config']['smtp_authendication']);                  // enable SMTP authentication
			$mail_new  ->Host       = trim($host_name); // sets the SMTP server
			$mail_new  ->Port       = trim($GLOBALS['site_config']['smtp_port']);                    // set the SMTP port for the GMAIL server
			$mail_new  ->Username   = trim($smtp_user); // SMTP account username
			$mail_new  ->Password   = trim($smtp_password);        // SMTP account password
			
			$mail_new  ->SetFrom(trim($smtp_user), 'WayOnNet');
			
			$mail_new  ->AddReplyTo(trim($smtp_user),"WayOnNet");
			
			$mail_new  ->Subject    = trim($subject);
			
			$mail_new  ->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			
			$mail_new  ->MsgHTML($body);
			
			$address = trim($to_email);
			$mail_new  ->AddAddress($address, $GLOBALS['site_config']['company_name']);
			
			
			if(!$mail_new  ->Send()) {
			 // echo "Mailer Error: " . $mail_new  ->ErrorInfo;
				$ret_val = 0;
			} else {
				$ret_val = 1;
			}
			
		$mail_arr = array($ret_val, $mail);
		$GLOBALS['logger_obj']->debug('<br>METHOD email::send_email() -  Value : ', $mail_arr);

		return $mail_arr;
		
  }

}



/* Sample to use

$eml_cls = new email();

$eml_cls->add_ccemail("apr_emp@hotmail.com");

$eml_cls->add_bccemail("apr_emp@sify.com");

$eml_cls->frame_email_body("1", array("#first_name#","#last_name#","#address1#","#address2#","#city#","#state#","#country#","#postalcode#","#phone#","#email#","#cust_password#", "#CN#"), array("Apr First n","Apr Ln","Address Line1","Address Line2","City","TN","IN","600001","1234567890","apr_emp@yahoo.com","apr123", "APR Infotech"));

$eml_cls->send_email("apr_emp@india.com");

*/

?>