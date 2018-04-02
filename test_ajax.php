<script language="JavaScript" src="scripts/ajax.js"></script>

<span id="currency_fld"><form name="currency_form" method="post" action="" onSubmit=""><table width="100%" ><tr><td><font class="newsletter">Currency:</font><span id="currency_fld">
            <select name="currency" class="textfield" style="width:75;" onChange="get_dynamic_dropdown('currency_fld','ajax_content.php','required=set_currency&frm_fld_name=currency&selected_val=USD');">
            <option value="USD">USD</option>
            <option value="SGD">SGD</option>
            <option value="RM">RM</option> </select></span></td></tr></table></form>