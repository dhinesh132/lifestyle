<?php 

$frm_page = "login";

require_once("admin_header.php"); 



require_once("../classes/admin.class.php"); 



$mobj = new admin();





$submit_action = $_REQUEST['submit_action'];



switch ($submit_action)

{



	case "login":
	
		include("../captcha/securimage.php");

		$img = new Securimage();

		$valid = $img->check($_POST['code']);
		
		if($valid == true) {

			if($mobj->login())
				$redirect_url = "static_pages.php";
			else
				$redirect_url = "index.php";
		}
		else{
			frame_notices("Sorry, Incorrect security code. Please try again!!", "redfont");
			$redirect_url = "index.php";
		}

		header("location:$redirect_url");

		exit();			

		break;



}//end switch



?>



 <h1>Administrator Login</h1>

<table <?php echo $inner_table_param; ?>>

  <tr>

    <td>

	<?php require_once("../includes/error_message.php"); ?>

      <table width="60%" border="0" cellspacing="0" cellpadding="2" align="center">

              <form name="login_frm" method="post" action="" onSubmit="return check_form(window.document.login_frm);">

        <tr> 

          <td> 

		

<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0" class="listing">

                <script language="javascript">

function check_validate() {

        error_message = "Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n";

        check_empty(form.elements["admin_uname"].name,"Username should not be empty");

        check_empty(form.elements["admin_password"].name,"Password should not be empty");
		
		 check_empty(form.elements["code"].name,"Security code should not be empty");

}

</script>

               

                <tr> 

                  <td><span class="whitefont">Username</span></td>

                  <td><input name="admin_uname" type="text" class="mediumtxtbox"></td>

                </tr>

                <tr> 

                  <td><span class="whitefont">Password</span></td>

                  <td><input name="admin_password" type="password" class="mediumtxtbox"></td>

                </tr>
                
                <tr> 

                  <td><span class="whitefont">Security Code</span></td>

                  <td>                     <div ><img id="cimage" align="left" style="padding-right: 5px; border: 0" src="../captcha/securimage_show.php?sid=<?php echo md5(time()) ?>" />

        <div style="margin-right:10px; margin-bottom:10px;"><a tabindex="-1" style="float:right;border-style: none; margin-top:15px;" href="#" title="Refresh Image" onClick="document.getElementById('cimage').src = '../captcha/securimage_show.php?sid=' + Math.random(); return false"><img src="../captcha/images/refresh.gif" alt="Reload Image" border="0" onClick="this.blur()" align="bottom" /></a></div></div><br /><input name="code" type="text" class="mediumtxtbox"></td>

                </tr>
                

                <tr align="center"> 

                  <td colspan="2"> 

                    <input type="submit" name="Submit" value="Submit" > 

                    <input type="hidden" name="submit_action" value="login">

                  </td>

                </tr>

              </table></td>

        </tr>

		

              </form>

        <tr> 

            <td align="center">&nbsp; </td>

        </tr>

       

      </table>

	</td>

  </tr>

</table>





<?php 



require_once("admin_footer.php"); 



?>