<?php


class paging extends database_manipulation
{

//Member Variables - Start

	var $num_of_rows;

	var $num_of_pages;
	
	//17082007 - page navigation should be done via form submission - Start
	var $use_javascript;

	var $javascript_function;
	//17082007 - page navigation should be done via form submission - End

	var $prev_text;

	var $next_text;

	var $prev_text_style;

	var $next_text_style;

	var $curr_pg_style;

	var $other_pg_style;

	var $break_numbers;
	
	var $paging_rows;
	
	var $pages_of_style;
	
	var $url;
	
	var $resultset;

	var $start_index;

	var $end_index;

	var $page_key_val;

//Member Variables - End

//Start Constructor

	function paging($qry, $paging_rows=0, $break_numbers=0, $is_qry=1, $page_key_val="frm")
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::paging() - PARAMETER LIST : ', $param_array);
		
		$this->page_key_val = $page_key_val;
		
		if($is_qry == 1)
		{
			$result = database_manipulation::execute_sql($qry);
			$this->resultset = $result[0];
			$number_of_rows = $result[1];
		}
		else
		{
			$number_of_rows = $qry;
		}
		$this->num_of_rows = $number_of_rows;
		if($paging_rows > 0)
			$this->paging_rows = $paging_rows;
		else
		{
			if($GLOBALS['in_admin'] == 1)
				$this->paging_rows = $GLOBALS['site_config']['admin_paging_rows'];
			else
				$this->paging_rows = $GLOBALS['site_config']['paging_rows'];
		}
		
		//17082007 - start
		$this->use_javascript = false;
		
		$this->javascript_function = "";
		//17082007 - end
		
		$this->num_of_pages = ceil($this->num_of_rows/$this->paging_rows);
		
		$this->prev_text = "Previous";
		
		$this->next_text = "Next";
		
		$this->prev_text_style = "pagelink";
		
		$this->next_text_style = "pagelink";
		
		$this->curr_pg_style = "currentpagelink";
		
		$this->other_pg_style = "pagelink";
		
		if($break_numbers > 0)
		{
			$this->break_numbers = $break_numbers;
		}
		else
		{
			$this->break_numbers = 11;
		}
		
		$this->url = $_SERVER['REQUEST_URI'];
		
		$this->pages_of_style = "formprod";
		
		$this->frame_url();

		if(isset($_REQUEST[$this->page_key_val])==false)
			$frm=0;
		else
			$frm=$_REQUEST[$this->page_key_val];

		$this->start_index = ($frm * $this->paging_rows);
//		$this->end_index = ($this->start_index + $this->paging_rows);
//		if($this->num_of_rows > $this->paging_rows)
		if($this->num_of_rows > ($this->start_index + $this->paging_rows))
			$this->end_index = ($this->start_index + $this->paging_rows);
		else
			$this->end_index = $this->num_of_rows;


		$GLOBALS['logger_obj']->debug('<br>METHOD paging::paging() - RETURN VALUE : ', 'Constructor Returning Void');

	}

