<?php require_once 'dbconnect.php'; ?>

<?php

function checkLogin() {
    
    if(!isset($_SESSION['loggedin'])) {
    header("location:index.php");
    } else {    
            }
}

function executeQuery($sql_query){

    // Add query result to variable
    $result = mysql_query($sql_query);
    
    // Return result
    return $result;
}

// Function to add a new shift
function addShift($startMonth, $endMonth, $startDate, $endDate, $startTime, $endTime, $workFunction, $emp_function, $notes){
    
    // Get the current year
    $year = date('Y'); 
    
    // Form timestamps from inputted arguments
    $shiftStart = $year.'-'.$startMonth.'-'.$startDate.' '.$startTime;
    $shiftEnd = $year.'-'.$endMonth.'-'.$endDate.' '.$endTime;
	
	$sql_1="INSERT INTO shift (shift_start, shift_end, skill_id, note) VALUES ('$shiftStart', '$shiftEnd', '$workFunction', '$notes')";
	$sql_2="INSERT INTO shift (shift_start, shift_end, skill_id, shift_emp_id, note) VALUES ('$shiftStart', '$shiftEnd', '$workFunction', '$emp_function', '$notes')";
	
	if ($emp_function == ""){
		mysql_query($sql_1);}
	else{
		mysql_query($sql_2);}
}

