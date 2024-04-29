<?php

@include 'constants.php';

$PRSN_ROLE = $_SESSION['prsn_role'];
if ($PRSN_ROLE !== 'Admin') {
    header('location:' . SITEURL . 'login-page.php');
}

$FOOD_ID = $_GET['FOOD_ID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item | Fat Rap's Barbeque's Online Store</title>
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
                        <h2>Edit Menu Item</h2>
                        <a href="<?php echo SITEURL; ?>admin-edit-menu.php">Back</a>
                    </div>
                    <?php

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
                    ?>

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
                                                    <input class="js-user" type="text" id="product-name" name="product-name" value="<?php echo $FOOD_NAME; ?>"><!-- 20 characters only, letter only, with spaces -->
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="product-name">Description</label>
                                                    <input class="js-user" type="text" id="product-desc" name="product-desc" value="<?php echo $FOOD_DESC; ?>"><!-- 20 characters only, letter only, with spaces -->
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="price">Price ₱ </label>
                                                    <input class="js-user" type="text" id="price" name="price" value="<?php echo $FOOD_PRICE; ?>">
                                                    <div class="error"></div>
                                                </div>

                                                <div class="form-field-input">
                                                    <label for="price">Stock </label>
                                                    <input class="js-user" type="number" id="stock" name="stock" value="<?php echo $FOOD_STOCK; ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="type">Type</label>
                                                    <select class="dropdown" name="type" id="type" value="<?php echo $FOOD_TYPE; ?>">
                                                        <option value="Customer">Customer</option>
                                                        <option value="Wholesaler">Wholesaler</option>
                                                    </select>
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="active">Active</label>
                                                    <select class="dropdown" name="active" id="active">
                                                        <option value="No" <?php if ($FOOD_ACTIVE == 'No') echo ' selected'; ?>>No</option>
                                                        <option value="Yes" <?php if ($FOOD_ACTIVE == 'Yes') echo ' selected'; ?>>Yes</option>
                                                    </select>
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="valid-id">Image</label>
                                                    <p class="label-desc">(accepted files: .jpg, .png)</p>
                                                    <input class="image" type="file" name="image" id="image">
                                                    <div class="error"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="big-btn" name="submit">Save</button>
                                    </form>
                                </section>
                            </section>
                    <?php
                        }
                    }
                    ?>

                </div>
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
            </div>
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

            // Check if file extension is valid
            const validExtensions = ['png', 'jpg', 'jpeg'];
            const fileExtension = imageValue.split('.').pop().toLowerCase();

            if (imageValue === '') {
                setError(imageInput, 'Please select an image file');
            } else if (!validExtensions.includes(fileExtension)) {
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

        </section>
    </main>
</body>

</html>
<?php
if (isset($_POST['submit'])) {

    // Retrieve form data
    $FOOD_NAME = mysqli_real_escape_string($conn, $_POST['product-name']);
    $FOOD_DESC = mysqli_real_escape_string($conn, $_POST['product-desc']);
    $FOOD_PRICE =  $_POST['price'];
    $FOOD_STOCK = $_POST['stock'];
    $FOOD_ACTIVE = $_POST['active'];
    $FOOD_TYPE = $_POST['type'];
    $current_image = $FOOD_IMAGE;

    // Check if a new image is uploaded
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Get the image details
        $FOOD_IMG = $_FILES['image']['name'];

        // Check if the uploaded file is an image
        $image_info = getimagesize($_FILES['image']['tmp_name']);
        if ($image_info === false) {
            // Handle non-image files here
            $_SESSION['upload'] = "<div class='error'>Please upload a valid image file</div>";
            header('location:' . $_SERVER['PHP_SELF'] . '?FOOD_ID=' . $FOOD_ID);
            exit();
        }

        // Generate a unique filename for the image
        $image_info = pathinfo($FOOD_IMG);
        $ext = strtolower($image_info['extension']);
        $FOOD_IMG = "FOOD_IMAGE_" . $FOOD_NAME . "_" . uniqid() . "." . $ext;

        // Set the destination path for the uploaded image
        $dst = "images/" . $FOOD_IMG;

        // Upload the image
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $dst)) {
            // Handle upload failure
            $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
            header('location:' . $_SERVER['PHP_SELF'] . '?FOOD_ID=' . $FOOD_ID);
            exit();
        }

        // Remove the previous image if it exists
        if (!empty($current_image)) {
            $remove_path = "images/" . $current_image;
            if (!unlink($remove_path)) {
                // Handle image removal failure
                $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image</div>";
                header('location:' . SITEURL . 'admin-home.php');
                exit();
            }
        }
    } else {
        // No new image uploaded, retain the current image
        $FOOD_IMG = $current_image;
    }

    // Update the database with the new data
    $update = "UPDATE food 
        SET FOOD_NAME = '$FOOD_NAME',
            FOOD_DESC = '$FOOD_DESC',
            FOOD_IMG = '$FOOD_IMG',
            FOOD_PRICE = '$FOOD_PRICE',
            FOOD_STOCK = '$FOOD_STOCK',
            FOOD_ACTIVE = '$FOOD_ACTIVE',
            FOOD_TYPE = '$FOOD_TYPE'
        WHERE FOOD_ID = '$FOOD_ID'";

    mysqli_query($conn, $update);

    // Redirect to the edit page with the updated data
    echo "<script> window.location.href = 'admin-inventory.php'; </script>";
    exit();
}
?>