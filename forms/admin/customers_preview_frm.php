<?php 

require_once("../classes/customers.class.php");

$cust_obj = new customers();

if($edit == 1 && $edit_id > 0)
{
	
	$res = $cust_obj->fetch_record($edit_id);
	$cust_obj = set_values($cust_obj, "db", $res[0]);

}


?>

<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0" class="tableborder_new">
          <tr class="maincontentheading"> 
            <td height="29" colspan="2" align='center' class='whitefont_header'> 
             User Details</td>
          </tr>
          
          <tr valign="top" > 
            <td width="50%" class="postaddcontent"><span class="whitefont">First Name</span></td>
            <td width="50%"><?php echo stripslashes($cust_obj->cust_firstname['value']); ?>  
            </td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Last Name</span></td>
            <td><?php echo stripslashes($cust_obj->cust_lastname['value']); ?> 
            </td>
          </tr>
           <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Chinese Name</span></td>
            <td><?php echo stripslashes($cust_obj->cust_chinesename['value']); ?> 
            </td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Recommented By</span></td>
            <td><?php echo stripslashes($cust_obj->cust_recom_by['value']); ?></td>
          </tr>
           <tr  class="maincontentheading"> 
            <td colspan="2" height="30" align='center'><span class='whitefont_header'>Particulars</span></td>
          </tr> 
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Address Line 1</span></td>
            <td><?php echo stripslashes($cust_obj->cust_address1['value']); ?> 
            </td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Address Line 2</span></td>
            <td><?php echo stripslashes($cust_obj->cust_address2['value']); ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">City</span></td>
            <td><?php echo stripslashes($cust_obj->cust_city['value']); ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">State</span></td>
            <td> 
              <?php
			      $tmp_state = $cust_obj->cust_state['value'];
				  if(is_numeric($cust_obj->cust_state['value']) && $cust_obj->cust_state['value'] > 0)
				  {
				    $tmp_state=$GLOBALS[db_con_obj]->fetch_field("state","statename","stateid='" . $cust_obj->cust_state['value'] . "'");
				  }
				    echo $tmp_state;
				  ?>
            </td>
          </tr>
          <tr valign="top" > 
            <td height="31" class="postaddcontent"><span class="whitefont">Country</span></td>
            <td> 
                          <?php
			      $tmp_country = $cust_obj->cust_country['value'];
				  if(is_numeric($cust_obj->cust_country['value']) && $cust_obj->cust_country['value'] > 0)
				  {
				    $tmp_country=$GLOBALS[db_con_obj]->fetch_field("country","countryname","countryid='" . $cust_obj->cust_country['value'] . "'");
				  }
				    echo $tmp_country;
				  ?>

            </td>
          </tr>
          <tr valign="top" > 
            <td height="33" class="postaddcontent"><span class="whitefont">Zip Code</span></td>
            <td><?php echo stripslashes($cust_obj->cust_zip['value']); ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Mobile</span></td>
            <td><?php echo stripslashes($cust_obj->cust_phone['value']); ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Landline</span></td>
            <td><?php echo stripslashes($cust_obj->cust_landline['value']); ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Office Phone</span></td>
            <td><?php echo stripslashes($cust_obj->cust_office['value']); ?></td>
          </tr>
           <tr  class="maincontentheading"> 
            <td colspan="2" height="30" align='center'><span class='whitefont_header'>More About You</span></td>
          </tr> 
         <!-- <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">IC/Passport</span></td>
            <td><?php echo stripslashes($cust_obj->cust_ic['value']); ?></td>
          </tr> -->
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Date of Birth</span></td>
            <td><?php echo $cust_obj->cust_dob_month['value']." ".$cust_obj->cust_dob_day['value'].", ".$cust_obj->cust_dob_year['value']; ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Profession</span></td>
            <td><?php echo stripslashes($cust_obj->cust_profession['value']); ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Income Level</span></td>
            <td><?php echo stripslashes($cust_obj->cust_income['value']) ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Register From</span></td>
            <td><?php echo ucfirst(stripslashes($cust_obj->cust_register_from['value'])) ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Register for Newsletter and promotion</span></td>
            <td><?php 
			if($cust_obj->cust_newsletter['value'] ==1)
				echo "yes";
		     else
			    echo "No";
			 ?></td>
             
          </tr
		  <tr>
		    <td colspan="2" height=8px>&nbsp;
			</td>
		  </tr>
          <tr  class="maincontentheading"> 
            <td colspan="2" height="30" align='center'><span class='whitefont_header'>Login 
              Information</span></td>
          </tr> 
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">User Name/Email</span></td>
            <td><?php echo stripslashes($cust_obj->cust_email['value']); ?></td>
          </tr>
          <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Password</span></td>
            <td>***************</td>
          </tr> 
		  <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Created On</span></td>
            <td> <?php echo convert_date(stripslashes($cust_obj->cust_create_datetime['value']),"m/d/Y h:i:s"); ?>  </td>
          </tr> 
		   <tr valign="top" > 
            <td class="postaddcontent"><span class="whitefont">Modified On</span></td>
            <td> <?php echo convert_date(stripslashes($cust_obj->cust_modify_datetime['value']),"m/d/Y h:i:s"); ?> </td>
          </tr> 
           <tr> 
				<td align="center" colspan="2"><a href="#"> <img border="0" align="absmiddle" src="../images/close.jpg" onClick="window.close();"></a>
				</td>
            </tr>
          <tr> 
            <td colspan="2" height="8px"> </td>
          </tr>
        </table>
		
		<?php 
		
		$temp_window_tilte = stripslashes($cust_obj->cust_firstname['value'])." ".stripslashes($cust_obj->cust_lastname['value']); 
		
		?>	  
 