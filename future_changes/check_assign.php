<?Php
// Three way linked drop down.
require "config.php";

$category_id = $_GET['category_id'];
$product_id = $_GET['product_id'];
$asset_code = $_GET['asset_code'];

if(strlen($category_id) > 0)
{
    // Validate the inputs
    if(!is_numeric($category_id))
    {
        echo "Data Error";
        exit;
    }

    if($category_id === "0")
    {
        $prod_select = "SELECT Product_ID, Name FROM product";
        $prod_query = $db_conn->prepare($prod_select);
        $prod_query->execute();
        $products = $prod_query->fetchAll(PDO::FETCH_ASSOC);
    }
    else
    {
        $prod_select = "SELECT DISTINCT Product_ID, Name FROM product WHERE product.Category_ID = :category_id";
        $prod_query = $db_conn->prepare($prod_select);
        $prod_query->bindParam(":category_id", $category_id, PDO::PARAM_STR);
        $prod_query->execute();
        $products = $prod_query->fetchAll(PDO::FETCH_ASSOC);
    }
}

if(strlen($product_id) > 0)
{
    // Validate the inputs
    if(!is_numeric($product_id))
    {
        echo "Data Error";
        exit;
    }

    if($product_id === "0")
    {
        $asset_select = "SELECT Barcode, Product_ID FROM asset";
        $asset_query = $db_conn->prepare($asset_select);
        $asset_query->execute();
        $assets = $asset_query->fetchAll(PDO::FETCH_ASSOC);
    
    }
    else
    {
        $asset_select = "SELECT Barcode, Product_ID FROM asset WHERE asset.Product_ID = :product_id";
        $asset_query = $db_conn->prepare($asset_select);
        $asset_query->bindParam(":product_id", $product_id, PDO::PARAM_STR);
        $asset_query->execute();
        $assets = $asset_query->fetchAll(PDO::FETCH_ASSOC);
    }
}
else if($product_id === '')
{
    if($category_id === "0")
    {
        $asset_select = "SELECT Barcode, Product_ID FROM asset";
        $asset_query = $db_conn->prepare($asset_select);
        $asset_query->execute();
        $assets = $asset_query->fetchAll(PDO::FETCH_ASSOC);
    }
    else
    {
        $asset_select = "SELECT DISTINCT Barcode, Product_ID FROM asset INNER JOIN product WHERE product.Category_ID = :category_id";
        $asset_query = $db_conn->prepare($asset_select);
        $asset_query->bindParam(":product_id", $product_id, PDO::PARAM_STR);
        $asset_query->execute();
        $assets = $asset_query->fetchAll(PDO::FETCH_ASSOC);
    }
}

$main = array('products' => $products, 
              'assets' => $assets, 
              'value' => array("product_id" => $product_id, 
                               "asset_code" => $asset_code));
echo json_encode($main); 

?>