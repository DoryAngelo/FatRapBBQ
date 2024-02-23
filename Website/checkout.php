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
    <title>Checkout</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css">
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
        <form method="POST">
            <section class="section">
                <div class="section-heading">
                    <h2>Checkout</h2>
                    <p>You are about to place your order</p>
                </div>
                <section class="section-body">
                    <section class="block">
                        <h3 class="block-heading">Order Summary</h2>
                            <div class="block-body">
                                <div class="table-wrap">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td></td>
                                                <th><span class="sr-only year">Quantity</span></th>
                                                <th><span class="sr-only year">Price</span></th>
                                                <th class="current"><span class="sr-only year">Sub Total</span></th>
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
                                                                <td>₱<?php echo $IN_ORDER_TOTAL ?></td>
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
                                                <td></td>
                                                <td>Total Payment:</td>
                                                <td class="current">₱<?php echo $total ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </section>
                    <section class="block red-theme">
                        <h3 class="block-heading">Contact Information</h2>
                            <div class="block-body contact-info-blk ">
                                <?php

                                $sql2 = "SELECT * FROM person WHERE PRSN_ID=$PRSN_ID";

                                $res2 = mysqli_query($conn, $sql2);

                                $row2 = mysqli_fetch_assoc($res2);

                                //get individual values
                                $PRSN_NAME = $row2['PRSN_NAME'];
                                $PRSN_PHONE = $row2['PRSN_PHONE'];
                                $PRSN_EMAIL = $row2['PRSN_EMAIL'];

                                ?>
                                <!-- TODO: validate inputs -->
                                <div class="input-grp">
                                    <p>Name</p>
                                    <input type="text" name="name" placeholder="" value="<?php echo $PRSN_NAME ?>">
                                </div>
                                <div class="input-grp">
                                    <p>Address</p>
                                    <input type="text" name="address" placeholder="Enter your address"> <!-- value="" -->
                                </div>
                                <div class="input-grp">
                                    <p>Contact Number</p>
                                    <input type="text" name="contact-number" placeholder="Enter your contact number" value="<?php echo $PRSN_PHONE ?>">
                                </div>
                                <div class="input-grp">
                                    <p>Email</p>
                                    <input type="email" name="email" placeholder="Enter your email" value="<?php echo $PRSN_EMAIL ?>">
                                </div>
                            </div>
                    </section>
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
                    <div class="block note">
                        <p>Note: We can only deliver from 9AM to 5PM. Moreover, delivery will be shouldered by third-party couriers.</p>
                    </div>
                    <div class="btn-container center">
                        <a href="" class="page-button clear-bg">Back</a>
                        <button name="submit" class="primary-btn">Place Order</button>
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

<?php
if (isset($_POST['submit'])) {
    $CUS_ID = $PRSN_ID;
    $CUS_NAME = $_POST['name'];
    $CUS_NUMBER = $_POST['contact-number'];
    $CUS_EMAIL = $_POST['email'];
    $PLACED_ORDER_DATE = date("Y-m-d h:i:sa");
    $PLACED_ORDER_TOTAL = $total;
    $DELIVERY_ADDRESS = $_POST['address'];
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

    $sql3 = "INSERT INTO placed_order SET
    CUS_ID = '$CUS_ID',
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

    $res3 = mysqli_query($conn, $sql3);
}
?>