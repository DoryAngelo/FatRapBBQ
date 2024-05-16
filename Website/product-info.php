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

// $sql = "SELECT f.*, SUM(m.MENU_STOCK) AS total_menu_stock, m.MENU_ID
//         FROM food f 
//         LEFT JOIN menu m ON f.FOOD_ID = m.food_id
//         WHERE f.FOOD_ID = '$FOOD_ID'
//         AND NOW() BETWEEN STR_TO_DATE(m.menu_start, '%M %d, %Y %h:%i:%s %p') AND STR_TO_DATE(m.menu_end, '%M %d, %Y %h:%i:%s %p')
//         AND m.MENU_STOCK != 0
//         GROUP BY f.FOOD_ID";

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
    }
}

// if (isset($_SESSION['prsn_id'])) {
//     $sql9 = "SELECT f.*, io.in_order_quantity, m.*
//     FROM food f 
//     LEFT JOIN in_order io ON f.FOOD_ID = io.food_id AND io.placed_order_id IS NULL
//     LEFT JOIN menu m ON f.FOOD_ID = m.food_id
//     WHERE f.FOOD_ID = '$FOOD_ID'
//     AND io.PRSN_ID = '$PRSN_ID'";
// } else if (isset($_SESSION['guest_id'])) {
//     $sql9 = "SELECT f.*, io.in_order_quantity, m.*
//         FROM food f 
//         LEFT JOIN in_order io ON f.FOOD_ID = io.food_id AND io.placed_order_id IS NULL
//         LEFT JOIN menu m ON f.FOOD_ID = m.food_id
//         WHERE f.FOOD_ID = '$FOOD_ID'
//         AND io.GUEST_ORDER_IDENTIFIER = '$GUEST_ID'";
// }
// $IN_ORDER_QUANTITY = 0;

// $res9 = mysqli_query($conn, $sql9);
// $count9 = mysqli_num_rows($res9);
// if ($count9 > 0) {
//     while ($row9 = mysqli_fetch_assoc($res9)) {
//         $IN_ORDER_QUANTITY = $row9['in_order_quantity'];
//     }
// }


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
            $sql2 = "INSERT INTO in_order (FOOD_ID, MENU_ID, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS)
            VALUES ('$FOOD_ID', '$MENU_ID','$PRSN_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered')";
        } else {
            $sql2 = "INSERT INTO in_order (FOOD_ID, MENU_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS, GUEST_ORDER_IDENTIFIER)
            VALUES ('$FOOD_ID', '$MENU_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered', '$GUEST_ID')";
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
                                    <div class="quantity-grp">
                                        <input type="number" class="amount js-num" value="1" min="1" max="<?php echo $FOOD_STOCK; ?>">
                                    </div>
                                    <?php if ($PRSN_ROLE === "Wholesaler") { ?>
                                        <p class="remaining">10:00 am - 11:00 am<?php echo ($FOOD_STOCK < 0) ? 0 : $FOOD_STOCK; ?> available</p>
                                    <?php } else { ?>
                                        <p></p>
                                        <p class="remaining">10:00 am - 11:00 am <?php echo ($FOOD_STOCK < 0) ? 0 : $FOOD_STOCK; ?> sticks available</p>
                                    <?php } ?>
                                </div>
                                <div class="date-grp">
                                    <p>Date</p>
                                    <input type="date">
                                </div>
                                <div class="time-slots">
                                    <p>Time</p>
                                    <div class="tile-wrapper">
                                        <?php
                                            $startHour = 10; // Start hour
                                            $endHour = 17;   // End hour

                                            // Loop through each hour from 10:00 am to 5:00 pm
                                            for ($hour = $startHour; $hour <= $endHour; $hour++) {
                                                // Calculate the hour in 12-hour format
                                                $displayHour = ($hour % 12 == 0) ? 12 : $hour % 12;
                                                // Determine AM or PM
                                                $period = ($hour < 12) ? 'am' : 'pm';

                                                // Check if food stock is available for this hour
                                                $tileAvailable = false; // Assume no stock available by default
                                                if ($FOOD_STOCK > 0 && $hour >= date('H') + 4) {
                                                    // Assuming tiles start appearing 4 hours from the current time
                                                    $tileAvailable = true;
                                                }

                                                // Define the URL or JavaScript function for the tile
                                                $tileLink = "javascript:void(0)"; // Default link is a JavaScript function, change this to a specific URL if needed

                                                // If the tile is available, set the link to a specific URL or JavaScript function
                                                if ($tileAvailable) {
                                                    // Here you can set the link to a specific URL or JavaScript function
                                                    // For example, if you have a JavaScript function named 'handleTileClick(hour)', you can use:
                                                    // $tileLink = "javascript:handleTileClick($hour)";
                                                    // Or if you have a PHP file to handle the click action, you can use:
                                                    // $tileLink = "handle_click.php?hour=$hour";
                                                    $tileLink = "javascript:void(0)"; // Example: Using JavaScript function
                                                }
                                        ?>

                                        <!-- Wrap each tile in an button tag -->
                                        <!-- <a href="<?php echo $tileLink; ?>" class="tile <?php echo ($tileAvailable) ? 'available' : 'unavailable'; ?>">
                                            <p><?php echo $displayHour; ?>:00 <?php echo $period; ?></p>
                                            <?php if ($tileAvailable) : ?>
                                                <p><?php echo min($FOOD_STOCK, $HOURLY_CAP); ?> available</p>
                                            <?php endif; ?>
                                        </a> -->
                                        <?php } ?>
                                        
                                        <button class="tile">10:00AM</button>
                                        <button class="tile">11:00AM</button>
                                        <button class="tile">12:00AM</button>
                                        <button class="tile">1:00PM</button>
                                        <button class="tile">2:00PM</button>
                                        <button class="tile">3:00PM</button>
                                        <button class="tile">4:00PM</button>
                                        <button class="tile">5:00PM</button>
                                    </div>
                                </div>
                                <input type="hidden" id="quantity" name="quantity" value="1">
                                <input type="hidden" name="price" value="<?php echo $FOOD_PRICE ?>">
                                <input type="date" name="date">
                                <button name="order" type="submit" <?php echo ($FOOD_STOCK <= 0 || (isset($_POST['quantity']) && ($IN_ORDER_QUANTITY + intval($_POST['quantity']) > $FOOD_STOCK))) ? 'disabled' : ''; ?>>Add to Cart</button>
                            </form>
                        </div>
                    </section>
                    <section class="tiles">
                        
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
            const maxStock = <?php echo $FOOD_STOCK; ?>;
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