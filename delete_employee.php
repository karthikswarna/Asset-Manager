<?php
// Script that is executes when "Delete" button is pressed on employee tab.

include("config.php");

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['emp_id']))
{
    $emp_id = (int)$_GET['emp_id'];
    if(!filter_var($emp_id, FILTER_VALIDATE_INT))
    {
        // If server error occurs, only show that error and exit.
        $error = array("delErr" => "Internal server Error, try again later!");
        include("error.php");
        exit;
    }

    try
    {
        $db_conn->beginTransaction();

        $select_stmt = "SELECT COUNT(Check_ID) AS debt
                        FROM checkouts
                        WHERE Employee_ID = '$emp_id' AND checkin_date IS NULL;";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $debt = $select_query->fetch(PDO::FETCH_ASSOC);
        $select_query->closeCursor();
        $debt = $debt['debt'];

        if($debt == 0)
        {
            // Update the status of employee as not current.
            $update_stmt = "UPDATE employee
                            SET Current_employee = false
                            WHERE Employee_ID = '$emp_id;";
            $update_query = $db_conn->prepare($update_stmt);
            $update_query->execute();
            $update_query->closeCursor();
        }
        else
        {
            throw new Exception("Cannot delete employee, some assets are still assigned.");    
        }
        
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

header("Location: emp_dashboard.php");

?>