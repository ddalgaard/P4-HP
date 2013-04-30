<?php require_once 'dbconnect.php';

function checkLogin() {
    
    if(!isset($_SESSION['loggedin'])) {
    redirect('index.php');
    } else {    
            }
}

function redirect($url){
//Checks if headers are already sent, if not the function uses the good old header(Location: ) function, and if they are sent. The function first uses javascript to try and redirect, if javascript is disabled. The function uses meta refresh to redirect. 
	if(!headers_sent()){
		header('Location: '.$url);
		exit;
	}
	 else
        {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
	
}

function executeQuery($sql_query){

    // Add query result to variable
    $result = mysql_query($sql_query);
    
    // Return result
    return $result;
}

// Function to add a new shift
function addShift($startMonth, $endMonth, $startDate, $endDate, $startTime, $endTime, $workFunction, $empID, $notes){
    
    // Get the current year
    $year = date('Y'); 
    
    // Form timestamps from inputted arguments
    $shiftStart = $year.'-'.$startMonth.'-'.$startDate.' '.$startTime;
    $shiftEnd = $year.'-'.$endMonth.'-'.$endDate.' '.$endTime;
	
    // Note that $empID is not surrounded by quotes. This is because a NULL value can be inserted. If it was quoted, the null value would become a string. Quotes are added when necessary in the if-statement in browseDate.php.
	$sql_query="INSERT INTO shift (shift_start, shift_end, skill_id, shift_emp_id, note) VALUES ('$shiftStart', '$shiftEnd', '$workFunction', $empID, '$notes')";

    executeQuery($sql_query); 
}

// Function to update a shift
function updateShift($startMonth, $endMonth, $startDate, $endDate, $startTime, $endTime, $workFunction, $empID, $notes, $shiftID){
    
    // Get the current year
    $year = date('Y'); 
    
    // Form timestamps from inputted arguments
    $shiftStart = $year.'-'.$startMonth.'-'.$startDate.' '.$startTime;
    $shiftEnd = $year.'-'.$endMonth.'-'.$endDate.' '.$endTime;
    
    // Note that $empID is not surrounded by quotes. This is because a NULL value can be inserted. If it was quoted, the null value would become a string. Quotes are added when necessary in the if-statement in browseDate.php.
    $sql_query ="UPDATE shift SET shift_start='$shiftStart', shift_end='$shiftEnd', skill_id='$workFunction', shift_emp_id=$empID, note='$notes' WHERE shift_id='$shiftID'";
    
    executeQuery($sql_query);
}

// Function to delete shift by shift-id (which is unique)
function deleteShift($shift_id){
    $sql_query = "DELETE FROM shift WHERE shift_id = '$shift_id'";

    executeQuery($sql_query);
}

// Function to check if there is any shifts that starts or ends on the specified date
function checkIfEventExistOnDate($year, $month, $day){

    // Create the date-variable from the function inputs
    $date = $year.'-'.$month.'-'.$day;
    
    //http://www.w3schools.com/sql/func_datediff_mysql.asp
    //http://www.stillnetstudios.com/comparing-dates-without-times-in-sql-server/comment-page-1/
    $sql_query ="SELECT * FROM shift WHERE DATEDIFF(shift_start, '$date') = 0 OR DATEDIFF(shift_end, '$date') = 0"; 
    
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Get the amount of rows that is returned from the query. If no rows are returned no entry in the database is found for the specified date. 
    $num_rows = mysql_num_rows($query_result);
    
    // Return number of rows when the function is called
    return $num_rows;
    
}


// Function to return any shifts that starts or ends on the specified date
function returnEventsOnDate($year, $month, $day){
    
    // Create the date-variable from the function inputs
    $date = $year.'-'.$month.'-'.$day;

    //http://www.w3schools.com/sql/func_datediff_mysql.asp
    //http://www.stillnetstudios.com/comparing-dates-without-times-in-sql-server/comment-page-1/
   // The following select statement uses 2 left join because it works 3 different tables where the main table is shift. The joins helps to clarify the information in the shift table by adding skill name and employee name from skill and emp table.
    $sql_query="SELECT shift.shift_start, shift.shift_end, shift.note, shift.shift_id, shift.skill_id, shift.shift_emp_id, CONCAT(emp.first_name, ' ', emp.last_name) AS name , skill.skill_name
               FROM (shift LEFT JOIN skill ON skill.skill_id = shift.skill_id)
               LEFT JOIN emp
               ON emp.emp_id = shift.shift_emp_id
               WHERE DATEDIFF(shift_start, '$date')=0
               OR DATEDIFF(shift_end, '$date')=0";
   
   // Use query function (executeQuery()) to return result of query
   $query_result = executeQuery($sql_query);

    // Extract information for each entry in the table
    while($row = mysql_fetch_array($query_result)){

        $startMonth = date('m', strtotime($row['shift_start']));
        $endMonth = date('m', strtotime($row['shift_end']));
        $startDay = date('d', strtotime($row['shift_start']));
        $endDay = date('d', strtotime($row['shift_end']));
        $startTime = date('G:i', strtotime($row['shift_start']));
        $endTime = date('G:i', strtotime($row['shift_end']));
        $workFunction = $row['skill_name'];
        $skillID = $row['skill_id'];
        $empID = $row['shift_emp_id'];
        $notes = $row['note'];
        $name = $row['name'];
        
        echo "<tr>
                <td>".returnFormattedDateTime($row['shift_start'])."</td>
                <td>".returnFormattedDateTime($row['shift_end'])."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['name']."</td>
                <td>".$row['note']."</td>
                <td><a href='browseDate.php?year=".$year."&month=".$month."&day=".$day."&shift_id=".$row['shift_id']."&deleteShift=yes'><img src='img/trashcan.png' alt='Delete shift' title='Delete this shift' /></a>
                <td><a href='updateShift.php?year=".$year."&month=".$month."&day=".$day."&startMonth=".$startMonth."&endMonth=".$endMonth."&startDay=".$startDay."&endDay=".$endDay."&startTime=".$startTime."&endTime=".$endTime."&workfunction=".$workFunction."&notes=".$notes."&shift_id=".$row['shift_id']."&skill_id=".$skillID."&emp_id=".$empID."&empName=".$name."'><img src='img/update.png' alt='Update shift' title='Update shift' /></a>
              </tr>";
    } 
}

// Function to display workfunctions
function workfunction(){
    $sql_query = "SELECT skill_name, skill_id FROM skill";
    $query_result = executeQuery($sql_query);
    while($row = mysql_fetch_array($query_result)){
            
            echo "<tr>
                    <td>".$row['skill_name']."</td><br>
                  </tr>";
        }
}


function selectWorkfunction(){

    $sql_query = "SELECT skill_id, skill_name FROM skill";

    $query_result = executeQuery($sql_query);
    while($row = mysql_fetch_array($query_result)){
            
        echo "<option value='".$row['skill_id']."'>".$row['skill_name']."</option>";
    }
}

// Function to display workers
function selectEmpfunction(){

    $sql_query = "SELECT emp_id, CONCAT(first_name, ' ', last_name) as full_name FROM emp";
    $query_result = executeQuery($sql_query);
    while($row = mysql_fetch_array($query_result))
    {
        echo "<option value='" . $row['emp_id'] . "'>" . $row['full_name'] ."</option>";
    }
}
                         


// Function to create calendar
function createCalendar($month, $year){  
        
    // Get the unix timestamp for the first day in the specified month. We use unix timestamp in order to make sure that the timestamp is not dependent on 
    // the server date/time, but the timezone of the visitor - using mktime(hour, minute, second, month, day, year).
    $timestamp = mktime(0,0,0,$month,1,$year);
    
    // Using the timestamp from the specified date, get the number of days in specified month - using date(format, timestamp). 
    // t = number of days (see PHP manual)
    $numberOfDaysInMonth = date('t', $timestamp);
    
    // Get a numeric representation of the first day of the month from the timestamp
    // w = numeric representation of first day in month (see PHP manual)
    $firstDayOfMonth = date('w', $timestamp);
    
    // Get the name of the month from the timestamp
    // F = Full name of month (see PHP manual)
    $monthName = date('F', $timestamp);
        
    // Add name of month to h2 heading
    $calendar ='<h2 class="monthname">'.$monthName.' '.$year.'</h2>';
        
    // Create first part of calendar table.
     $calendar .= '<table id="calendar_table">';
    
    // Create table column headings (weekdays). Could as well have been made as an array where a foreach loop would grab each day from the array.
    $calendar .='<thead>
                    <tr>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                    </tr>
                </thead>'; 
    
    // Create table body  
    $calendar .='<tbody>
                    <tr>';   
    
    // Count how many days there are before the first day of the month ($firstDayOfMonth). Output these as blank cells.
    // Start count at 1 because monday is day in the week 1 (we know this because $firstDayOfMonth returns '5' for the first day of March which is a friday). 
    for($daysBeforeFirstDayOfMonth = 1; $daysBeforeFirstDayOfMonth < $firstDayOfMonth; $daysBeforeFirstDayOfMonth++){
            $calendar .='<td class="nodate">&nbsp;</td>';
    }
    
    // Add a cell with the date for each day of the month. 
    // Count from 1 because the first day of the month is alway the 1st.
    for($dayInMonth = 1; $dayInMonth <= $numberOfDaysInMonth; $dayInMonth++){
    
        // Check is there is one or more shifts on a date - if there is, style the table cell
        if(checkIfEventExistOnDate($year,$month,$dayInMonth) > 0){
            //$calendar .='<td style="background:#CFDE5C;">'.$dayInMonth.'</td>';
            $calendar .='<td style="background:#CFDE5C;"><a href="browseDate.php?year='.$year.'&month='.$month.'&day='.$dayInMonth.'" style="color:#fff;">'.$dayInMonth.'</a></td>';
        } 
        
        // If there are no shifts on a date, apply default style to the cell
        else {  
            $calendar .='<td><a href="browseDate.php?year='.$year.'&month='.$month.'&day='.$dayInMonth.'" style="color:#fff;">'.$dayInMonth.'</a></td>';
        }    
        
        //For each day that is added, add 1 to the first day of month. 
        //As long as the first day of the month is below 7 the days are added in the same row. 
        $firstDayOfMonth++;
            
        // When the first day of month reaches 7, the row is ended to push days to a new row and the days counter is reset to start over again. 
        if($firstDayOfMonth > 7){
                $calendar .='</tr><tr>';
                $firstDayOfMonth = 1;
        }
    }
    
    // Complete the table with body and table closing tags.
    $calendar .='</tbody>
            </table>';
    
    // Return calendar    
    return $calendar;
    
}

// Function to return a weekly calendar with each day's events. 
function returnWeeklySchedule(){

    // Get current year and month. Used to generate a timestamp below. 
    $thisYear = date("Y");
    $thisMonth = date("m");

    // Get current day. Used to Generate a timestamp below. 
    // Because Sunday is the first day of the english week we subtract the date with one to 'fake' that monday is the first day of the week. 
    // E.g.: Sunday 7th will return monday 8th as the first monday of that week. By subtracting 1 we really get the monday for last week which is correct if monday is the first day of the week. 
    $thisDay = date("d")-1;

    // Generate timestamp for today. 
    $timestamp = mktime(0,0,0,$thisMonth,$thisDay,$thisYear);

    // Get monday in this week by using 'strtotime' and our timestamp. If we had not subtracted 1 from '$thisDay' this would have caused problems because the week would then start on sunday. 
    $mondayThisWeek = date("Y-m-d", strtotime("Monday this week",$timestamp));

    // Get the week start date (date for monday). 
    // Used in the SQL query to extract events for each date. For each loop that extracts data, the date is added by 1 to get events for the next day.
    $thisDate = $mondayThisWeek;

    // Add heading.
    $calendar = "<h2>Weekly schedule</h2>";

    // Extracts data for each day of the week. The week has 7 days and thus the loop runs 7 times. 
    for($day=1; $day<=7; $day++){

        // Get the date and name of the day for each day in the week. Used as a header for each of the 7 lists that holds events for each day. 
        $dayInWeek = date("l d/m", strtotime($thisDate));

        // Create an unordered list for each day.
        $calendar .= "<ul class='day_list'>";

        // Add the date and name of the day as the first list item in each list. 
        $calendar .= "<li>".$dayInWeek."</li>";

        // SQL-query. Extracts data for each day by matching the shift start date with the date for each day in the week. 
        $sql_query = "SELECT shift_start, shift_end, skill_name, CONCAT(first_name, ' ', last_name) AS emp_name 
                    FROM shift, skill, emp 
                    WHERE DATEDIFF(shift_start, '$thisDate') = 0 
                    AND skill.skill_id = shift.skill_id AND shift.shift_emp_id = emp.emp_id
                    ORDER BY shift_start";

        // Execute query.
        $query_result = executeQuery($sql_query); 

        // Extract all entries in the DB for the corresponding day as items in the unordered list.
        while($row = mysql_fetch_array($query_result)){
            $calendar .= "<li><span>".returnFormattedWeeklyTime($row['shift_start'])."-".returnFormattedWeeklyTime($row['shift_end'])."</span><span>".$row['skill_name']."</span><span>".$row['emp_name']."</span></li>";
        }

        // Add 1 day to '$thisDate' to go to the next day in the week. 
        // Should be last
        $thisDate = date("Y-m-d",strtotime($thisDate."+ 1 days"));

        // End the unordered list. 
        $calendar .= "</ul>";
    }

    // Return the weekly calendar. 
    return $calendar;
} 
          
function returnHelloUser(){

        $username = $_SESSION['username']; 
        $userid = mysql_query("SELECT first_name, last_name FROM login, emp WHERE username = '$username' and login.emp_id = emp.emp_id");
        while($row_id = mysql_fetch_array($userid)){

            echo "Hello <b>".$row_id['first_name']." ".$row_id['last_name']."</b>";
            echo "<a id='logout_link' class='hidden' href='log_out.php'>Log out</a>";
        }
}




// KOMMENTER FUNKTION!!!
// Ændre navn til at afspejle funktionens funcktionbalitet
function returnEventsOnID(){

        $username = $_SESSION['username']; 
        $userId = mysql_query("SELECT emp_id FROM login WHERE username = '$username'");
        while($row_id = mysql_fetch_array($userId)){
        $ID = $row_id["emp_id"]; 
    }

    $sql_query ="SELECT shift_id, shift_start, shift_end, skill_name, note FROM shift, skill WHERE shift_emp_id = $ID AND shift.skill_id = skill.skill_id AND shift_start >= CURDATE() GROUP BY shift_start ASC;";
                
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Extract information for each entry in the table
    //echo"<tr>My Shifts</td><br>";
    while($row = mysql_fetch_array($query_result)){
              //<tr> closes in function returnFreeEvents();
        echo "<tr> 
                <td>".returnFormattedDateTime($row['shift_start'])."</td>
                <td>".returnFormattedDateTime($row['shift_end'])."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['note']."</td>
            ";
    }
}


// Function to format a datetime-string from the database to a more readable format.
// See PHP Manual for formatting options: http://php.net/manual/en/datetime.createfromformat.php
function returnFormattedDateTime($dateTimeString){

    // Use newline-character (\n) to break line after month.
    $formattedDateTime = date("F j \n G:i", strtotime($dateTimeString));

    // Use the nl2br php function to add a html linebreak(<br/>) before all newlines (\n) in a string
    return nl2br($formattedDateTime);
} 

// Function to format a datetime-string from the database to a more readable format.
// See PHP Manual for formatting options: http://php.net/manual/en/datetime.createfromformat.php
function returnFormattedWeeklyTime($dateTimeString){

    // Use newline-character (\n) to break line after month.
    $formattedDateTime = date("G:i", strtotime($dateTimeString));

    // Use the nl2br php function to add a html linebreak(<br/>) before all newlines (\n) in a string
    return nl2br($formattedDateTime);
} 
    
 
function returnFreeEvents(){

    // Get username of current user from session
    $username = $_SESSION['username'];

    // Get the userID from the DB on base of username. This is used to send as a parameter in the URL (see below).
    $userId = mysql_query("SELECT emp_id FROM login WHERE username = '$username'");

    // Use a while-loop to extract data from query array
    while($row_id = mysql_fetch_array($userId)){

        // Assign the value from the db-field 'emp_id' to a variable $empID
        $empID = $row_id["emp_id"];
    }
    //
    $sql_query ="SELECT shift.shift_id, shift.shift_start, shift.shift_end, skill.skill_name, shift.note, shift.skill_id
                 FROM (shift LEFT JOIN skill ON skill.skill_id = shift.skill_id)
                 WHERE shift_emp_id IS NULL
                 AND EXISTS (SELECT emp_id, skill_id FROM emp_skill WHERE emp_id = '$empID' AND shift.skill_id = emp_skill.skill_id)
                 AND shift.shift_start >= CURDATE()
                 GROUP BY shift_start ASC;";
                
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Extract information for each entry in the table
    while($row = mysql_fetch_array($query_result)){

      echo "    <td>".returnFormattedDateTime($row['shift_start'])."</td>
                <td>".returnFormattedDateTime($row['shift_end'])."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['note']."</td>
                <td><form method='post'> <input type='hidden' name='shiftId' value='{$row['shift_id']}'/> <input type='hidden' name='empId' value='{$empID}' /> <input type='submit' class='button' onclick=\"return confirm('Are you sure?');\" name='takeShift-submit' value='Take Shift' /></form></td>
                </tr>";
    }
}


// Function to create new employee
function addEmp($firstName, $lastName, $address, $zip_code, $email, $phone_no, $workFunction1, $workFunction2, $workFunction3, $isAdmin, $password){
    if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        /*if($isAdmin == 1){
            $isAdmin = 1;
        }else {
            $isAdmin = "NULL";
        }*/

    
        if(!$isAdmin){
            $isAdmin = "NULL";
        }


       


    $sql_1="INSERT INTO `emp`(`first_name`, `last_name`, `email`) VALUES ('$firstName','$lastName','$email')";
    $sql_2="INSERT INTO `address`(`emp_id`, `street`, `zip_code`) VALUES (LAST_INSERT_ID(),'$address','$zip_code')";
    $sql_3="INSERT INTO `phone`(`emp_id`,`phone_no`) VALUES (LAST_INSERT_ID(),'$phone_no')";
    $sql_4="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workFunction1')";
    $sql_5="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workFunction2')";
    $sql_6="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workFunction3')";
    $sql_7="INSERT INTO `login`(`emp_id`, `username`, `password`, `is_admin`) VALUES (LAST_INSERT_ID(), CONCAT('$firstName', LAST_INSERT_ID()),'$password', $isAdmin)";
    
    

    $checkWorkFunction2 = mysql_real_escape_string($workFunction2);
    $checkWorkFunction3 = mysql_real_escape_string($workFunction3);

    mysql_query($sql_1);
    mysql_query($sql_2);
    mysql_query($sql_3);
    mysql_query($sql_4);
    mysql_query($sql_7);
        if ($checkWorkFunction2 > 0)
        {
            mysql_query($sql_5);
        }
        if ($checkWorkFunction3 > 0)
        {
            mysql_query($sql_6);
        }
       
}

// Function to delete an employee
function deleteEmp($emp_id){
    $sql_del1="DELETE FROM `emp_skill` WHERE emp_id = $emp_id";
    $sql_del2="DELETE FROM `phone` WHERE emp_id = $emp_id";
    $sql_del3="DELETE FROM `address` WHERE emp_id = $emp_id";
    $sql_del4="DELETE FROM `login` WHERE emp_id = $emp_id";
    $sql_del5="DELETE FROM `emp` WHERE emp_id = $emp_id";
    $sql_del6="UPDATE `shift` SET shift_emp_id = NULL WHERE shift_emp_id = $emp_id";

    $checkEmp = mysql_real_escape_string($emp_id);

    if ($checkEmp > 0)
    {
        mysql_query($sql_del1);
        mysql_query($sql_del2);
        mysql_query($sql_del3);
        mysql_query($sql_del4);
        mysql_query($sql_del5);
        mysql_query($sql_del6);
    }
}

// Function to check if a shift you are about to take conflicts with a shift you have already taken
function checkIfShiftsConflict($shiftId, $empId){

    // Query to check if the shift you are about to take is within the interval of a shift you have already taken
    $sql_query = "SELECT * FROM shift WHERE (select shift_start from shift where shift_id = $shiftId) < shift_end AND (select shift_end from shift where shift_id = $shiftId) > shift_start AND shift_emp_id = $empId";

    // Execute query
    $query_result = executeQuery($sql_query); 

    // Get the amount of rows that is returned from the query. 
    // If one or more rows are returned an entry in the database is conflicting with the specified date interval and a warning is displayed. 
    if(mysql_num_rows($query_result) > 0){
        print '<script type="text/javascript">';
        print 'alert("You cannot take this shift \n due to double booking.")';
        print '</script>';
    }else {
    $sql_query ="UPDATE `shift` SET `shift_emp_id`='$empId' WHERE shift_id = '$shiftId';";

        // Use query function (executeQuery()) to return result of query
    executeQuery($sql_query);
    }
}
function returnUserName() {

$sqlReturnUsername = "SELECT `username` FROM `login` WHERE `emp_id` = LAST_INSERT_ID()";

$query_result = executeQuery($sqlReturnUsername);

if($row = mysql_num_rows($query_result) > 0){

    $userName = mysql_fetch_array($query_result);
    $yourUserName = $userName['username'];
    print '<script type="text/javascript">';
    print 'alert("Your username is: '.$yourUserName.'")';
    print '</script>';



}
}
?>
