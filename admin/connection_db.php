<?
function dbConnect()
{
 $dbName = "spex4eye_db"; 
    $dbCon = @mysql_connect("localhost", "root", "") or die("Could not connect to the database<BR><BR>Error:" . mysql_error());
	$dbChoose = mysql_select_db($dbName) or die("Could not select to the database<BR><BR>Error:" . mysql_error());
	
//$objcon = mysql_connect("216.51.232.120", "1367", "c1e2d3a5r6") or die("Could not connect to Mysql") ;
 //	mysql_select_db("db2310") or die("Database not found"); 

}
?>