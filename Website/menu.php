<?php

@include 'constants.php';

// $selectedDate = isset($_SESSION['DATE_SELECTED']) ? $_SESSION['DATE_SELECTED'] : "";
// $selectedTime = isset($_SESSION['TIME_SELECTED']) ? $_SESSION['TIME_SELECTED'] : "";

// if (isset($_SESSION['DATE_SELECTED']) && isset($_SESSION['TIME_SELECTED'])) {
//     $selectedDate = $_SESSION['DATE_SELECTED'];
//     $selectedTime = $_SESSION['TIME_SELECTED'];
// }

if (isset($_GET['DATE_SELECTED'])) {
    $_SESSION['DATE_SELECTED'] = $_GET['DATE_SELECTED'];
}

if (isset($_GET['TIME_SELECTED'])) {
    $_SESSION['TIME_SELECTED'] = $_GET['TIME_SELECTED'];
}

if (isset($_SESSION['prsn_id'])) {
    $PRSN_ID = $_SESSION['prsn_id'];
} else if (isset($_SESSION['guest_id'])) {
    $_SESSION['prsn_role'] = "Customer";
    $GUEST_ID = $_SESSION['guest_id'];
} else {
    $random = random_bytes(16);
    $GUEST_ID = bin2hex($random);
    $_SESSION['prsn_role'] = "Customer";
    $_SESSION['guest_id'] = $GUEST_ID;
}

