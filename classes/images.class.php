<?php

class images
{

	//member varaibales for condition checking - Start
	
	var $file_arr;//set the file info to this var, that is set what is returned by $_FILES['fldname'] to this var
	
	var $file_type;//set the file type. can hold values img/files
	
	var $allowable_ext;//set extensions that are allowed
	
	var $file_size;//set file size in bytes that is to be uploaded
	
	var $img_height;//height of the image that is uploaded
	
	var $img_width;//width of the image that is uploaded
	
	var $img_error_msg;//error message for the file upload cases..
	
	var $img_attached_log_str;//attached file credentials

	var $img_modified_log_str;//uploaded file credentials

	//member varaibales for condition checking - End

	function images()
	{

		$this->file_size = $GLOBALS['site_config']['files_allowed_size'];

		$this->allowable_ext = $GLOBALS['site_config']['files_allowed_ext'];
		
		$this->img_error_msg = array();
		
		$this->img_attached_log_str = "";

		$this->img_modifiedlog_str = "";

	}

	/**********************************************************************************************

					Method To check the extension of the uploaded file.

	***********************************************************************************************/
	
	function check_extension($typ="images")
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD images::check_extension() - PARAMETER LIST : ', $param_array);

		$fname = explode(".", $this->file_arr['name']);
		
		$count = count($fname);
	
		$fext = $fname[$count-1];
		
		$boolean = false;
		
		if($typ == "images")
		$this->allowable_ext = $GLOBALS['site_config']['img_files_allowed_ext'];
		
		if(substr_count($this->allowable_ext, $fext) >= 1)
		{
			$boolean = true;
			$this->img_modifiedlog_str .= "<strong>Process [Check Extension]:</strong> Ok<br>";
		}
		else
		{
			if(!in_array("Upload a valid file, File extension is not allowed !!", $this->img_error_msg))
			$this->img_error_msg[] = "Upload a valid file, File extension is not allowed !!";
			
			$this->img_modifiedlog_str .= "<strong>Process [Check Extension]:</strong> Failed<br>";
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD images::check_extension() - Return Value : ', $boolean);
		
		return $boolean;
		
	}

	/**********************************************************************************************

					Method To check the size of the uploaded file.

	***********************************************************************************************/
	
	function check_size($sz=0)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD images::check_size() - PARAMETER LIST : ', $param_array);

		$boolean = true;
		
		if($sz == 0)
		$sz = $this->file_size;
		
		if($this->file_arr['size'] > $sz)
		{
			$boolean = false;
			if(!in_array("File size exceeds the limit $sz bytes !!", $this->img_error_msg))
			$this->img_error_msg[] = "File size exceeds the limit $sz bytes !!";
		}

		//07022008 - image log purpose - Start

		if($boolean)
			$this->img_modifiedlog_str .= "<strong>Checking Size:</strong> Allowed file size is " . $sz . " bytes. Uploaded File size is " . $this->file_arr['size'] . ". Satisfied.<br>";
		else
			$this->img_modifiedlog_str .= "<strong>Checking Size:</strong> Allowed file size is " . $sz . " bytes. Uploaded File size is " . $this->file_arr['size'] . ". Not Satisfied.<br>";

		//07022008 - image log purpose - End

		$GLOBALS['logger_obj']->debug('<br>METHOD images::check_size() - Return Value : ', $boolean);
		
