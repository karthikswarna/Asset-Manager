<?php
    // Script for viewing all the ownerships on dashboard page. This is included in dashboard.php
    
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
    else
    {
        require_once("config.php");
        require_once("dashboard.php");
        $select_stmt = "SELECT DISTINCT p.Name, cat.Category_name, e.Name as emp_name, p.Image, p.Description, c.Barcode, a.Expiry_date
                        FROM ((((checkouts as c
                        INNER JOIN employee as e ON e.Employee_ID = c.Employee_ID)
                        INNER JOIN asset as a ON c.Barcode = a.Barcode)
                        INNER JOIN product as p ON a.Product_ID = p.Product_ID)
                        INNER JOIN category as cat ON p.Category_ID = cat.Category_ID);";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $rows = $select_query->fetchAll(PDO::FETCH_ASSOC);

        $barcode = "";
        $select_stmt2 = "SELECT DISTINCT e.Name, c.checkout_date, c.checkin_date
                        FROM checkouts as c
                        INNER JOIN employee as e ON c.Barcode = :barcode AND c.Employee_ID = e.Employee_ID
                        ORDER BY c.checkout_date ASC;";
        $select_query2 = $db_conn->prepare($select_stmt2);
        $select_query2->bindParam(":barcode", $barcode, PDO::PARAM_STR);
    }
?>

<table id="customers">
            <thead class="text-center">
                <th>S.no</th>
                <th>Asset Name</th>
                <th>Category</th>
                <th>Acquired by</th>
                <th>Action</th>
            </thead>

            <tbody class="text-center">
                <?php $i = 0; foreach($rows as $row): ?>
                    <tr>
                        <td>
                            <?php echo ++$i ; ?>
                        </td>
                        <td>
                            <?php echo $row['Name'];?>
                        </td>
                        <td>
                            <?php echo $row['Category_name'];?>
                        </td>
                        <td>
                            <?php echo $row['emp_name'];?>
                        </td>

                        <td>
                            <button type="button" class="collapsible">Details</button>
                            <div class="content">
                                <table>
                                    <tr>
                                        <th>Product Image</th>
                                        <td><img class="display" src="data:image/jpeg;base64, <?= base64_encode($row['Image']) ?>" alt=<?php echo "Image of " . $row['Name']; ?>></td>
                                    </tr>
                                    <tr>
                                        <th>Barcode</th>
                                        <td>
                                            <?php echo $row['Barcode'];?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>
                                            <?php echo $row['Description'];?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Expiry Date</th>
                                        <td>
                                            <?php echo $row['Expiry_date'];?>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <th><button>Reassign Owner</button></th>
                                        <td>
                                            <select class="selectable" name="owner_select">
                                                <option value="Owner_1">Owner_1</option>
                                                <option value="Owner_2">Owner_2</option>
                                                <option value="Owner_3">Owner_3</option>
                                                <option value="Owner_4">Owner_4</option>
                                                <option value="None" selected>None</option>
                                            </select>
                                        </td>
                                    </tr> -->
                                </table>
                            </div>

                            <button type="button" class="collapsible">History</button>
                            <div class="content">
                                <h3>Owners</h3>
                                <table>
                                    <thead class="text-center">
                                        <tr>
                                            <th>S.no</th>
                                            <th> Name</th>
                                            <th>Check-Out Time</th>
                                            <th>Check-In Time</th>
                                        </tr>
                                    </thead>

                                    </tbody class="text-center">
                                        <?php
                                            $barcode = $row['Barcode'];
                                            $select_query2->execute();
                                            $rows2 = $select_query2->fetchAll(PDO::FETCH_ASSOC);
                                            $j = 0;
                                            foreach($rows2 as $row2): ?>
                                                <tr>
                                                    <td><?php echo ++$j; ?></td>
                                                    <td><?php echo $row2['Name']; ?></td>
                                                    <td><?php echo $row2['checkout_date']; ?></td>
                                                    <td>
                                                        <?php if(empty(trim($row2['checkin_date']))){echo "Current Owner";}
                                                                else{echo $row2['checkin_date'];} ?>
                                                    </td>
                                                </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <button>Check-in this item</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="./Javascript/dashboard.js"></script>
    <script src="./Javascript/ajax.js"></script>
</body>
</html>