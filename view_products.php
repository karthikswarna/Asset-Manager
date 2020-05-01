<?php
    // Script for viewing all products on prod_dashboard page. This is included in prod_dashboard.php

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
        require_once("prod_dashboard.php");
        
        $select_stmt = "SELECT * FROM product;";
        $select_query = $db_conn->prepare($select_stmt);
        $select_query->execute();
        $products = $select_query->fetchAll(PDO::FETCH_ASSOC);
        
        $product_id = "";
        $select_stmt2 = "SELECT s.Supplier_name, sp.Date_supplied, sp.Quantity_supplied, sp.Price
                        FROM (supplier as s
                        INNER JOIN suppliedproduct as sp ON sp.Supplier_ID = s.Supplier_ID AND sp.Product_ID = :product_id);";
        $select_query2 = $db_conn->prepare($select_stmt2);
        $select_query2->bindParam(":product_id", $product_id, PDO::PARAM_STR);
    }
?>

        <table id="customers">
            <thead class="text-center">
                <tr>
                    <th>S. no</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Total Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody class="text-center">
                <?php $i = 0; foreach($products as $product): ?>
                    <tr>
                        <td>
                            <?php echo ++$i ; ?>
                        </td>
                        <td>
                            <?php echo $product['Name'];?>
                        </td>
                        <td>
                            <?php echo $product['Description'];?>
                        </td>
                        <td>
                            <img class="display" src="<?php echo "Uploads/" . $product['Image'] ?>" alt=<?php echo "Image of " . $product['Name']; ?> >
                        </td>
                        <td>
                            <?php echo $product['Total_quantity'];?>
                        </td>
                        
                        <td>
                            <button type="button" class="collapsible">History</button>
                            <div class="content">
                                <table>
                                    <thead class="text-center">
                                        <th>S.no</th>
                                        <th>Supplier</th>
                                        <th>Date supplied</th>
                                        <th>Quantity supplied</th>
                                        <th>Total price</th>
                                    </thead>

                                    <tbody class="text-center">
                                        <?php
                                            $product_id = $product['Product_ID'];
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
                                                        <td><?php echo $supply['Supplier_name'] ?></td>
                                                        <td><?php echo $supply['Date_supplied'] ?></td>
                                                        <td><?php echo $supply['Quantity_supplied'] ?></td>
                                                        <td><?php echo $supply['Price'] ?></td>
                                                    </tr>
                                                <?php endforeach;
                                            } ?> 
                                    </tbody>
                                </table>
                            </div>

                            <button>Update</button>
                            <button>Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="./Javascript/dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script>
        $('#prod_cat').change(function ()
        {
            if($(this).val() != '') 
            {
                $('#new_cat').val('');
                $('#new_cat').removeAttr('required');
            }
            else
            {
                $('#new_cat').attr('required', 'required');
            }
        });

        $('#new_cat').keyup(function ()
        {
            if($(this).val() != '') 
            {
                $('#prod_cat').val('').change();
                $('#prod_cat').removeAttr('required');
            }
            else
            {
                $('#prod_cat').attr('required', 'required');
            }
        });

        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0, 10);
        });

        document.getElementById('date_sup').value = new Date().toDateInputValue();
    </script>
</body>
</html>