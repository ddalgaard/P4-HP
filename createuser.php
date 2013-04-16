<?php
require_once "functions.php";
?>
<html>
<head>
    <title>Crtl-All-Shift</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="css/create_user.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="createuser">
	<table width="300">
    	<form id="form1" name="form1" method="post" action="createEmp.php">
	    	<fieldset>
       			<legend>Create employee</legend>
       				<label>First name:</label><input type="text" name="txtFirstName"/>
       				<label>Last name:</label><input type="text" name="txtLastName"/>
       				<label>Address:</label><input type="text" name="txtAddress"/>
       				<label>Zip code:</label><input type="text" name="txtZip"/>
       				<label>Email:</label><input type="text" name="txtEmail"/>
	       			<label>Phone:</label><input type="text" name="txtPhone"/>
	       			<label>Work function 1:</label><select name="selectWorkFunction1">
                    <?php
                    $sql_query = "SELECT skill_name, skill_id FROM skill";
                    $query_result = executeQuery($sql_query);
                    while($row = mysql_fetch_array($query_result)){
                        $skill=$row['skill_name'];
                        echo "<option value=\"" . $row['skill_id'] . "\">" . $skill ."</option>";
                    }
                    ?>
                    </select>
                	<label>Work function 2:</label><select name="selectWorkFunction2">
                    <option value="-1"> None </option>
                    <?php
                    $sql_query = "SELECT skill_name, skill_id FROM skill";
                    $query_result = executeQuery($sql_query);
                    while($row = mysql_fetch_array($query_result))
                    {
                        $skill=$row['skill_name'];
                        echo "<option value=\"" . $row['skill_id'] . "\">" . $skill ."</option>";
                    }
                    ?>
                    </select>
                	<label>Work function 3:</label><select name="selectWorkFunction3">
                    <option value="-1"> None </option>
                    <?php
                    $sql_query = "SELECT skill_name, skill_id FROM skill";
                    $query_result = executeQuery($sql_query);
                    while($row = mysql_fetch_array($query_result)){
                        $skill=$row['skill_name'];
                        echo "<option value=\"" . $row['skill_id'] . "\">" . $skill ."</option>";
                    }
                    ?>
                    </select>
                    <input type="submit" name="createUser" id="createUser" value="Create" />
	    	</fieldset>

	    </form>
    </div>
  
    <div id="deleteuser">  
	    <fieldset>
		    <legend>Delete employee</legend>
		    	<form id="deleteForm" name="delForm" method="post" action="delEmp.php">
			    	<label>Select employee:</label>
			    	<select name="selectEmpName">
				    <option value="-1"> None </option>
                <?php
                $sql_query = "SELECT emp_id, CONCAT(first_name, ' ', last_name) as full_name FROM emp";
                $query_result = executeQuery($sql_query);
                while($row = mysql_fetch_array($query_result))
                {
                    $name=$row['full_name'];
                    echo "<option value=\"" . $row['emp_id'] . "\">" . $name ."</option>";
                }
                ?>
                	</select>
                	<input type="submit" name="delEmp" id="delEmp" value="Delete Employee" />
  
        </form>

   </div>
</body>
</html>