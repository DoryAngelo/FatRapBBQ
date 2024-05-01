<?php

@include 'constants.php';

// if (isset($_SESSION['prsn_id'])) {
//     $PRSN_ID = $_SESSION['prsn_id'];
// } else {
//     $_SESSION['prsn_role'] = "Customer";
//     $GUEST_ID = $_SESSION['guest_id'];
// }

// $PRSN_ROLE = $_SESSION['prsn_role'];

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
        <section class="section cart">
            <div class="container">
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
                                        if (isset($_SESSION['prsn_id'])) {
                                            $sql = "SELECT io.IN_ORDER_ID, f.FOOD_NAME, f.FOOD_IMG, f.FOOD_PRICE, f.FOOD_STOCK, m.menu_stock, io.PRSN_ID, io.IN_ORDER_QUANTITY, io.IN_ORDER_TOTAL 
                                            FROM in_order io
                                            LEFT JOIN placed_order po ON io.placed_order_id = po.placed_order_id
                                            JOIN food f ON io.FOOD_ID = f.FOOD_ID
                                            LEFT JOIN menu m ON f.FOOD_ID = m.food_id
                                            WHERE io.IN_ORDER_STATUS != 'Delivered' 
                                            AND io.PRSN_ID = '$PRSN_ID'
                                            AND po.placed_order_id IS NULL
                                            GROUP BY f.FOOD_ID";
                                        } else {
                                            $sql = "SELECT io.IN_ORDER_ID, f.FOOD_NAME, f.FOOD_IMG, f.FOOD_PRICE, f.FOOD_STOCK, m.menu_stock, io.PRSN_ID, io.IN_ORDER_QUANTITY, io.IN_ORDER_TOTAL 
FROM in_order io
LEFT JOIN placed_order po ON io.placed_order_id = po.placed_order_id
JOIN food f ON io.FOOD_ID = f.FOOD_ID
LEFT JOIN menu m ON f.FOOD_ID = m.food_id
WHERE io.IN_ORDER_STATUS != 'Delivered' 
AND io.GUEST_ORDER_IDENTIFIER = '$GUEST_ID'
AND po.placed_order_id IS NULL
GROUP BY f.FOOD_ID";
                                        }

                                        $res = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($res);
                                        $stockValues = array();
                                        if ($count > 0) {
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $IN_ORDER_ID = $row['IN_ORDER_ID'];
                                                $FOOD_NAME = $row['FOOD_NAME'];
                                                $FOOD_PRICE = $row['FOOD_PRICE'];
                                                $FOOD_IMG = $row['FOOD_IMG'];
                                                $MENU_STOCK = $row['menu_stock'];
                                                $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'];
                                                $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'];
                                                $stockValues[$FOOD_NAME] = $MENU_STOCK;
                                        ?>
                                                <tr> <!-- one row for a product-->
                                                    <td data-cell="customer" class="first-col">
                                                        <div class="pic-grp">
                                                            <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                                            <p><?php echo $FOOD_NAME ?></p>
                                                        </div>
                                                    </td> <!--Pic and Name-->
                                                    <td class="narrow-col quantity-col">
                                                        <div class="with-remaining">
                                                            <div class="quantity-grp">
                                                                <i class='bx bxs-minus-circle js-minus' data-in-order-id="<?php echo $IN_ORDER_ID; ?>" data-stock="<?php echo $FOOD_STOCK; ?>" data-price="<?php echo $FOOD_PRICE; ?>"></i>
                                                                <p class="amount js-num"><?php echo $IN_ORDER_QUANTITY ?></p>
                                                                <i class='bx bxs-plus-circle js-plus' data-in-order-id="<?php echo $IN_ORDER_ID; ?>" data-stock="<?php echo $FOOD_STOCK; ?>" data-price="<?php echo $FOOD_PRICE; ?>"></i>
                                                            </div>
                                                            <p class="remaining"><?php echo ($MENU_STOCK < 0) ? 0 : $MENU_STOCK; ?>
                                                                sticks remaining</p>
                                                        </div>
                                                    </td> <!--Quantity-->
                                                    <td class="narrow-col price-col">
                                                        <p>₱<?php echo $IN_ORDER_TOTAL ?></p>
                                                    </td><!--Price-->
                                                    <td class="narrow-col">
                                                        <p><a href="delete_in_order.php?IN_ORDER_ID=<?php echo $IN_ORDER_ID; ?>" class="bx bxs-trash-alt trash"></a>
                                                        <p><!-- pa remove na lang ng underline sa link -->
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
                                        if ($count >= 0) {
                                            if (isset($_SESSION['prsn_id'])) {
                                                $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM IN_ORDER WHERE PRSN_ID = '$PRSN_ID' AND PLACED_ORDER_ID IS NULL";
                                            } else {
                                                $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM IN_ORDER WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND PLACED_ORDER_ID IS NULL";
                                            }
                                            $res2 = mysqli_query($conn, $sql2);
                                            $row2 = mysqli_fetch_assoc($res2);
                                            $total = $row2['Total'];
                                        } else {
                                            $total = '';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="payment">
                                <div class="text">
                                    <h3>Total Payment:</h3>
                                    <h3>₱<?php echo $total; ?></h3>
                                </div>
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