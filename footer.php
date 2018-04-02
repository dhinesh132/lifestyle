<?php require_once(dirname(__FILE__) . '/templates/newsletter_signup.php'); ?>
      
    </div>
  </div><div class="footer maincon">
    <div class="footer1 w-clearfix">
      <div class="footlinks-blk">
        <div class="footlink-con"><a class="foot-title" href="#">About Us</a>
          <ul class="footlinklit">
          <?php
		  $sub_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style,UniqueKey","menu_type=4 and parent_id =1 and display_status=1 order by display_order"); 
		  while($sub_data = mysql_fetch_object($sub_res[0])){?>
              		 <li class="foot-list-item"><a class="footlinks" href="<?php echo $GLOBALS['site_config']['site_path'];?>index/<?php echo $sub_data->UniqueKey;?>"><?php echo display_field_value($sub_data,"Title");?></a></li>
               <?php } ?>
           
          </ul>
        </div>
        <div class="footlink-con"><a class="foot-title" href="#">Emblems</a>
          <ul class="footlinklit">
          <?php
		  $footer_fun_res = $db_con_obj->fetch_flds("functions", "*", "FunStatus =1 order by DisplayOrder DESC"); 
		  while($fun_data = mysql_fetch_object($footer_fun_res[0])){?>
                         <li class="foot-list-item"><a class="footlinks" href="<?php echo $GLOBALS['site_config']['site_path'];?>emblems/<?php echo $fun_data->UniqueKey;?>"><?php echo display_field_value($fun_data,"Name");?></a></li>
						<?php } ?>
        
          </ul>
        </div>
        <div class="big footlink-con"><a class="foot-title" href="#">Publications</a>
          <ul class="footlinklit">
          <?php 
            $footer_auth_res = $db_con_obj->fetch_flds("authors", "*", "AuthStatus =1 order by DisplayOrder DESC"); 	
              while($ftr_auth_data = mysql_fetch_object($footer_auth_res[0])){
         ?>
               <li class="foot-list-item"><a href="<?php echo $GLOBALS['site_config']['site_path'];?>publications/<?php echo $ftr_auth_data->UniqueKey;?>" class="footlinks"><?php echo display_field_value($ftr_auth_data,"Name");?></a></li>
          <?php }?>
          </ul>
        </div>
        <div class="footlink-con"><a class="foot-title" href="#">News &amp; Promotions</a>
          <ul class="footlinklit">
             <?php
		  $sub_res = $GLOBALS['db_con_obj']->fetch_flds("static_pages","Id,EnTitle,ChTitle,page_link,style,UniqueKey","menu_type=4 and parent_id =4 and display_status=1 order by display_order"); 
		  while($sub_data = mysql_fetch_object($sub_res[0])){?>
              		 <li class="foot-list-item"><a class="footlinks" href="<?php echo $GLOBALS['site_config']['site_path'];?>index/<?php echo $sub_data->UniqueKey;?>"><?php echo display_field_value($sub_data,"Title");?></a></li>
               <?php } ?>
          </ul>
        </div>
        <div class="footlink-con"><a class="foot-title" href="#">Other WayFengshui Sites</a>
          <ul class="footlinklit">
            <li class="foot-list-item"><a class="footlinks" href="https://wayfengshui.com/">Group</a></li>
            <li class="foot-list-item"><a class="footlinks" href="https://wayfengshui.com/consultancy">Consultancy</a></li>
            <li class="foot-list-item"><a class="footlinks" href="https://wayfengshui.com/academy">Academy</a></li>
          </ul>
        </div>
      </div>
      <div class="group-fioot-blk">
        <p><span class="small-text-foot">A member of</span><br><strong>WAY FENGSHUI GROUP</strong><br>CONSULTANCY . ACADEMY . LIFESTYLE<br><br>Empowering Harmony since 1984</p>
      </div>
    </div>
    <div class="footer2">
      <div><a href="#" class="copylinks">Privacy Policy</a>&nbsp;|&nbsp;<a class="copylinks">Terms and Conditions</a>&nbsp;| Copyright 2016 Way Fengshui</div>
    </div>
  </div>
 
  <script src="<?php echo $GLOBALS['site_config']['site_path']?>js/jquery.min.js" type="text/javascript"></script>
  
  <script src="<?php echo $GLOBALS['site_config']['site_path']?>js/way-fengsui.js" type="text/javascript"></script>
  <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>
</html>