<?php
	//Start sessions
session_start();
require_once 'dbconnect.php';
require_once 'functions.php';
checkLogin();
?>
<html>
	<head>
		<title>CTRL-ALL-SHIFTS</title>
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body>

		<div id="container">
			<ul id="menu">
				<li><a href="">Main</a></li>
				<li><a href="calendar.php">Calendar</a></li>
				<li><a href="">Bulletin</a></li>
				<li><a href="">Settings</a></li>
				<li><a href="">About</a></li>
				<li><a href="http://swps-dev.cgasberg.dk/log_out.php">Logout</a></li>
			</ul>
			
			<div id="totalworksch">
				<table id="my_shifts" class="shifts_table">
					<thead>
						<tr>
							<th colspan="7"> Shifts this week </th>
						</tr>
					</thead>
					<tbody>
						<tr class="table_boldtext"> 
							<td>Monday</td>
							<td>Tuesday</td>
							<td>Wednesday</td>
							<td>Thursday</td>
							<td>Friday</td>
							<td>Saturday</td>
							<td>Sunday</td>
						</tr>				
		                    <?php 
		                    	// spans 4 rows
		                    	//echo returnEventsOnID();
		                    ?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>