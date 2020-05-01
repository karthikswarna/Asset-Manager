<?php
//// This script is executed when "Add employee" button is pressed on employee dashboard.

include("config.php");

$emp_name = $_POST["emp_name"];
$emp_dept = $_POST["emp_dept"];
$emp_mail = $_POST["emp_mail"];
$emp_phn1 = $_POST["emp_phn1"];

if(isset($_POST["emp_phn2"]))
{
    $emp_phn2 = $_POST["emp_phn2"];

}
else
{
    $emp_phn2 = null;
}

if(!isset($_FILES['emp_img']) || $_FILES['emp_img']['error'] == UPLOAD_ERR_NO_FILE)
{
    $emp_img = null;
    echo "vbdnvbjnk";
}
else
{    
    // Validating and Uploading image.
    $target_dir = "Uploads/";
    $target_file = $target_dir . basename($_FILES["emp_img"]["name"]); // Destination path of the image to be uploaded.
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File extension of the file (in lower case)
    $emp_img = date("YmdHis") . "." . $imageFileType; // Give the image a new name with the current date + time.

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"]))
    {
        $check = getimagesize($_FILES["emp_img"]["tmp_name"]);
        if($check !== false)
        {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }
        else
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file))
    {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size - 500KB
    if ($_FILES["emp_img"]["size"] > 500000)
    {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0)
    {
        echo "Sorry, your file was not uploaded.";
    }
    else
    {
        $target_file = $target_dir . $emp_img; // Give the file a new name -> Cuttent date + time.
        
        if (move_uploaded_file($_FILES["emp_img"]["tmp_name"], $target_file))
        {
            echo "The file ". basename( $_FILES["emp_img"]["name"]). " has been uploaded.";
        }
        else
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


// Insert employee into database.
$insert_stmt = "INSERT INTO employee (Name, Department, Email, Work_phone, Personal_phone, Image)
                VALUES (?, ?, ?, ?, ?, ?);";
$insert_query = $db_conn->prepare($insert_stmt);
$insert_query->execute([$emp_name, $emp_dept, $emp_mail, $emp_phn1, $emp_phn2, $emp_img]);

header("Location: emp_dashboard.php");

?>