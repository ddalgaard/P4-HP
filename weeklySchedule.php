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
		<?php include("includes/helloUser.php");?>
		<div id="container">
			<?php include("includes/menu.php");?>
			<div id="weeklySchedule">
				<?php 
		            echo returnWeeklySchedule();
		        ?>
			</div>
		</div>
	</body>
</html>
