<?php
//// This script is executed when "Add supplier" button is pressed on supplier dashboard.

include("config.php");
include("test_input.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $error = array("nameErr"=>"", "emailErr"=>"", "phnErr"=>"");
    $uploadOk = 1;

    // Name validation.
    $supp_name = test_input($_POST["supp_name"]);
    if (!preg_match("/^[a-zA-Z-' ]+$/", $supp_name))
    {
        $error["nameErr"] = "Name Error - Only letters, hyphen, apostrophe and white space allowed";
        $uploadOk = 0;
    }

    // Email validation
    $supp_mail = test_input($_POST["supp_mail"]);
    if (!filter_var($supp_mail, FILTER_VALIDATE_EMAIL))
    {
        $error["emailErr"] = "E-mail Error - Invalid format";
        $uploadOk = 0;
    }

    // Phone validation.
    $supp_phn = test_input($_POST["supp_phn"]);
    $supp_phn = filter_var($supp_phn, FILTER_SANITIZE_NUMBER_INT);
    $num_without_dash = str_replace("-", "", $supp_phn);
    if (strlen($num_without_dash) < 10 || strlen($num_without_dash) > 14)
    {
        $error["phnErr"] = "Phone Error - Invalid Number";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error.
    if($uploadOk == 0)
    {
        include("error.php");
        exit;
    }


    try
    {
        $db_conn->beginTransaction();

        // Insert supplier into database.
        $insert_stmt = "INSERT INTO supplier (Supplier_name, Email, Phone_number)
                        VALUES (?, ?, ?);";
        $insert_query = $db_conn->prepare($insert_stmt);
        $insert_query->execute([$supp_name, $supp_mail, $supp_phn]);
        $insert_query->closeCursor();
        
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