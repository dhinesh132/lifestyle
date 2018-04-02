<?php




class filematrixpaging
{

//Member Variables - Start

	var $num_of_rows;

	var $num_of_pages;

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

	var $mat_cols;


//Member Variables - End

//Start Constructor

	function filematrixpaging($number_of_rows, $paging_rows=0, $break_numbers=0,$cols=0)
	{
	
		$this->num_of_rows = $number_of_rows;

		$this->mat_cols = $cols;

		if($paging_rows > 0)
			$this->paging_rows = $paging_rows;
		else
		{
			if(file_exists("connections/mainread.php"))
				require_once("connections/mainread.php");
			else
				require_once("../connections/mainread.php");
			
			$cnf=new configRead();
			
			if(file_exists("connections/mainread.php"))
				$cnf->configfile("connections/main.php");
			else
				$cnf->configfile("../connections/main.php");

			$paging_rows = $cnf->getConfigValue("PAGEROW");
			$this->paging_rows = $paging_rows;
		}
		
		$this->num_of_pages = ceil($this->num_of_rows/$this->paging_rows);
		
		$this->prev_text = "Previous";
		
		$this->next_text = "Next";
		
		$this->prev_text_style = "click";
		
		$this->next_text_style = "click";
		
		$this->curr_pg_style = "formprod";
		
		$this->other_pg_style = "click";
		
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

	}

//End Constructor

	function frame_url()
	{
	
		$temp_arr = explode("?", $this->url);
		
		$cur_page = $temp_arr[0] . "?";
		
		foreach ($_REQUEST as $key => $value)
		{
			if($key != "frm")
			$cur_page .= $key . "=" . $value . "&";
		}
		
		$this->url = $cur_page;

	}
	
	function find_limit()
	{
		
		$temp_frm = @$_REQUEST['frm'];
		
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
		return $return_value;
				
	
	}
	
	function print_prev()
	{
		
		$temp_frm = @$_REQUEST['frm'];
		$temp_arr = $this->find_limit();
		if($temp_frm >= ($this->break_numbers - 1))
		{
			
			$temp_url = $this->url;
			//$temp_url .= "frm=" . ($temp_frm - 1);
			$temp_url .= "frm=" . $temp_arr[0];
			echo "&nbsp;<a href='" . $temp_url . "' class='" . $this->prev_text_style . "'>" . $this->prev_text . "</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		
		}

	}

	function print_next()
	{
		
		$temp_frm = @$_REQUEST['frm'];
		
		if($temp_frm <= 0)
		$temp_frm = 0;
		
		if($this->mat_cols > 0)
		  $temp_frm = $temp_frm * $this->mat_cols;
		  
		
		$temp_arr = $this->find_limit();
		/*
		print_r($temp_arr);
		echo $this->num_of_pages . "<hr>";
		*/
		if($temp_arr[1] <= ($this->num_of_pages - 1))
		{
			$temp_url = $this->url;
			//$temp_url .= "frm=" . ($temp_frm + 1);
			$temp_url .= "frm=" . $temp_arr[1];
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . $temp_url . "' class='" . $this->next_text_style . "'>" . $this->next_text . "</a>&nbsp;";
		
		}

	}



	function print_numbered_links()
	{
	
			$temp_url = $this->url;
			
			$temp_frm = @$_REQUEST['frm'];
			
			if($temp_frm <= 0)
			$temp_frm = 0;
		if($this->mat_cols > 0 && 1 == 2)
		  $temp_frm = $temp_frm * $this->mat_cols;
			
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

				$new_temp_url = $temp_url . "frm=" . $i;
				
				if($temp_frm == $i)
				
					$link_class = $this->curr_pg_style;
				
				else
				
					$link_class = $this->other_pg_style;
				
				if($temp_frm == $i)
				
					echo "&nbsp;<a class='" . $link_class . "'>" . ($i + 1) . "</a>&nbsp;";
				
				else
				
					echo "&nbsp;<a href='" . $new_temp_url . "' class='" . $link_class . "'>" . ($i + 1) . "</a>&nbsp;";
			
			}

	}


	function print_pages_of()
	{
		
		$temp_frm = @$_REQUEST['frm'];
		
		if($temp_frm <= 0)
		$temp_frm = 1;
		else
		$temp_frm += 1;
		
		echo "<p><span class='" . $this->pages_of_style . "'>Page: " . $temp_frm . "/" . $this->num_of_pages . "</span></p>";
	
	}
	

} //end class

/*
Sample to use

$paging_cls = new paging(1030, 10, 11);

$paging_cls->print_prev();

$paging_cls->print_numbered_links();

$paging_cls->print_pages_of();

$paging_cls->print_next();

*/

?>