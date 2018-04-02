<?php

class EasyDownload
{
	var $ContentType;				
	var $ContentLength;
	var $ContentDisposition;
	var $ContentTransferEncoding;
	var $Path;
	var $FileName;
	var $FileNameDown;	
	
	/**
	* Constructor
	* @access		public	
	*/	
	function EasyDownload()
	{
		$this->ContentType 				= "application/force-download";
		$this->ContentLength			= "";	
		$this->ContentDisposition		= "";
		$this->ContentTransferEncoding	= "";
		$this->Path						= "";
		$this->FileName					= "";
		$this->FileNameDown		= "";		
	}
	
	/**
	* It configures value Header 'ContentType'
	*
	* @access		public
	*/		
	function setContentType($strValue)
	{
		$this->ContentType = $strValue;
	}
	
	/**
	* It configures value Header 'ContentLength' with the size of the informed file
	* @return		void
	* @access		private
	*/	
	function _setContentLength()
	{
		$this->ContentLength = filesize($this->Path . "/" . $this->FileName);
	}
	
	/**
	* It configures value Header 'ContentDisposition' 
	* @access		public
	*/	
	function setContentDisposition($strValue)
	{
		$this->ContentDisposition = $strValue;
	}
	
	/**
	* It configures value Header 'ContentTransferEncoding' 
	* @access		public
	*/	
	function setContentTransferEncoding($strValue)
	{
		$this->ContentTransferEncoding = $strValue;
	}
	
	/**
	* It configures the physical place where the file if finds in the server
	* @access		public
	*/	
	function setPath($strValue)
	{
		$this->Path = $strValue;
	}
	
	/**
	* It configures the real name of the archive in the server
	* @access		public
	*/	
	function setFileName($strValue)
	{
		$this->FileName = $strValue;
	}		
	
	/**
	* It configures the personalized name of the file 
	* (therefore it can be different of the located real name in the server)
	* @access		public
	*/	
	function setFileNameDown($strValue)
	{
		$this->FileNameDown = $strValue;
	}			
	
	/**
	* Init Download
	* @access		public
	*/	
	function send()
	{
		if(1==2)
		{
		$this->_setContentLength();
		header("Content-Type: " .  $this->ContentType); 	
		header("Content-Length: " .  $this->ContentLength);

		if ($this->FileNameDown == "")
			header("Content-Disposition: inline; filename=" . $this->FileName); 
		else
			header("Content-Disposition: inline; filename=" . $this->FileNameDown); 
					
			
		header("Content-Transfer-Encoding: binary");
		$fpath = $this->Path . "/" . $this->FileName;
		$fp = fopen($this->Path . "/" . $this->FileName, "r"); 
		//fpassthru($fp);
		readfile($fpath);
		fclose($fp);		
		
		
		//$this->force_download();
		}
		
		//$this->output($this->Path . "/" . $this->FileName);
		$this->download_file();
	}
	
	function download_file()
	{
		
$allowed_ext = array (

  // archives
  'zip' => 'application/zip',

  // documents
  'pdf' => 'application/pdf',
  'doc' => 'application/msword',
  'xls' => 'application/vnd.ms-excel',
  'ppt' => 'application/vnd.ms-powerpoint',
  
  // executables
  'exe' => 'application/octet-stream',

  // images
  'gif' => 'image/gif',
  'png' => 'image/png',
  'jpg' => 'image/jpeg',
  'jpeg' => 'image/jpeg',

  // audio
  'mp3' => 'audio/mpeg',
  'wav' => 'audio/x-wav',

  // video
  'mpeg' => 'video/mpeg',
  'mpg' => 'video/mpeg',
  'mpe' => 'video/mpeg',
  'mov' => 'video/quicktime',
  'avi' => 'video/x-msvideo'
);

		$fname = $this->FileName;
		$file_path = $this->Path . "/" . $this->FileName;
		
		// file size in bytes
		$fsize = filesize($file_path); 
		
		// file extension
		$fext = strtolower(substr(strrchr($fname,"."),1));
		
		// check if allowed extension
		if (!array_key_exists($fext, $allowed_ext)) {
		  die("Not allowed file type."); 
		}
		
		// get mime type
		if ($allowed_ext[$fext] == '') {
		  $mtype = '';
		  // mime type is not set, get from server settings
		  if (function_exists('mime_content_type')) {
			$mtype = mime_content_type($file_path);
		  }
		  else if (function_exists('finfo_file')) {
			$finfo = finfo_open(FILEINFO_MIME); // return mime type
			$mtype = finfo_file($finfo, $file_path);
			finfo_close($finfo);  
		  }
		  if ($mtype == '') {
			$mtype = "application/force-download";
		  }
		}
		else {
		  // get mime type defined by admin
		  $mtype = $allowed_ext[$fext];
		}
		
		// Browser will try to save file with this filename, regardless original filename.
		// You can override it if needed.
		
		  // remove some bad chars
		  $asfname = str_replace(array('"',"'",'\\','/'), '', $this->FileNameDown);
		  if ($asfname === '') $asfname = 'NoName';
		
		// set headers
		//15082007 - modifications - Start
		ob_end_clean(); //discard all informations that were stored in buffer so far, as this may be written along with the file that is to be downloaded..
		ob_start(); //start a new buffer memory
		//15082007 - modifications - End
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: $mtype");
		header("Content-Disposition: attachment; filename=\"$asfname\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $fsize);
		
		// download
		// @readfile($file_path);
		$file = @fopen($file_path,"rb");
		if ($file) {
		  while(!feof($file)) {
			print(fread($file, 1024*8));
			flush();
			if (connection_status()!=0) {
			  @fclose($file);
			  die();
			}
		  }
		  @fclose($file);
		}
		/*
		$file = ob_get_contents();
		echo $file;
		*/
		ob_end_flush();//output the information that were stored in the output buffer.
	}
	
	
	
	function force_download() 
	{ 
		$dir = $this->Path; 
		$file = $this->FileName;
		if ((isset($file))&&(file_exists($dir . "/" . $file))) { 
		   header("Content-type: application/force-download"); 
		   header('Content-Disposition: inline; filename="' . $dir . "/" . $file . '"'); 
		   header("Content-Transfer-Encoding: Binary"); 
		   header("Content-length: ".filesize($dir . "/" . $file)); 
		   //header('Content-Type: application/octet-stream'); 
		   //header('Content-Disposition: attachment; filename="' . $this->FileNameDown . '"'); 
		   readfile("$dir/$file"); 
		} else { 
		   echo "No file selected"; 
		} //end if 

	}//
	
	
	function output($filename)
	{
	
		/* Offer file for download and do some browser checks
		 * for correct download. */
		$agent = trim($_SERVER['HTTP_USER_AGENT']);
		if ((preg_match('|MSIE ([0-9.]+)|', $agent, $version)) ||
			(preg_match('|Internet Explorer/([0-9.]+)|', $agent, $version))) {
			header('Content-Type: application/x-msdownload');
			header('Content-Type: application/pdf');
			Header('Content-Length: ' . strlen($this->_buffer));
			if ($version == '5.5') {
				header('Content-Disposition: filename="' . $filename . '"');
			} else {
				header('Content-Disposition: attachment; filename="' . $this->FileNameDown . '"');
			}
		} else {
			Header('Content-Type: application/pdf');
			Header('Content-Length: ' . filesize($filename));
			Header('Content-disposition: attachment; filename=' . $filename);
		}
		readfile($filename);
	} 			

}

?>