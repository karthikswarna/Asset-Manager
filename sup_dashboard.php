<?php
// Page for Supplier data.

if(!isset($_SESSION))
{
    session_start();
}

// Check if the user is logged in, if not redirect to login page.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("Location: index.php");
    exit;
}

include("config.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Suppliers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="./CSS/dash_sup.css">
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
            <h2>All Suppliers</h2>
            <button id="myBtn">New Supplier  +</button>
            <hr>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" name="supplier_form" action="add_supplier.php" id="log" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="supp_name">Supplier Name</label>
                        <input id="supp_name" type="text" name="supp_name" value="" placeholder="Enter supplier's Name" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="supp_mail">Email</label>
                        <input id="supp_mail" type="text" name="supp_mail" value="" placeholder="Enter E-mail" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="supp_phn">Phone</label>
                        <input id="supp_phn" type="text" name="supp_phn" value="" placeholder="Enter phone" required class="form-control">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add New Supplier</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <?php include("view_suppliers.php"); ?>