// Function to update a shift
function updateShift($startMonth, $endMonth, $startDate, $endDate, $startTime, $endTime, $workFunction, $notes, $shiftID){
    
    // Get the current year
    $year = date('Y'); 
    
    // Form timestamps from inputted arguments
    $shiftStart = $year.'-'.$startMonth.'-'.$startDate.' '.$startTime;
    $shiftEnd = $year.'-'.$endMonth.'-'.$endDate.' '.$endTime;
    
    $sql_query ="UPDATE shift SET shift_start='$shiftStart', shift_end='$shiftEnd', skill_id='$workFunction', note='$notes' WHERE shift_id='$shiftID'";
    
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
    $sql_query="SELECT shift.shift_start, shift.shift_end, shift.note, shift.shift_id, CONCAT(emp.first_name, ' ', emp.last_name) AS name , skill.skill_name
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
        $notes = $row['note'];
        
        echo "<tr>
                <td>".$row['shift_start']."</td>
                <td>".$row['shift_end']."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['name']."</td>
                <td>".$row['note']."</td>
                <td><a href='browseDate.php?year=".$year."&month=".$month."&day=".$day."&shift_id=".$row['shift_id']."&deleteShift=yes'><img src='img/trashcan.png' alt='Delete shift' title='Delete this shift' /></a>
                <td><a href='updateShift.php?year=".$year."&month=".$month."&day=".$day."&startMonth=".$startMonth."&endMonth=".$endMonth."&startDay=".$startDay."&endDay=".$endDay."&startTime=".$startTime."&endTime=".$endTime."&workfunction=".$workFunction."&notes=".$notes."&shift_id=".$row['shift_id']."'><img src='img/update.png' alt='Update shift' title='Update shift' /></a>
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

    $sql_query = "SELECT emp_id, first_name, last_name FROM EMP";

    $query_result = executeQuery($sql_query);
    while($row = mysql_fetch_array($query_result)){

    echo "<option value='".$row['emp_id']."'>".$row['first_name']." ".$row['last_name']."</option>";
    
	
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
    $calendar ='<h2>'.$monthName.' '.$year.'</h2>';
        
    // Create first part of calendar table.
     $calendar .= '<table>';
    
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
            $calendar .='<td>&nbsp;</td>';
    }
    
    // Add a cell with the date for each day of the month. 
    // Count from 1 because the first day of the month is alway the 1st.
    for($dayInMonth = 1; $dayInMonth <= $numberOfDaysInMonth; $dayInMonth++){
    
        // Check is there is one or more shifts on a date - if there is, style the table cell
        if(checkIfEventExistOnDate($year,$month,$dayInMonth) > 0){
            //$calendar .='<td style="background:#ff6600;">'.$dayInMonth.'</td>';
            $calendar .='<td style="background:#ff6600;"><a href="browseDate.php?year='.$year.'&month='.$month.'&day='.$dayInMonth.'">'.$dayInMonth.'</a></td>';
        } 
        
        // If there are no shifts on a date, apply default style to the cell
        else {  
            $calendar .='<td><a href="browseDate.php?year='.$year.'&month='.$month.'&day='.$dayInMonth.'">'.$dayInMonth.'</a></td>';
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

function returnHelloUser($username){

        $username = $_SESSION['username']; 
        $userid = mysql_query("SELECT first_name, last_name FROM login, emp WHERE username = '$username' and login.emp_id = emp.emp_id");
        while($row_id = mysql_fetch_array($userid)){
        echo "Hej <b>".$row_id['first_name']." ".$row_id['last_name']."</b>";
        $ID = $row_id["emp_id"];

    }}



// KOMMENTER FUNKTION!!!
// Ændre navn til at afspejle funktionens funcktionbalitet

function returnEventsOnID($username){

        $username = $_SESSION['username']; 
        $userId = mysql_query("SELECT emp_id FROM login WHERE username = '$username'");
        while($row_id = mysql_fetch_array($userId)){
        $ID = $row_id["emp_id"]; 
    }

    $sql_query ="SELECT shift_id, shift_start, shift_end, skill_name, note FROM shift, skill WHERE shift_emp_id = $ID and shift.skill_id = skill.skill_id GROUP by shift_start asc;";
                
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
    $sql_query ="select shift_id, shift_start, shift_end, skill_name, note from shift, skill where shift_emp_id is null and skill.skill_id = shift.skill_id group by shift_start asc;";
                
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Extract information for each entry in the table
    while($row = mysql_fetch_array($query_result)){

      echo "    <td>".returnFormattedDateTime($row['shift_start'])."</td>
                <td>".returnFormattedDateTime($row['shift_end'])."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['note']."</td>
                <td class='button_row'><a href='?takeShift=yes&shiftID=".$row['shift_id']."&empID=".$empID."' class='button'>take shift</a></td>
            </tr>";

                      
    }
}

function takeShift($shiftID, $empID){

$sql_query ="UPDATE `shift` SET `shift_emp_id`='$empID' WHERE shift_id = '$shiftID';";
executeQuery($sql_query);
    // Use query function (executeQuery()) to return result of query

}




// Function to create new employee
function addEmp($firstName, $lastName, $email, $address, $zip_code, $phone_no, $workFunction1, $workFunction2, $workFunction3){
    if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    $sql_1="INSERT INTO `emp`(`first_name`, `last_name`, `email`) VALUES ('$firstName','$lastName','$email')";
    $sql_2="INSERT INTO `address`(`emp_id`, `street`, `zip_code`) VALUES (LAST_INSERT_ID(),'$address','$zip_code')";
    $sql_3="INSERT INTO `phone`(`emp_id`,`phone_no`) VALUES (LAST_INSERT_ID(),'$phone_no')";
    $sql_4="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workFunction1')";
    $sql_5="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workFunction2')";
    $sql_6="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workFunction3')";

    $checkWorkFunction2 = mysql_real_escape_string($workFunction2);
    $checkWorkFunction3 = mysql_real_escape_string($workFunction3);

    mysql_query($sql_1);
    mysql_query($sql_2);
    mysql_query($sql_3);
    mysql_query($sql_4);
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
    $sql_del4="DELETE FROM `emp` WHERE emp_id = $emp_id";
    $sql_del5="UPDATE `shift` SET shift_emp_id = NULL WHERE shift_emp_id = $emp_id";

    $checkEmp = mysql_real_escape_string($emp_id);

    if ($checkEmp > 0)
    {
        mysql_query($sql_del1);
        mysql_query($sql_del2);
        mysql_query($sql_del3);
        mysql_query($sql_del4);
        mysql_query($sql_del5);
    }
}
 
?>
