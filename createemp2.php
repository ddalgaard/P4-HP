<?php
require_once "dbconnect.php";

if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
$sql="INSERT INTO `emp`(`first_name`, `last_name`, `email`) VALUES ('$_POST[txtFirstName]','$_POST[txtLastName]','$_POST[txtEmail]')";

 if ($mysqli_query($sql))
    {
    die('Error: ' . $mysqli_error());
    }
echo "great success!";
?>