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

$FOOD_ID = $_GET['FOOD_ID'];


$sql = "SELECT * FROM food WHERE FOOD_ID = '$FOOD_ID'";

$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $FOOD_NAME = $row['FOOD_NAME'];
        $FOOD_DESC = $row['FOOD_DESC'];
        $FOOD_IMG = $row['FOOD_IMG'];
        $FOOD_PRICE = $row['FOOD_PRICE'];
        $FOOD_STOCK = $row['FOOD_STOCK'];
        $HOURLY_CAP = $row['HOURLY_CAP'];
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

        $res = mysqli_query($conn, $sql_orders);
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $total_quantity = $row['total_quantity'];
                $avail -= $total_quantity;
            }
        }
    }
}

$SELECTED_DATE = isset($_SESSION['DATE_SELECTED']) ? $_SESSION['DATE_SELECTED'] : date('M j Y');
$SELECTED_TIME = isset($_SESSION['TIME_SELECTED']) ? $_SESSION['TIME_SELECTED'] : date('g:i a');
$selected_datetime = strtotime($SELECTED_DATE . " " . $SELECTED_TIME);
$selected_hour = date('G', $selected_datetime);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    $FOOD_PRICE = $_POST['price'];

    if (isset($_SESSION['prsn_id'])) {
        $sql = "SELECT * FROM in_order WHERE FOOD_ID = $FOOD_ID AND PRSN_ID = $PRSN_ID AND PLACED_ORDER_ID IS NULL";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
    } else {
        $sql = "SELECT * FROM in_order WHERE FOOD_ID = $FOOD_ID AND GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND PLACED_ORDER_ID IS NULL";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
    }
    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $IN_ORDER_ID = $row['IN_ORDER_ID'];
            $IN_ORDER_QUANTITY += $quantity;
            $IN_ORDER_TOTAL = $IN_ORDER_QUANTITY * $FOOD_PRICE;
            $sql = "UPDATE in_order SET 
                            IN_ORDER_QUANTITY = $IN_ORDER_QUANTITY,
                            IN_ORDER_TOTAL = $IN_ORDER_TOTAL
                            WHERE IN_ORDER_ID = $IN_ORDER_ID";
            $res_update = mysqli_query($conn, $sql);
        }
    } else {
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
        $IN_ORDER_TOTAL = (float)$quantity * (float)$FOOD_PRICE;
        if (isset($_SESSION['prsn_id'])) {
            $sql2 = "INSERT INTO in_order (FOOD_ID, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS, DELIVERY_DATE, DELIVERY_HOUR)
            VALUES ('$FOOD_ID', '$PRSN_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered', '$SELECTED_DATE', '$selected_hour')";
        } else {
            $sql2 = "INSERT INTO in_order (FOOD_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS, GUEST_ORDER_IDENTIFIER, DELIVERY_DATE, DELIVERY_HOUR)
            VALUES ('$FOOD_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered', '$GUEST_ID', '$SELECTED_DATE', '$selected_hour')";
        }
        $res2 = mysqli_query($conn, $sql2);
    }
    // Redirect to the home page after processing
    $_SESSION['fromProdInfo'] = 'yes';
    header('location:menu.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Product Information | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css"><!--change css file-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="app.js" defer></script>
    <!-- add the code below to load the icons -->
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
                    <?php
                    if ($PRSN_ROLE == "Wholesaler") {
                    ?>
                        <p>WHOLESALE</p>
                    <?php
                    }
                    ?>
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
        <section class="section product-info-page">
            <div class="container">
                <div class="wrapper">
                    <a href="<?php echo SITEURL; ?>menu.php" class="back">Back</a>
                    <section class="block">
                        <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                        <div class="right-grp">
                            <div class="top">
                                <h1><?php echo $FOOD_NAME ?></h1>
                                <p><?php echo $FOOD_DESC ?></p>
                            </div>
                            <form class="bottom" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <div class="inline">
                                    <h1>₱<?php echo $FOOD_PRICE ?></h1>
                                    <p id="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'stick-hidden' : ''; ?>">per stick</p>
                                    <div class="quantity-grp">
                                        <input type="number" class="amount js-num" value="1" min="1" max="<?php echo $avail; ?>">
                                    </div>
                                    <?php if ($PRSN_ROLE === "Wholesaler") { ?>
                                        <p class="remaining"><?php echo ($avail < 0) ? 0 : $avail; ?> available</p>
                                    <?php } else { ?>
                                        <p></p>
                                        <p class="remaining"><?php echo ($avail < 0) ? 0 : $avail; ?> sticks available</p>
                                    <?php } ?>
                                </div>
                                <input type="hidden" id="quantity" name="quantity" value="1">
                                <input type="hidden" name="price" value="<?php echo $FOOD_PRICE ?>">
                                <button name="order" type="submit" <?php echo ($avail <= 0 || (isset($_POST['quantity']) && ($IN_ORDER_QUANTITY + intval($_POST['quantity']) > $avail))) ? 'disabled' : ''; ?>>Add to Cart</button>
                            </form>
                        </div>
                    </section>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputField = document.querySelector('.js-num');
            const quantityInput = document.getElementById("quantity");
            const addButton = document.querySelector('[name="order"]');
            const maxStock = <?php echo $avail; ?>;
            const quantityData = <?php echo isset($IN_ORDER_QUANTITY) ? $IN_ORDER_QUANTITY : 0; ?>;

            inputField.addEventListener('input', function() {
                let currentValue = parseInt(inputField.value, 10);
                if (isNaN(currentValue) || currentValue < 1) {
                    inputField.value = 1;
                } else if (currentValue > maxStock) {
                    alert("The quantity exceeds the available stock.");
                    inputField.value = maxStock;
                }

                quantityInput.value = inputField.value;
                updateButtonState();
            });

            function updateButtonState() {
                const currentQuantity = parseInt(inputField.value, 10);
                addButton.disabled = (maxStock <= 0 || currentQuantity + quantityData > maxStock);
            }

            updateButtonState();
        });
    </script>

    <!-- floating button -->
    <a href="<?php echo SITEURL; ?>cart.php" class="material-icons floating-btn" style="font-size: 45px;">shopping_cart</a>

</body>

</html>