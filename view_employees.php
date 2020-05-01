<?php
    // Script for viewing all employees on emp_dashboard page. This is included in emp_dashboard.php
    
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
        require_once("emp_dashboard.php");
        
        $select_stmt = "SELECT * FROM employee;";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $employees = $select_query->fetchAll(PDO::FETCH_ASSOC);
        
        $employee_id = "";
        $select_stmt2 = "SELECT DISTINCT c.Barcode, c.checkin_date, c.checkout_date, p.Name
                        FROM ((checkouts as c
                        INNER JOIN asset as a ON c.Barcode = a.Barcode AND c.Employee_ID = :employee_id)
                        INNER JOIN product as p ON a.Product_ID = p.Product_ID);";
        $select_query2 = $db_conn->prepare($select_stmt2);
        $select_query2->bindParam(":employee_id", $employee_id, PDO::PARAM_STR);
    }
?>


        <table id="customers">
            <thead class="text-center">
                <tr>
                    <th>S. no</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Work Phone</th>
                    <th>Personal Phone</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php $i = 0; foreach($employees as $employee): ?>
                    <tr>
                        <td>
                            <?php echo ++$i ; ?>
                        </td>
                        <td>
                            <?php echo $employee['Name'];?>
                        </td>
                        <td>
                            <?php echo $employee['Department'];?>
                        </td>
                        <td>
                            <?php echo $employee['Email'];?>
                        </td>
                        <td>
                            <?php echo $employee['Work_phone'];?>
                        </td>
                        
                        <td>
                            <?php
                                if(empty(trim($employee['Personal_phone'])))
                                {
                                    echo "Not available";
                                }
                                else
                                {
                                    echo $employee['Personal_phone'];
                                }
                            ?>
                        </td>

                        <td>
                            <button type="button" class="collapsible">Details</button>
                            <div class="content">
                                <table>
                                    <tr>
                                        <th>Display Image</th>
                                        <td>
                                            <?php
                                                if(empty(trim($employee['Image'])))
                                                {
                                                    echo "Not available";
                                                }
                                                else
                                                { ?>
                                                    <img class="display" src="<?php echo "Uploads/" . $employee['Image'] ?>" alt=<?php echo "Image of " . $employee['Name']; ?> >
                                          <?php } ?>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Employee ID</th>
                                        <td> <?php echo $employee['Employee_ID'] ?> </td>
                                    </tr>
                                </table>
                            </div>

                            <button type="button" class="collapsible">History</button>
                            <div class="content">
                                <h3>Products</h3>
                                <table>
                                    <thead class="text-center">
                                        <tr>
                                            <th>S.no</th>
                                            <th>Name of the product</th>
                                            <th>Barcode</th>
                                            <th>Check-out date</th>
                                            <th>Check-in date</th>
                                        </tr>
                                    </thead>
                                    
                                    </tbody class="text-center">
                                        <?php
                                            $employee_id = $employee['Employee_ID'];
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
                                                $checkouts = $select_query2->fetchAll(PDO::FETCH_ASSOC); 
                                                $j = 0;
                                                foreach($checkouts as $checkout): ?>
                                                    <tr>
                                                        <td><?php echo ++$j; ?></td>
                                                        <td><?php echo $checkout['Name'] ?></td>
                                                        <td><?php echo $checkout['Barcode'] ?></td>
                                                        <td><?php echo $checkout['checkout_date'] ?></td>
                                                        <td>
                                                            <?php
                                                                if(empty(trim($checkout['checkin_date'])))
                                                                {
                                                                    echo "Not yet returned";
                                                                }
                                                                else
                                                                {
                                                                    echo $checkout['checkin_date'];
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;
                                            } ?>
                                    </tbody>
                                </table>
                            </div>

                            <button>Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="./Javascript/dash_emp.js"></script>
</body>
</html>