<?php
// Login and login info validation page.

session_start();
 
// Check if the user is already logged in, if yes then redirect him to dashboard.
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("Location: dashboard.php");
    exit;
}
 
require_once "config.php";
 
$username = $password = "";
$name = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
    // Check if username is empty
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter username.";
    }
    else
    {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter your password.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err))
    {
        // Prepare a select statement
        $sql = "SELECT User_name, Name, Password FROM user WHERE User_name = :username";
        
        if($stmt = $db_conn->prepare($sql))
        {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute())
            {
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1)
                {
                    if($row = $stmt->fetch())
                    {
                        $username = $row["User_name"];
                        $name = $row["Name"];
                        $hashed_password = $row["Password"];
                        
                        if(password_verify($password, $hashed_password))
                        {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["name"] = $name;                            

                            // Redirect user to dashboard
                            header("Location: dashboard.php");
                        }
                        else
                        {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                }
                else
                {
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    //unset($db_conn);
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/login.css">
    <title>Login</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Asset</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            </ul>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-inline my-2 my-lg-0">

                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <input class="form-control mr-sm-2" type="text" name="username" placeholder="Username" aria-label="Username">
                    <!-- <span class="help-block"><?php echo $username_err; ?></span> -->
                    <?php if(!empty($username_err)){echo "<script type='text/javascript'>alert('$username_err');</script>";} ?>
                </div>
                
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input class="form-control mr-sm-2" type="password" name="password" placeholder="Password" aria-label="Password">
                    <!-- <span class="help-block"><?php echo $password_err; ?></span> -->
                    <?php if(!empty($password_err)){echo "<script type='text/javascript'>alert('$password_err');</script>";} ?>
                </div>

                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>

                <a class="nav-link" href="../rigister/register.html">Register</a>
            </form>
        </div>
    </nav>

    <div class="empty">
    </div>

    <div class="screen">
        <div class="screen2 jumbotron">
            <h1 class="display-3">Asset Manager</h1>
            <hr class="my-3">
            <p class="lead">
                This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.
            </p>
            <hr class="my-3">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>