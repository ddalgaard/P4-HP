<?php
//skal flyttes over i functions.php
require_once "dbConnect.php";

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql_del1="DELETE FROM `emp_skill` WHERE emp_id = $_POST[selectEmpName]";
$sql_del2="DELETE FROM `phone` WHERE emp_id = $_POST[selectEmpName]";
$sql_del3="DELETE FROM `address` WHERE emp_id = $_POST[selectEmpName]";
$sql_del4="DELETE FROM `emp` WHERE emp_id = $_POST[selectEmpName]";

$checkEmp = mysql_real_escape_string($_POST['selectEmpName']);

if ($checkEmp > 0)
{
    mysql_query($sql_del1);
    mysql_query($sql_del2);
    mysql_query($sql_del3);
    mysql_query($sql_del4);
}
?>