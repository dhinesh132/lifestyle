<?php
require_once("classes/product_master.class.php");

$prod_obj = new product_master();
?><table width="732" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><!--option table starts--><table width="732" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="14" id="t_left1"></td>
                    <td width="712" id="t_middle1"></td>
                    <td width="10" id="t_right1"></td>
                  </tr>
                  <tr>
                    <td colspan="3" >
<table id="option_cont" width="732" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  id="left1"></td>
                        <td height="176" ><form name="search_frm" action="" method="post" ><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td style="border-right:solid 1px #f6f6f6;" width="26%" valign="top"><table style="border-right:solid 1px #e2e2e2;" width="98%" border="0" align="right" cellpadding="0" cellspacing="0">
                              <tr>
                                <td height="50" class="cont">Browse Frames by:<br />
                                  PRICE CATEGORY</td>
                              </tr>
                              <tr>
                                <td height="40"><table id="tag" width="45%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="6%"><img src="images/tag_left.gif" width="7" height="32" /></td>
                                      <td align="center" width="91%" background="images/tagbg.gif"><?php
									  if(isset($_REQUEST['price']))
									   echo "US$".$_REQUEST['price'];
									   else if(isset($_REQUEST['price1'])&& isset($_REQUEST['price2']))
									   echo "US$".$_REQUEST['price1']." - ".$_REQUEST['price2'];
									else
										echo "NULL";								  
									  ?></td>
                                      <td width="3%"><img src="images/tag_right.gif" width="5" height="32" /></td>
                                    </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td height="50" class="cont">Browse Frames by:<br />
                                  FRAME TYPE</td>
                              </tr>
                              <tr>
                                <td height="45"><table id="tag" width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="6%"><img src="images/tag_left.gif" width="7" height="32" /></td>
                                      <td align="center" width="91%" background="images/tagbg.gif"><?php 
									  if(isset($_REQUEST['frame_id']))
									  echo $framename = $GLOBALS['db_con_obj']->fetch_field("frame_master","frame_name","frame_id='".$_REQUEST['frame_id']."'");
									  else if(isset($_SESSION['ses_temp_search_obj']['frame_type']))
									  echo $framename = $GLOBALS['db_con_obj']->fetch_field("frame_master","frame_name","frame_id='".$_SESSION['ses_temp_search_obj']['frame_type']."'");
									  else
									  echo "NULL";
									  
									  ?></td>
                                      <td width="3%"><img src="images/tag_right.gif" width="5" height="32" /></td>
                                    </tr>
                                </table></td>
                              </tr>
                            </table></td>
                            <td width="74%"><table width="97%" border="0" align="right" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="32%" class="cont">Further Filter by:</td>
                                    <td width="30%">&nbsp;</td>
                                    <td width="28%">&nbsp;</td>
                                    <td width="10%">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="30" class="cont">FRAME TYPE</td>
                                    <td class="cont">MATERIAL</td>
                                    <td class="cont">GENDER / STYLE</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="30"><?php	  $frame_dd_name = "frame_type";
				  
				  $select_option = $_SESSION['ses_temp_search_obj']['frame_type'];
				  
				  $frma_default_selection = false;
				
				  
				  if(file_exists("../includes/frame_dropdown.php"))
				  
				  	require_once("../includes/frame_dropdown.php");
					
				else
				
				  	require_once("includes/frame_dropdown.php");
				  
				  ?>                                      </td>
                                    <td><?php	  $mat_dd_name = "mat_type";
				  
				  $select_option = $_SESSION['ses_temp_search_obj']['mat_type'];
				  
				  $frma_default_selection = false;
				
				  
				  if(file_exists("../includes/mat_dropdown.php"))
				  
				  	require_once("../includes/mat_dropdown.php");
					
				else
				
				  	require_once("includes/mat_dropdown.php");
				  
				  ?></td>
                                    <td><?php	  $gen_dd_name = "gen_type";
				  
				  $select_option = $_SESSION['ses_temp_search_obj']['gen_type'];
				  
				  $gen_default_selection = false;
				
				  
				  if(file_exists("../includes/gen_dropdown.php"))
				  
				  	require_once("../includes/gen_dropdown.php");
					
				else
				
				  	require_once("includes/gen_dropdown.php");
				  
				  ?></td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="30"><span class="cont">COLOR</span></td>
                                    <td><?php $color_dd_name = "color";
				  				  $text = "Color 1";
				  $select_option = $_SESSION['ses_temp_search_obj']['color'];				  
				  $gen_default_selection = false;
				
				  
				  if(file_exists("../includes/color_dropdown.php"))
				  
				  	include("../includes/color_dropdown.php");
					
				else
				
				  	include("includes/color_dropdown.php");
				  
				  ?></td>
                                    <td>&nbsp;</td>
                                    <td><a href="#"><input type="image" src="images/go.gif" width="44" height="23" border="0" /></a><input type="hidden" name="submit_action" value="search" /></td>
                                  </tr>
                                  <tr>
                                    <td height="30"><span class="cont">View items by:</span></td>
                                    <td><label>
                                      <select name="tot_rec" >
                                       <option value="6" <?php if($_SESSION['ses_temp_search_obj']['tot_rec'] ==6) {?>selected ="selected"<?php }?>>6 Items</option>
                                      <option value="12" <?php if($_SESSION['ses_temp_search_obj']['tot_rec'] ==12) {?>selected ="selected"<?php }?>>12 Items</option>
                                       <option value="24" <?php if($_SESSION['ses_temp_search_obj']['tot_rec'] ==24) {?>selected ="selected"<?php }?>>24 Items</option>
                                       <option value="48" <?php if($_SESSION['ses_temp_search_obj']['tot_rec'] ==48) {?>selected ="selected"<?php }?>>48 Items</option>
                                       <option value="1000" <?php if($_SESSION['ses_temp_search_obj']['tot_rec'] ==1000) {?>selected ="selected"<?php }?>>All available Items</option>
                                       
                                      </select>
                                    </label></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  
                                </table></td>
                              </tr>
                              
                             <!-- Previous code
                             
                             <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="29%" height="45" class="cont">View items by:</td>
                                    <td width="11%" class="cont"><input type="radio" name="tot_rec" value="2" style="border:0px;"  checked="checked" />6</td>
                                    <td width="10%" class="cont"><input type="radio" name="tot_rec" value="4" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['tot_rec'] ==4) {?> checked="checked"<?php }?> />12</td>
                                    <td width="9%" class="cont"><input type="radio" name="tot_rec" value="8" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['tot_rec'] ==8) {?> checked="checked"<?php }?> />24</td>
                                    <td width="41%"><input type="radio" name="tot_rec" value="1000" style="border:0px;" <?php if($_SESSION['ses_temp_search_obj']['tot_rec'] =="1000") {?> checked="checked"<?php }?> /><span class="link_1">View All Available Items</span></td>
                                  </tr>
                                </table></td>
                              </tr>-->
                            </table></td>
                          </tr>
                        </table></form></td>
                        <td id="right1"></td>
                      </tr>
                    </table></td>
                    </tr>
                  <tr>
                    <td id="b_left1"></td>
                    <td id="b_middle1"></td>
                    <td id="b_right1"></td>
                  </tr>
                </table>
                  <!--option table end--></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><!--product table starts-->