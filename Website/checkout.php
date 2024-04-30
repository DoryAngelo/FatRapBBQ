<?php

@include 'constants.php';

// if (isset($_SESSION['prsn_id'])) {
//     $PRSN_ID = $_SESSION['prsn_id'];
// } else {
//     $GUEST_ID = $_SESSION['guest_id'];
// }

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

if (isset($_SESSION['prsn_id'])) {
    $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM IN_ORDER WHERE PRSN_ID = '$PRSN_ID' AND PLACED_ORDER_ID IS NULL";
} else {
    $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM IN_ORDER WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND PLACED_ORDER_ID IS NULL";
}
$res2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($res2);
$total = $row2['Total'];

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
    $random = random_bytes(8);
    $PLACED_ORDER_TRACKER = bin2hex($random);

    $PLACED_ORDER_NOTE = $_POST['customer-note'];

    $select = " SELECT * FROM `placed_order` WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER'";

    $result = mysqli_query($conn, $select);

    while (mysqli_num_rows($result) > 0) {
        $random = random_bytes(8);
        $PLACED_ORDER_TRACKER = bin2hex($random);
        $select = "SELECT * FROM `placed_order` WHERE PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER'";
        $result = mysqli_query($conn, $select);
    }

    $_SESSION['PLACED_ORDER_TRACKER'] =  $PLACED_ORDER_TRACKER;

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
        PLACED_ORDER_TRACKER = '$PLACED_ORDER_TRACKER',
        PLACED_ORDER_NOTE = '$PLACED_ORDER_NOTE'
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
        PLACED_ORDER_NOTE = '$PLACED_ORDER_NOTE',
        GUEST_ORDER_IDENTIFIER = '$GUEST_ID'
        ";
    }


    $res3 = mysqli_query($conn, $sql3);

    if ($res3 == true) {
        if (isset($_SESSION['prsn_id'])) {
            $sql4 = "SELECT PLACED_ORDER_ID FROM placed_order WHERE PRSN_ID = $CUS_ID AND PLACED_ORDER_STATUS = 'Placed' ORDER BY PLACED_ORDER_ID DESC LIMIT 1";
        } else {
            $sql4 = "SELECT PLACED_ORDER_ID FROM placed_order WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND PLACED_ORDER_STATUS = 'Placed' ORDER BY PLACED_ORDER_ID DESC LIMIT 1";
        }

        $res4 = mysqli_query($conn, $sql4);
        if ($res4 && mysqli_num_rows($res4) > 0) {
            $row5 = mysqli_fetch_assoc($res4);
            $PLACED_ORDER_ID = $row5['PLACED_ORDER_ID'];

            // Update the in_order table with the latest placed_order_id
            if (isset($_SESSION['prsn_id'])) {
                $sql5 = "UPDATE in_order SET PLACED_ORDER_ID = $PLACED_ORDER_ID WHERE PRSN_ID = $CUS_ID AND IN_ORDER_STATUS = 'Ordered' AND PLACED_ORDER_ID IS NULL";
            } else {
                $sql5 = "UPDATE in_order SET PLACED_ORDER_ID = $PLACED_ORDER_ID WHERE GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND IN_ORDER_STATUS = 'Ordered' AND PLACED_ORDER_ID IS NULL";
            }

            $res5 = mysqli_query($conn, $sql5);
            if ($res5) {
                header('location: checkout-success.php');
                exit(); // Ensure no further execution after redirection
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Fat Rap's Barbeque</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="app.js" defer></script>
    <script src="ph-address-selector.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        <style>
            .error-text {
                color: yellow;
                font-size: 10px;
            }
        </style>
        <section class="section" id="checkout">
            <div class="container">
                <div class="section-heading">
                    <h2>Checkout</h2>
                    <p>You are about to place your order</p>
                </div>
                <section>
                    <form method="POST" class="section-body" onsubmit="return validateInputs()">
                        <!--order summary block-->
                        <section class="block">
                            <h3 class="block-heading">Order Summary</h2>
                                <div class="block-body">
                                    <div class="table-wrap">
                                        <table class="order">
                                            <thead>
                                                <tr>
                                                    <th class="header first-col"></th>
                                                    <th class="header">
                                                        <p>Quantity</p>
                                                    </th>
                                                    <th class="header">
                                                        <p>Price</p>
                                                    </th>
                                                    <th class="header">
                                                        <p>Sub Total</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_SESSION['prsn_id'])) {
                                                    $CUS_ID = $_SESSION['prsn_id'];
                                                    $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, FOOD_STOCK, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
                                        FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered' AND PRSN_ID = $PRSN_ID AND PLACED_ORDER_ID IS NULL";
                                                } else {
                                                    $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, FOOD_STOCK, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
                                        FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered' AND GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND PLACED_ORDER_ID IS NULL";
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
                                                            <td>
                                                                <p><?php echo $IN_ORDER_QUANTITY ?></p>
                                                            </td> <!--Quantity-->
                                                            <td>
                                                                <p>₱<?php echo $FOOD_PRICE; ?></p>
                                                            </td><!--Price-->
                                                            <td>
                                                                <p>₱<?php echo $IN_ORDER_TOTAL; ?></p>
                                                            </td><!--Sub Total-->
                                                        </tr>
                                                <?php
                                                    }
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
                                    <div class="form-field">
                                        <div class="input-grp">
                                            <p>First Name</p>
                                            <input type="text" id="first-name" name="first-name" class="input">
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>Last Name</p>
                                            <input type="text" id="last-name" name="last-name" class="input">
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>Contact Number</p>
                                            <input type="text" id="contact-number" name="contact-number" class="input">
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>Email</p>
                                            <input type="email" id="email" name="email" class="input">
                                            <div class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="right">
                                    <h3 class="block-heading">Address</h3>
                                    <!-- <div class="form-field">
                                        <div class="input-grp">
                                            <p>Region</p>
                                            <select name="region" class="form-control form-control-md input" id="region"></select>
                                            <input type="text" id="first-name" name="first-name" class="input">
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>Province</p>
                                            <input type="text" id="last-name" name="last-name" class="input">
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>City/Municipality</p>
                                            <input type="text" id="contact-number" name="contact-number" class="input">
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>Barangay</p>
                                            <input type="email" id="email" name="email" class="input">
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>House no./Bldg./Street</p>
                                            <input type="text" class="form-control form-control-md" name="street" id="street-text" class="input">
                                            <div class="error"></div>
                                        </div>
                                    </div> -->
                                    <div class="form-field">
                                        <div class="input-grp">
                                            <p>Region</p>
                                            <select name="region" class="form-control form-control-md input" id="region"></select>
                                            <input type="hidden" class="form-control form-control-md" name="region" id="region-text" required>
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>Province</p>
                                            <select name="province" class="form-control form-control-md input" id="province"></select>
                                            <input type="hidden" class="form-control form-control-md" name="province" id="province-text" required>
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>City/Municipality</p>
                                            <select name="city" class="form-control form-control-md input" id="city"></select>
                                            <input type="hidden" class="form-control form-control-md" name="city" id="city-text" required>
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>Barangay</p>
                                            <select name="barangay" class="form-control form-control-md input" id="barangay"></select>
                                            <input type="hidden" class="form-control form-control-md" name="barangay" id="barangay-text" required>
                                            <div class="error"></div>
                                        </div>
                                        <div class="input-grp">
                                            <p>House no./Bldg./Street</p>
                                            <input type="text" class="form-control form-control-md input" name="street" id="street-text">
                                            <div class="error"></div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                        <!-- delivery info block-->
                        <section class="red-theme" id="delivery-block">
                            <div class="left-side">
                                <h3 class="block-heading">When do you want your order to be delivered?</h2>
                                    <?php
                                    $sql = "SELECT CALENDAR_DATE, DATE_STATUS FROM calendar";
                                    $res = mysqli_query($conn, $sql);
                                    $calendar_data = array();

                                    if ($res) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            // Convert date string to a format JavaScript can understand
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
                                    <div class="date-grp">
                                        <?php
                                        $today = date("Y-m-d");
                                        $oneMonthFromNow = date("Y-m-d", strtotime("+1 month"));
                                        ?>
                                        <input class="date" type="date" name="date" min="<?php echo $today ?>" max="<?php echo $oneMonthFromNow ?>" oninput="disableInvalidDates(this)">
                                        <script>
                                            function disableInvalidDates(input) {
                                                var selectedDate = new Date(input.value);
                                                var currentDate = new Date();
                                                currentDate.setHours(0, 0, 0, 0);
                                                var dateStr = selectedDate.toISOString().slice(0, 10);
                                                var currentTime = new Date().toLocaleTimeString('en-US', {
                                                    hour12: false,
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                });

                                                if (selectedDate < currentDate) {
                                                    input.setCustomValidity("Date invalid.");
                                                } else if (calendarData[dateStr] === 'fullybooked' || calendarData[dateStr] === 'closed') {
                                                    input.setCustomValidity("This date is not available.");
                                                } else if (selectedDate.getTime() === currentDate.getTime() && input.value < currentTime) {
                                                    input.setCustomValidity("Time invalid.");
                                                } else {
                                                    input.setCustomValidity("");
                                                }
                                            }
                                        </script>
                                    </div>
                            </div>
                            <div class="block time-slot">
                                <h3 class="block-heading">Time Slot</h3>
                                    <div class="block-body">
                                        <input type="time" name="time" min="09:00:00" max="17:00:00">
                                        <div class="error"></div>
                                    </div>
                            </div>
                        </section>
                        <!-- customer note block-->
                        <section class="block red-theme">
                            <h3 class="block-heading">Additional Notes</h2>
                                <div class="block-body">
                                    <label for="customer-note"></label>
                                    <textarea id="customer-note" class="customer-note" name="customer-note" rows="4" placeholder="You may send an additional note such as extra spoon and fork, extra sauce, etc."></textarea>
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
                    </form>
                </section>
            </div>
        </section>

        <script>
            const firstNameInput = document.getElementById('first-name');
            const lastNameInput = document.getElementById('last-name');
            const emailInput = document.getElementById('email');
            const numberInput = document.getElementById('contact-number');

            const regionInput = document.getElementsByName('region')[0];
            const provinceInput = document.getElementsByName('province')[0];
            const cityInput = document.getElementsByName('city')[0];
            const barangayInput = document.getElementsByName('barangay')[0];
            const streetInput = document.getElementsByName('street')[0];

            const dateInput = document.getElementsByName('date')[0];
            const timeInput = document.getElementsByName('time')[0];

            function setError(input, message) {
                const errorDiv = input.nextElementSibling;
                errorDiv.innerHTML = `<span class="error-text">${message}</span>`;
            }

            function clearError(input) {
                const errorDiv = input.nextElementSibling;
                errorDiv.innerHTML = ''; // Clear the error message
            }

            function validateInputs() {
                let isValid = true;

                const firstNameValue = firstNameInput.value.trim();
                const lastNameValue = lastNameInput.value.trim();
                const emailValue = emailInput.value.trim();
                const numberValue = numberInput.value.trim();

                const regionValue = regionInput.value.trim();
                const provinceValue = provinceInput.value.trim();
                const cityValue = cityInput.value.trim();
                const barangayValue = barangayInput.value.trim();
                const streetValue = streetInput.value.trim();

                const dateValue = dateInput.value.trim();
                const timeValue = timeInput.value.trim();

                const nameRegex = /^[a-zA-Z\s]+$/;
                const numberRegex = /^(?! )\S*(?<! )09\d{9}$/;
                const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,}$/; // Password should not contain special characters
                const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]+$/; // Email must contain an '@'

                if (firstNameValue === '') {
                    setError(firstNameInput, 'Please enter your name');
                    isValid = false;
                } else if (!nameRegex.test(firstNameValue)) {
                    setError(firstNameInput, 'Name must contain only letters');
                    isValid = false;
                } else {
                    clearError(firstNameInput);
                }

                if (lastNameValue === '') {
                    setError(lastNameInput, 'Please enter your name');
                    isValid = false;
                } else if (!nameRegex.test(lastNameValue)) {
                    setError(lastNameInput, 'Name must contain only letters');
                    isValid = false;
                } else {
                    clearError(lastNameInput);
                }


                if (emailValue === '') {
                    setError(emailInput, 'Please enter your email');
                    isValid = false;
                } else if (!emailRegex.test(emailValue)) {
                    setError(emailInput, 'Invalid email format');
                    isValid = false;
                } else {
                    clearError(emailInput);
                }

                if (numberValue === '') {
                    setError(numberInput, 'Please enter your number');
                    isValid = false;
                } else if (!numberRegex.test(numberValue)) {
                    setError(numberInput, 'Invalid number');
                    isValid = false;
                } else {
                    clearError(numberInput);
                }

                if (regionValue === '') {
                    setError(regionInput, 'Please enter your region');
                    isValid = false;
                } else {
                    clearError(regionInput);
                }

                if (provinceValue === '') {
                    setError(provinceInput, 'Please enter your province');
                    isValid = false;
                } else {
                    clearError(provinceInput);
                }

                if (cityValue === '') {
                    setError(cityInput, 'Please enter your city');
                    isValid = false;
                } else {
                    clearError(cityInput);
                }

                if (barangayValue === '') {
                    setError(barangayInput, 'Please enter your barangay');
                    isValid = false;
                } else {
                    clearError(barangayInput);
                }

                if (streetValue === '') {
                    setError(streetInput, 'Please enter your street');
                    isValid = false;
                } else {
                    clearError(streetInput);
                }

                if (dateValue === '') {
                    setError(dateInput, 'Please enter your date');
                    isValid = false;
                } else {
                    clearError(dateInput);
                }

                if (timeValue === '') {
                    setError(timeInput, 'Please enter your time');
                    isValid = false;
                } else {
                    clearError(timeInput);
                }


                return isValid;
            }
        </script>
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