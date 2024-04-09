<?php

@include 'constants.php';

if (isset($_SESSION['prsn_id'])) {
    $PRSN_ID = $_SESSION['prsn_id'];
    // $sql2 = "SELECT * FROM placed_order WHERE PRSN_ID = $PRSN_ID";
} else {
    $GUEST_ID = $_SESSION['guest_id'];
}

$PLACED_ORDER_TRACKER = $_SESSION['placed_order_tracker'];

$sql2 = "SELECT * FROM placed_order WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER'";

$res2 = mysqli_query($conn, $sql2);

$count2 = mysqli_num_rows($res2);

$row2 = mysqli_fetch_assoc($res2);

$PLACED_ORDER_ID = $row2['PLACED_ORDER_ID'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order | Fat Rap's BBQ</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="order-status-progress-bar.js" defer></script>
    <!-- add the code below to load the icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!-- from boxicons.com -->
</head>

<body>
    <header>
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
                    <label class='menu-button-container' for="menu-toggle">
                        <div class='menu-button'></div>
                    </label>
                <ul class = 'menubar'>
                    <!--TODO: ADD LINKS-->
                    <li><a href="cus-home-page.php">Home</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
                    <!-- Text below should change to 'Logout'once user logged in-->
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
        </div>
    </header>
    <main>
        <section class="section track-order">
            <div class="section-heading">
                <h2>Track your Order</h2>
            </div>
            <section class="section-body">
                <section class="block">
                    <h3 class="block-heading">Order code: <?php echo $PLACED_ORDER_ID ?></h3>
                    <div class="block-body">
                        <div class="container">
                            <div class="steps">
                                <?php
                                if ($count2 > 0) {
                                    $PLACED_ORDER_ID = $row2['PLACED_ORDER_ID'];
                                    $PRSN_ID = $row2['PRSN_ID'];
                                    $CUS_NAME = $row2['CUS_NAME'];
                                    $CUS_NUMBER = $row2['CUS_NUMBER'];
                                    $CUS_EMAIL = $row2['CUS_EMAIL'];
                                    $PLACED_ORDER_DATE = $row2['PLACED_ORDER_DATE'];
                                    $PLACED_ORDER_TOTAL = $row2['PLACED_ORDER_TOTAL'];
                                    $DELIVERY_ADDRESS = $row2['DELIVERY_ADDRESS'];
                                    $DELIVERY_DATE = $row2['DELIVERY_DATE'];
                                    $PLACED_ORDER_STATUS = $row2['PLACED_ORDER_STATUS'];

                                    switch ($PLACED_ORDER_STATUS) {
                                        case "Ordered": //PLACED
                                ?>
                                            <p id="status">placed</p>
                                        <?php
                                            break;
                                        case "Awaiting Payment": //APPROVED
                                        ?>
                                            <p id="status">approved</p>
                                        <?php
                                            break;
                                        case "Paid": //PAID
                                        ?>
                                            <p id="status">paid</p>
                                        <?php
                                            break;
                                        case "Preparing":
                                        ?>
                                            <p id="status">packed</p>
                                        <?php
                                            break;
                                        case "For Delivery": //PACKED
                                        ?>
                                            <p id="status">shipped</p>
                                        <?php
                                            break;
                                        case "Shipped": //SHIPPED
                                        ?>
                                            <p id="status">shipped</p>
                                        <?php
                                            break;
                                        case "Completed": //DELIVERED
                                        ?>
                                            <p id="status">completed</p>
                                <?php
                                            break;
                                    }
                                }
                                ?>
                                <!-- if status = placed -->
                                <div class="step">
                                    <span class="circle active">
                                        <i class='bx bx-check'></i>
                                    </span>
                                    <span class="label">Placed</span>
                                </div>
                                <!-- if status = approved -->
                                <div class="step">
                                    <span class="circle">
                                        <i class='bx bx-check'></i>
                                    </span>
                                    <span class="label">Approved</span>
                                </div>
                                <!-- if status = paid -->
                                <div class="step">
                                    <span class="circle">
                                        <i class='bx bx-check'></i>
                                    </span>
                                    <span class="label">Preparing</span>
                                </div>
                                <!-- if status = packed -->
                                <div class="step">
                                    <span class="circle">
                                        <i class='bx bx-check'></i>
                                    </span>
                                    <span class="label">Packed</span>
                                </div>
                                <!-- if status = shipped -->
                                <div class="step">
                                    <span class="circle">
                                        <i class='bx bx-check'></i>
                                    </span>
                                    <span class="label">Shipped</span>
                                </div>
                                <!-- if status = delivered -->
                                <div class="step">
                                    <span class="circle">
                                        <i class='bx bx-check'></i>
                                    </span>
                                    <span class="label">Delivered</span>
                                </div>
                                <div class="progress-bar">
                                    <span class="indicator"></span>
                                </div>
                            </div>
                            <!-- admin buttons controlling the progress bar -->
                            <!-- <div class="buttons">
                                <button id="prev" disabled>Prev</button>
                                <button id="next">Next</button>
                            </div> -->
                        </div>
                        <!-- <p>Order status: PLACED (for testing)</p> this line is used for backend testing and will be removed later on -->
                        <h3 class="block-heading order-status">Your order has been approved</h2>
                            <p class="order-status-desc">Lorem ipsum dolor sit amet, consectetur adipiscing Lorem ipsum
                                dolor sit amet</p>
                    </div>
                </section>
                <!-- section directly below this will only appear if order status is approved -->
                <section class="block" id="payment-section">
                    <form action="" method="post">
                        <h3 class="block-heading">Payment</h3>
                        <div class="block-body">
                            <div style="width: 10rem; height: 10rem; background-color: white;"></div>
                            <div>
                                <p class="ref-label">Reference number</p>
                                <input name="reference-number" type="text">
                                <button name="submit">Submit</button>
                                <p class="prompt">Thanks for submitting!</p>
                            </div>
                        </div>
                    </form>
                </section>
                <section class="block">
                    <h3 class="block-heading">Order Summary</h3>
                    <div class="block-body">
                        <div class="table-wrap">
                            <table class="order">
                                <thead>
                                    <tr>
                                        <th class="header first-col"></th>
                                        <th class="header">Quantity</th>
                                        <th class="header">Price</th>
                                        <th class="header">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['prsn_id'])) {
                                        $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
                                        FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered' AND PRSN_ID = $PRSN_ID";
                                    } else {
                                        $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
                                        FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered' AND GUEST_ORDER_IDENTIFIER = '$GUEST_ID'";
                                    }
                                    $res = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($res);
                                    if ($count > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $IN_ORDER_ID = $row['IN_ORDER_ID'];
                                            $FOOD_NAME = $row['FOOD_NAME'];
                                            $FOOD_PRICE = $row['FOOD_PRICE'];
                                            $FOOD_IMG = $row['FOOD_IMG'];
                                            $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'];
                                            $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'];
                                    ?>
                                            <tr>
                                                <td data-cell="customer" class="first-col">
                                                    <div class="pic-grp">
                                                        <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                                        <p>Pork BBQ</p>
                                                    </div>
                                                </td> <!--Pic and Name-->
                                                <td>
                                                    <?php echo $IN_ORDER_QUANTITY ?>
                                                </td> <!--Quantity-->
                                                <td>₱
                                                    <?php echo $FOOD_PRICE ?>
                                                </td><!--Price-->
                                                <td>₱
                                                    <?php echo $IN_ORDER_TOTAL ?>
                                                </td><!--Sub Total-->
                                            </tr>
                                    <?php
                                        }
                                    }
                                    if (isset($_SESSION['prsn_id'])) {
                                        $sql3 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM  IN_ORDER WHERE PRSN_ID = $PRSN_ID";
                                    } else {
                                        $sql3 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM  IN_ORDER WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID'";
                                    }
                                    $res3 = mysqli_query($conn, $sql3);
                                    $row3 = mysqli_fetch_assoc($res3);
                                    $total = $row3['Total'];
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="payment">
                            <h3>Total Payment:</h3>
                            <h3>₱
                                <?php echo $total ?>
                            </h3>
                        </div>
                    </div>
                </section>
            </section>
        </section>
    </main>
    <footer>
        <div class="footer-container">
            <div class="left-container">
                <h1>Fat Rap's Barbeque's Online Store</h1>
                <div class="list">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="<?php echo SITEURL; ?>menu.php">Menu</a></li>
                        <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
                        <li><a href="<?php echo SITEURL; ?>track-order.php">Track order</a></li>
                    </ul>
                </div>
            </div>
            <div class="right-container">
                <div class="icons-block">
                    <a href="https://www.youtube.com/">
                        <i class='bx bxl-facebook-circle'></i>
                    </a>
                    <a href="https://www.youtube.com/">
                        <i class='bx bxl-tiktok'></i>
                    </a>
                    <a href="https://www.youtube.com/">
                        <i class='bx bxl-instagram'></i>
                    </a>
                </div>
                <div class="list">
                    <div class="list-items">
                        <i class='bx bxs-envelope'></i>
                        <p>email@gmail.com</p>
                    </div>
                    <div class="list-items">
                        <i class='bx bxs-phone'></i>
                        <p>0912 345 6789 | 912 1199</p>
                    </div>
                    <div class="list-items">
                        <i class='bx bxs-map'></i>
                        <p>123 Magaling St., Brgy. Something, Somewhere City</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>

<?php


if (isset($_POST['submit'])) {

    $REFERENCE_NUMBER = mysqli_real_escape_string($conn, $_POST['reference-number']);

    $update = "UPDATE placed_order 
    SET REFERENCE_NUMBER = '$REFERENCE_NUMBER' 
    WHERE PLACED_ORDER_ID = '$PLACED_ORDER_ID'";

    mysqli_query($conn, $update);
    // header('location:track-order.php');
}

?>