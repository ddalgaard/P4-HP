<?php
require_once "dbconnect.php";
?>
<html>
<head>
    <title>Crtl-All-Shift</title>
</head>

<body>
<table width="300" border="0" >
    <form id="form1" name="form1" method="post" action="createEmp.php">
        <tr>
            <td colspan="3"><b>Create employee:</b></td>
        </tr>
        <tr>
            <td>First name:</td>
            <td>
                <input type="text" name="txtFirstName" id="txtFirstName" />
            </td>
        </tr>
        <tr>
            <td>Last name:</td>
            <td>
                <input type="text" name="txtLastName" id="txtLastName" />
            </td>
        </tr>
        <tr>
            <td>Address:</td>
            <td>
                <input type="text" name="txtAddress" id="txtAddress" />
            </td>
        </tr>
        <tr>
            <td>Zip code:</td>
            <td>
                <input type="text" name="txtZip" id="txtZip" />
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="txtEmail" id="txtEmail" />
            </td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td>
                <input type="text" name="txtPhone" id="txtPhone" />
            </td>
        </tr>
<!--        <tr>
            <td>Work function 1:</td>
            <td>
                <select name="selectWorkFunction1" id="selectWorkFunction1">
                    <php
                    $sql_query = "SELECT skill_name, skill_id FROM skill";
                    $query_result = executeQuery($sql_query);
                    while($row = mysql_fetch_array($query_result)){
                        $skill=$row['skill_name'];
                        echo "<option value=\"" . $row['skill_id'] . "\">" . $skill ."</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <!--
        <tr>
            <td>Work function 2:</td>
            <td>
                <select name="WorkFunction2" id="selectWorkFunction2">
                    <option> none </option>
                    <php
                    $sql_query = "SELECT skill_name, skill_id FROM skill";
                    $query_result = executeQuery($sql_query);
                    while($row = mysql_fetch_array($query_result))
                    {
                        $skill=$row['skill_name'];
                        $skillId=$row['skill_id'];
                        echo "<option value=\"" . $skillId . "\">" . $skill ."</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
         <td>Work function 3:</td>
            <td>
                <select name="WorkFunction3" id="selectWorkFunction3">
                    <option> none </option>
                    <php
                    $sql_query = "SELECT skill_name, skill_id FROM skill";
                    $query_result = executeQuery($sql_query);
                    while($row = mysql_fetch_array($query_result)){
                        $skill=$row['skill_name'];
                        echo "<option value=\"" . $row['skill_id'] . "\">" . $skill ."</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        -->
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="createUser" id="createUser" value="Create" />
            </td>
        </tr>

    </form>
</table>
</body>
</html>