<div class="invoice-info">
            <?php //print_r($_SESSION['ses_ship_bill_arr']); ?>
            <div class="invoice-info-blk w-clearfix">
              <div class="invoice-col1">
                <p><strong>BILL TO:</strong><br><?php 
			  echo stripslashes($_SESSION['ses_ship_bill_arr']['bfname'] . " " . $_SESSION['ses_ship_bill_arr']['blname']) . "<br>";
               echo stripslashes($_SESSION['ses_ship_bill_arr']['baddress1']) . ", ".stripslashes($_SESSION['ses_ship_bill_arr']['baddress2'])."<br>";
			   echo stripslashes($_SESSION['ses_ship_bill_arr']['bunit']) ;
			  if(strlen(trim($_SESSION['ses_ship_bill_arr']['bbuilding'])) > 0)
              echo  ", ".stripslashes($_SESSION['ses_ship_bill_arr']['bbuilding']) . ",<br>";
			  echo stripslashes($_SESSION['ses_ship_bill_arr']['bcity']).", ";
              echo $_SESSION['ses_ship_bill_arr']['bstate']."<br>";
              $bctry = $db_con_obj->fetch_field("country", "countryname", "countryid = '". $_SESSION['ses_ship_bill_arr']['bcountry'] . "'");

			  if(strlen($bctry) > 0)

			  echo stripslashes($bctry . "- " . $_SESSION['ses_ship_bill_arr']['bzip']);?>.
              <br /> <br />
			  <?php 
			  echo "Email :". $_SESSION['ses_ship_bill_arr']['bemail']."<br>";
			  echo "Mobile :". $_SESSION['ses_ship_bill_arr']['bmobile']."<br>";
			  if(strlen($_SESSION['ses_ship_bill_arr']['blandline']) >0)
			  echo "Landline :". $_SESSION['ses_ship_bill_arr']['blandline']."<br>";
			  ?></p>
              </div>
              <div class="invoice-col2">
                <p><strong>SHIP TO (IF DIFFERENT ADDRESS)</strong><br><?php 
			  echo stripslashes($_SESSION['ses_ship_bill_arr']['fname'] . " " . $_SESSION['ses_ship_bill_arr']['lname']) . "<br>";
              echo stripslashes($_SESSION['ses_ship_bill_arr']['saddress1']) . ", ".stripslashes($_SESSION['ses_ship_bill_arr']['saddress2'])."<br>";
			   echo stripslashes($_SESSION['ses_ship_bill_arr']['sunit']) ;
			  if(strlen(trim($_SESSION['ses_ship_bill_arr']['sbuilding'])) > 0)
              echo  ", ".stripslashes($_SESSION['ses_ship_bill_arr']['sbuilding']) . ",<br>";
			  echo stripslashes($_SESSION['ses_ship_bill_arr']['city']).", ";
			  echo $_SESSION['ses_ship_bill_arr']['state']."<br>";
              $bctry_res = $db_con_obj->fetch_flds("country", "countryname,countrycode", "countryid = '". $_SESSION['ses_ship_bill_arr']['country'] . "'");
			  $bctry_data = mysql_fetch_object($bctry_res[0]);
			  if(strlen($bctry) > 0)
			  echo stripslashes($bctry_data->countryname . " " . $_SESSION['ses_ship_bill_arr']['zip']);
			  ?>.
               <br /> <br />
			  <?php 
			   echo "Email :". $_SESSION['ses_ship_bill_arr']['email']."<br>";
			  echo "Mobile :". $_SESSION['ses_ship_bill_arr']['mobile']."<br>";
			  if(strlen($_SESSION['ses_ship_bill_arr']['landline']) >0)
			  echo "Landline :". $_SESSION['ses_ship_bill_arr']['landline']."<br>";
			  ?></p>
              </div>
            </div>
          </div>