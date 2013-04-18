
<?php

// establish connection and login to mysql database

$db_host="db8.meebox.net";	

$db_username="root";

$db_password="congobajer2013";

$db_name="final";

$tbl_name="login";
 


// connect to mysql database

mysql_connect("$db_host", "$db_username", "$db_password")or die("cannot connect");

mysql_select_db("$db_name")or die("cannot select DB");

mysql_query("SET NAMES utf8");

mysql_query("SET character_set_results=’utf8′");

?>

