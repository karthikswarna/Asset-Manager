<?php
// Page for storing new products and maintaining the inventory.

if(!isset($_SESSION))
{
    session_start();
}

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("Location: index.php");
    exit;
}

include("config.php");


// Query to select the categories.
$cat_select = "SELECT Category_name FROM category;";
$cat_query = $db_conn->prepare($cat_select);

// Query to select the supplier.
$sup_stmt = "SELECT Supplier_ID, Supplier_name FROM supplier;";
$sup_query = $db_conn->prepare($sup_stmt);

?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
    <title>Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/dashboard.css">
    <link rel="stylesheet" href="./CSS/common.css">
</head>

<body>

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>

    <!-- Page Content -->
    <div class="PageContent">
        <div class="w3-container w3-teal">
            <button style="float: left; padding: 20px;;" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">☰</button>

            <h1 style="margin-top:1%">Hello, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>.</h1>
        </div>
        
        <div class="w3-container">
            <h2>All products</h2>
            <button id="myBtn">Add a new product  +</button>
            <hr>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">
            
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form method="POST" name="product_form" action="add_product.php" id="log" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="prod_name">Name </label>
                        <input id="prod_name" type="text" name="prod_name" value="" placeholder="Enter product's Name" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="prod_desc">Description </label>
                        <input id="prod_desc" type="text" name="prod_desc" value="" placeholder="Enter description" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="prod_img">Photo  </label>
                        <input id="prod_img" type="file" name="prod_img" value="" accept="image/*" placeholder="Upload the photo" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="prod_cat"> Select the Category </label>
                        <select id="prod_cat" name="prod_cat" required class="form-control">
                            <option value="" selected>Choose</option>
                            <?php
                                $cat_query->execute();
                                if($categories = $cat_query->fetchAll())
                                {
                                    foreach($categories as $category): ?>
                                            <option value="<?php echo $category['Category_name']?>"><?php echo $category['Category_name']; ?></option>";
                                    <?php endforeach;
                                }

                                $cat_query->closeCursor();
                            ?>
                        </select>
                    </div>
                    
                    <a data-toggle="collapse" href="#" aria-controls="add_cat" class="text-secondary collapsible"><span class="fa fa-plus p-2 icon-color"></span>Add New Categories</a>
                    <div class="form-group collapse" id="add_cat">
                        <label for="new_cat"> Name of category </label>
                        <input id="new_cat" type="text" name="new_cat" value="" placeholder="Type a Category" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="prod_sup"> Supplied by &nbsp </label>
                        <span style="font-size:14px" class="fa fa-question-circle" data-toggle='tooltip' title="Didn't find the right supplier? Considering adding the supplier details by going into Suppliers tab." aria-hidden="true"></span>
                        <select id="prod_sup" name="prod_sup" required class="form-control">
                            <option value="" selected>Choose</option>
                            <?php
                                $sup_query->execute();
                                if($suppliers = $sup_query->fetchAll())
                                {
                                    foreach($suppliers as $supplier): ?>
                                            <option value="<?php echo $supplier['Supplier_ID']?>"><?php echo $supplier['Supplier_name']; ?></option>";
                                    <?php endforeach;
                                }

                                $sup_query->closeCursor();
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date_sup">Date supplied</label>
                        <input id="date_sup" type="date" name="date_sup" value="" placeholder="Date at which product is supplied" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="prod_quant">Quantity supplied</label>
                        <input id="prod_quant" type="text" name="prod_quant" value="" placeholder="Enter quantity" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="prod_price">Total price</label>
                        <input id="prod_price" type="text" name="prod_price" value="" placeholder="Enter price" required class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Add product</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php include("view_products.php"); ?>