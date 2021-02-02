<?php
//// This script is executed when "Add employee" button is pressed on employee dashboard.

include("config.php");
include("test_input.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $error = array("nameErr"=>"", "emailErr"=>"", "deptErr"=>"", "phn1Err"=>"", "phn2Err"=>"", "imgErr"=>"");
    $uploadOk = 1;

    // Name validation
    $emp_name = test_input($_POST["emp_name"]);
    if (!preg_match("/^[a-zA-Z ]+$/", $emp_name))
    {
        $error["nameErr"] = "Name Error - Only letters and white space allowed";
        $uploadOk = 0;
    }
    
    // Email validation
    $emp_mail = test_input($_POST["emp_mail"]);
    if (!filter_var($emp_mail, FILTER_VALIDATE_EMAIL))
    {
        $error["emailErr"] = "E-mail Error - Invalid format";
        $uploadOk = 0;
    }
    
    // Department validation.
    $emp_dept = test_input($_POST["emp_dept"]);
    if (!preg_match("/^[a-zA-Z ]*$/", $emp_dept))
    {
        $error["deptErr"] = "Department Error - Only letters and white space allowed";
        $uploadOk = 0;
    }

    // Work phone Validation
    $emp_phn1 = test_input($_POST["emp_phn1"]);
    $emp_phn1 = filter_var($emp_phn1, FILTER_SANITIZE_NUMBER_INT);
    $num_without_dash = str_replace("-", "", $emp_phn1);
    if (strlen($num_without_dash) < 10 || strlen($num_without_dash) > 14)
    {
        $error["phn1Err"] = "Work phone Error - Invalid Number";
        $uploadOk = 0;
    }

    // Personal phone Validation
    if(isset($_POST["emp_phn2"]))
    {
        $emp_phn2 = test_input($_POST["emp_phn2"]);
        $emp_phn2 = filter_var($emp_phn2, FILTER_SANITIZE_NUMBER_INT);
        $num2_without_dash = str_replace("-", "", $emp_phn2);
        if (strlen($num2_without_dash) < 10 || strlen($num2_without_dash) > 14)
        {
            $error["phn2Err"] = "Personal phone Error - Invalid Number";
            $uploadOk = 0;
        }
    }
    else
    {
        $emp_phn2 = null;
    }

    // Image Validation
    if(!isset($_FILES['emp_img']) || $_FILES['emp_img']['error'] == UPLOAD_ERR_NO_FILE)
    {
        $emp_img = null;
    }
    else
    {    
        // Validating and Uploading image.
        $target_dir = "Uploads/";
        $target_file = $target_dir . basename($_FILES["emp_img"]["name"]); // Destination path of the image to be uploaded.
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File extension of the file (in lower case)
        $emp_img = date("YmdHis") . "." . $imageFileType; // Give the image a new name with the current date + time.

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"]))
        {
            $check = getimagesize($_FILES["emp_img"]["tmp_name"]);
            if($check === false)
            {
                $error["imgErr"] = "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check file size - 500KB
        if ($_FILES["emp_img"]["size"] > 500000)
        {
            $error["imgErr"] = "Image file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
        {
            $error["imgErr"] = "Invalid file format. Only JPG, PNG, JPEG, GIF allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error. This is necessary because, the file should not be saved if there is an error.
        if ($uploadOk == 0)
        {
            include("error.php");
            exit;
        }
        else
        {
            $target_file = $target_dir . $emp_img; // Give the file a new name -> Cuttent date + time.
            
            if (!move_uploaded_file($_FILES["emp_img"]["tmp_name"], $target_file)) // Move the file from src to dest location.
            {
                // If server error occurs, only show that error and exit.
                $error = array("uploadErr" => "Internal server error while uploading the image, try again later!");
                include("error.php");
                exit;
            }
        }
    }

    // Check if $uploadOk is set to 0 by an error. This is necessary as image may not be uploaded by the user.
    if($uploadOk == 0)
    {
        include("error.php");
        exit;
    }

    try
    {
        $db_conn->beginTransaction();

        // Insert employee into database.
        $insert_stmt = "INSERT INTO employee (Name, Department, Email, Work_phone, Personal_phone, Image)
                        VALUES (?, ?, ?, ?, ?, ?);";
        $insert_query = $db_conn->prepare($insert_stmt);
        $insert_query->execute([$emp_name, $emp_dept, $emp_mail, $emp_phn1, $emp_phn2, $emp_img]);
        $insert_query->closeCursor();
        
        $db_conn->commit();
    }
    catch(PDOException $e)
    {
        $db_conn->rollBack();
        $error = array("addErr"=>$e->getMessage());
        include("error.php");
        exit;
    }
}

header("Location: emp_dashboard.php");

?>