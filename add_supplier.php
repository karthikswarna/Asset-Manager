<?php
//// This script is executed when "Add supplier" button is pressed on supplier dashboard.

include("config.php");

$supp_name = $_POST["supp_name"];
$supp_mail = $_POST["supp_mail"];
$supp_phn = $_POST["supp_phn"];

// Insert supplier into database.
$insert_stmt = "INSERT INTO supplier (Supplier_name, Email, Phone_number)
                VALUES (?, ?, ?);";
$insert_query = $db_conn->prepare($insert_stmt);
$insert_query->execute([$supp_name, $supp_mail, $supp_phn]);

header("Location: sup_dashboard.php");

?>