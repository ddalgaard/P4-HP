<?php
	//Start sessions
session_start();
require_once 'dbconnect.php';
require_once 'functions.php';


?>


<html>
<head> 
</head>
<body>

<html>
<head>
	<title>CTRL-ALL-SHIFTS</title>
	<link href="css/main.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>

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
				</tr>
                    <?php 
                    	returnWeeklySchedule();
                    ?>
			</tbody>
		</table>

</body>
</html>


</body>
</html>