<?php
// Main page for assigning assets and viewing all ownerships.

session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("Location: index.php");
    exit;
}

include("config.php");



// Query to select the categories.
$cat_select = "SELECT Category_ID, Category_name FROM category";
$cat_query = $db_conn->prepare($cat_select);



// Query to select available products.
$prod_select = "SELECT product.Product_ID, Name, COUNT(Availability) 
                FROM product 
                INNER JOIN asset ON product.Product_ID = asset.Product_ID AND asset.Availability = true 
                GROUP BY Name";
$prod_query = $db_conn->prepare($prod_select);



// Query to select the employees.
$emp_select = "SELECT Employee_ID, Name FROM employee";
$emp_query = $db_conn->prepare($emp_select);

?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
    <title>Asset Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
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

            <h1>Hello, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>.</h1>
        </div>
        
        <div class="w3-container">
            <h2>All assigned assets</h2>
            <button id="myBtn">Assign an asset  +</button>
            <hr>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">
            
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Assets</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form method="POST" name="assign_form" action="assign_asset.php" id="log" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label> Select the Category </label>
                        <select class="form-control" id="s1" onchange="AjaxFunction()" name="category" required>
                            <option value="0" selected>All Categories</option>
                            <?php
                                $cat_query->execute();
                                if($cat_query->rowCount() > 0)
                                {
                                    if($categories = $cat_query->fetchAll())
                                    {
                                        foreach($categories as $category): ?>
                                                <option value="<?php echo $category['Category_ID']?>"><?php echo $category['Category_name']; ?></option>";
                                        <?php endforeach;
                                    }
                                }
                                else
                                { ?>
                                    <option value="None">None</option>
                          <?php }

                                $cat_query->closeCursor();
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label> Select the Product </label>
                        <select class="form-control" id="s2" name="product" required>
                            <?php
                                $prod_query->execute();
                                if($prod_query->rowCount() > 0)
                                {
                                    if($products = $prod_query->fetchAll())
                                    {
                                        foreach($products as $product): ?>
                                                <option value="<?php echo $product['Product_ID']?>"><?php echo $product['Name']; ?></option>";
                                        <?php endforeach;
                                    }
                                }
                                else
                                { ?>
                                    <option value="None">None</option>
                          <?php }

                                $cat_query->closeCursor();
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label> Select the Assignee </label>
                        <select class="form-control" name="assignee" required>
                            <?php
                                $emp_query->execute();
                                if($emp_query->rowCount() > 0)
                                {
                                    if($employees = $emp_query->fetchAll())
                                    {
                                        foreach($employees as $employees): ?>
                                                <option value="<?php echo $employees['Employee_ID']?>"><?php echo $employees['Name']; ?></option>";
                                        <?php endforeach;
                                    }
                                }
                                else
                                { ?>
                                    <option value="None">None</option>
                          <?php }

                                $cat_query->closeCursor();
                            ?>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign asset</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php include("view_assigns.php"); ?>