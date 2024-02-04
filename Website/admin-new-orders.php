<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--change title-->
        <title>New Orders | Admin</title>
        <link rel="stylesheet" href="header-styles.css">
        <link rel="stylesheet" href="admin-styles.css"><!--change css file-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
        <script src="app.js" defer></script>
    </head>
    <body>
        <header class="backend">
            <div class="header-container">
                <div class="website-title">
                    <img id="logo" src="images/client-logo.jpg">
                    <div class="text">
                        <h1>Fat Rap's Barbeque's Online Store</h1>
                        <p>ADMIN</p>
                    </div>
                </div>
                <nav>
                    <ul>
                        <!--TODO: ADD LINKS-->
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Orders</a></li>
                        <!-- Text below should change to 'Logout'once user logged in-->
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <section class="section">
                <div class="section-heading">
                    <h2>New Orders</h2>
                    <div class="inline">
                        <p>Date range:</p>
                        <p class="dropdown">Today</p>
                    </div>
                </div> 
                <section class="section-body">
                    <section class="main-section table">
                        <table>
                            <tr>
                              <th>Date and Time</th>
                              <th>Customer</th>
                              <th>Order #</th>
                              <th>Payment</th>
                              <th>Confirmed</th>
                            </tr>
                            <?php
                                $sql = "SELECT * FROM placed_order";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);

                                if($count>0)
                                {
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $PLACED_ORDER_ID = $row['PLACED_ORDER_ID'];
                                        $CUS_ID= $row['CUS_ID'];
                                        $PLACED_ORDER_DATE = $row['PLACED_ORDER_DATE'];
                                        $PLACED_ORDER_TOTAL = $row['PLACED_ORDER_TOTAL'];
                                        $DELIVERY_ADDRESS = $row['DELIVERY_ADDRESS'];
                                        $DELIVERY_ADDRESS = $row['DELIVERY_DATE'];
                                        $PLACED_ORDER_CONFIRMATION = $row['PLACED_ORDER_CONFIRMATION'];
                                        $PAYMENT_METHOD = $row['PAYMENT_METHOD'];
                                        $PLACED_ORDER_TOTAL = $row['PLACED_ORDER_TOTAL'];
                                        ?>
                                            <tr>
                                                <td><?php echo $PLACED_ORDER_DATE; ?></td>
                                                <td><?php echo $CUS_ID; ?></td>
                                                <td><a href=""><?php echo $PLACED_ORDER_ID; ?></a></td>
                                                <td><?php echo $PLACED_ORDER_TOTAL; ?></td>
                                                <td><?php echo $PLACED_ORDER_TOTAL; ?></td>
                                                <td>
                                                </td>
                                            </tr>
                                        <?php
                                    }

                                }
                                else
                                {
                                    echo "<div class='error'>No Order Found</div>";  
                                }
                            ?>
                          </table> 
                    </section>
                    <section class="side-menu">
                        <div class="group inventory">
                            <h3>Inventory</h3>
                            <div class="inventory-box">
                                <div class="inline">
                                    <p>Pork BBQ</p>
                                    <p class="number">10</p>
                                </div>
                                <a href="" class="edit">Edit</a>
                            </div>
                        </div>
                        <div class="group">
                            <h3>Calendar</h3>
                            <a href="" class="view">View</a>
                        </div>
                        <div class="group">
                            <h3>Wholesale Users</h3>
                            <a href="" class="view">View</a>
                        </div>
                        <div class="group">
                            <h3>Employee</h3>
                            <a href="" class="view">View</a>
                        </div>
                    </section>
                </section>
            </section>
        </main>
    </body>
</html>