<form name="book_list_frm" method="post" action="" onSubmit="return check_form(window.document.books_list_frm);">
<script language="JavaScript">
var bool_select = 0;
var select_name = '';
function check_validate()
{

	error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";
	
	if(bool_select == 0)
	{
		error_message += "* Please select appropriate book";
		error = true;
	}
	
	if(!error)
	{
		do
		{
		select_name = select_name.replace('#sq#',"'");
		} while(select_name.indexOf('#sq#') != -1);
		
		window.opener.document.<?php echo $prod_obj->frm_name; ?>.book_file.value=select_name;
		window.opener.focus();
		window.close();
	}
}
</script>
<table border="0" cellspacing="0" cellpadding="0" align="center">
<tr align="center"><td colspan="26"><strong>Select the alphabets to view the book names starting with that character.</strong></td></tr>
<tr><td height="5"></td></tr>
        <tr align="center"> 
          <?php for($i=65; $i < 91; $i++) { ?>
          <td width="20" align="center"><a href="choose_books.php?char=<?php echo chr($i); ?>"><?php echo chr($i); ?></a></td>
          <?php } ?>
        </tr>
      </table><br>
<table align="center" cellpadding="5" width="560" cellspacing="0" class="tableborder_new">
  <tr class="maincontentheading"> 
    <td align="center" colspan="2">Select appropriate book</td>
  </tr>
  <tr> 
    <?php
require_once("../classes/file.matrixpaging.class.php");

$location = $prod_obj->books_path;

$path = opendir($location);
 
$disp_char = strtolower($_REQUEST['char']);

if(strlen($disp_char) <= 0)
$disp_char = "a";
 
?>
    <?php 


    $pg_rows = 10;
	$no_col = 2;

	$ctr = 0;
	  $file_array= array();
  $time_array=array();
while(false!==($file=readdir($path)))
	{
	
	if($file!="." && $file!="..") 
		{
		if(is_file($location . $file))
			{
			    if(strtolower(substr($file,0,1)) == $disp_char)
				{
					$ctr++;
					$file_array[]=$file;
				}
			}
		} // end of if
	} //end of while
    
	sort($file_array);

 	$i = 0;
	
 //   echo $ctr;


				
$path = opendir($location);
      								$tctr = 0;
      								$temp_ctr = 0;
      								$frm = $_REQUEST['frm'];
      								$temp_ctr = $frm * ($pg_rows * $no_col);
 foreach ($file_array as $keyval => $value)
   {
			$tctr++;								    
				if($tctr > $temp_ctr)
				{
	
				     $i++;   
?>
    <td> <table width="280" border="0" cellspacing="5" cellpadding="3">
        <tr> 
          <td><input type="radio" name="bk_name" value="<?php echo str_replace("'","#sq#",$value); ?>" onClick="bool_select = 1; select_name=this.value"></td>
          <td><?php echo $value; ?></td>
        </tr>
      </table></td>
    <?php
	
	}
	
                          if($tctr == ($temp_ctr + ($pg_rows*$no_col)))
                          break;

    if ($i==$no_col) // to show the no of templates in a row
	 {
	  $i=0;
	  ?>
  </tr>
  <tr> 
    <?php

					
		}//end if ($i==3)
			

   }//end for
	
	if($ctr	> 0)
	{
?>
  <tr>
    <td align="center" colspan="2"><input type="image" src="../templates/godess/images/select_book.jpg" border="0" style="border: 0px;"></td>
  </tr>
  <?php } ?>
  <tr> 
    <td align="center" colspan="2"> 
      <?php 
  				if($ctr	== 0)
				{
					echo "<font class='redfont'>Sorry, no books found starting with the character </font><strong>" . strtoupper($disp_char) . "</strong><font class='redfont'> !!</font>";
				}
				else
				{
  				
     		        $paging_cls = new filematrixpaging($ctr,($pg_rows*$no_col),11,$no_col);
			 		$paging_cls->print_prev();
					$paging_cls->print_numbered_links();
					$paging_cls->print_next();
					$paging_cls->print_pages_of(); 
				}	
					?>
    </td>
  </tr>
</table>
</form>