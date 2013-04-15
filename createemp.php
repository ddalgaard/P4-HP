<?php
//alt dette skal naturligvis flyttes over i functions.php
require_once "dbConnect.php";

if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
$sql_1="INSERT INTO `emp`(`first_name`, `last_name`, `email`) VALUES ('$_POST[txtFirstName]','$_POST[txtLastName]','$_POST[txtEmail]')";
$sql_2="INSERT INTO `address`(`emp_id`, `street`, `zip_code`) VALUES (LAST_INSERT_ID(),'$_POST[txtAddress]','$_POST[txtZip]')";
$sql_3="INSERT INTO `phone`(`emp_id`,`phone_no`) VALUES (LAST_INSERT_ID(),'$_POST[txtPhone]')";
$sql_4="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$_POST[selectWorkFunction1]')";
$sql_5="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$_POST[selectWorkFunction2]')";
$sql_6="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$_POST[selectWorkFunction3]')";

$checkWorkFunction2 = mysql_real_escape_string($_POST['selectWorkFunction2']);
$checkWorkFunction3 = mysql_real_escape_string($_POST['selectWorkFunction3']);

mysql_query($sql_1);
mysql_query($sql_2);
mysql_query($sql_3);
mysql_query($sql_4);
    if ($checkWorkFunction2 > 0)
    {
        mysql_query($sql_5);
    }
    if ($checkWorkFunction3 > 0)
    {
        mysql_query($sql_6);
    }
?>
