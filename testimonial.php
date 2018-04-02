<?php 

require_once("header.php"); 

require_once("classes/testimonial_master.class.php");

$testimonial_obj = new testimonial_master();

?>
<table <?php echo $inner_table_param; ?>>
  <tr>
    <td width="98%">	<?php require_once("includes/error_message.php"); ?>

	<table border="0" cellpadding="0" cellspacing="0" rules="rows" width="100%"><tr><td><strong class="addtocart">Testimonials</strong></td><td align="right"><a href="testimonial_details.php">Add Testimonial</a></td></tr></table><br />
<table border="0" cellpadding="0" cellspacing="0"  width="100%">
  <?php
  

	$qry = "select posted_by, testimonial_text, address from " . $testimonial_obj->cls_tbl . " where testimonial_status = 1 order by testimonial_id";
$paging_cls = new paging($qry,10);
unset($_SESSION['ses_testimonial_master_obj']);
//echo $paging_cls->start_index ." - " . $paging_cls->end_index . "<hr>";

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
/* if(file_exists("../includes/admin_alternate_color.php"))
  include("../includes/admin_alternate_color.php");
  else
  include("includes/admin_alternate_color.php");
  */
?>
<tbody>
<tr>
<td align="left" ><p class="conte">

<?php  echo stripslashes($data->testimonial_text); ?><br />
<strong ><?php  echo stripslashes($data->posted_by); ?><br /><?php  echo stripslashes($data->address); ?></strong></p></td>
</tr>
<tr><td>&nbsp;</td></tr>
  <?php

  
  }
  
}


if($paging_cls->num_of_rows <= 0)
{
?>
  <tr> 
    <td colspan="5" algin='center'> <font class='redfont'>No Records Available !!.</font></td>
  </tr>
  <?php

}

?>
</table>
<br>
<table cellpadding="0" cellspacing=0 border="0" width="80%" align="center"> 
 <!-- <tr> 
    <td colspan="5" align="center"><span class="hintstyle">Note : To delete a 
      testimonial_master it should not contain any products in it.</span></td>
  </tr> -->
  <tr>
	  <td height=5px>
	  </td>
  </tr>
  <tr> 
    <td align="center" width="33%"> 
      <?php
	
	
$paging_cls->print_prev();


	
	
	?>
    </td>
    <td colspan="3" align="center" width="34%"> 
      <?php
	
$paging_cls->print_numbered_links();

$paging_cls->print_pages_of();

	
	?>
    </td>
    <td align="center" width="33%"> 
      <?php
	
	$paging_cls->print_next();

	
	?>
    </td>
  </tr>
</table>
		      </td>
  </tr>
</table>
<?php

require_once("footer.php"); 

?>