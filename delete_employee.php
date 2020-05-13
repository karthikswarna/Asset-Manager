<?php

//Stopped here on 7-5-2020, foreign key constraint.
include("config.php");

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];
    $delete_stmt = "DELETE FROM employee
                    WHERE Employee_ID = '$id';";
    $delete_query = $db_conn->prepare($delete_stmt);
    $delete_query->execute();
}

header("Location: emp_dashboard.php");

?>