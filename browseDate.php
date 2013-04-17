<?php
session_start();
require_once "functions.php";
checkLogin();
if($_SESSION['loggedin'] == TRUE){


// Retrieve values in the URL parsed from the calendar dates link
$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];


// If all fields are set (and not null) and the URL contains 'addShift=yes', add the shift
if(isset($_GET['addShift']) == 'yes' && isset($_POST['shift_start_month'], $_POST['shift_end_month'], $_POST['shift_start_date'], $_POST['shift_end_date'], $_POST['shift_start_time'], $_POST['shift_end_time'], $_POST['shift_work_function'])){

    addShift($_POST['shift_start_month'], $_POST['shift_end_month'], $_POST['shift_start_date'], $_POST['shift_end_date'], $_POST['shift_start_time'], $_POST['shift_end_time'], $_POST['shift_work_function'], $_POST['emp_function'], $_POST['shift_notes']);
}

// If the URL contains 'deleteshift=yes', retreive its id from the url and delete it
if(isset($_GET['deleteShift']) == 'yes'){
	
    // The shift id is recovered from the URL and is used to identify which shift to delete.
    $shiftId = $_GET['shift_id'];
    
    deleteShift($shiftId);
}

// If the URL contains 'updateShift=yes', retreive its id from the url and update it
if(isset($_GET['updateShift']) == 'yes'){

        // The shift id is recovered from the URL and is used to identify which shift to update. 
        $shiftID = $_GET['shiftID'];
    
        updateShift($_POST['shift_start_month'], $_POST['shift_end_month'], $_POST['shift_start_date'], $_POST['shift_end_date'], $_POST['shift_start_time'], $_POST['shift_end_time'], $_POST['shift_work_function'], $_POST['shift_notes'], $shiftID);
}

?>

<!DOCTYPE html>

<html>
<head>
    <title>CTRL-ALL-SHIFTS</title>
    <link href="css/main.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>

<body>
    <div id="container">
        <div id="create_shift_popup">
        		<div id="create">
                    
                    <!-- When the form is submitted, the query in the URL gets cleared. Therefore, we insert them again on submit in order to make the shifts on the current day show -->
                    <!-- The query 'addShift=yes' ensures that the shift is added when the form is submitted. -->
        			<form action=<?php echo "'?year=$year&month=$month&day=$day&addShift=yes'"; ?> method="post">
        				<fieldset>
        					<legend>Shift start</legend>
                            <div>
        					    <input type="text" id="start_date" value="<?php echo $day ?>" name="shift_start_date" />
                                <label for="start_date">Date</label>
                            </div>
                            <div>
        					    <input type="text" id="start_month" value="<?php echo $month ?>" name="shift_start_month" />
                                <label for="start_month">Month</label>
                            </div>
                            <div>
        					    <input type="text" id="start_time" value="00:00" name="shift_start_time" />
                                <label for="start_time">Time</label>
                            </div>
        				</fieldset>

        				<fieldset>
        					<legend>Shift end</legend>
                            <div>
                                <input type="text" id="end_date" value="<?php echo $day ?>" name="shift_end_date" />
                                <label for="end_date">Date</label>
                            </div>
                            <div>
                                <input type="text" id="end_month" value="<?php echo $month ?>" name="shift_end_month" />
                                <label for="end_month">Month</label>
                            </div>
                            <div>
                                <input type="text" id="end_time" value="00:00" name="shift_end_time" />
                                <label for="end_time">Time</label>
                            </div>
        				</fieldset>

        			    <label for="select_work_function">Work function</label>
        				<select id="select_work_function" name="shift_work_function">
        					<?php selectWorkfunction(); ?>
        				</select>

        				<label for="select_emp_function">Employee</label>
        				<select id="select_emp_function" name="emp_function">
        					<option value="">Free</option>
        					<?php selectEmpfunction(); ?>
        				</select>
        				
        				
        				<label for="shift_notes">Notes</label>
        				<textarea id="shift_notes" name="shift_notes" maxlength="1000">Notes
        				</textarea>
        				
        				<br/>
        				<input type="submit" value="Create shift" />
        			</form>
        		</div>
        		<div id="overview">
                    <table id="shifts_today" class="shifts_table">
                        <thead>
                            <tr>
                                <th colspan="7"> Shifts of the day </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table_boldtext">
                                <td>Start time</td>
                                <td>End time</td>
                                <td>Work function</td>
                                <td>Employee</td>
                                <td>Notes</td>
                                <td>Delete</td>
                                <td>Update Shift</td>
                            </tr>
                            <?php // Return events for the specified date
                                echo returnEventsOnDate($year,$month,$day);
                            ?>
                        </tbody>
                        
                    </table>
                    
                    <a href="calendar.php">Go back to calendar</a>
        		</div>
        	</div>
    </div>
</body>
</html>




<?php
}
?>