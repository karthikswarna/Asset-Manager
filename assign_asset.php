<?php
//// This script is executed when "Assign Asset" button is pressed on dashboard.

include("config.php");

$category_id = $_POST["category"];
$product_id = $_POST["product"];
$employee_id = $_POST["assignee"];

// Select an "available" asset from asset table to checkout.
$select_stmt = "SELECT Barcode 
                FROM asset 
                WHERE Product_ID = :product_id AND Availability = true 
                LIMIT 1;";
$select_query = $db_conn->prepare($select_stmt);
$select_query->bindParam(":product_id", $product_id, PDO::PARAM_STR);
$select_query->execute();
$asset = $select_query->fetch(PDO::FETCH_ASSOC);

// Barcode of the selected asset.
$barcode = $asset["Barcode"];

// Update the availability of the asset in asset table.
$update_stmt = "UPDATE asset
                SET Availability = false
                WHERE Barcode = :barcode;";
$update_query = $db_conn->prepare($update_stmt);
$update_query->bindParam(":barcode", $barcode, PDO::PARAM_STR);
$update_query->execute();

// Insert checkout data into checkouts table.
$insert_stmt = "INSERT INTO checkouts(Employee_ID, Barcode, checkin_date, checkout_date)
                VALUES (:employee_id, :barcode, NULL, now());";
$insert_query = $db_conn->prepare($insert_stmt);
$insert_query->bindParam(":employee_id", $employee_id, PDO::PARAM_STR);
$insert_query->bindParam(":barcode", $barcode, PDO::PARAM_STR);
$insert_query->execute();

header("Location: dashboard.php");

?>