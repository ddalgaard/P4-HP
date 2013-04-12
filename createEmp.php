<?php

//function createEmp(){

$userFirstName          =    mysql_real_escape_string($_POST['txtFirstName']);
$userLastName           =    mysql_real_escape_string($_POST['txtLastName']);
//$userAddress            =    mysql_real_escape_string($_POST['txtAddress']);
//$userZip                =    mysql_real_escape_string($_POST['txtZip']);
$userEmail              =    mysql_real_escape_string($_POST['txtEmail']);
//$userPhone              =    mysql_real_escape_string($_POST['txtPhone']);
//$userWorkFunction1    =    mysql_real_escape_string($_POST['selectWorkFunction1']);
//$userWorkFunction2    =    mysql_real_escape_string($_POST['selectWorkFunction2']);
//$userWorkFunction3    =    mysql_real_escape_string($_POST['selectWorkFunction3']);

if(isset($_POST['createUser']) == 'yes'){
    $sql_query ="INSERT INTO `emp`(`first_name`, `last_name`, `email`) VALUES ('$userFirstName','$userLastName','$userEmail')";
                   //"INSERT INTO `address`(`emp_id`, `street,zip_code`) VALUES (LAST_INSERT_ID(),'$userAddress','$userZip')";
                   //"INSERT INTO `phone`(`emp_id`, `phone_no`) VALUES (LAST_INSERT_ID(),'$userPhone')";
                   // "INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(),'$userWorkFunction1')";
    executeQuery($sql_query);
};
?>
