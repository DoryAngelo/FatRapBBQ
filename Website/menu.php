<!-- customer menu page -->
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
$selectedTime = $selectedDateTime ? date('H:i', strtotime($selectedDateTime)) : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Menu | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css"><!--change css file-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="app.js" defer></script>
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
        <?php if(isset($_SESSION['fromProdInfo']) && $_SESSION['fromProdInfo'] == 'yes')
        {?>
        <script>
        Swal.fire({
            title: 'Success!',
            text: 'Your order has been added to the cart.',
            icon: 'success',
            iconColor: '#edcb1c',
            confirmButtonText: '<font color="#3a001e">Continue</font>',
            confirmButtonColor: '#edcb1c',
            color: 'white',
            background: '#539b3b',
        });
        </script>
        <?php
        unset($_SESSION['fromProdInfo']);}
        if ($PRSN_ROLE == "Wholesaler") {
        ?>
            <div class="wholesaler-menu-banner">
                <h1>WHOLESALE DEALS!!!</h1>
            </div>
        <?php
        }
        ?>
        <section class="section menu">
            <div class="container">
                <div class="section-heading">
                    <h2>Menu</h2>
                    <h2><?php echo $_SESSION['selectedDateTime'] ?></h2>
                    <h3>When do you want your order to be delivered?</h3>
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
                    <input min="<?php echo $today ?>" max="<?php echo $oneMonthFromNow ?>" oninput="validateDate(this)" type="date" id="delivery-date" name="delivery-date" value="<?php echo $selectedDateTime ? date('Y-m-d', strtotime($selectedDateTime)) : ''; ?>">
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

                            // Check if selected time is within 30 minutes of current time
                            var timeDiff = new Date("1970-01-01 " + selectedTime) - new Date("1970-01-01 " + currentTime);
                            var minutesDiff = Math.abs(timeDiff / 60000);
                            if (minutesDiff < 30) {
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
                </div>
                <section class="section-body">
                    <?php
                    if ($PRSN_ROLE === 'Admin') {
                        $sql = "SELECT * FROM food WHERE FOOD_ACTIVE = 'Yes'";
                    } else {
                        $sql = "SELECT * FROM food WHERE FOOD_ACTIVE = 'Yes' AND FOOD_TYPE = '$PRSN_ROLE'";
                    }
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $FOOD_ID = $row['FOOD_ID'];
                            $FOOD_NAME = $row['FOOD_NAME'];
                            $FOOD_IMG = $row['FOOD_IMG'];
                            $FOOD_STOCK = $row['FOOD_STOCK'];
                            $HOURLY_CAP = $row['HOURLY_CAP'];
                            $FOOD_PRICE = $row['FOOD_PRICE'];
                            $avail;
                            if ($FOOD_STOCK <= $HOURLY_CAP) {
                                $avail = $FOOD_STOCK;
                            } else {
                                $avail = $HOURLY_CAP;
                            }
                    ?>
                            <a class="menu-item" href="<?php echo SITEURL; ?>product-info.php?FOOD_ID=<?php echo $FOOD_ID ?>">
                                <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                <div class="text">
                                    <p class="name"><?php echo $FOOD_NAME ?></p>
                                    <div class="inline">
                                        <h2>₱<?php echo $FOOD_PRICE ?></h2>
                                        <p><?php echo $avail ?> sticks remaining</p>
                                        <p id="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'stick-hidden' : ''; ?>">1 stick</p>
                                    </div>
                                </div>
                            </a>
                    <?php
                        }
                    }
                    ?>
                </section>
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