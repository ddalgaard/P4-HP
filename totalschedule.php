<?php
	//Start sessions
session_start();
require_once 'dbconnect.php';
require_once 'functions.php';
//checkLogin();
?>
<html>

<head>
	<title>CTRL-ALL-SHIFTS</title>
	<link href="css/main.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
 </head>

<body>

	<div id="main">
		<ul id="menu">
			<li><a href="">Main</a></li>
			<li><a href="calendar.php">Calendar</a></li>
			<li><a href="">Bulletin</a></li>
			<li><a href="">Settings</a></li>
			<li><a href="">About</a></li>
			<li><a href="http://swps-dev.cgasberg.dk/log_out.php">Logout</a></li>
		</ul>
		
		<div id="weeklywork">

		
		<?php 
		

		
			$week_number = date("W");
			$year = date("Y");
			$month = date("M");
			
			
			$todaysdate = date("Y-m-d");
			
			
			
			$date = strtotime(date("Y-m-d", strtotime($todaysdate))."+1 day");
		;
			$tomorrowsdate = date("Y-m-d", $date);
						// Function to format a datetime-string from the database to a more readable format.
// See PHP Manual for formatting options: http://php.net/manual/en/datetime.createfromformat.php
function returnFormattedTimeForWeeklySchedule($dateTimeString){

    // Use newline-character (\n) to break line after month.
    // 't' needs to be double-escaped, otherwise it is interpreted as \t which is the horizontal tab character.
    $formattedDateTime = date("G:i", strtotime($dateTimeString));

    // Use the nl2br php function to add a html linebreak(<br/>) before all newlines (\n) in a string
    return nl2br($formattedDateTime);
} 
			
			//http://www.w3schools.com/sql/func_datediff_mysql.asp
					//http://www.stillnetstudios.com/comparing-dates-without-times-in-sql-server/comment-page-1/
					// HUSK at rette, så vi selecter de aktuelle felter og ikke bruger '*' - det gør man kun i testmiljø. 
					
				
    
					// Use query function (executeQuery()) to return result of query
					$query_result = executeQuery($sql_query);
					$n = 0;

		
			for($day=1; $day<=7; $day++) {
				echo "<td>".date('l d/m', strtotime($year."W".$week_number.$day))." "."</td>";
				
				}
			
		
				
					
				for($day=1; $day<=7; $day++) {
						
						$date = date('Y-m-d', strtotime($year."W".$week_number.$day));
						
					
					
					
					//http://www.w3schools.com/sql/func_datediff_mysql.asp
					//http://www.stillnetstudios.com/comparing-dates-without-times-in-sql-server/comment-page-1/
					// HUSK at rette, så vi selecter de aktuelle felter og ikke bruger '*' - det gør man kun i testmiljø. 
				
					$sql_query ="SELECT extract(hour_minute FROM shift_start) as start_time, extract(hour_minute FROM shift_end) as end_time, skill_name, first_name, last_name 								 FROM shift, skill, emp WHERE 
								 DATEDIFF(shift_start, '$date') = 0 and skill.skill_id = shift.skill_id and shift.shift_emp_id = emp.emp_id 
								 OR DATEDIFF(shift_end, '$date') = 0 and skill.skill_id = shift.skill_id and shift.shift_emp_id = emp.emp_id order by start_time ";	
				
								 
    
					// Use query function (executeQuery()) to return result of query
					$query_result = executeQuery($sql_query);
					
					
					// Extract information for each entry in the table
				$colno = 0;
				
				if(executeQuery($sql_query) > 0 && $colno <= 7) {
					
						while($row = mysql_fetch_array($query_result)){
							

							echo  "
							<br />".returnFormattedTimeForWeeklySchedule($row['start_time'])." - ".returnFormattedTimeForWeeklySchedule($row['end_time'])."<br />".$row['first_name']." ".$row['last_name']."<br />".$row['skill_name']." <br />"; 
						}
						
						$colno++;
						
						} else  {
							echo "";
							$colno++;
						}
						
						
						
						
							
        } 
        
							
						
						

					
				

					
	?>
	
	</table>
		</div></div>
	
	
	
	</div>
		



</body>

</html>