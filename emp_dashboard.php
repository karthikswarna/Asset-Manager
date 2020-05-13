<?php
// Page for Employee data.

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("Location: index.php");
    exit;
}

include("config.php");

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Employees</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/dash_emp.css">
    <link rel="stylesheet" href="./CSS/common.css">
</head>

<body>

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>

    <!-- Page Content -->
    <div class="PageContent">
        <div class="w3-container w3-teal">
            <button style="float: left; padding: 20px;;" id="navLink" class="w3-button w3-teal w3-xlarge">☰</button>

            <h1 style="margin-top:1%">Hello, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>.</h1>
        </div>

        <div class="w3-container">
            <h2>All Employees</h2>
            <button id="myBtn">New Employee  +</button>
            <hr>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" name="employee_form" action=<?php echo htmlspecialchars("add_employee.php") ?> id="log" enctype="multipart/form-data">
                    <div class="form-group required">
                        <label for="emp_name" class="control-label">Full Name </label>
                        <input id="emp_name" type="text" name="emp_name" value="" placeholder="Enter employee's Name" required class="form-control">
                    </div>

                    <div class="form-group required">
                        <label for="emp_dept" class="control-label">Department </label>
                        <input id="emp_dept" type="text" name="emp_dept" value="" placeholder="Enter the department" required class="form-control">
                    </div>
                    
                    <div class="form-group required">
                        <label for="emp_mail" class="control-label">E-mail  </label>
                        <input id="emp_mail" type="email" name="emp_mail" value="" placeholder="Enter E-mail" required class="form-control">
                    </div>
                    
                    <div class="form-group required">
                        <label for="emp_phn1" class="control-label">Work phone  </label>
                        <input id="emp_phn1" type="text" name="emp_phn1" value="" placeholder="Enter work phone" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="emp_phn2">Personal phone  </label>
                        <input id="emp_phn2" type="text" name="emp_phn2" value="" placeholder="Enter personal phone" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="emp_img">Photo  </label>
                        <input id="emp_img" type="file" name="emp_img" value="" accept="image/*" placeholder="Upload the photo" class="form-control">
                    </div>
                    
                    <div class="form-group required">
                        <label class="control-label"></label>
                        <span>Required</span>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add New Employee</button>
                    </div>
                </form>
            </div>
        </div>

        <?php include("view_employees.php"); ?>