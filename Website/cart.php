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

if (isset($_GET['datetime'])) {
    $_SESSION['selectedDateTime'] = $_GET['datetime'];
}

$selectedDateTime = isset($_SESSION['selectedDateTime']) ? $_SESSION['selectedDateTime'] : '';
$selectedDate = $selectedDateTime ? date('Y-m-d', strtotime($selectedDateTime)) : '';
$selectedTime = $selectedDateTime ? date('H:i', strtotime($selectedDateTime)) : '';

if (isset($_POST['checkout'])) {

    // $selectedDate = $selectedDateTime ? date('F j Y', strtotime($selectedDateTime)) : '';
    // echo "<script>alert('Selected date: $selectedDate');</script>";
    // $sql = "SELECT * FROM calendar WHERE calendar_date = '$selectedDate'";
    // $res = mysqli_query($conn, $sql);
    // $count = mysqli_num_rows($res);
    // if ($count > 0) {
    //     $selectedDate = $selectedDateTime ? date('Y-m-d', strtotime($selectedDateTime)) : '';
    //     echo "<script>alert('This date is not available.');</script>";
    // } else {
    //     $selectedDate = $selectedDateTime ? date('Y-m-d', strtotime($selectedDateTime)) : '';
    //     header("location:checkout.php");
    // }
    header("location:checkout.php");
    exit();
}


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
                    <div>
                        <!-- <p>Delivery date and time: </p> -->
                        <?php
                        $sql = "SELECT CALENDAR_DATE, DATE_STATUS FROM calendar";
                        $res = mysqli_query($conn, $sql);
                        $calendar_data = array();

                        if ($res) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $date = date_create_from_format("F d Y", $row['CALENDAR_DATE']);
                                $dateStr = date_format($date, "Y-m-d");
                                $calendar_data[$dateStr] = $row['DATE_STATUS'];
                            }
                        }
                        $calendar_json = json_encode($calendar_data);
                        ?>
                        <script>
                            var calendarData = <?php echo $calendar_json; ?>;
                        </script>
                        <?php
                        $today = date("Y-m-d");
                        $oneMonthFromNow = date("Y-m-d", strtotime("+1 month"));
                        ?>
                        <label for="delivery-date">Delivery Date:</label>
                        <input min="<?php echo $today ?>" max="<?php echo $oneMonthFromNow ?>" oninput="validateDate(this)" type="date" id="delivery-date" name="delivery-date" value="<?php echo $selectedDate; ?>">
                        <div class="error-date error-text" style="display: none;">Date not available.</div>

                        <label for="delivery-time">Delivery Time:</label>
                        <input min="09:00:00" max="17:00:00" oninput="validateTime(this)" type="time" id="delivery-time" name="delivery-time" value="<?php echo $selectedTime; ?>">
                        <div class="error-time error-text" style="display: none;">Time not available.</div>
                        <style>
                            .error-text {
                                color: red;
                                font-style: italic;
                                font-size: 12px;
                            }
                        </style>

                        <script>
                            function validateDate(input) {
                                var selectedDate = new Date(input.value);
                                var currentDate = new Date();
                                currentDate.setHours(0, 0, 0, 0);
                                var dateStr = selectedDate.toISOString().slice(0, 10);
                                var currentTime = new Date().toLocaleTimeString('en-US', {
                                    hour12: false,
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                                var dateError = document.querySelector('.error-date');
                                var timeError = document.querySelector('.error-time');

                                if (selectedDate < currentDate || calendarData[dateStr] === 'fullybooked' || calendarData[dateStr] === 'closed') {
                                    dateError.style.display = 'block';
                                } else {
                                    dateError.style.display = 'none';
                                }

                                if (selectedDate.getTime() === currentDate.getTime() && input.value < currentTime) {
                                    timeError.style.display = 'block';
                                } else {
                                    timeError.style.display = 'none';
                                }
                            }

                            function validateTime(input) {
                                var selectedTime = input.value;
                                var selectedDate = new Date(document.getElementById('delivery-date').value);
                                var currentDate = new Date();
                                var currentTime = new Date().toLocaleTimeString('en-US', {
                                    hour12: false,
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                                var timeError = document.querySelector('.error-time');

                                // Check if selected time is within the allowed range (9am - 5pm)
                                if (selectedTime < "09:00" || selectedTime > "17:00") {
                                    timeError.style.display = 'block';
                                    return;
                                }

                                // Check if selected time is within 1 hour of current time
                                var timeDiff = new Date("1970-01-01 " + selectedTime) - new Date("1970-01-01 " + currentTime);
                                var minutesDiff = Math.abs(timeDiff / 60000);
                                if (minutesDiff < 60) {
                                    timeError.style.display = 'block';
                                    return;
                                }


                                // Check if selected time is past the current day
                                if (selectedDate < currentDate && selectedTime < currentTime) {
                                    timeError.style.display = 'block';
                                    return;
                                }

                                timeError.style.display = 'none';
                            }

                            function redirectToFilteredOrders(event) {
                                event.preventDefault();

                                var dateError = document.querySelector('.error-date');
                                var timeError = document.querySelector('.error-time');

                                // Check if there are any error messages displayed
                                if (dateError.style.display === 'block' || timeError.style.display === 'block') {
                                    alert("Please correct the errors before submitting the form.");
                                    return; // Exit function if there are errors
                                }

                                var deliveryDate = document.getElementById('delivery-date').value;
                                var deliveryTime = document.getElementById('delivery-time').value;

                                if (deliveryDate && deliveryTime) {
                                    // Format date as YYYY-MM-DD
                                    var formattedDate = deliveryDate;

                                    // Format time as hh:mm AM/PM
                                    var hours = parseInt(deliveryTime.substring(0, 2));
                                    var minutes = deliveryTime.substring(3);
                                    var ampm = hours >= 12 ? 'PM' : 'AM';
                                    hours = hours % 12;
                                    hours = hours ? hours : 12; // the hour '0' should be '12'
                                    var formattedTime = hours + ':' + minutes + ' ' + ampm;

                                    // Construct selected date and time
                                    var selectedDateTime = formattedDate + ' ' + formattedTime;

                                    var baseUrl = window.location.href.split('?')[0];
                                    var queryParams = new URLSearchParams(window.location.search);
                                    queryParams.set('datetime', selectedDateTime);
                                    window.location.href = baseUrl + '?' + queryParams.toString();
                                } else {
                                    // alert("Please select both delivery date and time.");
                                }
                            }

                            const dateInput = document.getElementById('delivery-date');
                            const timeInput = document.getElementById('delivery-time');

                            dateInput.addEventListener('change', function() {
                                validateDate(this);
                                redirectToFilteredOrders(event);
                            });

                            timeInput.addEventListener('change', function() {
                                validateTime(this);
                                redirectToFilteredOrders(event);
                            });
                        </script>
                        <script>
                            function validateForm() {
                                var dateError = document.querySelector('.error-date');
                                var timeError = document.querySelector('.error-time');

                                // Check if there are any error messages displayed
                                if (dateError.style.display === 'block' || timeError.style.display === 'block') {
                                    alert("Please correct the errors before submitting the form.");
                                    return false; // Prevent form submission
                                }
                                return true; // Allow form submission if no errors
                            }

                            document.addEventListener("DOMContentLoaded", function() {
                                const form = document.getElementById('checkout-form');

                                form.addEventListener('submit', function(event) {
                                    // Validate the form before submission
                                    if (!validateForm()) {
                                        event.preventDefault(); // Prevent form submission if validation fails
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
                <form id="checkout-form" class="section-body" method="post">
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
                                            $sql = "SELECT io.IN_ORDER_ID, f.FOOD_NAME, f.FOOD_IMG, f.FOOD_PRICE, f.FOOD_STOCK, io.PRSN_ID, io.IN_ORDER_QUANTITY, io.IN_ORDER_TOTAL 
            FROM in_order io
            LEFT JOIN placed_order po ON io.placed_order_id = po.placed_order_id
            JOIN food f ON io.FOOD_ID = f.FOOD_ID
            WHERE io.IN_ORDER_STATUS != 'Delivered' 
            AND io.PRSN_ID = '$PRSN_ID'
            AND po.placed_order_id IS NULL
            GROUP BY f.FOOD_ID";
                                        } else {
                                            $sql = "SELECT io.IN_ORDER_ID, f.FOOD_NAME, f.FOOD_IMG, f.FOOD_PRICE, f.FOOD_STOCK, io.PRSN_ID, io.IN_ORDER_QUANTITY, io.IN_ORDER_TOTAL 
            FROM in_order io
            LEFT JOIN placed_order po ON io.placed_order_id = po.placed_order_id
            JOIN food f ON io.FOOD_ID = f.FOOD_ID
            WHERE io.IN_ORDER_STATUS != 'Delivered' 
            AND io.GUEST_ORDER_IDENTIFIER = '$GUEST_ID'
            AND po.placed_order_id IS NULL
            GROUP BY f.FOOD_ID";
                                        }


                                        $res = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($res);
                                        $stockValues = array();
                                        $flagValues = array();
                                        $quantityExceedsStock = false;
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

                                                if ($IN_ORDER_QUANTITY > $FOOD_STOCK) {
                                                    $quantityExceedsStock = true;
                                                    $flagValues[$FOOD_NAME] = $quantityExceedsStock;
                                                } else {
                                                    $flagValues[$FOOD_NAME] = false;
                                                }
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
                                                                <input type="number" class="quantity-input" data-in-order-id="<?php echo $IN_ORDER_ID; ?>" data-stock="<?php echo $FOOD_STOCK; ?>" data-price="<?php echo $FOOD_PRICE; ?>" data-food-name="<?php echo $FOOD_NAME; ?>" value="<?php echo $IN_ORDER_QUANTITY; ?>" min="1" max="<?php echo $FOOD_STOCK; ?>">
                                                            </div>
                                                            <p class="remaining"><?php echo ($FOOD_STOCK < 0) ? 0 : $FOOD_STOCK; ?> sticks remaining</p>
                                                        </div>
                                                    </td>
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
                                                $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM in_order WHERE PRSN_ID = '$PRSN_ID' AND PLACED_ORDER_ID IS NULL";
                                            } else {
                                                $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM in_order WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND PLACED_ORDER_ID IS NULL";
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

                    if ($count <= 0 || in_array(true, $flagValues)) {
                    ?>
                        <button class="page-button center">Checkout</button>
                    <?php
                    } else {
                    ?>
                        <button name="checkout" type="submit" class="page-button center">Checkout</button>
                    <?php
                    }
                    ?>
                    <script>
                        function validateForm() {
                            <?php if ($count <= 0 || in_array(true, $flagValues)) : ?>
                                alert("Cannot proceed with checkout. Please review your order.");
                                return false;
                            <?php else : ?>
                                return true;
                            <?php endif; ?>
                        }
                    </script>

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
            const quantityInputs = document.querySelectorAll(".quantity-input");

            quantityInputs.forEach((input) => {
                input.addEventListener("change", () => {
                    const stock = parseInt(input.dataset.stock);
                    const newQuantity = parseInt(input.value);
                    const foodName = input.dataset.foodName;
                    const foodPrice = parseFloat(input.dataset.price);

                    if (newQuantity < 1 || newQuantity > stock) {
                        alert(`Quantity for ${foodName} must be between 1 and ${stock}.`);
                        input.value = Math.min(Math.max(newQuantity, 1), stock); // Reset to valid range
                        input.classList.add('invalid-quantity'); // Mark as invalid
                    } else {
                        input.classList.remove('invalid-quantity'); // Mark as valid
                        const IN_ORDER_ID = input.dataset.inOrderId;
                        updateQuantity(IN_ORDER_ID, newQuantity, foodPrice);
                        updateItemTotal(input, newQuantity, foodPrice);
                        updateCartTotal();
                    }
                });
            });

            function updateQuantity(IN_ORDER_ID, newQuantity, foodPrice) {
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
                        console.log('Quantity updated:', data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            function updateItemTotal(input, newQuantity, foodPrice) {
                const itemTotalElement = input.closest('tr').querySelector('.price-col p');
                const newTotal = newQuantity * foodPrice;
                itemTotalElement.textContent = `₱${newTotal.toFixed(2)}`;
            }

            function updateCartTotal() {
                let cartTotal = 0;
                document.querySelectorAll('.quantity-input').forEach(input => {
                    const newQuantity = parseInt(input.value);
                    const foodPrice = parseFloat(input.dataset.price);
                    cartTotal += newQuantity * foodPrice;
                });
                document.querySelector('.payment .text h3:last-child').textContent = `₱${cartTotal.toFixed(2)}`;
            }

            document.querySelector('form').addEventListener('submit', function(event) {
                const invalidInputs = document.querySelectorAll('.invalid-quantity');
                if (invalidInputs.length > 0) {
                    alert('Please correct the invalid quantities before submitting the form.');
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>

</body>

</html>