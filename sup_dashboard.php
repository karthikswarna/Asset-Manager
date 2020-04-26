<!DOCTYPE html>
<html lang="en">
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="./CSS/dash_sup.css">
<link rel="stylesheet" href="./CSS/common.css">

<body>

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>

    <!-- Page Content -->
    <div class="PageContent">

        <div class="w3-container w3-teal">
            <button style="float: left; padding: 20px;;" class="w3-button w3-teal w3-xlarge" onclick="w3_open()">☰</button>

            <h1>Admin</h1>
        </div>




        <div class="w3-container">
            <h2>Suppliers</h2>
            <button id="myBtn">New Supplier  +</button>
            <hr>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">

                <table>
                    <tr>
                        <td>Supplier Name</td>
                        <th><input></th>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <th><input></th>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <th><input></th>
                    </tr>





                </table>
                <hr>
                <button>Add</button>
            </div>

        </div>




        <table id="customers">
            <tr>
                <th>Id</th>
                <th>Name</th>

                <th>Email</th>

                <th>Phone</th>
                <th>Action</th>


            </tr>


            <!-- Asset 1 -->
            <tr>
                <td>1</td>
                <td>Dheeraj</td>

                <td>daaa@mail.com</td>

                <td>187893233+</td>
                <td>

                    <button type="button" class="collapsible">History</button>
                    <div class="content">
                        <h3>Supplies</h3>
                        <table>
                            <tr>

                                <th>Supply Id</th>
                                <th>Product_ID</th>
                                <th>Date Supplied</th>
                                <th>Price</th>

                            </tr>
                            <tr>

                                <td>1</td>
                                <td>bottle</td>
                                <td>2nd April 2020</td>
                                <td>12$</td>

                            </tr>
                            <tr>

                                <td>6</td>
                                <td>table</td>
                                <td>2nd Oct 2019</td>
                                <td>55$</td>

                            </tr>
                            <tr>

                                <td>11</td>
                                <td>table</td>
                                <td>1st Jan 2019</td>
                                <td>80$</td>

                            </tr>
                        </table>
                    </div>
                    <button>Delete</button>
                </td>
            </tr>

            <!-- Asset 2 -->

        </table>

    </div>

    <script src="./Javascript/dash_sup.js"></script>
</body>

</html>