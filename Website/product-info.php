<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

$FOOD_ID = $_GET['FOOD_ID'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    $quantity = $_POST['quantity'];
    $FOOD_PRICE = $_POST['price'];

    $sql = "SELECT * FROM in_order WHERE FOOD_ID = $FOOD_ID AND PRSN_ID = $PRSN_ID";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

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
        $sql2 = "INSERT INTO in_order (FOOD_ID, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS)
                 VALUES ('$FOOD_ID', '$PRSN_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered')";
        $res2 = mysqli_query($conn, $sql2);
    }

    // Redirect to the home page after processing
    header('location:cart.php');
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

<body>
    <header>
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo SITEURL; ?>cus-home-page.php">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>menu.php">Menu</a></li>
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
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="section product-info-page">
            <div class="section-heading"></div>
            <a href="<?php echo SITEURL; ?>menu.php" class="back">Back</a>
            <?php

            $sql = "SELECT * FROM food WHERE FOOD_ID = '$FOOD_ID'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $FOOD_ID = $row['FOOD_ID'];
                    $FOOD_NAME = $row['FOOD_NAME'];
                    $FOOD_DESC = $row['FOOD_DESC'];
                    $FOOD_IMG = $row['FOOD_IMG'];
                    $FOOD_PRICE = $row['FOOD_PRICE'];
                    $FOOD_STOCK = $row['FOOD_STOCK'];
            ?>
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
                                        <i class='bx bxs-minus-circle js-minus circle'></i>
                                        <p class="amount js-num">1</p>
                                        <i class='bx bxs-plus-circle js-plus circle'></i>
                                    </div>
                                    <p class="remaining"><?php echo $FOOD_STOCK ?> sticks available</p>
                                </div>
                                <input type="hidden" id="quantity" name="quantity" value="1">
                                <input type="hidden" name="price" value="<?php echo $FOOD_PRICE?>">
                                <button name="order" type="submit">Add to Cart</button>
                            </form>
                        </div>
                    </section>
            <?php
                }
            }
            ?>

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
        const plus = document.querySelector(".js-plus"),
            minus = document.querySelector(".js-minus"),
            num = document.querySelector(".js-num"),
            quantityInput = document.getElementById("quantity");

        let a = 1;

        plus.addEventListener("click", () => {
            a++;
            console.log(a);
            num.innerText = a;
            quantityInput.value = a; // Update hidden input value
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
</body>

</html>