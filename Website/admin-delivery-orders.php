<?php

@include 'constants.php';

if ($PRSN_ROLE !== 'Admin') {
    header('location:' . SITEURL . 'login-page.php');
}

if (isset($_POST['confirmed'])) {

    $PLACED_ORDER_ID = $_POST['PLACED_ORDER_ID'];
    $PLACED_ORDER_STATUS = $_POST['PLACED_ORDER_STATUS'];


    $PLACED_ORDER_CONFIRMATION = "Confirmed";

    switch ($PLACED_ORDER_STATUS) {
        case "Placed":
            $PLACED_ORDER_STATUS = "Awaiting Payment";
            break;
        case "Awaiting Payment":
            $PLACED_ORDER_STATUS = "Preparing";
            break;
        case "Preparing":
            $PLACED_ORDER_STATUS = "For Delivery";
            break;
        case "For Delivery":
            $PLACED_ORDER_STATUS = "Shipped";
            break;
        case "Shipped":
            $PLACED_ORDER_STATUS = "Completed";
            break;
        case "Cancelled":
            $PLACED_ORDER_STATUS = "Placed";
            break;
    }

    $sql = "UPDATE placed_order SET
    PLACED_ORDER_STATUS = '$PLACED_ORDER_STATUS',
	PLACED_ORDER_CONFIRMATION = '$PLACED_ORDER_CONFIRMATION'
	WHERE PLACED_ORDER_ID = '$PLACED_ORDER_ID'
	";

    $res = mysqli_query($conn, $sql);

    header('location:admin-delivery-orders.php');
}

if (isset($_POST['not-confirmed'])) {

    $PLACED_ORDER_ID = $_POST['PLACED_ORDER_ID'];

    $PLACED_ORDER_CONFIRMATION = "Not Confirmed";
    $PLACED_ORDER_STATUS = "Cancelled";

    $sql = "UPDATE placed_order SET
    PLACED_ORDER_STATUS = '$PLACED_ORDER_STATUS',
	PLACED_ORDER_CONFIRMATION = '$PLACED_ORDER_CONFIRMATION'
	WHERE PLACED_ORDER_ID = '$PLACED_ORDER_ID'
	";

    $res = mysqli_query($conn, $sql);

    header('location:admin-delivery-orders.php');
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>For Delivery Orders | Admin</title>
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
                    <h1>Fat Rap's Barbeque</h1>
                    <p>ADMIN</p>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class='menubar'>
                <!--TODO: ADD LINKS-->
                <li><a href="<?php echo SITEURL; ?>admin-home.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-edit-menu.php">Menu</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-new-orders.php">Orders</a></li>
                <!-- Text below should change to 'Logout'once user logged in-->
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
        <section class="section" id="orders-page">
            <div class="container">
                <div class="section-heading">
                    <h2>For Delivery Orders</h2>
                    <div class="inline">
                        <p>Date range:</p>
                        <input type="date">
                    </div>
                </div>
                <section class="with-side-menu">
                    <section class="main-section table-wrapper">
                        <table class="alternating">
                            <tr>
                                <th class="header">Date and Time</th>
                                <th class="header">Customer</th>
                                <th class="header">Order #</th>
                                <th class="header">Payment</th>
                                <th class="header">Status</th>
                                <th class="header">Confirmed</th>
                                <th class="header"></th>
                            </tr>
                            <!-- PLACEHOLDER TABLE ROWS FOR FRONTEND TESTING PURPOSES -->
                            <?php
                            $sql = "SELECT * FROM placed_order WHERE PLACED_ORDER_STATUS = 'For Delivery'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $PLACED_ORDER_ID = $row['PLACED_ORDER_ID'];
                                    $PRSN_ID = $row['PRSN_ID'];
                                    $CUS_NAME = $row['CUS_NAME'];
                                    $PLACED_ORDER_DATE = $row['PLACED_ORDER_DATE'];
                                    $PLACED_ORDER_TOTAL = $row['PLACED_ORDER_TOTAL'];
                                    $DELIVERY_ADDRESS = $row['DELIVERY_ADDRESS'];
                                    $DELIVERY_DATE = $row['DELIVERY_DATE'];
                                    $PLACED_ORDER_STATUS = $row['PLACED_ORDER_STATUS'];
                            ?>
                                    <tr>
                                        <td data-cell="Date and Time"><?php echo $PLACED_ORDER_DATE ?></td>
                                        <td data-cell="customer"><?php echo $CUS_NAME ?></td>
                                        <td data-cell="Order #"><a href="<?php echo SITEURL ?>admin-order-details.php?PLACED_ORDER_ID=<?php echo $PLACED_ORDER_ID; ?>"><?php echo $PLACED_ORDER_ID ?></a></td>
                                        <td data-cell="Payment">₱<?php echo $PLACED_ORDER_TOTAL ?></td>
                                        <td data-cell="Status"><?php echo $PLACED_ORDER_STATUS ?></td>
                                        <td data-cell="Confimed">
                                            <div class="btn-wrapper">
                                                <form method="POST">
                                                    <input type="hidden" name="PLACED_ORDER_ID" value="<?php echo $PLACED_ORDER_ID; ?>">
                                                    <input type="hidden" name="PLACED_ORDER_STATUS" value="<?php echo $PLACED_ORDER_STATUS; ?>">
                                                    <button class="btn-check" name="confirmed"><i class='bx bxs-check-circle'></i></button>
                                                    <button class="btn-cross" name="not-confirmed"><i class='bx bxs-x-circle'></i></button>
                                                    <td><a href="#" onclick="confirmDelete(<?php echo $PLACED_ORDER_ID; ?>)" class="bx bxs-trash-alt trash"></a></td>
                                                    <script>
                                                        function confirmDelete(PLACED_ORDER_ID) {
                                                        if (confirm("Are you sure you want to delete this item?")) {
                                                        window.location.href = "delete_placed_order.php?PLACED_ORDER_ID=" + PLACED_ORDER_ID;
                                                        } else {
                                                        // Do nothing
                                                        }
                                                        }
                                                        </script>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <!-- <div class="error">No new orders</div> -->
                                <tr>
                                    <td colspan="5" class="error">No new orders</td>
                                </tr>
                            <?php

                            }
                            ?>
                        </table>
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
                                <a href="<?php echo SITEURL; ?>admin-edit-inventory.php" class="edit">Edit</a>
                            </div>
                        </div>
                        <div class="group">
                            <a href="admin-new-orders.php" class="view big-font">New Orders</a>
                            <a href="admin-awaiting-payment.php" class="view big-font">Awaiting Payment</a>
                            <a href="admin-preparing-orders.php" class="view big-font">Preparing Orders</a>
                            <a href="admin-delivery-orders.php" class="view big-font">For Delivery Orders</a>
                            <a href="admin-shipped-orders.php" class="view big-font">Shipped Orders</a>
                            <a href="admin-completed-orders.php" class="view big-font">Completed Orders</a>
                            <a href="admin-canceled-orders.php" class="view big-font">Canceled Orders</a>
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