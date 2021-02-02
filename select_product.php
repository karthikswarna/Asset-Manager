<?Php
    // Script for creating Linked drop down lists in "Assign an asset" modal on dashboard.

    @$cat_id = $_GET['cat_id'];

    if(!isset($cat_id) || !is_numeric($cat_id))
    {
        $error = array("catErr" => "Internal server Error, try again later!");
        include("error.php");
        exit;
    }

    require "config.php";

    if($cat_id == "0")
    {
        // Query to select available products for 'All Categories'(cat_id = 0).
        $prod_select = "SELECT product.Product_ID, Name, COUNT(Availability) 
                        FROM product 
                        INNER JOIN asset ON product.Product_ID = asset.Product_ID AND asset.Availability = true AND product.Expired = false
                        GROUP BY Name";
        $prod_query = $db_conn->prepare($prod_select);

        $prod_query->execute();
        $products = $prod_query->fetchAll(PDO::FETCH_ASSOC);
    }
    else
    {
        // Query to select available products for a specific category(cat_id > 0).
        $prod_select = "SELECT product.Product_ID, Name, COUNT(Availability) 
                        FROM product 
                        INNER JOIN asset ON product.Product_ID = asset.Product_ID AND asset.Availability = true AND product.Expired = false
                        WHERE product.Category_ID = :category_id
                        GROUP BY Name";
        $prod_query = $db_conn->prepare($prod_select);
        $prod_query->bindParam(":category_id", $cat_id, PDO::PARAM_STR);

        $prod_query->execute();
        $products = $prod_query->fetchAll(PDO::FETCH_ASSOC);
    }

    $main = array('data'=>$products);
    echo json_encode($main);
?>