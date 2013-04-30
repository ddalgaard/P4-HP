<?php
//Start sessions
session_start();
require_once 'functions.php';
checkLogin();
?>


<html>
<head>

</head>
<body>
    <?php
    //Tjekker om sessions username og loggedin er sat. Hvis de er, må man blive på siden med denne funktion, eller redirectes man tilbage til login.
    if($_SESSION['loggedin'] == TRUE && $_SESSION['isadmin'] == 1){

        if (!empty($_POST['create-submit'])) {
            if(isset($_POST['txtFirstName'], $_POST['txtLastName'], $_POST['txtAddress'], $_POST['txtZip'], $_POST['txtEmail'], $_POST['txtPhone'], $_POST['selectWorkFunction1'],$_POST['selectWorkFunction2'],$_POST['selectWorkFunction3'],$_POST['txtPassword'])){
                           
            $password = hash('sha256', $_POST['txtPassword']);

                addEmp($_POST['txtFirstName'], $_POST['txtLastName'], $_POST['txtAddress'], $_POST['txtZip'], $_POST['txtEmail'], $_POST['txtPhone'], $_POST['selectWorkFunction1'],$_POST['selectWorkFunction2'],$_POST['selectWorkFunction3'],$_POST['isAdmin'], $password);
                returnUserName();
            }
        }

        if (!empty($_POST['delete-submit'])) {
        $emp_id = $_POST['selectEmpToDelete'];
        deleteEmp($emp_id);
        }
    ?>

    <html>
    <head>
        <title>CTRL-ALL-SHIFTS</title>
        <link href="css/main.css" rel="stylesheet" type="text/css" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    </head>
    <body>
<!-- Echo out the name of the user logged in -->
	<?php include("includes/helloUser.php");?>

    <div id="container">
    
<!-- The html menu, made as an inline list -->
        <?php include("includes/menu.php");?>

<!-- Start Create new User form -->
        <form id="createForm" name="createForm" autocomplete="off" method="post">
            <fieldset class="createUser">
                <legend>Create employee</legend>
                <label>First name:</label><input type="text" name="txtFirstName"/>
                <label>Last name:</label><input type="text" name="txtLastName"/>
                <label>Address:</label><input type="text" name="txtAddress"/>
                <label>Zip code:</label><input type="text" name="txtZip"/>
                <label>Email:</label><input type="text" name="txtEmail"/>
                <label>Phone:</label><input type="text" name="txtPhone"/>
                <label>Work function 1:</label><select name="selectWorkFunction1">
                    <?php selectWorkfunction(); ?>
                </select>

                <label>Work function 2:</label><select name="selectWorkFunction2">
                    <option value="-1"> None </option>
                    <?php selectWorkfunction(); ?>
                </select>

                <label>Work function 3:</label><select name="selectWorkFunction3">
                    <option value="-1"> None </option>
                    <?php selectWorkfunction(); ?>
                </select>

                <label>Password:</label>
                <input type="password" name="txtPassword" />

                <label>Is admin?</label>
                <input type="checkbox" name="isAdmin" value="1" />
                
                <input class="button" type="submit" name="create-submit" id="createUser" value="Create" />

                
                

            </fieldset>
        </form>

<!-- End createUser form -- Start Delete user form -->
        <form id="deleteForm" name="deleteForm" method="post">
            <fieldset id="deleteUser">
                <legend>Delete employee</legend>

                <label>Select employee:</label>
                <select name="selectEmpToDelete">
                    <option value="-1"> None </option>
                    <?php selectEmpfunction(); ?>
                </select>
                <input class="deleteButton" type="submit" name="delete-submit" id="delEmp" value="Delete Employee" />

            </fieldset>
        </form>
        
      
    </div>
    </body>
    </html>

<?php
}
else {
    echo "Du er ikke logget ind";
    echo "<a href='index.php'></br> Klik her for at logge ind!</a>";
}
?>
</body>
</html>