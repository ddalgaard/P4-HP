<?php require_once 'dbconnect.php'; ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
</html>
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
    
    /*
    INSERT INTO shifts values('1','2013-03-14 12:15:00', '2013-03-14 15:15:00', "Dato 1");
    INSERT INTO shifts values('2','2013-03-15 10:00:00', '2013-03-16 01:00:00', "Dato 2 - spænder over to dage");
    */
    
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
    // HUSK at rette, så vi selecter de aktuelle felter og ikke bruger '*' - det gør man kun i testmiljø. 
    $sql_query ="SELECT shift_start, shift_end, skill_name, note, first_name, last_name FROM shift, skill, emp WHERE 
   DATEDIFF(shift_start, '$date') = 0 and skill.skill_id = shift.skill_id and shift.shift_emp_id = emp.emp_id 
   
   OR DATEDIFF(shift_end, '$date') = 0 and skill.skill_id = shift.skill_id and shift.shift_emp_id = emp.emp_id";
    
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Extract information for each entry in the table
    while($row = mysql_fetch_array($query_result)){
        
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
$sql_query = "SELECT skill_name, skill_id FROM `skill`";
$query_result = executeQuery($sql_query);
while($row = mysql_fetch_array($query_result)){
        
        echo "<tr>
                <td>".$row['skill_name']."</td><br>
              </tr>";

}}

function selectWorkfunction(){

$sql_query = "SELECT skill_name, skill_id FROM `skill`";
$query_result = executeQuery($sql_query);
while($row = mysql_fetch_array($query_result)){
        
$skill=$row['skill_name'];
              echo "<option>  $skill   </option>";
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
		echo "Hej ".$row_id['first_name']." ".$row_id['last_name'];
		$ID = $row_id["emp_id"];
	}}



// Function to return any shifts that starts or ends on the specified date
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
       /* $shift_id = $row['shift_id'] ;
		$shift_start = $row['shift_start'] ;
		$shift_end = $row['shift_end'] ;
		$skill_name = $row['skill_name'] ;
		$note = $row['note'] ;
        echo "<tr>
                <td>".$row['shift_id']."</td><br>
                <td>".$row['shift_start']."</td><br>
                <td>".$row['shift_end']."</td><br>
				<td>".$row['skill_name']."</td><br>
                <td>".$row['note']."</td><br><br>
              </tr>";*/

              //<tr> closes in function returnFreeEvents();
        echo "<tr> 
                <td>".$row['shift_start']."</td>
                <td>".$row['shift_end']."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['note']."</td>
            ";
    }
}


function returnFreeEvents(){


    $sql_query ="select shift_id, shift_start, shift_end, skill_name, note from shift, skill where shift_emp_id is null and skill.skill_id = shift.skill_id group by shift_start asc;";
				
    // Use query function (executeQuery()) to return result of query
    $query_result = executeQuery($sql_query);
    
    // Extract information for each entry in the table
    while($row = mysql_fetch_array($query_result)){
        
       /* echo "<tr>
                <td>".$row['shift_id']."</td><br>
                <td>".$row['shift_start']."</td><br>
                <td>".$row['shift_end']."</td><br>
				<td>".$row['skill_name']."</td><br>
                <td>".$row['note']."</td><br>
				<TD><INPUT TYPE=BUTTON OnClick="?> <?php //takeshift();?> <?php echo "NAME='Take Shift!' VALUE='Take Shift!'></TD>
				</td><br><br>				
              </tr>";*/

      echo "    <td>".$row['shift_start']."</td>
                <td>".$row['shift_end']."</td>
                <td>".$row['skill_name']."</td>
                <td>".$row['note']."</td>
                <td><a href='' class='button'>take shift</a></td>
            </tr>";

			  		  
    }
}

function takeshift(){

$sql_query ="UPDATE `shift` SET `shift_emp_id`='$ID';";
$query_result = executeQuery($sql_query);				
    // Use query function (executeQuery()) to return result of query

}


?>
