<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];
$FOOD_ID = $_GET['FOOD_ID'];

$PRSN_ROLE = $_SESSION['prsn_role'];
if ($PRSN_ROLE !== 'Admin') {
    header('location:' . SITEURL . 'login-page.php');
}

$sql = "SELECT * 
FROM food
WHERE food_id = '$FOOD_ID'";

$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $FOOD_ID = $row['FOOD_ID'];
        $FOOD_NAME = $row['FOOD_NAME'];
        $FOOD_DESC = $row['FOOD_DESC'];
        $FOOD_PRICE = $row['FOOD_PRICE'];
        $FOOD_STOCK = $row['FOOD_STOCK'];
        $FOOD_IMAGE = $row['FOOD_IMG'];
        $FOOD_ACTIVE = $row['FOOD_ACTIVE'];
    }
}

if (isset($_POST['submit'])) {
    $MENU_STOCK = mysqli_real_escape_string($conn, $_POST['stock']);
    $MENU_START = date("M d, Y h:i:s a", strtotime($_POST['start_date']));
    $MENU_END = date("M d, Y h:i:s a", strtotime($_POST['end_date']));

    $insert = "INSERT INTO menu(FOOD_ID, MENU_STOCK, MENU_START, MENU_END) 
               VALUES('$FOOD_ID', '$MENU_STOCK', '$MENU_START', '$MENU_END')";

    $update = "UPDATE food 
SET FOOD_STOCK = FOOD_STOCK - $MENU_STOCK
WHERE FOOD_ID = '$FOOD_ID'";



    if (mysqli_query($conn, $insert) &&  mysqli_query($conn, $update)) {


        header("location: admin-edit-menu.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product's Hourly Stock | Admin</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="admin-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="app.js" defer></script>
    <!-- add the code below to load the icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <header class="backend">
        <div class="header-container">
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
                <li><a href="<?php echo SITEURL; ?>admin-home.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-edit-menu.php">Menu</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-new-orders.php">Orders</a></li>
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
        <section class="section add-edit-menu">
            <div class="container">
                <div class="section-wrapper">
                    <div class="section-heading row back">
                        <h2>Edit Product's Hourly Stock</h2>
                        <a href="#" onclick="window.history.back();">Back</a>
                    </div>
                    <section class="section-body">
                        <section class="main-section column">
                            <style>
                                .error-text {
                                    color: red;
                                    font-size: 12px;
                                }
                            </style>
                            <form class="column" method="post" enctype="multipart/form-data" onsubmit="return validateInputs()">
                                <div class="block">
                                    <div class="form-field">
                                        <div class="form-field-input">
                                            <label for="product-name">Product Name</label>
                                            <input class="js-user" type="text" id="product-name" name="product-name" value="<?php echo $FOOD_NAME; ?>" disabled><!-- 20 characters only, letter only, with spaces -->
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="price">Stock <p>Maxmimum stock to be displayed is <?php echo $FOOD_STOCK ?></p></label>
                                            <input class="js-user" type="number" id="stock" name="stock" min="1" max="<?php echo $FOOD_STOCK ?>">
                                            <div class="error"></div>
                                        </div>
                                        <?php
                                        $today = date("Y-m-d");
                                        $oneMonthFromNow = date("Y-m-d", strtotime("+1 month"));
                                        $oneMonthFromNowFormatted = date("Y-m-d\TH:i", strtotime("+1 month"));
                                        ?>
                                        <div class="form-field-input">
                                            <label for="start_date">Start Date and Time</label>
                                            <input type="datetime-local" id="start_date" name="start_date" min="<?php echo $today ?>T00:00" max="<?php echo $oneMonthFromNowFormatted ?>">
                                            <div class="error"></div>
                                        </div>

                                        <div class="form-field-input">
                                            <label for="end_date">End Date and Time</label>
                                            <input type="datetime-local" id="end_date" name="end_date" min="<?php echo $today ?>T09:00" max="<?php echo $oneMonthFromNow ?>T17:00">
                                            <div class="error"></div>
                                        </div>
                                    </div>
                                </div>
                                <button class="big-btn" name="submit">Save</button>
                            </form>
                        </section>
                    </section>
                </div>
            </div>
        </section>
    </main>
    <script>
        const productNameInput = document.getElementById('product-name');
        const productDescInput = document.getElementById('product-desc');
        const priceInput = document.getElementById('price');
        const stockInput = document.getElementById('stock');
        const imageInput = document.getElementById('image');

        productNameInput.addEventListener('input', validateProductName);
        productDescInput.addEventListener('input', validateProductDesc);
        priceInput.addEventListener('input', validatePrice);
        stockInput.addEventListener('input', validateStock);
        imageInput.addEventListener('change', validateImage);

        function setError(input, message) {
            const errorDiv = input.nextElementSibling;
            errorDiv.innerHTML = `<span class="error-text">${message}</span>`;
        }

        function clearError(input) {
            const errorDiv = input.nextElementSibling;
            errorDiv.innerHTML = ''; // Clear the error message
        }

        function validateProductName() {
            const productNameValue = productNameInput.value.trim();
            const nameRegex = /^[a-zA-Z0-9\s]+$/;

            if (productNameValue === '') {
                setError(productNameInput, 'Please enter the product name');
            } else if (!nameRegex.test(productNameValue)) {
                setError(productNameInput, 'Invalid product name');
            } else {
                clearError(productNameInput);
            }
        }

        function validateProductDesc() {
            const productDescValue = productDescInput.value.trim();

            if (productDescValue === '') {
                setError(productDescInput, 'Please enter the product description');
            } else if (productDescValue.length > 50) {
                setError(productDescInput, 'Product description must not exceed 50 characters');
            } else {
                clearError(productDescInput);
            }
        }

        function validatePrice() {
            const priceValue = priceInput.value.trim();

            if (priceValue === '') {
                setError(priceInput, 'Please enter the price');
            } else if (isNaN(parseFloat(priceValue))) {
                setError(priceInput, 'Price must be a number');
            } else if (parseInt(priceValue) < 0) {
                setError(priceInput, 'Price cannot be negative');
            } else {
                clearError(priceInput);
            }
        }

        function validateStock() {
            const stockValue = stockInput.value.trim();

            if (stockValue === '') {
                setError(stockInput, 'Please enter the stock');
            } else if (isNaN(parseInt(stockValue))) {
                setError(stockInput, 'Stock must be a number');
            } else if (parseInt(stockValue) < 0) {
                setError(stockInput, 'Stock cannot be negative');
            } else {
                clearError(stockInput);
            }
        }

        function validateImage() {
            const imageValue = imageInput.value.trim();

            // Check if the input field is empty
            if (imageValue === '') {
                // Clear error message if input is empty
                clearError(imageInput);
                return; // Exit the function without further validation
            }

            // Check if file extension is valid
            const validExtensions = ['png', 'jpg', 'jpeg'];
            const fileExtension = imageValue.split('.').pop().toLowerCase();

            if (!validExtensions.includes(fileExtension)) {
                setError(imageInput, 'Only PNG, JPG, and JPEG files are allowed');
            } else {
                clearError(imageInput);
            }
        }

        function validateInputs() {
            validateProductName();
            validateProductDesc();
            validatePrice();
            validateStock();
            validateImage();

            // Check if any error exists
            const errors = document.querySelectorAll('.error-text');
            if (errors.length > 0) {
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>


    <script>
        // Function to check for new orders via AJAX
        function checkForNewOrders() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText.trim() === "NewOrder") {
                        notifyNewOrder(); // Play notification sound
                    }
                }
            };
            xhttp.open("GET", "order-notification.php", true);
            xhttp.send();
        }

        // Function to play notification sound
        function notifyNewOrder() {
            var audio = new Audio('sound/notification.mp3'); // Replace with correct path
            audio.play();
        }

        // Check for new orders every 5 seconds 
        setInterval(checkForNewOrders, 2000);
    </script>

</body>


</html>