//End Constructor

	function frame_url()
	{

		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::frame_url() - PARAMETER LIST : ', $param_array);

		$temp_arr = explode("?", $this->url);
		
		$cur_page = $temp_arr[0] . "?";
		
		foreach ($_REQUEST as $key => $value)
		{
			if($key != $this->page_key_val && strtoupper($key) != "PHPSESSID")
			$cur_page .= $key . "=" . $value . "&";
		}
		
		$this->url = $cur_page;

		$GLOBALS['logger_obj']->debug('<br>METHOD paging::frame_url() - RETURN VALUE : ', 'Returning Void');

	}
	
	function find_limit()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::find_limit() - PARAMETER LIST : ', $param_array);

		$temp_frm = @$_REQUEST[$this->page_key_val];
		
		if($temp_frm <= 0)
		$temp_frm = 0;

  	if($temp_frm < ($this->break_numbers - 1))
  	{
			$prev_lnk_frm = 0;
  		$next_link_frm = $this->break_numbers - 1;
  	}
		else
		{
		  $prev_link_frm = 0;
		  $next_link_frm = 0;
			for($i = 0; $i < $this->num_of_pages; $i++)
			{
		
				if(($i%($this->break_numbers - 1)) == 0 && $i >= ($temp_frm))
				{
				
					$prev_link_frm = ($i - ($this->break_numbers - 1));
					
					if($prev_link_frm <= 0)
					$prev_link_frm = 0;
					
					$next_link_frm = ($i + ($this->break_numbers - 1));
					
					if(($temp_frm%($this->break_numbers - 1)) != 0)
					{
						$prev_link_frm -= ($this->break_numbers - 1);
						$next_link_frm = $prev_link_frm + (2 * ($this->break_numbers - 1));
					}
					
					//echo $i . " - " . $this->break_numbers . "<hr>";
					break;
				
				}
				
			}
			
			if($prev_link_frm == 0 && $next_link_frm == 0)
			{
				
				$next_link_frm = $this->num_of_pages;
				
				$temp_var = ($this->num_of_pages%($this->break_numbers - 1));
				
				
				$prev_link_frm = ($this->num_of_pages - $temp_var) - ($this->break_numbers - 1);
			
			}
		}
		
		$return_value = array($prev_link_frm, $next_link_frm);
		//print_r($return_value);

		$GLOBALS['logger_obj']->debug('<br>METHOD paging::find_limit() - RETURN VALUE : ', $return_value);

		return $return_value;
	}
	
	function print_prev()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_prev() - PARAMETER LIST : ', $param_array);

		$temp_frm = @$_REQUEST[$this->page_key_val];
		$temp_arr = $this->find_limit();
		if($temp_frm >= ($this->break_numbers - 1))
		{
			
			$temp_url = $this->url;
			//$temp_url .= "frm=" . ($temp_frm - 1);
			$temp_url .= $this->page_key_val."=" . $temp_arr[0];
			if($this->use_javascript)
				echo "&nbsp;<a href='#' onclick='" . $this->javascript_function . "(\"" . $temp_arr[0] . "\");' class='" . $this->prev_text_style . "'>" . $this->prev_text . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			else
				echo "&nbsp;<a href='" . $temp_url . "' class='" . $this->prev_text_style . "'>" . $this->prev_text . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_prev() - RETURN VALUE : ', 'Returning Void');

	}

	function print_next()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_next() - PARAMETER LIST : ', $param_array);

		$temp_frm = @$_REQUEST[$this->page_key_val];
		
		if($temp_frm <= 0)
		$temp_frm = 0;
		
		$temp_arr = $this->find_limit();

		if($temp_arr[1] <= ($this->num_of_pages - 1))
		{
			$temp_url = $this->url;
			//$temp_url .= "frm=" . ($temp_frm + 1);
			$temp_url .= $this->page_key_val."=" . $temp_arr[1];
			if($this->use_javascript)
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='" . $this->javascript_function . "(\"" . $temp_arr[1] . "\");' class='" . $this->next_text_style . "'>" . $this->next_text . "</a>&nbsp;";
			else
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . $temp_url . "' class='" . $this->next_text_style . "'>" . $this->next_text . "</a>&nbsp;";
		
		}

		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_next() - RETURN VALUE : ', 'Returning Void');

	}



	function print_numbered_links()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_numbered_links() - PARAMETER LIST : ', $param_array);

			$temp_url = $this->url;
			
			$temp_frm = @$_REQUEST[$this->page_key_val];
			
			if($temp_frm <= 0)
			$temp_frm = 0;
			
			$start_index = 0;

			$end_index = ($this->break_numbers - 1);
			
			$temp_val = ($temp_frm % $end_index);

			if($temp_val == 0)
			{

				$start_index = $temp_frm;

				$end_index = ($temp_frm + $this->break_numbers - 1);

			}
			else
			{
				
				$start_index = $temp_frm - $temp_val;
				
				if($start_index <= 0)
				$start_index = 0;
				
				$end_index = ($start_index + $this->break_numbers - 1);
			
			}
			
			
			if($end_index  >= $this->num_of_pages)
			$end_index = $this->num_of_pages;
			
			for($i = $start_index; $i < $end_index; $i++)
			{

				$new_temp_url = $temp_url . $this->page_key_val . "=" . $i;
				
				if($temp_frm == $i)
				
					$link_class = $this->curr_pg_style;
				
				else
				
					$link_class = $this->other_pg_style;
				if($this->use_javascript)
				{
					if($temp_frm == $i)
					
						echo "&nbsp;<a class='" . $link_class . "'>" . ($i + 1) . "</a>&nbsp;";
					
					else
					
						echo "&nbsp;<a href='#' onclick='" . $this->javascript_function . "(\"" . $i . "\")' class='" . $link_class . "'>" . ($i + 1) . "</a>&nbsp;";
				}
				else
				{
					if($temp_frm == $i)
					
						echo "&nbsp;<a class='" . $link_class . "'>" . ($i + 1) . "</a>&nbsp;";
					
					else
					
						echo "&nbsp;<a href='" . $new_temp_url . "' class='" . $link_class . "'>" . ($i + 1) . "</a>&nbsp;";
				}
			
			}

		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_numbered_links() - RETURN VALUE : ', 'Returning Void');

	}


	function print_pages_of()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_pages_of() - PARAMETER LIST : ', $param_array);

		$temp_frm = @$_REQUEST[$this->page_key_val];
		
		if($temp_frm <= 0)
		$temp_frm = 1;
		else
		$temp_frm += 1;
		
		if($this->num_of_pages > 0)
		echo "<p><span class='" . $this->pages_of_style . "'>Page: " . $temp_frm . "/" . $this->num_of_pages . "</span></p>";
	
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_pages_of() - RETURN VALUE : ', 'Returning Void');

	}
	
	function print_previous_page()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_previous_page() - PARAMETER LIST : ', $param_array);

		$temp_frm = @$_REQUEST[$this->page_key_val];
		
		if($temp_frm <= 0)
		$temp_frm = 0;
		
		
		$temp_url = $this->url;
		if($temp_frm > 0)
		$temp_url .= $this->page_key_val . "=" . ($temp_frm - 1);
		
		if($temp_frm > 0)
		{
			if($this->use_javascript)
			{
			echo "&nbsp;<a href='#' onclick=\"" . $this->javascript_function . "('" . ($temp_frm - 1) . "');\" class='" . $this->prev_text_style . "'>" . $this->prev_text . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			else
			{
			echo "&nbsp;<a href='#' onclick=\"window.location.href='" . $temp_url . "';\" class='" . $this->prev_text_style . "'>" . $this->prev_text . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
		
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_previous_page() - RETURN VALUE : ', 'Returning Void');

	}
	
	function print_next_page()
	{
		$param_array = func_get_args();
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_next_page() - PARAMETER LIST : ', $param_array);

		$temp_frm = @$_REQUEST[$this->page_key_val];
		
		if($temp_frm <= 0)
		$temp_frm = 0;
		
		$temp_frm += 1;
		
		$temp_url = $this->url;
		//$temp_url .= "frm=" . ($temp_frm + 1);
		$temp_url .= $this->page_key_val . "=" . $temp_frm;

		if($temp_frm < $this->num_of_pages)
		{
			if($this->use_javascript)
			{
			echo "&nbsp;<a href='#' onclick=\"" . $this->javascript_function . "('" . $temp_frm . "');\" class='" . $this->next_text_style . "'>" . $this->next_text . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			else
			{
			echo "&nbsp;<a href='#' onclick=\"window.location.href='" . $temp_url . "';\" class='" . $this->next_text_style . "'>" . $this->next_text . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
		$GLOBALS['logger_obj']->debug('<br>METHOD paging::print_next_page() - RETURN VALUE : ', 'Returning Void');

	}
	

} //end class

/*
Sample to use

$paging_cls = new paging('select * from category', 1, 3);


for($i=$paging_cls->start_index;$i<$paging_cls->end_index;$i++)
{
  if(mysql_data_seek($paging_cls->resultset,$i))
  {
  	$data = mysql_fetch_object($paging_cls->resultset);  
  }
  else
  {
  	unset($data);
  }
  
  if(isset($data))
  {
  echo $data->res_id."<br>";
  }
  
}


$paging_cls->print_prev();

$paging_cls->print_numbered_links();

$paging_cls->print_pages_of();

$paging_cls->print_next();

*/

?>


