<?php
session_start();
require_once "functions.php";
checkLogin();
if($_SESSION['loggedin'] == TRUE){

echo updateShift($shiftupdate);








}
?>