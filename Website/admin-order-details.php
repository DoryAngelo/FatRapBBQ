<?php

@include 'constants.php';

$PRSN_ID = $_GET['PRSN_ID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Order Details | Admin</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="admin-styles.css"><!--change css file-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="app.js" defer></script>
    <!-- add the code below to load the icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header class="backend">
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                    <p>ADMIN</p>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo SITEURL; ?>admin-home.php">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin-edit-menu.php">Menu</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin-new-orders.php">Orders</a></li>
                    <?php
                    if (isset($_SESSION['prsn_id'])) {
                    ?>
                        <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a>
                        <li>
                        <?php
                    } else {
                        ?>
                        <li><a href="<?php echo SITEURL; ?>login-page.php">Login</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="section">
            <a href="" class="back">Back</a>
            <section class="block order-details">
                <div class="scroll">
                    <h2>Order Details</h2>
                    <?php
                    $sql = "SELECT * FROM placed_order WHERE PRSN_ID = $PRSN_ID";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $PLACED_ORDER_ID = $row['PLACED_ORDER_ID'];
                            $PRSN_ID = $row['PRSN_ID'];
                            $CUS_NAME = $row['CUS_NAME'];
                            $CUS_NUMBER = $row['CUS_NUMBER'];
                            $CUS_EMAIL = $row['CUS_EMAIL'];
                            $PLACED_ORDER_DATE = $row['PLACED_ORDER_DATE'];
                            $PLACED_ORDER_TOTAL = $row['PLACED_ORDER_TOTAL'];
                            $DELIVERY_ADDRESS = $row['DELIVERY_ADDRESS'];
                            $DELIVERY_DATE = $row['DELIVERY_DATE'];
                            $PLACED_ORDER_STATUS = $row['PLACED_ORDER_STATUS'];
                            $REFERENCE_NUMBER = $row['REFERENCE_NUMBER'];
                    ?>
                            <div>
                                <table class="contact-info">
                                    <tr>
                                        <th>Order #:</th>
                                        <td><?php echo $PLACED_ORDER_ID ?></td>
                                    </tr>
                                    <tr>
                                        <th>Order Status:</th>
                                        <td><?php echo $PLACED_ORDER_STATUS ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date and time placed:</th>
                                        <td><?php echo $PLACED_ORDER_DATE ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td><?php echo $CUS_NAME ?></td>
                                    </tr>
                                    <tr>
                                        <th>Contact number:</th>
                                        <td><?php echo $CUS_NUMBER ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><?php echo $CUS_EMAIL ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="delivery-grp">
                                <div class="text-grp">
                                    <h3>Delivery address:</h3>
                                    <p><?php echo $DELIVERY_ADDRESS ?></p>
                                </div>
                                <div class="text-grp">
                                    <h3>Delivery date:</h3>
                                    <p><?php echo $DELIVERY_DATE ?></p>
                                </div>
                                <div class="text-grp">
                                    <h3>Reference Number:</h3>
                                    <p><?php echo $REFERENCE_NUMBER ?></p>
                                </div>
                            </div>
                            <div>
                                <table class="order">
                                    <thead>
                                        <tr>
                                            <th class="item-col">Item</th>
                                            <th>Quantity</th>
                                            <th class="subtotal-col">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_PRICE, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered'";

                                        $res = mysqli_query($conn, $sql);

                                        $count = mysqli_num_rows($res);

                                        if ($count > 0) {
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                if ($row['PRSN_ID'] == $PRSN_ID) {
                                                    $IN_ORDER_ID = $row['IN_ORDER_ID'];
                                                    $FOOD_NAME = $row['FOOD_NAME'];
                                                    $FOOD_PRICE = $row['FOOD_PRICE'];
                                                    $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'];
                                                    $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'];
                                        ?>

                                                    <tr>
                                                        <td class="item-col"><?php echo $FOOD_NAME ?></td>
                                                        <td><?php echo $IN_ORDER_QUANTITY ?></td>
                                                        <td class="subtotal-col">₱<?php echo $IN_ORDER_TOTAL ?></td>
                                                    </tr>
                                        <?php

                                                }
                                            }
                                        }
                                        $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM  IN_ORDER WHERE PRSN_ID = $PRSN_ID";
                                        $res2 = mysqli_query($conn, $sql2);
                                        $row2 = mysqli_fetch_assoc($res2);
                                        $total = $row2['Total'];
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="payment">
                                <h3>Total Payment:</h3>
                                <h3>₱<?php echo $total ?></h3>
                            </div>
                </div>
        <?php
                        }
                    }
        ?>


            </section>
        </section>
    </main>
</body>

</html>