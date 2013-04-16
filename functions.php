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
function addShift($startMonth, $endMonth, $startDate, $endDate, $startTime, $endTime, $workFunction, $notes){
    
    // Get the current year
    $year = date('Y'); 
    
    // Form timestamps from inputted arguments
    $shiftStart = $year.'-'.$startMonth.'-'.$startDate.' '.$startTime;
    $shiftEnd = $year.'-'.$endMonth.'-'.$endDate.' '.$endTime;
    
    $sql_query ="INSERT INTO shift (shift_start, shift_end, skill_id, note) VALUES ('$shiftStart', '$shiftEnd', '$workFunction', '$notes')";
    
    executeQuery($sql_query); 

}

// Function to delete shift by shift-id (which is unique)
function deleteShift($shift_id){
    $sql_query = "DELETE FROM shift WHERE shift_id = '$shift_id'"; 
    
    executeQuery($sql_query);
}


// Function to update shift by shift-id (which is unique)
function updateShift($shift_id){
    echo $shiftupdate;
    $sql_query = "UPDATE shift set shift_start='$shiftStart' , shift_end='$shiftEnd', skill_id='$workFunction', note='$notes' where shift_id = '$shift_id'";
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

    ################################################################################
    ### HER SKAL RETTES, SÅ EVENTS IKKE KUN KOMMER UD NÅR DER ER EN EMP ASSIGNED ###
    ################################################################################
    
    //http://www.w3schools.com/sql/func_datediff_mysql.asp
    //http://www.stillnetstudios.com/comparing-dates-without-times-in-sql-server/comment-page-1/
    // HUSK at rette, så vi selecter de aktuelle felter og ikke bruger '*' - det gør man kun i testmiljø. 
    
   /* $sql_query ="SELECT shift_start, shift_end, skill_name, note, first_name, last_name, shift_id FROM shift, skill, emp WHERE 
   DATEDIFF(shift_start, '$date') = 0 and skill.skill_id = shift.skill_id and shift.shift_emp_id = emp.emp_id 
   
   OR DATEDIFF(shift_end, '$date') = 0 and skill.skill_id = shift.skill_id and shift.shift_emp_id = emp.emp_id"; */
   
   //NEW STUF!!!!!!!!!!!!!!!!!!!!!!
   $sql_query1="SELECT shift_start, shift_end, skill_name, note, shift_emp_id, shift_id FROM shift, skill WHERE 
   DATEDIFF(shift_start, '$date') = 0 and skill.skill_id = shift.skill_id 
   
   OR DATEDIFF(shift_end, '$date') = 0 and skill.skill_id = shift.skill_id";
   
   $query_result1 = executeQuery($sql_query1);
   
   $sql_query2="SELECT first_name, last_name FROM shift, emp WHERE 
   DATEDIFF(shift_start, '$date') = 0 and shift.shift_emp_id = emp.emp_id 
   
   OR DATEDIFF(shift_end, '$date') = 0 and shift.shift_emp_id = emp.emp_id";
    
    // Use query function (executeQuery()) to return result of query
    $query_result2 = executeQuery($sql_query2);
    
    
    
    
    // Extract information for each entry in the table
    while($row = mysql_fetch_array($query_result1, $query_result2)){
        
        echo "<tr>
                <td>".$row['shift_start']."</td>
                <td>".$row['shift_end']."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['first_name']." ".$row['last_name']."</td>
                <td>".$row['note']."</td>
                <td><a href='browseDate.php?year=".$year."&month=".$month."&day=".$day."&shift_id=".$row['shift_id']."&deleteShift=yes'><img src='img/trashcan.png' alt='Delete shift' title='Delete this shift' /></a>
                <td><a href='browseDate.php?year=".$year."&month=".$month."&day=".$day."&shift_id=".$row['shift_id']."&updateShift=yes'><img src='img/update.png' alt='Update shift' title='Update shift' /></a>
                
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
function returnEventsOnID($username){

        $username = $_SESSION['username']; 
        $userid = mysql_query("SELECT emp_id FROM login WHERE username = '$username'");
        while($row_id = mysql_fetch_array($userid)){
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
    // 't' needs to be double-escaped, otherwise it is interpreted as \t which is the horizontal tab character.
    $formattedDateTime = date("F j \n \a\\t G:i", strtotime($dateTimeString));

    // Use the nl2br php function to add a html linebreak(<br/>) before all newlines (\n) in a string
    return nl2br($formattedDateTime);
} 
    
 
function returnFreeEvents(){ 

    $sql_query ="select shift_id, shift_start, shift_end, skill_name, note from shift, skill where shift_emp_id is null and skill.skill_id = shift.skill_id group by shift_start asc;";
                
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Extract information for each entry in the table
    while($row = mysql_fetch_array($query_result)){

      echo "    <td>".returnFormattedDateTime($row['shift_start'])."</td>
                <td>".returnFormattedDateTime($row['shift_end'])."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['note']."</td>
                <td class='button_row'><a href='' class='button'>take shift</a></td>
            </tr>";

                      
    }
}

function takeshift(){

$sql_query ="UPDATE `shift` SET `shift_emp_id`='$ID';";
$query_result = executeQuery($sql_query);               
    // Use query function (executeQuery()) to return result of query

}




// Function to create new employee
function addEmp($firstName, $lastName, $email, $adress, $zip_code, $phone_no, $workfunction1, $workfunction2, $workfunction3){
    if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    $sql_1="INSERT INTO `emp`(`first_name`, `last_name`, `email`) VALUES ('$firstName','$lastName','$email')";
    $sql_2="INSERT INTO `address`(`emp_id`, `street`, `zip_code`) VALUES (LAST_INSERT_ID(),'$adress','$zip_code')";
    $sql_3="INSERT INTO `phone`(`emp_id`,`phone_no`) VALUES (LAST_INSERT_ID(),'$phone_no')";
    $sql_4="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workfunction1')";
    $sql_5="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workfunction2')";
    $sql_6="INSERT INTO `emp_skill`(`emp_id`, `skill_id`) VALUES (LAST_INSERT_ID(), '$workfunction3')";

    $checkWorkFunction2 = mysql_real_escape_string($workfunction2);
    $checkWorkFunction3 = mysql_real_escape_string($workfunction3);

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
