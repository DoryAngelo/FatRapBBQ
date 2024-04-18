<?php

@include 'constants.php';

$PRSN_ROLE = $_SESSION['prsn_role'];
if ($PRSN_ROLE !== 'Employee') {
    header('location:' . SITEURL . 'login-page.php');
}

if (isset($_POST['confirmed'])) {

    $PLACED_ORDER_ID = $_POST['PLACED_ORDER_ID'];
    $PLACED_ORDER_STATUS = $_POST['PLACED_ORDER_STATUS'];


    $PLACED_ORDER_CONFIRMATION = "Confirmed";

    switch ($PLACED_ORDER_STATUS) {
        case "Paid":
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

    header('location:employee-completed-orders.php');
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

    header('location:employee-completed-orders.php');
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
    <title>Completed Orders | Employee</title>
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
                <div class="section-heading row">
                    <h2>Completed Orders</h2>
                    <select name="order-type" id="order-type" class="dropdown">
                        <option value="all" <?php echo ($order_type === 'all') ? 'selected' : ''; ?>>All</option>
                        <option value="Today" <?php echo ($order_type === 'Today') ? 'selected' : ''; ?>>Today</option>
                        <option value="Advanced" <?php echo ($order_type === 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
                    </select>
                    <script>
                        document.getElementById('order-type').addEventListener('change', function() {
                            var selectedOrderType = this.value;
                            window.location.href = "employee-completed-orders.php?type=" + selectedOrderType;
                        });
                    </script>
                </div>
                <section class="with-side-menu">
                    <section class="main-section table-wrapper">
                        <table class="alternating">
                            <tr>
                                <th class="header">Date and Time</th>
                                <th class="header">Customer</th>
                                <th class="header">Order #</th>
                                <th class="header">Payment</th>
                                <th class="header">Confirmed</th>
                            </tr>
                            <!-- PLACEHOLDER TABLE ROWS FOR FRONTEND TESTING PURPOSES -->
                            <?php
                            $sql = "SELECT * FROM placed_order WHERE PLACED_ORDER_STATUS = 'Completed'";
                            $order_type = isset($_GET['type']) ? $_GET['type'] : 'all';

                            if ($order_type === 'Today') {
                                // Add condition for orders scheduled for delivery today
                                $sql .= " AND DATE_FORMAT(STR_TO_DATE(delivery_date, '%Y-%m-%d %H:%i'), '%Y-%m-%d') = CURDATE()";
                            } elseif ($order_type === 'Advanced') {
                                // Add condition for orders scheduled for delivery after today
                                $sql .= " AND DATE_FORMAT(STR_TO_DATE(delivery_date, '%Y-%m-%d %H:%i'), '%Y-%m-%d') > CURDATE()";
                            }
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
                                        <td data-cell="Order #"><a href="<?php echo SITEURL ?>employee-order-details.php?PLACED_ORDER_ID=<?php echo $PLACED_ORDER_ID; ?>"><?php echo $PLACED_ORDER_ID ?></a></td>
                                        <td data-cell="Payment">₱<?php echo $PLACED_ORDER_TOTAL ?></td>
                                        <td data-cell="Confimed">
                                            <div class="btn-wrapper">
                                                <form method="POST">
                                                    <input type="hidden" name="PLACED_ORDER_ID" value="<?php echo $PLACED_ORDER_ID; ?>">
                                                    <input type="hidden" name="PLACED_ORDER_STATUS" value="<?php echo $PLACED_ORDER_STATUS; ?>">
                                                    <button class="btn-check" name="confirmed"><i class='bx bxs-check-circle'></i></button>
                                                    <button class="btn-cross" name="not-confirmed"><i class='bx bxs-x-circle'></i></button>
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
                                    <td colspan="5" class="error">No completed orders yet</td>
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
                                <a href="<?php echo SITEURL; ?>employee-inventory.php" class="edit">Edit</a>
                            </div>
                        </div>
                        <div class="group">
                            <a href="<?php echo SITEURL; ?>employee-to-prepare-orders.php" class="view big-font">To Prepare</a>
                            <a href="<?php echo SITEURL; ?>employee-preparing-orders.php" class="view big-font">Preparing</a>
                            <a href="<?php echo SITEURL; ?>employee-to-deliver-orders.php" class="view big-font">To Deliver</a>
                            <a href="<?php echo SITEURL; ?>employee-shipped.php" class="view big-font">Shipped</a>
                            <a href="<?php echo SITEURL; ?>employee-canceled-orders.php" class="view big-font">Canceled Orders</a>
                    </section>
                </section>
            </div>

        </section>
    </main>
</body>

</html>

<?php
if (isset($_POST['confirmed'])) {

    $PLACED_ORDER_CONFIRMATION = "Confirmed";

    $sql = "UPDATE placed_order SET
	PLACED_ORDER_CONFIRMATION = '$PLACED_ORDER_CONFIRMATION'
	WHERE PRSN_ID = '$PRSN_ID'
	";

    $res = mysqli_query($conn, $sql);
} else if (isset($_POST['not-confirmed'])) {
    $PLACED_ORDER_CONFIRMATION = "Not Confirmed";

    $sql = "UPDATE placed_order SET
	PLACED_ORDER_CONFIRMATION = '$PLACED_ORDER_CONFIRMATION'
	WHERE PRSN_ID = '$PRSN_ID'
	";

    $res = mysqli_query($conn, $sql);
}
?>