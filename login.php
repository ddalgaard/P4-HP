<?php
session_start();
// load database login data
require_once 'dbconnect.php';
require_once 'functions.php';



//Test basic sql connection

$db_server = mysql_connect($db_host, $db_username, $db_password);
if (!$db_server) {
die("Kan ikke forbinde til MySQL: " . mysql_error());
}

// define username and password as variables
$username=$_POST['empUsername'];
$password=$_POST['empPassword']; 

// mysql security protection (injection cleaner)
$username = stripslashes($username);
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
$password = hash('sha256', $password);



// check login information from login window to database for verification
$sql_query="SELECT * FROM $tbl_name WHERE username='$username' and password='$password'";
$query_result=mysql_query($sql_query);

// counts number of rows in the result to ensure that the inputdata is only one row
$count=mysql_num_rows($query_result);
if($count==1){
	// redirect if login is successfull
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	$_SESSION['loggedin'] = TRUE;
	
	// extract the value is_admin from login and send it with the session. 
	// If NULL it is an employee, if 1 it is an admin.
	// Used on pages to restrict access for normal users.
	while($row = mysql_fetch_array($query_result)){
	
		$_SESSION['isadmin'] = $row['is_admin'];
	}
	

	redirect('main.php');
	//header("location:main.php");
}
// post error message if the login data is wrong
else {

redirect('index.php');

//header("location:index.php");
}



?>







