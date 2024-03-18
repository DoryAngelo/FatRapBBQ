<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Cart | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css"><!--change css file-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- <script src="app.js" defer></script> -->
    <!-- add the code below to load the icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
                        <ul class = "menubar">
                            <!--TODO: ADD LINKS-->
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Menu</a></li>
                            <li><a href="<?php echo SITEURL ;?>cart.php">Cart</a></li>
                        <!-- Text below should change to 'Logout'once user logged in-->
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
        <section class="section cart">
            <div class="section-heading">
                <h2>Cart</h2>
            </div>
            <form class="section-body" action="checkout.php" method="post">
                <section class="block">
                    <div class="block-body">
                        <div class="table-wrap">
                            <table class="order">
                                <thead>
                                    <tr>
                                        <th class="header first-col"></th>
                                        <th class="header narrow-col">Quantity</th>
                                        <th class="header narrow-col price-col">Price</th>
                                        <th class="header narrow-col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, FOOD_STOCK, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
                                        FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered' AND PRSN_ID = $PRSN_ID";
                                    $res = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($res);
                                    $stockValues = array();
                                    if ($count > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $IN_ORDER_ID = $row['IN_ORDER_ID'];
                                            $FOOD_NAME = $row['FOOD_NAME'];
                                            $FOOD_PRICE = $row['FOOD_PRICE'];
                                            $FOOD_IMG = $row['FOOD_IMG'];
                                            $FOOD_STOCK = $row['FOOD_STOCK'];
                                            $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'];
                                            $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'];
                                            $stockValues[$FOOD_NAME] = $FOOD_STOCK;
                                    ?>
                                            <tr> <!-- one row for a product-->
                                                <td data-cell="customer" class="first-col">
                                                    <div class="pic-grp">
                                                        <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                                        <p><?php echo $FOOD_NAME ?></p>
                                                    </div>
                                                </td> <!--Pic and Name-->
                                                <td class="narrow-col quantity-col">
                                                    <div class="quantity-grp">
                                                        <i class='bx bxs-minus-circle js-minus' data-in-order-id="<?php echo $IN_ORDER_ID; ?>" data-stock="<?php echo $FOOD_STOCK; ?>" data-price="<?php echo $FOOD_PRICE; ?>"></i>
                                                        <p class="amount js-num"><?php echo $IN_ORDER_QUANTITY ?></p>
                                                        <i class='bx bxs-plus-circle js-plus' data-in-order-id="<?php echo $IN_ORDER_ID; ?>" data-stock="<?php echo $FOOD_STOCK; ?>" data-price="<?php echo $FOOD_PRICE; ?>"></i>
                                                    </div>
                                                    <p class="remaining"><?php echo $FOOD_STOCK ?> sticks remaining</p>
                                                </td> <!--Quantity-->
                                                <td class="narrow-col price-col">₱<?php echo $IN_ORDER_TOTAL ?></td><!--Price-->
                                                <td class="narrow-col">
                                                    <a href="delete_in_order.php?IN_ORDER_ID=<?php echo $IN_ORDER_ID; ?>" class="bx bxs-trash-alt trash"></a><!-- pa remove na lang ng underline sa link -->
                                                </td><!--Action-->
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5" class="error">Cart is empty</td>
                                        </tr>
                                    <?php
                                    }
                                    $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM  IN_ORDER WHERE PRSN_ID = $PRSN_ID";
                                    $res2 = mysqli_query($conn, $sql2);
                                    $row2 = mysqli_fetch_assoc($res2);
                                    $total = $row2['Total'];
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="payment">
                            <h3>Total Payment:</h3>
                            <h3>₱<?php echo $total ?></h3>
                        </div>
                    </div>
                </section>
                <input type="hidden" id="quantity" name="quantity" value="1">
                <!-- <a href="checkout.php" class="page-button center">Checkout</a> -->
                <?php

                if ($count <= 0) {
                ?>
                    <button class="page-button center" disabled>Checkout</button>
                <?php
                } else {
                ?>
                    <button name="checkout" type="submit" class="page-button center">Checkout</button>
                    <!-- second version -->
                    <!-- <a href="checkout.php" class="page-button center">Checkout</a> -->
                    <!-- first version -->
                    <!-- <input type="submit" value="Checkout" name="checkout" class="page-button center"> -->
                <?php
                }
                ?>
            </form>
        </section>
    </main>
    <footer>
        <div class="footer-container">
            <div class="left-container">
                <h1>Fat Rap's Barbeque's Online Store</h1>
                <div class="list">
                    <ul>
                        <li><a href="<?php echo SITEURL; ?>cus-home-page.php">Home</a></li>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const plusButtons = document.querySelectorAll(".js-plus");
            const minusButtons = document.querySelectorAll(".js-minus");
            const quantityDisplays = document.querySelectorAll(".js-num");

            plusButtons.forEach((button, index) => {
                button.addEventListener("click", () => {
                    const stock = parseInt(button.dataset.stock);
                    const IN_ORDER_ID = button.dataset.inOrderId;
                    const currentQuantity = parseInt(quantityDisplays[index].innerText);
                    const newQuantity = currentQuantity + 1;
                    const foodPrice = parseFloat(button.dataset.price);

                    if (newQuantity <= stock) {
                        updateQuantity(IN_ORDER_ID, newQuantity, foodPrice, index);
                    } else {
                        alert("Cannot exceed food stock!");
                    }
                });
            });

            minusButtons.forEach((button, index) => {
                button.addEventListener("click", () => {
                    const IN_ORDER_ID = button.dataset.inOrderId;
                    const currentQuantity = parseInt(quantityDisplays[index].innerText);
                    const newQuantity = currentQuantity - 1;
                    const foodPrice = parseFloat(button.dataset.price);

                    if (newQuantity >= 1) {
                        updateQuantity(IN_ORDER_ID, newQuantity, foodPrice, index);
                    }
                });
            });

            function updateQuantity(IN_ORDER_ID, newQuantity, foodPrice, displayIndex) {
                const formData = new FormData();
                formData.append("IN_ORDER_ID", IN_ORDER_ID);
                formData.append("IN_ORDER_QUANTITY", newQuantity);
                formData.append("FOOD_PRICE", foodPrice);

                fetch("update_quantity.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        quantityDisplays[displayIndex].innerText = newQuantity;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>
</body>

</html>