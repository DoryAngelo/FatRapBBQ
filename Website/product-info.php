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

$sql = "SELECT f.*, SUM(m.MENU_STOCK) AS total_menu_stock, io.in_order_quantity, m.MENU_ID
        FROM food f 
        LEFT JOIN in_order io ON f.FOOD_ID = io.food_id AND io.placed_order_id IS NULL
        LEFT JOIN menu m ON f.FOOD_ID = m.food_id
        WHERE f.FOOD_ID = '$FOOD_ID'
        AND NOW() BETWEEN STR_TO_DATE(m.menu_start, '%M %d, %Y %h:%i:%s %p') AND STR_TO_DATE(m.menu_end, '%M %d, %Y %h:%i:%s %p')
        AND m.MENU_STOCK != 0
        GROUP BY f.FOOD_ID";


$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $FOOD_ID = $row['FOOD_ID'];
        $MENU_ID = $row['MENU_ID'];
        $FOOD_NAME = $row['FOOD_NAME'];
        $FOOD_DESC = $row['FOOD_DESC']; 
        $FOOD_IMG = $row['FOOD_IMG'];
        $FOOD_PRICE = $row['FOOD_PRICE'];
        $MENU_STOCK = $row['total_menu_stock'];
        $FOOD_STOCK = $row['FOOD_STOCK'];
        $IN_ORDER_QUANTITY = $row['in_order_quantity'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    $quantity = $_POST['quantity'];
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
        $IN_ORDER_TOTAL = $quantity * $FOOD_PRICE;
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
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>"><!--hidden product name to accompany the product's quantity-->
                                <div class="inline">
                                    <h1>₱<?php echo $FOOD_PRICE ?></h1>
                                    <div class="quantity-grp">
                                        <i class='bx bxs-minus-circle js-minus' data-stock="<?php echo $MENU_STOCK; ?>" data-price="<?php echo $FOOD_PRICE; ?>"></i>
                                        <p class="amount js-num">1</p>
                                        <i class='bx bxs-plus-circle js-plus' data-stock="<?php echo $MENU_STOCK; ?>" data-price="<?php echo $FOOD_PRICE; ?>"></i>
                                    </div>
                                    <?php if ($PRSN_ROLE === "Wholesaler") {
                                    ?>
                                        <p class="remaining"><?php echo ($MENU_STOCK < 0) ? 0 : $MENU_STOCK; ?>
                                            available</p>
                                    <?php
                                    } else {

                                    ?>
                                        <p class="remaining"><?php echo ($MENU_STOCK < 0) ? 0 : $MENU_STOCK; ?>
                                            sticks available</p>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <input type="hidden" id="quantity" name="quantity" value="<?php echo ($IN_ORDER_QUANTITY == NULL) ? 1 : $IN_ORDER_QUANTITY; ?>">
                                <input type="hidden" name="price" value="<?php echo $FOOD_PRICE ?>">
                                <button name="order" type="submit" <?php echo ($MENU_STOCK <= 0 || (isset($_POST['quantity']) && ($IN_ORDER_QUANTITY + intval($_POST['quantity']) > $FOOD_STOCK))) ? 'disabled' : ''; ?>>Add to Cart</button>

                            </form>
                        </div>
                    </section>
                    <?php

                    ?>
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
        var quantityData = <?php echo isset($IN_ORDER_QUANTITY) ? $IN_ORDER_QUANTITY : 0; ?>;
        document.addEventListener("DOMContentLoaded", function() {
            const plus = document.querySelector(".js-plus");
            const minus = document.querySelector(".js-minus");
            const num = document.querySelector(".js-num");
            const quantityInput = document.getElementById("quantity");
            const addButton = document.querySelector('[name="order"]');
            const stock = parseInt(plus.dataset.stock);

            updateButtonState(); // Call the function initially to set the button state

            plus.addEventListener("click", () => {
                updateQuantity(1);
            });

            minus.addEventListener("click", () => {
                updateQuantity(-1);
            });

            function updateQuantity(change) {
                let newQuantity = parseInt(num.innerText) + change;

                if (newQuantity < 1) {
                    return; // Prevent negative quantity
                }

                if (newQuantity + quantityData > stock) {
                    alert("Quantity selected exceeds available stock!");
                    return; // Prevent updating the quantity if it exceeds stock
                }

                num.innerText = newQuantity;
                quantityInput.value = newQuantity;

                updateButtonState();
            }

            function updateButtonState() {
                addButton.disabled = (stock <= 0 || parseInt(num.innerText) + parseInt('<?php echo $IN_ORDER_QUANTITY; ?>') > stock);
            }
        });
    </script>
</body>

</html>