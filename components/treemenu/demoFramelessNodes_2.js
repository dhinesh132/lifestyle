//
// Copyright (c) 2006 by Conor O'Mahony.
// For enquiries, please email GubuSoft@GubuSoft.com.
// Please keep all copyright notices below.
// Original author of TreeView script is Marcelino Martins.
//
// This document includes the TreeView script.
// The TreeView script can be found at http://www.TreeView.net.
// The script is Copyright (c) 2006 by Conor O'Mahony.
//
// You can find general instructions for this file at www.treeview.net.
//

USETEXTLINKS = 1
STARTALLOPEN = 0
USEFRAMES = 0
USEICONS = 0
WRAPTEXT = 1
PRESERVESTATE = 1
HIGHLIGHT = 1

//
// The following code constructs the tree.  This code produces a tree that looks like:
// 
// Tree Options
//  - Expand for example with pics and flags
//    - United States
//      - Boston
//      - Tiny pic of New York City
//      - Washington
//    - Europe
//      - London
//      - Lisbon
//  - Types of node
//    - Expandable with link
//      - London
//    - Expandable without link
//      - NYC
//    - Opens in new window
//

//foldersTree = gFld("<b>Imperial Tea Court</b>", "index.php?jtmenu=3")
 foldersTree = gFld("<table><tr><td background=\"../components/treemenu/bgcol.gif\" width=\"190\" height=\"25\">&nbsp;<b>" + company_name + "</b></td></tr></table>", "")
  //foldersTree.treeID = "Frameless"
  foldersTree.treeID = "FramelessHili"
  aux1 = insFld(foldersTree, gFld("Products/Publications", "javascript:undefined"))
  	aux2 = insFld(aux1, gFld("Manage Types", "types.php"))
	aux2 = insFld(aux1, gFld("Manage Materials", "materials.php"))
	aux2 = insFld(aux1, gFld("Manage Functions", "functions.php"))
	aux2 = insFld(aux1, gFld("Manage Products", "products.php"))
	aux2 = insFld(aux1, gFld("Manage Authors", "authors.php"))
	aux2 = insFld(aux1, gFld("Manage Publications", "publications.php"))
  aux1 = insFld(foldersTree, gFld("Masthead Images", "banner_master.php"))
  aux1 = insFld(foldersTree, gFld("Subscriber", "subscriber.php"))
  aux1 = insFld(foldersTree, gFld("Pages", "static_pages.php"))
  aux1 = insFld(foldersTree, gFld("Orders", "javascript:undefined"))
  	aux2 = insFld(aux1, gFld("Current Orders", "orders.php"))
	//aux2 = insFld(aux1, gFld("Orders History", "orders_master_backup.php?del_ses=1"))
  aux1 = insFld(foldersTree, gFld("Manage Customers", "customers.php"))
  aux1 = insFld(foldersTree, gFld("Settings", "javascript:undefined"))
    aux2 = insFld(aux1, gFld("General Settings", "subadmin_settings.php"))
	aux2 = insFld(aux1, gFld("Change Password", "admin.php?submit_action1=add&admin_id=<?php echo $_SESSION['ses_admin_id']; ?>"))
	aux2 = insFld(aux1, gFld("Payment Settings", "payment_settings.php"))
	//aux2 = insFld(aux1, gFld("Product Settings", "byfocal_settings_detail_frm.php"))
	aux2 = insFld(aux1, gFld("Shipping Info", "shipping_settings.php"))
	aux2 = insFld(aux1, gFld("Shipping Details", "shipping_details.php"))
/* aux1 = insFld(foldersTree, gFld("Search", "javascript:undefined"))
    aux2 = insFld(aux1, gFld("Frame Search", "frame_search.php"))
	aux2 = insFld(aux1, gFld("Customer Search", "customer_search.php"))
 aux1 = insFld(foldersTree, gFld("Manage News", "news_master.php"))*/
 aux1 = insFld(foldersTree, gFld("Manage Admin", "admin.php"))
 aux1 = insFld(foldersTree, gFld("Notification", "javascript:undefined"))
	aux2 = insFld(aux1, gFld("User informed about product QTY", "prod_qty_notify.php"))
	aux2 = insFld(aux1, gFld("Minimum quantity products", "minimum_qty_products.php"))
aux1 = insFld(foldersTree, gFld("Logout", "logout.php"))
   


  
