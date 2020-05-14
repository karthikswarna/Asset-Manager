<?php
// Script that is executes when "Delete" button is pressed on supplier tab.

include("config.php");

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['sup_id']))
{
    $sup_id = (int)$_GET['sup_id'];
    if(!filter_var($sup_id, FILTER_VALIDATE_INT))
    {
        // If server error occurs, only show that error and exit.
        $error = array("delErr" => "Internal server Error, try again later!");
        include("error.php");
        exit;
    }

    try
    {
        $db_conn->beginTransaction();

        // Update the status of supplier as not active.
        $update_stmt = "UPDATE supplier
                        SET Active = false
                        WHERE Supplier_ID = '$sup_id;";
        $update_query = $db_conn->prepare($update_stmt);
        $update_query->execute();
        $update_query->closeCursor();
        
        $db_conn->commit();
    }
    catch(PDOException $e)
    {
        $db_conn->rollBack();
        $error = array("delErr"=>$e->getMessage());
        include("error.php");
        exit;
    }
}

header("Location: sup_dashboard.php");

?>