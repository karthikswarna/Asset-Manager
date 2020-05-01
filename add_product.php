<?php
//// This script is executed when "Add Product" button is pressed on prod_dashboard.

include("config.php");

$prod_name = $_POST['prod_name'];
$prod_desc = $_POST['prod_desc'];
$prod_sup_id = $_POST['prod_sup'];
$date_sup = $_POST['date_sup'];

// Validating quantity.
$prod_quant = $_POST['prod_quant'];
if(!filter_var($prod_quant, FILTER_VALIDATE_INT))
{
    echo "Data Error, Enter valid quantity!";
    exit;
}

// Validating price.
$prod_price = $_POST['prod_price'];
if(!filter_var($prod_price, FILTER_VALIDATE_INT))
{
    echo "Data Error, Enter valid price!";
    exit;
}

// Select existing category or new category.
if(empty(trim($_POST['prod_cat'])))
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
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // File extension of the file (in lower case)
$new_file_name = date("YmdHis") . "." . $imageFileType; // Give the image a new name with the current date + time.

// Check if image file is a actual image or fake image
if(isset($_POST["submit"]))
{
    $check = getimagesize($_FILES["prod_img"]["tmp_name"]);
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
if ($_FILES["prod_img"]["size"] > 500000)
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
    $target_file = $target_dir . $new_file_name; // Give the file a new name -> Cuttent date + time.
    
    if (move_uploaded_file($_FILES["prod_img"]["tmp_name"], $target_file))
    {
        echo "The file ". basename( $_FILES["prod_img"]["name"]). " has been uploaded.";
    }
    else
    {
        echo "Sorry, there was an error uploading your file.";
    }
}



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

header("Location: prod_dashboard.php");

?>