<!-- Menu. If session is = 1 (meaning that the user logged in is an admin,
the user is able to see the buttons linking to calendar.php and createuser.php) -->
<ul id="menu">
				<li><a href="main.php">Main</a></li>
				<?php if($_SESSION['isadmin'] == 1){ ?>
					<li><a href="calendar.php">Calendar</a></li>
					<li><a href="createuser.php">User management</a></li>
				<?php } ?>
				<li><a href="weeklySchedule.php">Weekly schedule</a></li>
			</ul> 