<?php
//skal flyttes over i functions.php
require_once "dbConnect.php";

function deleteEmp($emp_id){
	$sql_del1="DELETE FROM `emp_skill` WHERE emp_id = $emp_id";
	$sql_del2="DELETE FROM `phone` WHERE emp_id = $emp_id";
	$sql_del3="DELETE FROM `address` WHERE emp_id = $emp_id";
	$sql_del4="DELETE FROM `emp` WHERE emp_id = $emp_id";

	$checkEmp = mysql_real_escape_string($emp_id);

	if ($checkEmp > 0)
	{
	    mysql_query($sql_del1);
	    mysql_query($sql_del2);
	    mysql_query($sql_del3);
	    mysql_query($sql_del4);
	}
}
?>