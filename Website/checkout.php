<?php

@include 'constants.php';

if (isset($_SESSION['prsn_id'])) {
    $PRSN_ID = $_SESSION['prsn_id'];
} else {
    $GUEST_ID = $_SESSION['guest_id'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css">
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
            <input type="checkbox" id="menu-toggle">
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class = 'menubar'>
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
        <form method="POST">
            <section class="section">
                <div class="section-heading">
                    <h2>Checkout</h2>
                    <p>You are about to place your order</p>
                </div>
                <section class="section-body">
                    <!--order summary block-->
                    <section class="block">
                        <h3 class="block-heading">Order Summary</h2>
                            <div class="block-body">
                                <div class="table-wrap">
                                    <table class="order">
                                        <thead>
                                            <tr>
                                                <th class="header first-col"></th>
                                                <th class="header">Quantity</th>
                                                <th class="header">Price</th>
                                                <th class="header">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_SESSION['prsn_id'])) {
                                                $CUS_ID = $_SESSION['prsn_id'];
                                                $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, FOOD_STOCK, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
                                    FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered' AND PRSN_ID = $PRSN_ID";
                                            } else {
                                                $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, FOOD_STOCK, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
                                    FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered' AND GUEST_ORDER_IDENTIFIER = '$GUEST_ID'";
                                            }
                                            $res = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($res);
                                            if ($count > 0) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $IN_ORDER_ID = $row['IN_ORDER_ID'];
                                                    $FOOD_NAME = $row['FOOD_NAME'];
                                                    $FOOD_PRICE = $row['FOOD_PRICE'];
                                                    $FOOD_IMG = $row['FOOD_IMG'];
                                                    $FOOD_STOCK = $row['FOOD_STOCK'];
                                                    $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'];
                                                    $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'];
                                            ?>
                                                    <tr>
                                                        <td data-cell="customer" class="first-col">
                                                            <div class="pic-grp">
                                                                <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                                                <p><?php echo $FOOD_NAME; ?></p>
                                                            </div>
                                                        </td> <!--Pic and Name-->
                                                        <td><?php echo $IN_ORDER_QUANTITY ?></td> <!--Quantity-->
                                                        <td>₱<?php echo $FOOD_PRICE; ?></td><!--Price-->
                                                        <td>₱<?php echo $IN_ORDER_TOTAL; ?></td><!--Sub Total-->
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            if (isset($_SESSION['prsn_id'])) {
                                                $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM IN_ORDER WHERE PRSN_ID = $PRSN_ID";
                                            } else {
                                                $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM IN_ORDER WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID'";
                                            }
                                            $res2 = mysqli_query($conn, $sql2);
                                            $row2 = mysqli_fetch_assoc($res2);
                                            $total = $row2['Total'];
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="payment">
                                    <h3>Total Payment:</h3>
                                    <h3>₱<?php echo $total; ?></h3>
                                </div>
                            </div>
                    </section>
                    <!-- contact info block-->
                    <section class="block red-theme">

                        <div class="block-body contact-info-blk ">
                            <?php

                            if (isset($_SESSION['prsn_id'])) {
                                $sql2 = "SELECT * FROM person WHERE PRSN_ID=$PRSN_ID";

                                $res2 = mysqli_query($conn, $sql2);

                                $row2 = mysqli_fetch_assoc($res2);

                                //get individual values
                                $PRSN_NAME = $row2['PRSN_NAME'];
                                $PRSN_PHONE = $row2['PRSN_PHONE'];
                                $PRSN_EMAIL = $row2['PRSN_EMAIL'];
                            } else {
                                $sql2 = "SELECT * FROM person WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID'";
                            }
                            ?>
                            <!-- TODO: validate inputs -->
                            <div class="left">
                                <h3 class="block-heading">Contact Information</h3>
                                <div class="input-grp">
                                    <p>First Name</p>
                                    <input type="text" name="first-name"> <!-- value="<?php echo $PRSN_NAME ?>" -->
                                </div>
                                <div class="input-grp">
                                    <p>Last Name</p>
                                    <input type="text" name="last-name"> <!-- value="<?php echo $PRSN_NAME ?>" -->
                                </div>
                                <div class="input-grp">
                                    <p>Contact Number</p>
                                    <input type="text" name="contact-number"> <!-- value="<?php echo $PRSN_PHONE ?>" -->
                                </div>
                                <div class="input-grp">
                                    <p>Email</p>
                                    <input type="email" name="email"> <!-- value="<?php echo $PRSN_EMAIL ?>" -->
                                </div>
                            </div>
                            <hr>
                            <div class="right">
                                <h3 class="block-heading">Address</h3>
                                <div class="input-grp">
                                    <p>Region</p>
                                    <input type="text" name="region"> <!-- value="" -->
                                </div>
                                <div class="input-grp">
                                    <p>Province</p>
                                    <input type="text" name="province"> <!-- value="" -->
                                </div>
                                <div class="input-grp">
                                    <p>City</p>
                                    <input type="text" name="city"> <!-- value="" -->
                                </div>
                                <div class="input-grp">
                                    <p>Barangay</p>
                                    <input type="text" name="barangay"> <!-- value="" -->
                                </div>
                                <div class="input-grp">
                                    <p>House no./Bldg./Street</p>
                                    <input type="text" name="street"> <!-- value="" -->
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- delivery info block-->
                    <section class="wrapper red-theme">
                        <div class="block left-side-dvd red-theme">
                            <h3 class="block-heading">When do you want your order to be delivered?</h2>
                                <div class="block-body radio">
                                    <label for=""><input id="" type="radio" name="" class="" /> Today</label>
                                    <label for=""><input id="" type="radio" name="" class="" /> Select a date:</label>
                                    <input type="date" name="date">
                                </div>
                        </div>
                        <div class="block time-slot">
                            <h3 class="block-heading">Time Slot</h2>
                                <div class="block-body">
                                    <input type="time" name="time">
                                </div>
                        </div>
                    </section>
                    <!-- note block-->
                    <div class="block note">
                        <p>Note: We can only deliver from 9AM to 5PM. Moreover, delivery will be shouldered by third-party couriers.</p>
                    </div>
                    <div class="btn-container center">
                        <a href="<?php echo SITEURL; ?>cart.php" class="page-button clear-bg">Back</a>
                        <button name="submit" class="page-button">Place Order</button>
                        <!-- <a href="place_order.php" class="page-button">Place Order</a> -->
                    </div>
                </section>
            </section>
        </form>
    </main>
    <footer>
        <div class="footer-container">
            <div class="left-container">
                <h1>Fat Rap's Barbeque's Online Store</h1>
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
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    if (isset($_SESSION['prsn_id'])) {
        $CUS_ID = $PRSN_ID;
    }

    $CUS_FNAME = $_POST['first-name'];
    $CUS_LNAME = $_POST['last-name'];
    $CUS_NAME = $CUS_FNAME . " " . $CUS_LNAME;

    $CUS_NUMBER = $_POST['contact-number'];
    $CUS_EMAIL = $_POST['email'];
    $PLACED_ORDER_DATE = date("Y-m-d h:i:sa");
    $PLACED_ORDER_TOTAL = $total;

    $Region = $_POST['region'];
    $Province = $_POST['province'];
    $City = $_POST['city'];
    $Barangay = $_POST['barangay'];
    $Street = $_POST['street'];
    $DELIVERY_ADDRESS = $Region . ", " . $Province . ", " . $City . ", " . $Barangay . ", " . $Street;


    $date = $_POST['date'];
    $time = $_POST['time'];
    $DELIVERY_DATE = $date . " " . $time;
    $PLACED_ORDER_STATUS = "Placed";
    $random = random_bytes(16);
    $PLACED_ORDER_TRACKER = bin2hex($random);

    $select = " SELECT * FROM `placed_order` WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER'";

    $result = mysqli_query($conn, $select);

    while (mysqli_num_rows($result) > 0) {
        $random = random_bytes(16);
        $PLACED_ORDER_TRACKER = bin2hex($random);
        $select = "SELECT * FROM `placed_order` WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER'";
        $result = mysqli_query($conn, $select);
    }

    if (isset($_SESSION['prsn_id'])) {
        $sql3 = "INSERT INTO placed_order SET
        PRSN_ID = '$CUS_ID',
        CUS_NAME = '$CUS_NAME',
        CUS_NUMBER = '$CUS_NUMBER',
        CUS_EMAIL= '$CUS_EMAIL',
        PLACED_ORDER_DATE = '$PLACED_ORDER_DATE',
        PLACED_ORDER_TOTAL = $PLACED_ORDER_TOTAL,
        DELIVERY_ADDRESS = '$DELIVERY_ADDRESS',
        DELIVERY_DATE = '$DELIVERY_DATE',
        PLACED_ORDER_STATUS = '$PLACED_ORDER_STATUS',
        PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER'
        ";
    } else {
        $sql3 = "INSERT INTO placed_order SET
        CUS_NAME = '$CUS_NAME',
        CUS_NUMBER = '$CUS_NUMBER',
        CUS_EMAIL= '$CUS_EMAIL',
        PLACED_ORDER_DATE = '$PLACED_ORDER_DATE',
        PLACED_ORDER_TOTAL = $PLACED_ORDER_TOTAL,
        DELIVERY_ADDRESS = '$DELIVERY_ADDRESS',
        DELIVERY_DATE = '$DELIVERY_DATE',
        PLACED_ORDER_STATUS = '$PLACED_ORDER_STATUS',
        PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER',
        GUEST_ORDER_IDENTIFIER = '$GUEST_ID'
        ";
    }


    $res3 = mysqli_query($conn, $sql3);

    if ($res3 == true) {
        if (isset($_SESSION['prsn_id'])) {
            $sql4 = "SELECT PLACED_ORDER_ID FROM placed_order WHERE PRSN_ID = $CUS_ID AND PLACED_ORDER_STATUS = 'Placed'";
        } else {
            $sql4 = "SELECT PLACED_ORDER_ID FROM placed_order WHERE  GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND PLACED_ORDER_STATUS = 'Placed'";
        }

        $res4 = mysqli_query($conn, $sql4);
        $row5 = mysqli_fetch_array($res4);
        $PLACED_ORDER_ID = $row5['PLACED_ORDER_ID'];

        if (isset($_SESSION['prsn_id'])) {
            $sql5 = "UPDATE in_order SET
            PLACED_ORDER_ID = $PLACED_ORDER_ID
            WHERE PRSN_ID = $CUS_ID AND IN_ORDER_STATUS = 'Ordered' 
            ";
        } else {
            $sql5 = "UPDATE in_order SET
            PLACED_ORDER_ID = $PLACED_ORDER_ID
            WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND IN_ORDER_STATUS = 'Ordered'
            ";
        }

        $res5 = mysqli_query($conn, $sql5);
    }
}
?>