		return $boolean;
		
	}

	/**********************************************************************************************

					Method To check the dimensions of the uploaded file.

	***********************************************************************************************/
	
	function check_dimension($chk_type="none", $param_height=0, $param_width=0)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD images::check_dimension() - PARAMETER LIST : ', $param_array);

		$boolean = true;
		
		list($width, $height, $type, $attr) = getimagesize($this->file_arr['tmp_name']);		
		
		switch ($chk_type)
		{
		
			case "both":
				
				if($height > $param_height || $width > $param_width)
				{
					$boolean = false;
					$err_msg = "Height/Width exceeds the limit, please upload a file of dimension (" . $param_width . " px w x " . $param_height . " px h) !!";
				}
				break;
				
			case "height":
				
				if($height > $param_height)
				{
					$boolean = false;
					$err_msg = "Height exceeds the limit, please upload a file of height " . $param_height . " px !!";
				}
				break;
				
			case "width":

				if($width > $param_width)
				{
					$boolean = false;
					$err_msg = "Width exceeds the limit, please upload a file of width " . $param_width . " px !!";
				}
				break;
				
		}

		if(!in_array($err_msg, $this->img_error_msg))
		$this->img_error_msg[] = $err_msg;

		//07022008 - image log purpose - Start

		if($boolean)
			$this->img_modifiedlog_str .= "<strong>Checking Dimension:</strong> Allowed file dimensions are " . $param_width . " px (w) * " . $param_height . " px (h). Uploaded File dimensions are " . $width . " px (w) * " . $height . " px (h). Satisfied.<br>";
		else
			$this->img_modifiedlog_str .= "<strong>Checking Dimension:</strong> Allowed file dimensions are " . $param_width . " px (w) * " . $param_height . " px (h). Uploaded File dimensions are " . $width . " px (w) * " . $height . " px (h). Not Satisfied.<br>";

		//07022008 - image log purpose - End

		$GLOBALS['logger_obj']->debug('<br>METHOD images::check_dimension() - Return Value : ', $boolean);
		
		return $boolean;
		
	}

	/**********************************************************************************************

					Method To upload the file and return the uploaded filename.

	***********************************************************************************************/
	
	function upload_file($obj, $fld_name, $file_type, $chk_what="s", $size=0, $height=0, $width=0)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD images::upload_file() - PARAMETER LIST : ', $param_array);


		$this->file_arr = $_FILES[$fld_name];

		$upload_file = 0;
		
		$error_str = "";
		
		//07022008 - log attached file details - Start
		
		$this->img_attached_log_str = "<strong>Attached File Credentials:</strong> ";
		
		foreach($this->file_arr as $key => $val)
		$this->img_attached_log_str .= $key . " = '" . $val . "', ";
		

		//07022008 - log attached file details - End

		//05042007 - Start
		$all_ext = true;
		
		if($file_type == "file")
			$all_ext = $this->check_extension("file");
		else
			$all_ext = $this->check_extension("images");
		
		$this->img_modifiedlog_str .= "<strong>Attributes to be checked:</strong> " . $chk_what . "<br>";
		
		if($all_ext)
		{//05042007 - allowed extension	
		
		switch ($chk_what)
		{
			
			case "s":
				$upload_file = $this->check_size($size);
				break;

			case "h":
				$upload_file = $this->check_dimension("height", $height);
				break;

			case "w":
				$upload_file = $this->check_dimension("width", 0, $width);
				break;

			case "sh":
				$upload_file = ($this->check_size($size) && $this->check_dimension("height", $height))?true:false;
				break;

			case "sw":
				$upload_file = ($this->check_size($size) && $this->check_dimension("width", 0, $width))?true:false;
				break;

			case "hw":
				$upload_file = $this->check_dimension("both", $height, $width);
				break;

			case "shw":
				$upload_file = ($this->check_size($size) && $this->check_dimension("both", $height, $width))?true:false;
				break;

		}
		
		$new_upload_file_name = "File Not Uploaded.";
		
		$resize_ret_arr = $new_upload_file_name;
		
		if($upload_file)
		{//file can be uploaded
			
			//13082007 - Special Characters Should not occur in uploaded filenames - Start
			$spl_char_arr = array("\\", "/", "'", "\"", " ", "?", "!", "(", ")", "%", "^", "@", "#", "$", "*", "[","]", ",", "+", "|");

			$file_name = stripslashes($this->file_arr['name']);

			for($i = 0; $i < count($spl_char_arr); $i++)
			$file_name = str_replace($spl_char_arr[$i], "", $file_name);
			
			//13082007 - Special Characters Should not occur in uploaded filenames - End
			
			$new_upload_file_name = $obj->cls_tbl . "_" . date("YmdHis") . "_" . $file_name;
			$new_upload_file_path = $obj->attachment_path . $new_upload_file_name;
			
			if (move_uploaded_file($this->file_arr['tmp_name'], $new_upload_file_path))
			{
		
				//07022008 - image log purpose - Start
		
				$this->img_modifiedlog_str .= "Uploading the attached file to the server.<br>";
		
				//07022008 - image log purpose - End
		
				@chmod($new_upload_file_path, 0777);
			}
			else
			{
		
				//07022008 - image log purpose - Start
		
				$this->img_modifiedlog_str .= "Unable to Upload the attached file to the server.<br>";
		
				//07022008 - image log purpose - End
		
				$ttext = "";
				$ttext .= "<table border=0 cellpadding=3 cellspacing=1 align=center width=90%>";
				$ttext .= "<tr align=left><td colspan='2'><strong>File Details - Following File has not been uploaded.</strong></td></tr>";
				$ttext .= "<tr align=left><td>Related Table</td><td>" . $obj->cls_tbl . "</td></tr>";
				$ttext .= "<tr align=left><td>Field Name</td><td>" . $fld_name . "</td></tr>";
				$ttext .= "</table>";
				
				$GLOBALS['logger_obj']->error('<br>METHOD images::upload_file() -  Value : ', $ttext, 'img');
			}

			$resize_ret_arr = $new_upload_file_name;
			
			if($obj->{$fld_name}['frm_fld_type'] == "imgcopy" && $obj->image_copies[$fld_name][0] > 0)
			{//resizing image
			
				//07022008 - image log purpose - Start
		
				$this->img_modifiedlog_str .= "<strong>Requirements:</strong> Image resizing required";
		
				//07022008 - image log purpose - End
		
				$copy_arr = explode(",", $obj->image_copies[$fld_name][1]);
				$resize_ret_arr = array();
				foreach($copy_arr as $resize_key => $resize_val)
				{
					
					$specific_dets = explode("|", $resize_val);
					
					$orig_img_n = $new_upload_file_name;
					$orig_img_pth = $new_upload_file_path;
					$new_img_n = $specific_dets[1] . "_" . $new_upload_file_name;
					$new_img_pth = $obj->attachment_path . $new_img_n;
					
					$allow_resize = true;
					
					if($obj->image_copies[$fld_name][2] == "resizeonlyifdimensionexceeds")
					{
					
						//07022008 - image log purpose - Start
				
						$this->img_modifiedlog_str .= " only if dimension exceeds";
				
						//07022008 - image log purpose - End
				
						$allow_resize = false;
						list($width, $height, $type, $attr) = getimagesize($orig_img_pth);
						if($width > $specific_dets[2] || $height > $specific_dets[3])
						$allow_resize = true;
					}

					
						//07022008 - image log purpose - Start
				
						$this->img_modifiedlog_str .= ".<br>";
				
						//07022008 - image log purpose - End
				
					if($allow_resize && $this->resize_image($orig_img_pth, $new_img_pth, $specific_dets[2], $specific_dets[3],$specific_dets[4]))
						
						$resize_ret_arr[$specific_dets[0]] = $new_img_n;
						
					else if(!$allow_resize)
					
						$resize_ret_arr[$specific_dets[0]] = $orig_img_n;
					
					else
						
						$resize_ret_arr[$specific_dets[0]] = 'Resizing Failed';
					
				}
				
				
				if($allow_resize && file_exists($new_upload_file_path))
				unlink($new_upload_file_path);
			
			}
			
		}
		else
		{
			$str = implode("<br>", $this->img_error_msg);
			frame_notices($str, "redfont");
		}

		$result = $resize_ret_arr;
		
		}//end if
		else
		{
			$str = implode("<br>", $this->img_error_msg);
			frame_notices($str, "redfont");
			$result = "File Not Uploaded.";//10042007
		}
		
		//07022008 - log file uploads - Start
		
		$final_log_str = $this->img_attached_log_str;
		$final_log_str .= $this->img_modifiedlog_str;
		
		$GLOBALS['logger_obj']->error('<br>METHOD images::upload_file() -  Value : ', $final_log_str, 'img');
		//07022008 - log file uploads - End
		
		$GLOBALS['logger_obj']->debug('<br>METHOD images::upload_file() - Return Value : ', $result);
		
		return $result;
		
	}//end function upload_file
	
	function resize_image($thimg, $newthumb, $wth=0, $ht=0, $exact_resize=1)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD images::resize_image() - PARAMETER LIST : ', $param_array);

		if($wth>$ht)
				$dimen = $wth;
		else
				$dimen = $ht;
				
		list($thwidth, $thheight, $thtype, $thattr) = getimagesize($thimg);
		$ext = pathinfo($thimg);

		if($thwidth>$thheight)
				$newper = $dimen/$thwidth;
		else
				$newper = $dimen/$thheight;
								
		if($exact_resize == 1)
		{
			$width = $wth;
			$height = $ht;
			
			$this->img_modifiedlog_str .= "<strong>Attached image dimensions:</strong> " . $thwidth . " px (w) * " . $thheight . " px (h), Required Dimension: " . $wth . " px (w) * " . $ht . " px (h). Force resizing.";
		
		}
		else
		{
			$width = round($thwidth*$newper);
			$height = round($thheight*$newper);
			
			$this->img_modifiedlog_str .= "<strong>Attached image dimensions:</strong> " . $thwidth . " px (w) * " . $thheight . " px (h), Required Dimension: " . $wth . " px (w) * " . $ht . " px (h). Resized to proportional dimension: " . $width . " px (w) * " . $height . " px (h). Resizing proportianally.";
		
		}				
	
		if(strcasecmp($ext["extension"], "jpg") == 0 || strcasecmp($ext["extension"], "jpeg") == 0)
		{
			$image_p = imagecreatetruecolor($width, $height);
			$image = imagecreatefromjpeg($thimg);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $thwidth, $thheight);
			$ret = imagejpeg($image_p,$newthumb);
		}

		if(strcasecmp($ext["extension"], "gif")==0)
		{
				$image_p = imagecreatetruecolor($width, $height);
				$image = imagecreatefromgif($thimg);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $thwidth, $thheight);
				$ret = imagegif($image_p,$newthumb);
		}

		if(strcasecmp($ext["extension"], "png")==0)
		{
				$image_p = imagecreatetruecolor($width, $height);
				$image = imagecreatefrompng($thimg);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $thwidth, $thheight);
				$ret = imagepng($image_p,$newthumb);
		}

		chmod($newthumb, 0777);

		$GLOBALS['logger_obj']->debug('<br>METHOD images::resize_image() - Return Value : ', $ret);
		
		return $ret;

	}
	
	function resize_image1($thimg, $newthumb, $wth=0, $ht=0)
	{
		
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD images::resize_image() - PARAMETER LIST : ', $param_array);

		if($wth>$ht)
				$dimen = $wth;
		else
				$dimen = $ht;
				
		list($thwidth, $thheight, $thtype, $thattr) = getimagesize($thimg);
		$ext = pathinfo($thimg);

		if($thwidth>$thheight)
				$newper = $dimen/$thwidth;
		else
				$newper = $dimen/$thheight;
								
		$width = $wth;
		$height = $ht;
						
		$this->img_modifiedlog_str .= "<strong>Attached image dimensions:</strong> " . $thwidth . " px (w) * " . $thheight . " px (h), Required Dimension: " . $wth . " px (w) * " . $ht . " px (h). Force resizing.";
	
		if(strcasecmp($ext["extension"], "jpg") == 0 || strcasecmp($ext["extension"], "jpeg") == 0)
		{
			$image_p = imagecreatetruecolor($width, $height);
			$image = imagecreatefromjpeg($thimg);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $thwidth, $thheight);
			$ret = imagejpeg($image_p,$newthumb);
		}

		if(strcasecmp($ext["extension"], "gif")==0)
		{
				$image_p = imagecreatetruecolor($width, $height);
				$image = imagecreatefromgif($thimg);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $thwidth, $thheight);
				$ret = imagegif($image_p,$newthumb);
		}

		if(strcasecmp($ext["extension"], "png")==0)
		{
				$image_p = imagecreatetruecolor($width, $height);
				$image = imagecreatefrompng($thimg);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $thwidth, $thheight);
				$ret = imagepng($image_p,$newthumb);
		}

		chmod($newthumb, 0777);

		$GLOBALS['logger_obj']->debug('<br>METHOD images::resize_image() - Return Value : ', $ret);
		
		return $ret;

	}

}





?>
