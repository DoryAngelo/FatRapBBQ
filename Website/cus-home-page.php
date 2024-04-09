<?php

@include 'constants.php';

if (isset($_SESSION['prsn_id'])) {
    $PRSN_ID = $_SESSION['prsn_id'];
} else {
    $GUEST_ID = $_SESSION['guest_id'];
}

$FOOD_NAME = 'Barbeque';

$sql = "SELECT * FROM food WHERE FOOD_ACTIVE='Yes' AND FOOD_NAME = '$FOOD_NAME'";
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
    $_SESSION['tracker'] = $_POST['track-order'];
    $select = " SELECT * FROM `placed_order` WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER'";
    $res = mysqli_query($conn, $select);
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        header('location:track-order.php');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['prsn_id'])) {
        $sql = "SELECT * FROM in_order WHERE FOOD_ID = $FOOD_ID AND PRSN_ID = $PRSN_ID";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
    } else {
        $sql = "SELECT * FROM in_order WHERE FOOD_ID = $FOOD_ID AND GUEST_ORDER_IDENTIFIER = '$GUEST_ID'";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
    }

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $IN_ORDER_ID = $row['IN_ORDER_ID'];
            $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'] + $quantity;
            $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'] + ($quantity * $FOOD_PRICE);

            $sql = "UPDATE in_order SET 
                            IN_ORDER_QUANTITY = $IN_ORDER_QUANTITY,
                            IN_ORDER_TOTAL = $IN_ORDER_TOTAL
                            WHERE IN_ORDER_ID = $IN_ORDER_ID";
            $res_update = mysqli_query($conn, $sql);
        }
    } else {
        $IN_ORDER_TOTAL = $quantity * $FOOD_PRICE;
        if (isset($_SESSION['prsn_id'])) {
            $sql2 = "INSERT INTO in_order (FOOD_ID, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS)
            VALUES ('$FOOD_ID', '$PRSN_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered')";
        } else {
            $sql2 = "INSERT INTO in_order (FOOD_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS, GUEST_ORDER_IDENTIFIER)
            VALUES ('$FOOD_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered', '$GUEST_ID')";
        }
        $res2 = mysqli_query($conn, $sql2);
    }

    // Redirect to the home page after processing
    header('location:cus-home-page.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="home-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="home.js" defer></script>
</head>

<body>
    <header>
        <div class="header-container ">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque</h1>
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
                    <li>
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
        <!-- section 1 -->
        <section class="section" id="featured-section">
            <div class="container responsive">
                <div class="text">
                    <h1>Order our best-selling BBQ</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
                    <a href="#product-section" class="button">Order Now</a>
                </div>
                <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="picture of a pork bbq">
                <!-- <img src="images/pork-bbq.jpg" alt="picture of 3 pork bbq sticks"> -->
            </div>
        </section>
        <!-- section 2 -->
        <section class="section" id="calendar-section">
            <div class="container responsive">
                <div class="text">
                    <h1>See our available dates</h1>
                    <div class="legend">
                        <button class="button available-tag">Available</button>
                        <button class="button fully-booked-tag">Fully Booked</button>
                        <button class="button closed-tag">Closed</button>
                    </div>
                </div>
                <section class="calendar-block"> <!-- reference code: https://www.youtube.com/watch?v=OcncrLyddAs-->
                    <div class="header">
                        <button id="prevBtn">
                            <i class='bx bx-chevron-left'></i>
                        </button>
                        <div class="monthYear" id="monthYear"></div>
                        <button id="nextBtn">
                            <i class='bx bx-chevron-right'></i>
                        </button>
                    </div>
                    <div class="days">
                        <div class="day">Mon</div>
                        <div class="day">Tue</div>
                        <div class="day">Wed</div>
                        <div class="day">Thur</div>
                        <div class="day">Fri</div>
                        <div class="day">Sat</div>
                        <div class="day">Sun</div>
                    </div>
                    <div class="dates" id="dates"></div>
                </section>
            </div>
        </section>
        <!-- section 3 -->
        <section class="section" id="product-section">
            <div class="container responsive">
                <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="picture of a pork bbq">
                <!-- <img src="images/pork-bbq.jpg" alt="picture of 3 pork bbq sticks"> -->
                <div class="text">
                    <h1><?php echo $FOOD_NAME; ?></h1>
                    <p>₱<?php echo $FOOD_PRICE; ?></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
                    <div class="action-grp responsive">
                        <form method="post" class="form">
                            <input type="hidden" id="quantity" name="quantity" value="1"> <!-- Hidden input to store the quantity -->
                            <button name="order" type="submit" class="button">Order Now</button>
                        </form>
                        <div class="with-remaining">
                            <div class="quantity-group">
                                <i class='bx bxs-minus-circle js-minus circle' data-stock="<?php echo $FOOD_STOCK; ?>"></i>
                                <p class="amount js-num">1</p>
                                <i class='bx bxs-plus-circle js-plus circle' data-stock="<?php echo $FOOD_STOCK; ?>"></i>
                            </div>
                            <p class="remaining"><?php echo $FOOD_STOCK; ?> sticks remaining</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            const plus = document.querySelector(".js-plus");
            const minus = document.querySelector(".js-minus");
            const num = document.querySelector(".js-num");
            const quantityInput = document.getElementById("quantity");

            let a = parseInt(num.innerText);
            const stock = parseInt(plus.dataset.stock); // Accessing data-stock attribute from plus element

            plus.addEventListener("click", () => {
                if (a < stock) {
                    a++;
                    console.log(a);
                    num.innerText = a;
                    quantityInput.value = a; // Update hidden input value
                } else {
                    alert("Cannot exceed food stock!");
                }
            });

            minus.addEventListener("click", () => {
                if (a > 1) {
                    a--;
                    console.log(a);
                    num.innerText = a;
                    quantityInput.value = a; // Update hidden input value
                }
            });
        </script>
        <!-- section 4 -->
        <section class="section" id="track-order-section">
            <div class="container responsive">
                <div class="text">
                    <h1>Want to track your order?</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
                </div>
                <form class="form" method="post">
                    <div class="top input-control">
                        <h2>Order Number</h2>
                        <hr>
                        <input name="track-order" type="text" placeholder="0123456789">
                        <div class="error"></div>
                    </div>
                    <button name="submit" type="submit" class="button">Track Order</button>
                </form>
            </div>
            </div>
        </section>
        <!-- section 5 -->
        <section class="section" id="wholesale-section">
            <div class="container responsive">
                <div class="text">
                    <h1>Looking for wholesale deals?</h1>
                    <a href="<?php echo SITEURL; ?>wc-register.php" class="button">Sign up as a Wholesale Customer</a>
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
                        <li><a href="#">Home</a></li>
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
</body>

</html>