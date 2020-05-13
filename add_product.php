<?php
//// This script is executed when "Add Product" button is pressed on prod_dashboard.

include("config.php");
include("test_input.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $error = array("dateErr"=>"", "quantErr"=>"", "priceErr"=>"", "imgErr"=>"");
    $uploadOk = 1;

    $prod_name = test_input($_POST['prod_name']); //Sanitizing product name. 
    $prod_desc = test_input($_POST['prod_desc']); //Sanitizing product description.
    

    // Validating supplier ID.
    $prod_sup_id = test_input($_POST['prod_sup']);
    if(!filter_var($prod_sup_id, FILTER_VALIDATE_INT))
    {
        // If server error occurs, only show that error and exit.
        $error = array("supErr" => "Internal server Error, try again later!");
        include("error.php");
        exit;
    }


    // Validating date.
    $date_sup = $_POST['date_sup'];
    list($y, $m, $d) = explode('-', $date_sup);
    if(!checkdate($m, $d, $y))
    {
        $error["dateErr"] = "Date Error - Invalid format";
        $uploadOk = 0;
    }


    // Validating quantity.
    $prod_quant = test_input($_POST['prod_quant']);
    if(!filter_var($prod_quant, FILTER_VALIDATE_INT))
    {
        $error["quantErr"] = "Data Error, Enter valid quantity.";
        $uploadOk = 0;
    }


    // Validating price.
    $prod_price = test_input($_POST['prod_price']);
    if(!filter_var($prod_price, FILTER_VALIDATE_INT))
    {
        $error["priceErr"] = "Data Error, Enter valid price.";
        $uploadOk = 0;
    }


    // Select existing category or new category.
    if(!isset($_POST['prod_cat']) || empty(trim($_POST['prod_cat'])))
    {
        $prod_cat = $_POST['new_cat'];
    }
    else
    {
        $prod_cat = $_POST['prod_cat'];
    }


    // Validating and Uploading image.
    $target_dir = "Uploads/";
    $target_file = $target_dir . basename($_FILES["prod_img"]["name"]); // Destination path of the image to be uploaded.
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File extension of the file (in lower case)
    $new_file_name = date("YmdHis") . "." . $imageFileType; // Give the image a new name with the current date + time.

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"]))
    {
        $check = getimagesize($_FILES["prod_img"]["tmp_name"]);
        if($check === false)
        {
            $error["imgErr"] = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size - 500KB
    if ($_FILES["prod_img"]["size"] > 500000)
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

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0)
    {
        include("error.php");
        exit;
    }
    else
    {
        $target_file = $target_dir . $new_file_name; // Give the file a new name -> Cuttent date + time.
        
        if (!move_uploaded_file($_FILES["prod_img"]["tmp_name"], $target_file)) // Move the file from src to dest location.
        {
            // If server error occurs, only show that error and exit.
            $error = array("uploadErr" => "Internal server error while uploading the image, try again later!");
            include("error.php");
            exit;
        }
    }


    try
    {
        $db_conn->beginTransaction();

        // Check the existance of category -> if already present continue, else insert new category into DB.
        $check_stmt = "SELECT 1 
                    FROM category 
                    WHERE Category_name = '$prod_cat' 
                    LIMIT 1;";
        $check_query = $db_conn->prepare($check_stmt);
        $check_query->execute();

        if($check_query->rowCount() == 0)
        {
            $insert_stmt = "INSERT INTO category (Category_name)
                            VALUES (?);";
            $insert_query = $db_conn->prepare($insert_stmt);
            $insert_query->execute([$prod_cat]);
        }


        // Get the category Id of the needed category from DB.
        $select_stmt = "SELECT Category_ID 
                        FROM category 
                        WHERE Category_name = '$prod_cat';";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $prod_cat_id = $select_query->fetch(PDO::FETCH_ASSOC);
        $prod_cat_id = $prod_cat_id['Category_ID'];


        // Insert products into database.
        $insert_stmt = "INSERT INTO product (Category_ID, Name, Description, Total_quantity, Image)
                        VALUES (?, ?, ?, ?, ?);";
        $insert_query = $db_conn->prepare($insert_stmt);
        $insert_query->execute([$prod_cat_id, $prod_name, $prod_desc, $prod_quant, $new_file_name]);


        // Get the product Id of the current product from DB.
        $select_stmt = "SELECT Product_ID 
                        FROM product
                        WHERE Name = '$prod_name';";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $prod_id = $select_query->fetch(PDO::FETCH_ASSOC);
        $prod_id = $prod_id['Product_ID'];


        // Insert total quantity of assets into DB with their barcodes.
        $insert_stmt = "INSERT INTO asset (Barcode, Product_ID, Availability, Expiry_date)
                        VALUES (?, ?, ?, ?);";
        $insert_query = $db_conn->prepare($insert_stmt);
        for($i = 1; $i <= (int)$prod_quant; $i++)
        {
            $barcode = "IITT-" . $prod_id . "-" . $prod_name . "-" . $i;
            $insert_query->execute([$barcode, $prod_id, true, null]);
        }


        // Insert entry into suppliedproduct table.
        $insert_stmt = "INSERT INTO suppliedproduct (Supplier_ID, Product_ID, Date_supplied, Quantity_supplied, Price)
                        VALUES (?, ?, ?, ?, ?);";
        $insert_query = $db_conn->prepare($insert_stmt);
        $insert_query->execute([$prod_sup_id, $prod_id, $date_sup, $prod_quant, $prod_price]);
    
    
        $db_conn->commit();
    }
    catch(PDOException $e)
    {
        $db_conn->rollBack();
        die($e->getMessage);
    }
}

header("Location: prod_dashboard.php");

?>