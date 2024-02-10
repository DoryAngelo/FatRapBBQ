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
    <title>Cart</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css"><!--change css file-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="app.js" defer></script>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.jpg">
                <div class="text">
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                </div>
            </div>
            <nav>
                <ul>
                    <!--TODO: ADD LINKS-->
                    <li><a href="cus-home-page.php">Home</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="#">Cart</a></li>
                    <!-- Text below should change to 'Logout'once user logged in-->
                    <?php
                    if (isset($_SESSION['prsn_id'])) {
                    ?>
                        <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a>
                        <li>
                        <?php
                    } else {
                        ?>
                        <li><a href="<?php echo SITEURL; ?>login-page.php">Login</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="section cart">
            <div class="section-heading">
                <h2>Cart</h2>
            </div>
            <section class="section-body">
                <section class="block">
                    <div class="block-body">
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <td></td>
                                        <th><span class="sr-only year">Quantity</span></th>
                                        <th><span class="sr-only year">Price</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $CUS_ID = $_SESSION['prsn_id'];

                                    $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, CUS_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
                                FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered'";

                                    $res = mysqli_query($conn, $sql);

                                    $count = mysqli_num_rows($res);

                                    if ($count > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            if ($row['CUS_ID'] == $CUS_ID) {
                                                $IN_ORDER_ID = $row['IN_ORDER_ID'];
                                                $FOOD_NAME = $row['FOOD_NAME'];
                                                $FOOD_PRICE = $row['FOOD_PRICE'];
                                                $FOOD_IMG = $row['FOOD_IMG'];
                                                $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'];
                                                $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'];
                                    ?>
                                                <div class="green">
                                                    <tr class="data">
                                                        <th><?php echo $FOOD_NAME ?><span class="description"></span></th>
                                                        <td><?php echo $IN_ORDER_QUANTITY ?></td>
                                                        <td>₱<?php echo $FOOD_PRICE ?></td>
                                                    </tr>
                                                </div>
                                    <?php
                                            }
                                        }
                                    }
                                    $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM  IN_ORDER WHERE CUS_ID = $CUS_ID";
                                    $res2 = mysqli_query($conn, $sql2);
                                    $row2 = mysqli_fetch_assoc($res2);
                                    $total = $row2['Total'];
                                    ?>
                                    <tr class="total">
                                        <th></th>
                                        <td>Total:</td>
                                        <td class="current">₱<?php echo $total?></td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <a href="checkout.php" class="page-button center">Checkout</a>
            </section>
        </section>
    </main>
    <footer>
        <div class="footer-container">
            <div class="left-container">
                <h1>Fat Rap's Barbeque's Online Store</h1>
                <div class="list">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Cart</a></li>
                        <li><a href="#">Track order</a></li>
                    </ul>
                </div>
            </div>
            <div class="right-container">
                <div class="icons-block">
                    <img id="logo" src="images/circle logo.png">
                    <img id="logo" src="images/circle logo.png">
                    <img id="logo" src="images/circle logo.png">
                </div>
                <div class="list">
                    <div class="list-items">
                        <!--insert icon-->
                        <p>email@gmail.com</p>
                    </div>
                    <div class="list-items">
                        <!--insert icon-->
                        <p>0912 345 6789 | 912 1199</p>
                    </div>
                    <div class="list-items">
                        <!--insert icon-->
                        <p>123 Magaling St., Brgy. Something, Somewhere City</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>