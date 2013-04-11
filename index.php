<!DOCTYPE HTML5>
<html>

<head>
	<title>CTRL-ALL-SHIFTS</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
	
</head>

<body>

<img src="img/logo2.png" id="logo" />
<div id="login_div">
	
	<h3 id="loginh3"> Please login </h3> 
	<form id="login_form" name="Login_form" method="POST" action="login.php" enctype="multipart/form-data">
		<label for="username">Username:</label> 
		<input id="username" name="empUsername" type="text" value="" />
		<br />
		<label for="password">Password:</label>	
		<input id="password" name="empPassword" type="password" value="" />
		
		<br />
		<input id="loginbut" type="submit" value="Login" />
		
	</form><br />
	
</div>
<br />
	
</body>
</html>