<?php
require_once "functions.php";
?>
<html>
<head>
    <title>Crtl-All-Shift</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
                <input type="text" name="txtFirstName"/>
            </td>
        </tr>
        <tr>
            <td>Last name:</td>
            <td>
                <input type="text" name="txtLastName"/>
            </td>
        </tr>
        <tr>
            <td>Address:</td>
            <td>
                <input type="text" name="txtAddress"/>
            </td>
        </tr>
        <tr>
            <td>Zip code:</td>
            <td>
                <input type="text" name="txtZip"/>
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="txtEmail"/>
            </td>
        </tr>
        <tr>
            <td>Phone:</td>
            <td>
                <input type="text" name="txtPhone"/>
            </td>
        </tr>
        <tr>
            <td>Work function 1:</td>
            <td>
                <select name="selectWorkFunction1">
                    <?php
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
        <tr>
            <td>Work function 2:</td>
            <td>
                <select name="selectWorkFunction2">
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
            </td>
        </tr>
        <tr>
         <td>Work function 3:</td>
            <td>
                <select name="selectWorkFunction3">
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
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="createUser" id="createUser" value="Create" />
            </td>
        </tr>

    </form>
    <form id="deleteForm" name="delForm" method="post" action="delEmp.php">
        <td>Select employee:</td>
        <td>
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
        </td>
        <tr>
            <td colspan="2">
                <input type="submit" name="delEmp" id="delEmp" value="Delete Employee" />
            </td>
        </tr>
    </form>

</table>
</body>
</html>