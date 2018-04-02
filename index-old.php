<?php 
$from_page = "index";
require_once("header.php"); 
require_once("classes/banner_master.class.php");
$ban_obj = new banner_master();

?>
 <div id="slider">
    	<div class="slider-container">
        <ul id="accordion-slider">
        <?php 
		$ban_res = $GLOBALS['db_con_obj']->fetch_flds($ban_obj->cls_tbl,"*","ban_status=1 order by ban_id desc");
		while($ban_data = mysql_fetch_object($ban_res[0])){
			$banner_image = display_field_value($ban_data,"Banimage");
			$image_path = $ban_obj->attachment_path.$banner_image;
		?>
         	<li><a href="<?php echo $ban_data->ban_link?>" target="_blank"><img src="<?php echo $image_path?>" width="800" height="350" title="<?php echo $ban_data->ban_name?>" alt="<?php echo $ban_data->ban_name?>"/></a></li>
        <?php } ?>
        </ul>
        </div>
    </div>
    
 <div id="content">
    	<div class="left">
        	<?php 
			include("forms/future_product.php");
			include("forms/mostpopular_product.php");
			?>          
            
        </div>
        
        <div class="right">
        	<div class="sbrown-bg">
            	<div class="title-bar"><?php echo PRODUCTFINDER; ?></div>
                <form name="ProductFinder" id="ProductFinder" action="product_lists.php">
               <div>
                   <select class="select"  name="functions[]" >
                        <option value=""><?php echo SELECTFUNCTION; ?>:</option>
                        <?php
						$fun_res = $db_con_obj->fetch_flds("functions", "*", "1=1 and FunStatus =1 order by DisplayOrder desc"); 
						while($fun_data = mysql_fetch_object($fun_res[0])){
						?>
                        <option  value="<?php echo $fun_data->FunId?>"><?php echo display_field_value($fun_data,"Name")?></option>
                        <?php } ?>
                    </select>
                    
                </div>
                            
                <div>
                   <select class="select" title="Select one" name="materials[]">
                        <option value=""> <?php echo SELECTMATERIAL; ?>:</option>
                        <?php
						$mat_res = $db_con_obj->fetch_flds("materials", "*", "1=1 and MatStatus =1 order by DisplayOrder desc"); 
						while($mat_data = mysql_fetch_object($mat_res[0])){
						?>
                        <option  value="<?php echo $mat_data->MatId?>"><?php echo display_field_value($mat_data,"Name")?></option>
                        <?php } ?>
                    </select>
                    
                </div>
                
                <div>
                   <select class="select" title="Select one" name="types[]">
                        <option value=""> <?php echo SELECTTYPE; ?>:</option>
                       
                        <?php
						$type_res = $db_con_obj->fetch_flds("types", "*", "1=1 and TypeStatus =1 order by DisplayOrder desc"); 
						while($type_data = mysql_fetch_object($type_res[0])){
						?>
                      <option  value="<?php echo $type_data->TypeId?>"><?php echo display_field_value($type_data,"Name")?></option>
                        <?php } ?>
                    </select>
                    
                </div>
                
                <div>
                   <select class="select" title="Select one" name="price_range">
                        <option value=""> <?php echo SELECTPRICE;?>:</option>
                        <option value="0.1-10"> SGD 0.1 - SGD 10</option>
                        <option value="11-50"> SGD 11 - SGD 50</option>
                        <option value="51-100"> SGD 51 - SGD 100</option>
                        <option value="101-251"> SGD 101 - SGD 250</option>
                        <option value="251-500"> SGD 251 - SGD 500</option>
                        <option value="501-750"> SGD 501 - SGD 750</option>
                        <option value="751-1000"> SGD 751 - SGD 1000</option>
                    </select>
                </div>
                <input type="hidden" name="submit_action" value="index_filder" />
                </form>
             <a href="#" style="margin-left:90px; color:#807b5f" class="gradient-btn" onclick="$('#ProductFinder').submit()">GO!</a>
            </div>
            
            
            <div class="orange-bg">
            <script language="javascript">
			var frm_obj;
			function formSubmit()
			{
				 var sEmail = $('#email').val();
				 var sName = $('#name').val();
				 var Phone = $('#ContactNo').val();
				 var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				 if(jQuery.trim(sName) =='' || jQuery.trim(sName)=="<?php echo FULLNAME?>:"){
					 alert('Name should not be empty');
					 return false;
				 }
				 if(jQuery.trim(sEmail) =='' || jQuery.trim(sEmail)=="<?php echo EMAILADDRESS?>:"){
					 alert('Email should not be empty');
					 return false;
				 }
				 
				 if(jQuery.trim(Phone) =='' || jQuery.trim(Phone)=="<?php echo MOBILNUMBER?>:"){
					 alert('Contact number should not be empty');
					 return false;
				 }
				 else{
						$('#signup').submit();	
						//return true;	
				 }
			//document.getElementById("signup").submit();
			}
    		/*function check_validate2() 
			{
        		error_message = "";  
				check_empty(form.elements["name"].name,"Please enter your email!");
        		check_email(form.elements["email"].name,"Please enter your email!");
			}*/
			</script>
            <form name="signup"  id="signup" action="" method="post" >
            	<h1><?php echo SIGNUPNOW; ?>!</h1>
                <?php include("includes/error_message.php")?><br />
                <?php echo STAYCONNECTEDMEMBER; ?><br /><br />
                <?php echo SIGNUPASAMEMBER; ?><br /><br />
                <input type="text" id="name" name="name" value="<?php echo FULLNAME?>:" onClick="if(this.value=='<?php echo FULLNAME?>:') this.value='';" /><br />
                <input type="text" id="email" name="email" value="<?php echo EMAILADDRESS?>:" onClick="if(this.value=='<?php echo EMAILADDRESS?>:') this.value='';"  /><br />
                <input type="text" id="ContactNo" name="ContactNo" value="<?php echo MOBILNUMBER?>:" onClick="if(this.value=='<?php echo MOBILNUMBER?>:') this.value='';" /><br />
                <a href="javascript:void(0)" onclick="formSubmit();" style="margin:5px 0 0 90px; color:#807b5f" class="gradient-btn"><?php echo JOINNOW ?>!</a>
                <input type="hidden" name="action" value="subscribe" >
         		<input type="hidden" name="date_entered" value="<?php echo date("Y-m-d H:i:s"); ?>">
              </form>
            </div>
        </div>
    </div>   
    
<?

require_once("footer.php"); 

?>