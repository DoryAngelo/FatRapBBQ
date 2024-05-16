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
    $_SESSION['guest_id'] = $GUEST_ID;
}

$PRSN_ROLE = $_SESSION['prsn_role'];

// $FOOD_NAME = 'Barbeque';

// $sql = "SELECT food.*, SUM(menu.menu_stock) AS total_menu_stock
//         FROM food 
//         INNER JOIN menu ON food.food_id = menu.food_id 
//         WHERE food.FOOD_ACTIVE='Yes' 
//         AND food.FOOD_NAME = 'Barbeque'
//         AND NOW() BETWEEN STR_TO_DATE(menu.menu_start, '%M %d, %Y %h:%i:%s %p') AND STR_TO_DATE(menu.menu_end, '%M %d, %Y %h:%i:%s %p')";


// $res = mysqli_query($conn, $sql);
// $count8 = mysqli_num_rows($res);


// //check whether there are food available
// if ($count8 > 0) {
//     while ($row = mysqli_fetch_assoc($res)) {
//         //get the values
//         $FOOD_ID = $row['FOOD_ID'];
//         $FOOD_NAME = $row['FOOD_NAME'];
//         $FOOD_PRICE = $row['FOOD_PRICE'];
//         $FOOD_DESC = $row['FOOD_DESC'];
//         $FOOD_IMG = $row['FOOD_IMG'];
//         $FOOD_STOCK = $row['FOOD_STOCK'];
//         $TOTAL_MENU_STOCK = $row['total_menu_stock'];
//     }
// }

// if (isset($_SESSION['prsn_id'])) {
//     $sql = "SELECT f.*, io.in_order_quantity, m.*
//     FROM food f 
//     LEFT JOIN in_order io ON f.FOOD_ID = io.food_id AND io.placed_order_id IS NULL
//     LEFT JOIN menu m ON f.FOOD_ID = m.food_id
//     WHERE f.FOOD_ID = '$FOOD_ID'
//     AND io.PRSN_ID = '$PRSN_ID'";
// } else if (isset($_SESSION['guest_id'])) {
//     $sql = "SELECT f.*, io.in_order_quantity, m.*
//         FROM food f 
//         LEFT JOIN in_order io ON f.FOOD_ID = io.food_id AND io.placed_order_id IS NULL
//         LEFT JOIN menu m ON f.FOOD_ID = m.food_id
//         WHERE f.FOOD_ID = '$FOOD_ID'
//         AND io.GUEST_ORDER_IDENTIFIER = '$GUEST_ID'";
// }

