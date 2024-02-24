<?php

@include 'constants.php';

session_start();
$PRSN_ID = $_SESSION['prsn_id'];

$sql = "SELECT * FROM food WHERE FOOD_ACTIVE='Yes'";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

//check whether there are food available
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        //get the values
        $FOOD_ID = $row['FOOD_ID'];
        $FOOD_NAME = $row['FOOD_NAME'];
        $FOOD_PRICE = $row['FOOD_PRICE'];
        $FOOD_DESC = $row['FOOD_DESC'];
        $FOOD_IMG = $row['FOOD_IMG'];
        $FOOD_STOCK = $row['FOOD_STOCK'];
    }
}

if (isset($_POST['submit'])) {
    $PLACED_ORDER_TRACKER =  mysqli_real_escape_string($conn, $_POST['track-order']);
    $_SESSION['placed_order_tracker'] = mysqli_real_escape_string($conn, $_POST['track-order']);
    $select = " SELECT * FROM `placed_order` WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    header('location:track-order.php');
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Home | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="cus-home-styles.css"><!--change css file-->
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
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
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
            </nav>
        </div>
    </header>
    <main>
        <!-- section 1 - product landing -->
        <section class="product-landing section">
            <div class="PL-text">
                <h1>Order our best-selling BBQ</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
                <a href="" class="button">Order Now</a>
            </div>
            <div class="featured-pic"></div>
        </section>
        <!-- section 2 - calendar -->
        <section class="calendar section">
            <div class="front">
                <section class="left-text">
                    <h1 class="section-heading">See our available dates</h1>
                    <div class="legend">
                        <ul>
                            <li class="available button">Available</li>
                            <li class="fully-booked button">Fully Booked</li>
                            <li class="closed button">Closed</li>
                        </ul>
                    </div>
                </section>
                <section class="calendar-block">
                    <div class="month-heading">
                        <p>2023</p>
                        <div>
                            <h2>November</h2>
                        </div>
                    </div>
                    <div class="weekday-container">
                        <ul>
                            <li class="weekday width">SUN</li>
                            <li class="weekday width">MON</li>
                            <li class="weekday width">TUES</li>
                            <li class="weekday width">WED</li>
                            <li class="weekday width">THUR</li>
                            <li class="weekday width">FRI</li>
                            <li class="weekday width">SAT</li>
                        </ul>
                    </div>
                    <div class="days-container">

                    </div>
                </section>
            </div>
            </div>
            <div class="back">
                <div class="green-block"></div>
                <div class="cream-block"></div>
            </div>
        </section>
        <!-- section 3 - product info -->
        <section class="product-landing info section">
            <div class="featured-pic"></div>
            <div class="PL-text">
                <h1 class="product-name"><?php echo $FOOD_NAME; ?></h1>
                <p class="product"><?php echo $FOOD_PRICE; ?></p>
                <p class="product"><?php echo $FOOD_DESC; ?></p>
                <form class="button-group">
                    <a href="add_food.php?FOOD_ID=<?php echo $FOOD_ID; ?>&FOOD_PRICE=<?php echo $FOOD_PRICE; ?>&PRSN_ID=<?php echo $PRSN_ID; ?>" class="button">Order Now</a>
                    <div class="right-contents">
                        <div class="quantity-group">
                            <div class="circle">-</div>
                            <p class="amount">9999</p>
                            <div class="circle">+</div>
                        </div>
                        <p class="remaining"><?php echo $FOOD_STOCK; ?></p>
                    </div>
                </form>
            </div>
        </section>
        <!-- section 4 - order tracking-->
        <section class="product-landing order-track section">
            <div class="PL-text">
                <h1 class="section-heading other-sections">Want to track your order?</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
            </div>
            <form class="featured-pic" method="POST">
                <div class="top">
                    <h2>Order Number</h2>
                    <hr>
                    <input name="track-order" type="text" placeholder="0123456789">
                </div>
                <button name="submit" type="submit" class="button">Track Order</button>
            </form>
        </section>
        <!-- section 5 - wholesale-->
        <section class="product-landing wholesale section">
            <h1 class="other-sections">Looking for wholesale deals?</h1>
            <a href="" class="button">Sign up as a Wholesale Customer</a>
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
