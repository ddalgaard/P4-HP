<?php
// Start session. Always need to be set first!
session_start();
// Load database login data
require_once 'dbconnect.php';
require_once 'functions.php';

// Test basic sql connection.
$db_server = mysql_connect($db_host, $db_username, $db_password);
if (!$db_server) {
	die("Cannot connect to MySQL: " . mysql_error());
}

// Define typed username and password as variables.
$username=$_POST['empUsername'];
$password=$_POST['empPassword']; 

// MySQL security protection (injection cleaner) + hashing of password.
$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

/* In case someone gets access to the database we have encrypted the password by using the function
“hash” and a  custom algorithm in this case ‘sha256’. The data in the variable is changed to a numbers
and characters so it  will be unreadable to anyone who either gets access to the database or
successfully retrieves the passwords. */
$password = hash('sha256', $password);

// Check login information from login window to database for verification
/* This is where where the MySQL query compares the entered data with the data already in the database.
If the result of MySQL query is a match on this case the output gives 1 it will start three session
called username and password, the last session is set to TRUE which is the session that shows that the
user has successfully logged in. After the sessions have been created the user is send to the main.php file. */
$sql_query="SELECT * FROM $tbl_name WHERE username='$username' and password='$password'";
$query_result=mysql_query($sql_query);

// Counts number of rows in the result to ensure that the input data is only one row (count ==1).
$count=mysql_num_rows($query_result);
if($count==1){
	// Redirect if login is successful.
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;
	$_SESSION['loggedin'] = TRUE;
	
	// Extract the value is_admin from login and send it with the session.
	// If NULL it is an employee, if 1 it is an admin.
	// Used on pages to restrict access for normal users.
	while($row = mysql_fetch_array($query_result)){
			$_SESSION['isadmin'] = $row['is_admin'];
	}
	
	// Redirect to main page.
	redirect('main.php');
}

// Post error message if the login data is wrong.
else {

redirect('index.php');

}
?>







