<form name="forget_pwd_frm" method="post" action="cust_forgotpassword1.php" onSubmit="return check_form_pwd(window.document.forget_pwd_frm);">
            <table width="94%" border="0">
              <tr>
                <td colspan="2"><font class="login">Forget Password</font></td>
              </tr>
              <tr>
                <td width="31%"><font class="login_fld">email : </font></td>
                <td width="69%" align="left"><input type="text" name="email" class="textfield" style="width:140px; height:18px;"></td>
              </tr>
               <tr>
                <td width="31%" height="10" colspan="2"></td>
               
              </tr>
              <tr>
                <td colspan="2" align="right" style="padding-right:20px;"><img src="images/buttons/close.jpg" value="Cancel" onclick="tb_remove()" />&nbsp;&nbsp;<input type="image" src="images/buttons/submit1.jpg" style="border:0px;" name="Submit2" value="Submit"><input type="hidden" name="submit_action" value="login">
                <input type="hidden" name="submit_action" value="send_fpwd"></td>
              </tr>
            </table> 
            </form>
