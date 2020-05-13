<?php

include("config.php");

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];
    $update_stmt = "UPDATE checkouts
                    SET checkin_date = now()
                    WHERE Check_ID = '$id';";
    $update_query = $db_conn->prepare($update_stmt);
    $update_query->execute();

    $select_stmt = "SELECT Barcode 
                    FROM checkouts
                    WHERE Check_ID = '$id';";
    $select_query = $db_conn->prepare($select_stmt);
    $select_query->execute();

    $barcode = $select_query->fetch(PDO::FETCH_ASSOC)['Barcode'];

    $update_stmt = "UPDATE asset
                    SET Availability = 1
                    WHERE Barcode = :barcode;";
    $update_query = $db_conn->prepare($update_stmt);
    $update_query->bindParam(":barcode", $barcode, PDO::PARAM_STR);
    $update_query->execute();
}

header("Location: dashboard.php");

?>