$PRSN_ROLE = $_SESSION['prsn_role'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="app.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'wholesaler' : ''; ?>">
    <header class="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'wholesaler' : ''; ?>">
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque</h1>
                    <?php if ($PRSN_ROLE == "Wholesaler") { ?>
                        <p>WHOLESALE</p>
                    <?php } ?>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class='menubar'>
                <li><a href="<?php echo SITEURL; ?>cus-home-page.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>menu.php">Menu</a></li>
                <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
                <?php if (isset($_SESSION['prsn_id'])) { ?>
                    <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo SITEURL; ?>login-page.php">Login</a></li>
                <?php } ?>
            </ul>
        </div>
    </header>
    <main>
        <?php if (isset($_SESSION['fromProdInfo']) && $_SESSION['fromProdInfo'] == 'yes') { ?>
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Your order has been added to the cart.',
                    icon: 'success',
                    iconColor: '#edcb1c',
                    confirmButtonText: '<font color="#3a001e">Continue</font>',
                    confirmButtonColor: '#edcb1c',
                    color: 'white',
                    background: '#539b3b',
                });
            </script>
        <?php
            unset($_SESSION['fromProdInfo']);
        }
        if ($PRSN_ROLE == "Wholesaler") {
        ?>
            <div class="wholesaler-menu-banner">
                <h1>WHOLESALE DEALS!!!</h1>
            </div>
        <?php } ?>
        <section class="section menu">
            <div class="container">
                <div class="section-heading">
                    <h2>Menu</h2>
                    <?php if (isset($_SESSION['DATE_SELECTED'])) : ?>
                        <p>Selected Pick up Date: <?php echo $_SESSION['DATE_SELECTED']; ?></p>
                    <?php else : ?>
                        <p>No date selected.</p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['TIME_SELECTED'])) : ?>
                        <p>Selected Pick up Time: <?php echo $_SESSION['TIME_SELECTED']; ?></p>
                    <?php else : ?>
                        <p>No time selected.</p>
                    <?php endif; ?>
                </div>
                <section class="section-body">
                    <?php
                    if ($PRSN_ROLE === 'Admin') {
                        $sql = "SELECT * FROM food WHERE FOOD_ACTIVE = 'Yes'";
                    } else {
                        $sql = "SELECT * FROM food WHERE FOOD_ACTIVE = 'Yes' AND FOOD_TYPE = '$PRSN_ROLE'";
                    }
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);

                    echo "<script>console.log('Total food items count: $count');</script>";

                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $FOOD_ID = $row['FOOD_ID'];
                            $FOOD_NAME = $row['FOOD_NAME'];
                            $FOOD_IMG = $row['FOOD_IMG'];
                            $FOOD_STOCK = $row['FOOD_STOCK'];
                            $HOURLY_CAP = $row['HOURLY_CAP'];
                            $FOOD_PRICE = $row['FOOD_PRICE'];

                            $avail = min($FOOD_STOCK, $HOURLY_CAP);

                            $SELECTED_DATE = isset($_SESSION['DATE_SELECTED']) ? $_SESSION['DATE_SELECTED'] : date('M j Y');
                            $SELECTED_TIME = isset($_SESSION['TIME_SELECTED']) ? $_SESSION['TIME_SELECTED'] : date('g:i a');
                            $selected_datetime = strtotime($SELECTED_DATE . " " . $SELECTED_TIME);
                            $selected_hour = date('G', $selected_datetime);

                            $sql_orders = "
                                SELECT SUM(in_order_quantity) AS total_quantity
                                FROM in_order
                                WHERE placed_order_id IS NOT NULL
                                AND food_id = '$FOOD_ID'
                                AND DELIVERY_DATE = '$SELECTED_DATE'
                                AND DELIVERY_HOUR = '$selected_hour'
                                GROUP BY food_id, delivery_date, delivery_hour
                            ";

                            $res_orders = mysqli_query($conn, $sql_orders);
                            $count_orders = mysqli_num_rows($res_orders);

                            if ($count_orders > 0) {
                                while ($row_orders = mysqli_fetch_assoc($res_orders)) {
                                    $total_quantity = $row_orders['total_quantity'];
                                    $avail -= $total_quantity;
                                }
                            }

                            $disabledClass = ($avail <= 0) ? 'disable-click' : '';
                    ?>
                            <a class="menu-item position <?php echo $disabledClass; ?>" href="<?php echo ($avail <= 0) ? '#' : SITEURL . 'product-info.php?FOOD_ID=' . $FOOD_ID; ?>">
                                <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                <div class="text">
                                    <p class="name"><?php echo $FOOD_NAME ?></p>
                                    <div class="inline">
                                        <h2>₱<?php echo $FOOD_PRICE ?></h2>
                                        <p id="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'stick-hidden' : ''; ?>">per stick</p>
                                        <?php if ($avail > 0) : ?>
                                            <p><?php echo $avail ?> sticks remaining</p>
                                        <?php endif; ?>
                                        
                                    </div>
                                </div>
                                <?php if ($avail <= 0) : ?>
                                    <div class="unavailable">
                                        <p>Product limit reached at this time slot. Please choose another time slot.</p>
                                        <button class="button">Select another date and time</button>
                                    </div>
                                <?php endif; ?>
                            </a>
                    <?php
                        }
                    }
                    ?>
                </section>
            </div>
        </section>
        <a href="<?php echo SITEURL; ?>cart.php" class="material-icons floating-btn" style="font-size: 45px;">shopping_cart</a>
    </main>
    <footer>
        <div class="footer-container">
            <div class="left-container">
                <h2>Fat Rap's Barbeque</h2>
                <div class="list">
                    <ul>
                        <li><a href="<?php echo SITEURL; ?>cus-home-page.php">Home</a></li>
                        <li><a href="<?php echo SITEURL; ?>menu.php">Menu</a></li>
                        <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
                        <li><a href="cus-home-page.php#track-order-section">Track order</a></li>
                    </ul>
                </div>
            </div>
            <div class="right-container">
                <div class="icons-block">
                    <a href="https://www.facebook.com/profile.php?id=100077565231475">
                        <i class='bx bxl-facebook-circle'></i>
                    </a>
                </div>
                <div class="list">
                    <!-- <div class="list-items">
                        <i class='bx bxs-envelope'></i>
                        <p>email@gmail.com</p>
                    </div> -->
                    <div class="list-items">
                        <i class='bx bxs-phone'></i>
                        <p>09178073760 | 09190873861</p>
                    </div>
                    <div class="list-items">
                        <i class='bx bxs-map'></i>
                        <p>Sta. Ignaciana, Brgy. Kalusugan, Quezon City, Metro Manila, Philippines</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>