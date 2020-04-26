<!DOCTYPE html>
<html lang = 'en'>

<head>
    <title>Employees</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="./CSS/dash_emp.css">
    <link rel="stylesheet" href="./CSS/common.css">
</head>

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
            <h2>All Employees</h2>
            <button id="myBtn">New Employee  +</button>
            <hr>
        </div>

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">

                <table>
                    <tr>
                        <td>Employee Name</td>
                        <th><input></th>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <th><input></th>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <th><input></th>
                    </tr>
                    <tr>
                        <td>Work Phone</td>
                        <th><input></th>
                    </tr>
                    <tr>
                        <td>Presonal Phone</td>
                        <th><input></th>
                    </tr>


                    <tr>
                        <td>Display Picture</td>
                        <th><input type="file" id="img" name="img" accept="image/*"></th>
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
                <th>Department</th>
                <th>Email</th>
                <th>Work Phone</th>
                <th>Personal Phone</th>
                <th>Action</th>


            </tr>


            <!-- Asset 1 -->
            <tr>
                <td>1</td>
                <td>Karthik</td>
                <td>Computers</td>
                <td>daaa@mail.com</td>
                <td>123123123+</td>
                <td>123893233+</td>
                <td>
                    <button type="button" class="collapsible">Details</button>
                    <div class="content">
                        <table>

                            <tr>
                                <th>Display Image</th>
                                <td><img class="display" src="./imgs/real_man.jpg" alt="Bar_Code">
                                </td>
                            </tr>
                            <tr>
                                <th>Employee ID</th>
                                <td>123</td>
                            </tr>

                        </table>



                    </div>
                    <button type="button" class="collapsible">History</button>
                    <div class="content">
                        <h3>Products</h3>
                        <table>
                            <tr>

                                <th>Product Id</th>
                                <th> Name</th>
                                <th>Check-In Time</th>
                                <th>Check-Out Time</th>

                            </tr>
                            <tr>

                                <td>1</td>
                                <td>bottle</td>
                                <td>2nd April 2020</td>
                                <td>Current Owner</td>

                            </tr>
                            <tr>

                                <td>6</td>
                                <td>table</td>
                                <td>2nd Oct 2019</td>
                                <td>4th Oct 2019</td>

                            </tr>
                            <tr>

                                <td>11</td>
                                <td>table</td>
                                <td>1st Jan 2019</td>
                                <td>2nd April 2019</td>

                            </tr>
                        </table>
                    </div>
                    <button>Delete</button>
                </td>
            </tr>

            <!-- Asset 2 -->

        </table>

    </div>

    <script src="./Javascript/dash_emp.js"></script>
</body>

</html>