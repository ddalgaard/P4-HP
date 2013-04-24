<?php
	//Start sessions
session_start();
require_once 'dbconnect.php';
require_once 'functions.php';


?>

<html>
	<head>
		<title>CTRL-ALL-SHIFTS</title>
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body>
		<div id="hello_user" class="reveal_hidden">
			<?php returnHelloUser(); ?>
		</div>
		<div id="container">
			<ul id="menu">
				<li><a href="main.php">Main</a></li>
				<li><a href="calendar.php">Calendar</a></li>
				<li><a href="createUser.php">Settings</a></li>
			</ul> 
			<div id="weeklySchedule">
				<?php 
		            echo returnWeeklySchedule();
		        ?>
			</div>
		</div>
	</body>
</html>
