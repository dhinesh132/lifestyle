<div class="right">
        	<div class="title-header">
            	<img src="images/t-member.jpg" alt="" />
            </div>
            	<div class="registration">
                <script language="javascript">
					var frm_obj;
					function MainloginFormSubmit()
					{
						 var sEmail = $('#email').val();
						 var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
						 if(jQuery.trim(sEmail) =='' || jQuery.trim(sEmail)=="<?php echo EMAILADDRESS?>:"){
							 alert('Email should not be empty');
							 return false;
						 }
						 
						 else{
								$('#login').submit();	
								//return true;	
						 }
					}
					
					</script>
                <h1><?php echo FORGOTPWD?></h1><br />
                <?php  require_once("includes/error_message.php");?>
                  <form name="login"  id="login" action="" method="post" >
       
				  <table width="685px">
                  <div id="sign-in">
                       <div class="sign-left">
                         <h1><?php echo SENDPWD;?></h1><br />
                         
                         <?php echo IDOREMAIL;?> : <input type="text" id="email"  name="email"/><br /><br />
                          <input type="hidden" name="submit_action" value="send_fpwd">
                         <a href="#" style="margin-left:80px;" onclick="MainloginFormSubmit();" class="orage_gradient-btn"> &nbsp;<?php echo strtoupper(SUBMIT);?></a>
                         </div>
                        
                         <div class="sign-right">
                         <h1><?php echo LOGINREGISTER;?></h1><br />
                         <font style="font-size:16px"><?php echo DONTHAVEACCOUNT;?>?</font><br /><br />
                         
                         <a href="register.php" class="gradient-btn"><?php echo SIGNUPNOW;?></a>
                         
                        </div>
                    </div>
    			  </table>
   				 </form>
   	 </div> 
 </div>