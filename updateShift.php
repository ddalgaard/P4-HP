<?php 
require_once "functions.php";

// Retrieve values in the URL parsed from the calendar dates link
// These values are used when the shift is updated and the user is sent back to the browseDate.php page. Ensures that the user is sent back to the page with the date that he came from. 
$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];

// Retrieve values in the URL parsed from the calendar dates link.
// These values are used to insert current values for the shift in the fields. 
$startMonth = $_GET['startMonth'];
$endMonth = $_GET['endMonth'];
$startDay = $_GET['startDay'];
$endDay = $_GET['endDay'];
$startTime = $_GET['startTime'];
$endTime = $_GET['endTime'];
//$workFunction = $_GET['workfunction']; -- virker ikke, da workfunction bliver outputtet i en funktion
$notes = $_GET['notes'];
$shiftID = $_GET['shift_id'];



?>

<!DOCTYPE html>

<html>
<head>
    <title>CTRL-ALL-SHIFTS</title>
    <link href="css/create_shift.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>

<body>
<div id="create_shift_popup">
		<div id="create">
            
            <!-- When the form is submitted, the query in the URL gets cleared. Therefore, we insert them again on submit in order to make the shifts on the current day show -->
			<form action=<?php echo "'browseDate.php?year=$year&month=$month&day=$day&updateShift=yes&shiftID=$shiftID'"; ?> method="post">
				<fieldset>
					<legend>Shift start</legend>
                    <div><!-- &nbsp;/&nbsp; = adds a slash with a non-breaking space on each side - to seperate day and month fields -->
					    <input type="text" id="start_date" value="<?php echo $startDay; ?>" name="shift_start_date" />&nbsp;/&nbsp;
                        <label for="start_date">Date</label>
                    </div>
                    <div>
					    <input type="text" id="start_month" value="<?php echo $startMonth; ?>" name="shift_start_month" />
                        <label for="start_month">Month</label>
                    </div>
                    <div>
					    <input type="text" id="start_time" value="<?php echo $startTime; ?>" name="shift_start_time" />
                        <label for="start_time">Time</label>
                    </div>
				</fieldset>

				<fieldset>
					<legend>Shift end</legend>
                    <div>
                        <input type="text" id="end_date" value="<?php echo $endDay; ?>" name="shift_end_date" />&nbsp;/&nbsp;
                        <label for="end_date">Date</label>
                    </div>
                    <div>
                        <input type="text" id="end_month" value="<?php echo $endMonth; ?>" name="shift_end_month" />
                        <label for="end_month">Month</label>
                    </div>
                    <div>
                        <input type="text" id="end_time" value="<?php echo $endTime; ?>" name="shift_end_time" />
                        <label for="end_time">Time</label>
                    </div>
				</fieldset>

			    <label for="select_work_function">Work function</label>
				<select id="select_work_function" name="shift_work_function">
					<?php selectWorkfunction(); ?>
				</select>

				<label for="shift_notes">Notes</label>
				<textarea id="shift_notes" name="shift_notes" maxlength="1000"><?php echo $notes; ?>
				</textarea>
				
				<br/>
				<input type="submit" value="Update shift" />
			</form>
	</body>
</html>