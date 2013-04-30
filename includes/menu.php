<ul id="menu">
				<li><a href="main.php">Main</a></li>
				<?php if($_SESSION['isadmin'] == 1){ ?>
					<li><a href="calendar.php">Calendar</a></li>
					<li><a href="createuser.php">User management</a></li>
				<?php } ?>
				<li><a href="weeklySchedule.php">Weekly schedule</a></li>
			</ul> 