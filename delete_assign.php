<?php
// Script that executes when "check-in this item" is pressed on dashboard page.

include("config.php");

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']))
{
    $id = (int)$_GET['id'];
    if(!filter_var($id, FILTER_VALIDATE_INT))
    {
        // If server error occurs, only show that error and exit.
        $error = array("checkinErr" => "Internal server Error, try again later!");
        echo json_encode($error);
        exit;
    }

    try
    {
        $db_conn->beginTransaction();

        // Update checkouts table with current time as checkin time.
        $update_stmt = "UPDATE checkouts
                        SET checkin_date = now()
                        WHERE Check_ID = '$id';";
        $update_query = $db_conn->prepare($update_stmt);
        $update_query->execute();
        $update_query->closeCursor();


        // Get the barcode of checkedin asset.
        $select_stmt = "SELECT Barcode 
                        FROM checkouts
                        WHERE Check_ID = '$id';";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $barcode = $select_query->fetch(PDO::FETCH_ASSOC);
        $select_query->closeCursor();
        $barcode = $barcode['Barcode'];


        // Find whether the returned asset is expired or not.
        $select_stmt = "SELECT Expired
                        FROM asset
                        INNER JOIN product ON asset.Product_ID = product.Product_ID AND asset.Barcode = '$barcode';";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $expired = $select_query->fetch(PDO::FETCH_ASSOC);
        $select_query->closeCursor();
        $expired = $expired['Expired'];
        
        // If it is not expired.
        if($expired == 0)
        {
            // Update the availability of the currently checkedin asset.
            $update_stmt = "UPDATE asset
                            SET Availability = 1
                            WHERE Barcode = :barcode;";
            $update_query = $db_conn->prepare($update_stmt);
            $update_query->bindParam(":barcode", $barcode, PDO::PARAM_STR);
            $update_query->execute();
            $update_query->closeCursor();
        }
            
        $db_conn->commit();
    }
    catch(PDOException $e)
    {
        $db_conn->rollBack();
        $error = array("checkinErr"=>$e->getMessage());
        echo json_encode($error);
        exit;
    }
}

header("Location: dashboard.php");

?>