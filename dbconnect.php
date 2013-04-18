
<?php

// establish connection and login to mysql database

$db_host="db8.meebox.net";	

$db_username="root";

$db_password="";

$db_name="calendar";

$tbl_name="login";
 


// connect to mysql database

mysql_connect("$db_host", "$db_username", "$db_password")or die("cannot connect");

mysql_select_db("$db_name")or die("cannot select DB");

mysql_query("SET NAMES utf8");

mysql_query("SET character_set_results=’utf8′");

?>

