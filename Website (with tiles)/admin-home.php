<?php

@include 'constants.php';


$PRSN_ID = $_SESSION['prsn_id'];

$PRSN_ROLE = $_SESSION['prsn_role'];

$PRSN_ROLE = $_SESSION['prsn_role'];
if ($PRSN_ROLE !== 'Admin') {
    header('location:' . SITEURL . 'login-page.php');
}

$order_type = isset($_GET['type']) ? $_GET['type'] : 'all';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Home | Admin</title>
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
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque</h1>
                    <p>ADMIN</p>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class='menubar'>
                <li><a href="<?php echo SITEURL; ?>admin-home.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-inventory.php">Menu</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-new-orders.php">Orders</a></li>
                <?php
                if (isset($_SESSION['prsn_id'])) {
                ?>
                    <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a>
                    </li>
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
        <section class="section" id="dashboard">
            <div class="container">
                <div class="section-heading">
                    <h2>Dashboard</h2>
                    <div class="inline">
                        <p>Date range:</p>
                        <select name="order-type" id="order-type" class="dropdown">
                            <option value="all" <?php echo ($order_type === 'all') ? 'selected' : ''; ?>>All time</option>
                            <option value="Today" <?php echo ($order_type === 'Today') ? 'selected' : ''; ?>>Today</option>
                            <option value="Tomorrow" <?php echo ($order_type === 'Tomorrow') ? 'selected' : ''; ?>>Including tomorrow</option>
                            <option value="7days" <?php echo ($order_type === '7days') ? 'selected' : ''; ?>>Within 7 days</option>
                            <option value="2weeks" <?php echo ($order_type === '2weeks') ? 'selected' : ''; ?>>Within 2 weeks</option>
                            <option value="30days" <?php echo ($order_type === '30days') ? 'selected' : ''; ?>>Within 30 days</option>
                        </select>
                    </div>
                    <script>
                        document.getElementById('order-type').addEventListener('change', function() {
                            var selectedOrderType = this.value;
                            window.location.href = "admin-home.php?type=" + selectedOrderType;
                        });
                    </script>
                </div>
                <?php
                $order_type = isset($_GET['type']) ? $_GET['type'] : 'all';

                $selectCounts = "SELECT 
                PLACED_ORDER_STATUS,
                COUNT(*) as count 
                FROM placed_order";

                if ($order_type === 'Today') {
                    $selectCounts .= " WHERE DATE(delivery_date) = CURDATE()";
                } elseif ($order_type === 'Tomorrow') {
                    $selectCounts .= " WHERE DATE(delivery_date) = CURDATE() + INTERVAL 1 DAY";
                } elseif ($order_type === '7days') {
                    $selectCounts .= " WHERE delivery_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
                } elseif ($order_type === '2weeks') {
                    $selectCounts .= " WHERE delivery_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 14 DAY)";
                } elseif ($order_type === '30days') {
                    $selectCounts .= " WHERE delivery_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
                }

                $selectCounts .= " GROUP BY PLACED_ORDER_STATUS";

                $resCounts = mysqli_query($conn, $selectCounts);

                $counters = array();
                while ($row = mysqli_fetch_assoc($resCounts)) {
                    $counters[$row['PLACED_ORDER_STATUS']] = $row['count'];
                }

                $countNO = isset($counters['Placed']) ? $counters['Placed'] : 0;
                $countAP = isset($counters['Awaiting Payment']) ? $counters['Awaiting Payment'] : 0;
                $countPr = isset($counters['To Prepare']) ? $counters['To Prepare'] : 0;
                $countFD = isset($counters['Currently Preparing']) ? $counters['Currently Preparing'] : 0;
                $countS = isset($counters['Packed']) ? $counters['Packed'] : 0;
                $countCo = isset($counters['Completed']) ? $counters['Completed'] : 0;
                $countCa = isset($counters['Cancelled']) ? $counters['Cancelled'] : 0;
           
                $selectW = "SELECT *
                FROM wholesaler
                WHERE WHL_STATUS = 'New'";

                $resW = mysqli_query($conn, $selectW);

                $countW = mysqli_num_rows($resW);
                ?>
                <section class="with-side-menu">
                    <section class="main-section">
                        <div class="grid-container">
                            <a class="box" href="<?php echo SITEURL; ?>admin-new-orders.php">
                                <p>New</p>
                                <h1><?php echo $countNO ?></h1>
                                <p class="bottom">Orders</p>
                            </a>
                            <a class="box" href="<?php echo SITEURL; ?>admin-awaiting-payment.php">
                                <p>Awaiting Payment</p>
                                <h1><?php echo $countAP ?></h1>
                                <p class="bottom">Orders</p>
                            </a>
                            <!-- <a class="box" href="<?php echo SITEURL; ?>admin-preparing-orders.php">
                                <p>Preparing Orders</p>
                                <h1><?php echo $countPr ?></h1>
                            </a> -->
                            <!-- <a class="box" href="<?php echo SITEURL; ?>admin-packing-orders.php">
                                    <p>Packing Orders</p>
                                    <h1>100></h1>
                                </a> -->
                            <a class="box" href="<?php echo SITEURL; ?>admin-delivery-orders.php">
                                <p>Ready for Pickup</p>
                                <h1><?php echo $countS ?></h1>
                                <p class="bottom">Orders</p>
                            </a>
                            <!-- <a class="box" href="<?php echo SITEURL; ?>admin-shipped-orders.php">
                                <p>Shipped</p>
                                <h1><?php echo $countS ?></h1>
                            </a> -->
                            <a class="box" href="<?php echo SITEURL; ?>admin-completed-orders.php">
                                <p>Completed</p>
                                <h1><?php echo $countCo ?></h1>
                                <p class="bottom">Orders</p>
                            </a>
                            <a class="box" href="<?php echo SITEURL; ?>admin-canceled-orders.php">
                                <p>Canceled</p>
                                <h1><?php echo $countCa ?></h1>
                                <p class="bottom">Orders</p>
                            </a>
                        </div>
                    </section>
                    <section class="side-menu">
                        <!-- if there is a product in the inventory that is low in stock, show id="low-inventory" and hide id="inventory"-->
                        <div class="group inventory" id="low-inventory">
                            <h3>Low Inventory</h3>
                            <div class="inventory-box">
                                <?php
                                $sql = "SELECT * FROM food WHERE FOOD_STOCK < 100";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);
                                $stockValues = array();
                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $FOOD_NAME = $row['FOOD_NAME'];
                                        $FOOD_STOCK = $row['FOOD_STOCK'];
                                ?>
                                        <div class="inline">
                                            <p><?php echo $FOOD_NAME ?></p>
                                            <span class="<?php echo ($FOOD_STOCK < 100) ? 'red-text' : ''; ?>">
                                                <p><?php echo $FOOD_STOCK ?></p>
                                            </span>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                                <a href="<?php echo SITEURL; ?>admin-inventory.php" class="edit">Edit</a>
                            </div>
                        </div>
                        <!-- else, show id="inventory" and hide id="low-inventory"-->
                        <!-- <div class="group" id="inventory">
                            <h3>Inventory</h3>
                            <div class="position-notif">
                                <a href="<?php echo SITEURL; ?>admin-inventory.php" class="view">View</a>
                            </div>
                        </div> -->
                        <div class="group">
                            <h3>Calendar</h3>
                            <a href="<?php echo SITEURL; ?>admin-edit-calendar.php" class="view">View</a>
                        </div>
                        <div class="group">
                            <h3>Wholesale Users</h3>
                            <div class="position-notif">
                                <a href="<?php echo SITEURL; ?>admin-wholesaler-accounts.php" class="view">View</a>
                                <!-- <p class="notif"><?php echo $countW ?></p> -->
                            </div>
                        </div>
                        <div class="group">
                            <h3>Employee</h3>
                            <a href="<?php echo SITEURL; ?>admin-employee-accounts.php" class="view">View</a>
                        </div>
                        <div class="group">
                            <h3>Admin Profile</h3>
                            <a href="<?php echo SITEURL; ?>admin-profile.php" class="view">View</a>
                        </div>
                    </section>
                </section>
            </div>
        </section>
    </main>
    <script>
        // Function to check for new orders via AJAX
        function checkForNewOrders() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText.trim() === "NewOrder") {
                        notifyNewOrder(); // Play notification sound
                    }
                }
            };
            xhttp.open("GET", "order-notification.php", true);
            xhttp.send();
        }

        // Function to play notification sound
        function notifyNewOrder() {
            var audio = new Audio('sound/notification.mp3'); // Replace with correct path
            audio.play();
        }

        // Check for new orders every 5 seconds 
        setInterval(checkForNewOrders, 2000);
    </script>
</body>

</html>