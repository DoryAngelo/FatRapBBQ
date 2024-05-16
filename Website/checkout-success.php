<?php

@include 'constants.php';

if (isset($_SESSION['prsn_id'])) {
    $PRSN_ID = $_SESSION['prsn_id'];
} else if (isset($_SESSION['guest_id'])) {
    $_SESSION['prsn_role'] = "Customer";
    $GUEST_ID = $_SESSION['guest_id'];
} else {
    $random = random_bytes(16);
    $GUEST_ID = bin2hex($random);
    $_SESSION['prsn_role'] = "Customer";
    $_SESSION['guest_id'] =   $GUEST_ID;
}

$PRSN_ROLE = $_SESSION['prsn_role'];

$PLACED_ORDER_TRACKER = $_SESSION['PLACED_ORDER_TRACKER'];
$PLACED_ORDER_ID = $_GET['PLACED_ORDER_ID'];

$select = "SELECT io.food_id, SUM(io.in_order_quantity) AS total_quantity
           FROM in_order io
           WHERE io.placed_order_id = '$PLACED_ORDER_ID'
           GROUP BY io.food_id";

$select_result = mysqli_query($conn, $select);

$food_quantities = [];
while ($row = mysqli_fetch_assoc($select_result)) {
    $food_quantities[$row['food_id']] = $row['total_quantity'];
}

foreach ($food_quantities as $food_id => $total_quantity) {
    // Update food_stock in the food table
    $update_query = "UPDATE food 
                     SET food_stock = food_stock - $total_quantity 
                     WHERE food_id = '$food_id'";
    mysqli_query($conn, $update_query);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout success! | Fat Rap's Barbeque</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="success-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- add the code below to load the icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body class="<?php echo ($PRSN_ROLE === 'Customer') ? 'customer' : ''; ?>">
    <header class="<?php echo ($PRSN_ROLE === 'Customer') ? 'customer' : ''; ?>">
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque</h1>
                    <?php
                    if ($PRSN_ROLE == "Wholesaler") {
                    ?>
                        <p>WHOLESALE</p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section class="section product-info-page">
            <div class="container">
                <div class="success-box">
                    <div class="success-title">
                        <h1>Success!</h1>
                        <p class="title-desc">
                            Your order tracker is:
                            <a href="track-order.php?tracker=<?php echo urlencode($PLACED_ORDER_TRACKER); ?>">
                                <?php echo htmlspecialchars($PLACED_ORDER_TRACKER); ?>
                            </a>
                        </p>
                        <a href="cus-home-page.php" class="button">Go to Home</a>
                    </div>
                </div>
            </div>
        </section>
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