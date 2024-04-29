<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

$PRSN_ROLE = $_SESSION['prsn_role'];

if ($PRSN_ROLE !== 'Employee') {
    header('location:' . SITEURL . 'login-page.php');
}

$selectPa = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_CONFIRMATION = 'Confirmed' AND PLACED_ORDER_STATUS = 'Preparing'";

$resPa = mysqli_query($conn, $selectPa);

$countPa = mysqli_num_rows($resPa);

$selectPr = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'Preparing'";

$resPr = mysqli_query($conn, $selectPr);

$countPr = mysqli_num_rows($resPr);

$selectFD = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'For Delivery'";

$resFD = mysqli_query($conn, $selectFD);

$countFD = mysqli_num_rows($resFD);

$selectS = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'Shipped'";

$resS = mysqli_query($conn, $selectS);

$countS = mysqli_num_rows($resS);

$selectCo = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'Completed'";

$resCo = mysqli_query($conn, $selectCo);

$countCo = mysqli_num_rows($resCo);

$selectCa = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'Cancelled'";

$resCa = mysqli_query($conn, $selectCa);

$countCa = mysqli_num_rows($resCa);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Home | Employee</title>
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
                    <p>EMPLOYEE</p>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class='menubar'>
                <li><a href="<?php echo SITEURL; ?>employee-home.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>employee-to-prepare-orders.php">Orders</a></li>
                <?php
                if (isset($_SESSION['prsn_id'])) {
                ?>
                    <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a></li>
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
                    <!-- <div class="inline">
                        <p>Date range:</p>
                        <input type="date"> 
                    </div>-->
                </div>
                <section class="with-side-menu">
                    <section class="main-section">
                        <div class="grid-container">
                            <a class="box" href="<?php echo SITEURL; ?>employee-to-prepare-orders.php">
                                <p>To Prepare</p>
                                <h1><?php echo $countPa ?></h1>
                            </a>
                            <!-- <a class="box" href="<?php echo SITEURL; ?>employee-preparing-orders.php">
                                <p>Currently Preparing</p>
                                <h1><?php echo $countPr ?></h1>
                            </a> -->
                            <a class="box" href="<?php echo SITEURL; ?>employee-to-deliver-orders.php">
                                <p>Ready for Pickup</p>
                                <h1><?php echo $countFD ?></h1>
                            </a>
                            <a class="box" href="<?php echo SITEURL; ?>employee-shipped.php">
                                <p>Shipped</p>
                                <h1><?php echo $countS ?></h1>
                            </a>
                            <a class="box" href="<?php echo SITEURL; ?>employee-completed-orders.php">
                                <p>Completed</p>
                                <h1><?php echo $countCo?></h1>
                            </a>
                            <a class="box" href="<?php echo SITEURL; ?>employee-canceled-orders.php">
                                <p>Cancelled</p>
                                <h1><?php echo $countCa ?></h1>
                            </a>
                        </div>
                    </section>
                    <section class="side-menu">
                        <div class="group inventory">
                            <h3>Inventory</h3>
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
                                <a href="<?php echo SITEURL; ?>employee-inventory.php" class="edit">Edit</a>
                            </div>
                        </div>
                    </section>
                </section>
            </div>
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

        </section>
    </main>
</body>

</html>