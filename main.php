<?php
	//Start sessions
session_start();
require_once 'dbconnect.php';
require_once 'functions.php';
checkLogin();

// If the URL contains 'takeShift=yes', grab the shiftID and empID from the URL and execute takeShift() function.
if(isset($_GET['takeShift']) == 'yes'){

    $shiftID = $_GET['shiftID'];
    $empID = $_GET['empID'];

    takeShift($shiftID, $empID);
}
?>


<html>
<head> 
</head>
<body>
<?php
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

	<span id="hello_user">
		<?php echo returnHelloUser(); ?>
	</span>

	<div id="container">
		<ul id="menu">
			<li><a href="">Main</a></li>
			<li><a href="calendar.php">Calendar</a></li>
			<li><a href="">Bulletin</a></li>
			<li><a href="">Settings</a></li>
			<li><a href="">About</a></li>
			<li><a href="http://swps-dev.cgasberg.dk/log_out.php">Logout</a></li>
		</ul> 

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
	</div>
</body>
</html>



<?php


}

else {
	
		echo "Du er ikke logget ind";
		echo "<a href='http://swps-dev.cgasberg.dk/'></br> Klik her for at logge ind!</a>";

	}
	
	
	
?>
</body>
</html>