<?php
// Page to display error messages.

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

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/dash_emp.css">
    <link rel="stylesheet" href="./CSS/common.css">
</head>

<body>

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>

    <div class="PageContent">
        <div class="w3-container w3-teal">
            <button style="float: left; padding: 20px;;" id="navLink" class="w3-button w3-teal w3-xlarge">☰</button>

            <h1 style="margin-top:1%">Hello, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>.</h1>
        </div>

        <div class="container" style="text-align:center">
            <div class="alert alert-danger" role="alert">
                <?php foreach($error as $e => $e_value):
                    if($e_value != "")
                    {
                        echo "<strong>$e_value</strong><br>";
                    }
                endforeach; ?>
            </div>
            
            <div class="alert alert-info" role="alert">
                <a href="javascript:history.back()">Go Back to fill the form again</a>
            </div>
        </div>
    </div>

    <script src="./Javascript/sidebar.js"></script>

</body>
</html>