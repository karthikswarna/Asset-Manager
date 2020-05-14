<?php
    // Script for viewing all suppliers on supp_dashboard page. This is included in supp_dashboard.php
        
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
        require_once("sup_dashboard.php");
        
        $select_stmt = "SELECT * FROM supplier WHERE Active = true;";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $suppliers = $select_query->fetchAll(PDO::FETCH_ASSOC);
        
        $supplier_id = "";
        $select_stmt2 = "SELECT DISTINCT s.Product_ID, p.Name, s.Date_supplied, s.Price
                        FROM (suppliedproduct as s
                        INNER JOIN product as p ON s.Product_ID = p.Product_ID AND s.Supplier_ID = :supplier_id);";
        $select_query2 = $db_conn->prepare($select_stmt2);
        $select_query2->bindParam(":supplier_id", $supplier_id, PDO::PARAM_STR);
    }

?>


        <table id="customers">
            <thead class="text-center">
                <tr>
                    <th>S.no</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php $i = 0; foreach($suppliers as $supplier): ?>
                    <tr id="<?php echo $supplier['Supplier_ID'] ?>">
                        <td>
                            <?php echo ++$i ; ?>
                        </td>
                        <td>
                            <?php echo $supplier['Supplier_name'];?>
                        </td>
                        <td>
                            <?php echo $supplier['Email'];?>
                        </td>
                        <td>
                            <?php echo $supplier['Phone_number'];?>
                        </td>

                        <td>
                            <button type="button" class="collapsible">History</button>
                            <div class="content">
                                <h3>Supplies</h3>
                                <table>
                                    <thead class="text-center">
                                        <tr>
                                            <th>S.no</th>
                                            <th>Product Name</th>
                                            <th>Product_ID</th>
                                            <th>Date Supplied</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>

                                    </tbody class="text-center">
                                        <?php
                                            $supplier_id = $supplier['Supplier_ID'];
                                            $select_query2->execute();
                                            if($select_query2->rowCount() == 0)
                                            {
                                                echo "<td>-</td>";
                                                echo "<td>-</td>";
                                                echo "<td>-</td>";
                                                echo "<td>-</td>";
                                                echo "<td>-</td>";
                                            }
                                            else
                                            {
                                                $supplies = $select_query2->fetchAll(PDO::FETCH_ASSOC); 
                                                $j = 0;
                                                foreach($supplies as $supply): ?>
                                                    <tr>
                                                        <td><?php echo ++$j; ?></td>
                                                        <td><?php echo $supply['Name'] ?></td>
                                                        <td><?php echo $supply['Product_ID'] ?></td>
                                                        <td><?php echo $supply['Date_supplied'] ?></td>
                                                        <td><?php echo $supply['Price'] ?></td>
                                                    </tr>
                                                <?php endforeach;
                                            } ?>
                                    </tbody>
                                </table>
                            </div>

                            <button class="myBtn2">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="myModal2" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="yesBtn" class="btn btn-primary">Yes</button>
                    <button type="button" id="noBtn" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>

        <div id="myModal3" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supplier deleted successfully!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="okBtn" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./Javascript/sup_dashboard.js"></script>
    <script src="./Javascript/sidebar.js"></script>
</body>
</html>