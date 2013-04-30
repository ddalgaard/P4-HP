<?php
//Start sessions
session_start();
require_once 'dbconnect.php';
require_once 'functions.php';
checkLogin();

// If the URL contains 'takeShift=yes', grab the shiftID and empID from the URL and execute takeShift() function.
if(!empty($_POST['takeShift-submit'])){
    checkIfShiftsConflict($_POST['shiftId'], $_POST['empId']);
    }

	//Tjekker om sessions username og loggedin er sat. Hvis de er, må man blive på siden med denne funktion, eller redirectes man tilbage til login.
if($_SESSION['loggedin'] == TRUE){



?>

<html>
	<head>
		<title>CTRL-ALL-SHIFTS</title>
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body>

		<?php include("includes/helloUser.php");?>
		<div id="container">
			<?php include("includes/menu.php");?>
			
			<table id="my_shifts" class="shifts_table">
				<thead>
					<tr>
						<th colspan="4"> My Shifts </th>
					</tr>
				</thead>
				<tbody>
					<tr class="table_boldtext"> 
						<td>Start time</td>
						<td>End time</td>
						<td>Function</td>
						<td>Notes</td>
					</tr>				
	                    <?php 
	                    	// spans 4 rows
	                    	echo returnEventsOnID();
	                    ?>
				</tbody>
			</table>

			<table id="free_shifts" class="shifts_table">
				<thead>
					<tr>
						<th colspan="5"> Free Shifts </th>
					</tr>
				</thead>
				<tbody>
					<tr class="table_boldtext"> 
						<td>Start time</td>
						<td>End time</td>
						<td>Function</td>
						<td colspan="2">Notes</td>
					</tr>
	                    <?php 
	                    	echo returnFreeEvents();
	                    ?>
				</tbody>
			</table>
		</div>
	</body>
</html>








<?php

}

else {
		echo "Du er ikke logget ind";
		echo "<a href='index.php'></br> Klik her for at logge ind!</a>";
	}
?>