// $res = mysqli_query($conn, $sql);
// $count = mysqli_num_rows($res);
// if ($count > 0) {
//     while ($row = mysqli_fetch_assoc($res)) {
//         $MENU_ID = $row['MENU_ID'];
//         $MENU_STOCK = $row['MENU_STOCK'];
//         $IN_ORDER_QUANTITY = $row['in_order_quantity'];
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    $quantity = $_POST['quantity'];
    $FOOD_PRICE = $_POST['price'];
    $MENU_ID = $_POST['menu_id'];

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
            $IN_ORDER_TOTAL += $IN_ORDER_QUANTITY * $FOOD_PRICE;
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
            VALUES ('$FOOD_ID', '$MENU_ID', '$PRSN_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered')";
        } else {
            $sql2 = "INSERT INTO in_order (FOOD_ID, MENU_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS, GUEST_ORDER_IDENTIFIER)
            VALUES ('$FOOD_ID', '$MENU_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered', '$GUEST_ID')";
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

<body class="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'wholesaler' : ''; ?>">
    <header class="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'wholesaler' : ''; ?>">
        <div class="header-container ">
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
        <!-- section 1 -->
        <section class="section" id="featured-section">
            <div class="container responsive">
                <div class="text">
                    <h1>Order our best-selling BBQ</h1>
                    <p>Indulge in the ultimate barbeque experience and place your order today!</p>
                    <a href="menu.php" class="button">Order Now</a>
                </div>
                <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="picture of a pork bbq">
                <!-- <img src="images/pork-bbq.jpg" alt="picture of 3 pork bbq sticks"> -->
            </div>
        </section>
        <!-- section 2 -->
        <?php
        $sql = "SELECT * FROM calendar";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        $calendar_data = array();

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $calendar_data[] = $row;
            }
        }
        $calendar_json = json_encode($calendar_data);
        ?>
        <script>
            var calendarData = <?php echo $calendar_json; ?>;
        </script>
        <section class="section" id="calendar-section">
            <div class="container responsive">
                <div class="text">
                    <h1>See our available dates</h1>
                    <p>Days with the following colors below are unavailable dates for ordering</p>
                    <div class="legend">
                        <!-- <button class="button available-tag">Available</button> -->
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
        <!-- <section class="section" id="prdt-avail-section">
            <div class="container responsive">
                <div class="left-side">
                    <div class="text">
                        <h1>Check product availability</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam, culpa.</p>
                    </div>
                    <div class="input-grp">
                        <div class="item-grp">
                            <label for="date">Date</label>
                            <input type="date" id="date" class="input">
                        </div>
                        <div class="item-grp">
                            <label for="time">Time</label>
                            <input type="time" id="time" class="input">
                        </div>
                        <div class="item-grp">
                            <label for="product">Product</label>
                            <select name="product" id="product" class="input">
                                <?php
                                $sql = "SELECT * FROM food WHERE FOOD_ACTIVE='Yes'";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);
                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $FOOD_ID = $row['FOOD_ID'];
                                        $FOOD_NAME = $row['FOOD_NAME'];
                                ?>
                                        <option value="<?php echo $FOOD_ID; ?>"><?php echo $FOOD_NAME; ?></option>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <option value="0">No Food Found</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="right-side center">
                    <div class="circle center">
                        <div class="position">
                            <h1 id="availableStock">10</h1>
                            <p>sticks</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <script>
            function getProduct() {
                const FOOD_ID = document.getElementById('product').value;
                const Date = document.getElementById('date').value;
                const Time = document.getElementById('time').value;

                const formData = new FormData();
                formData.append("FOOD_ID", FOOD_ID);
                formData.append("date", Date);
                formData.append("time", Time);

                fetch("get-product.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => {
                        console.log('Response:', response);
                        response.json()
                    }) 
                    .then(data => {
                        const menuStock = data.menu_stock;
                        document.getElementById('availableStock').innerText = menuStock;
                        console.log(menuStock);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script> -->

        <!-- section 3 -->
        <!-- <?php
        // Check if the person role is not a wholesaler
        if ($PRSN_ROLE !== 'Wholesaler') {
            // Check if there are items with 'Barbeque' as the food name
            if ($count8 > 0) {
                // Fetch information for the product 'Barbeque'
                $sql = "SELECT f.*, io.in_order_quantity, m.menu_stock,  m.menu_id
                FROM food f 
                LEFT JOIN in_order io ON f.FOOD_ID = io.food_id AND io.placed_order_id IS NULL
                LEFT JOIN menu m ON f.FOOD_ID = m.food_id
                WHERE f.FOOD_NAME = 'Barbeque' 
                AND NOW() BETWEEN STR_TO_DATE(m.menu_start, '%M %d, %Y %h:%i:%s %p') AND STR_TO_DATE(m.menu_end, '%M %d, %Y %h:%i:%s %p')
                GROUP BY f.FOOD_ID";

                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                // Display section if product found and menu is within time range
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $IN_ORDER_QUANTITY = $row['in_order_quantity'];
                        $FOOD_PRICE = $row['FOOD_PRICE']; 
                        $MENU_ID = $row['menu_id']; 
                        $FOOD_STOCK = $row['FOOD_STOCK']; 
        ?>
                        <section class="section" id="product-section">
                            <div class="container responsive">
                                <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="picture of a pork bbq">
                                <div class="text">
                                    <h1>Barbeque</h1>
                                    <div>
                                        <p>₱<?php echo $FOOD_PRICE; ?></p>
                                        <p>1 stick</p>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dictumsum dolor sit amet</p>
                                    <div class="action-grp responsive">
                                        <form method="post" class="form">
                                            <input type="hidden" id="quantity" name="quantity" value="<?php echo ($IN_ORDER_QUANTITY == NULL) ? 1 : $IN_ORDER_QUANTITY; ?>">
                                            <input type="hidden" name="price" value="<?php echo $FOOD_PRICE ?>">
                                            <input type="hidden" name="menu_id" value="<?php echo $MENU_ID ?>">
                                            <button class="button" name="order" type="submit" <?php echo ($TOTAL_MENU_STOCK <= 0 || (isset($_POST['quantity']) && ($IN_ORDER_QUANTITY + intval($_POST['quantity']) > $FOOD_STOCK))) ? 'disabled' : ''; ?>>Order Now</button>
                                        </form>
                                        <div class="with-remaining">
                                            <div class="quantity-group">
                                                <i class='bx bxs-minus-circle js-minus circle' data-stock="<?php echo $TOTAL_MENU_STOCK; ?>"></i>
                                                <p class="amount js-num">1</p>
                                                <!-- <input type="text" class="amount js-num" value="1"> textfield--> 
                                                <i class='bx bxs-plus-circle js-plus circle' data-stock="<?php echo $TOTAL_MENU_STOCK; ?>"></i>
                                            </div>
                                            <p class="remaining"><?php echo ($TOTAL_MENU_STOCK < 0) ? 0 : $TOTAL_MENU_STOCK; ?> sticks remaining</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
        <?php
                    }
                }
            }
        }
        ?>


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
        </script> -->
        <!-- section 4 -->
        <section class="section" id="track-order-section">
            <div class="container responsive">
                <div class="text">
                    <h1>Want to see your order status?</h1>
                    <p>Enter your order tracking number to see the status of your order</p>
                </div>
                <style>
                    .error {
                        color: red;
                    }
                </style>
                <form class="form" method="post" onsubmit="return validateForm()">
                    <div class="top input-control">
                        <h2>Order Number</h2>
                        <hr>
                        <input name="track-order" id="order-number" type="text" placeholder="0123456789">
                        <div class="error" id="error-message">
                            <?php
                            if (isset($_POST['submit'])) {
                                $PLACED_ORDER_TRACKER = mysqli_real_escape_string($conn, $_POST['track-order']);
                                if (isset($_SESSION['prsn_id'])) {
                                    $select = "SELECT * FROM `placed_order` WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER' AND PRSN_ID = '$PRSN_ID'";
                                } else if (isset($_SESSION['guest_id'])) {
                                    $select = "SELECT * FROM `placed_order` WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER' AND PRSN_ID = '0'";
                                }
                                $res = mysqli_query($conn, $select);
                                $count = mysqli_num_rows($res);
                                if ($count > 0) {
                                    // If order is found, perform JavaScript redirection
                                    $_SESSION['tracker'] = $_POST['track-order'];
                                    echo '<script>window.location.href = "track-order.php";</script>';
                                    exit(); // Ensure no further PHP execution after redirection
                                } else {
                                    echo 'Order number does not exist.';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <button name="submit" type="submit" class="button">Track Order</button>
                </form>
                <script>
                    function validateForm() {
                        var orderNumber = document.getElementById('order-number').value.trim();
                        var errorMessage = document.getElementById('error-message');

                        // Regular expression to match the correct format
                        var regex = /^[0-9a-fA-F]{16}$/;

                        if (orderNumber === "") {
                            errorMessage.innerText = "Please enter an order number.";
                            return false;
                        } else if (!regex.test(orderNumber)) {
                            errorMessage.innerText = "Invalid order number format.";
                            return false;
                        } else {
                            errorMessage.innerText = ""; // Clear error message
                            return true;
                        }
                    }
                </script>
            </div>
            </div>
        </section>
        <!-- section 5 -->
        <section class="section" id="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'wholesale-section-hidden' : 'wholesale-section'; ?>">
            <div class="container responsive">
                <div class="text">
                    <h1>Looking for wholesale deals?</h1>
                    <!-- <a href=">wc-register.php" class="button">Sign up as a Wholesale Customer</a> -->
                    <p>For wholesale inquiries, contact 09178073760 or 09190873861</p>
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
</body>

</html>