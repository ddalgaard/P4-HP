
<?php

// Establish connection and login to mysql database
$db_host="db8.meebox.net";	
$db_username="cgasberg_swpsdev@web8.meebox.net";
$db_password="congobajer2013";
$db_name="cgasberg_swps-final";
$tbl_name="login";

// Connect to mysql database
mysql_connect("$db_host", "$db_username", "$db_password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");
mysql_query("SET NAMES utf8");
mysql_query("SET character_set_results=’utf8′");

?>

