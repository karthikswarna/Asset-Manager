<?php
// Export login validation into different file, currently in index.php
require_once("conf.php");

$u_email = $_POST['u_email'];
$u_pass = $_POST['u_pass'];

if ($u_email=="admin" && $u_pass=="admin")
{
    session_start();
    
    $_SESSION['user_id'] = "admin";
    $_SESSION['user_name'] = "admin";
    
    header("Location:admin.php");
}
else
{    
    header("Location:index.php?msg=1");   
}

?>