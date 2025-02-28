<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];
$PRSN_ROLE = $_SESSION['prsn_role'];
if ($PRSN_ROLE !== 'Employee') {
    header('location:' . SITEURL . 'login-page.php');
}

if (isset($_POST['submit'])) {
    $FOOD_NAME = mysqli_real_escape_string($conn, $_POST['product-name']);
    $FOOD_DESC = mysqli_real_escape_string($conn, $_POST['product-desc']);
    $FOOD_PRICE =  $_POST['price'];
    $FOOD_STOCK = $_POST['stock'];
    $FOOD_ACTIVE = $_POST['active'];
    $CTGY_ID = $_POST['category'];
    $FOOD_TYPE = $_POST['type'];


    if (isset($_FILES['image']['name'])) {
        $FOOD_IMG = $_FILES['image']['name'];

        if ($FOOD_IMG != "") {
            $image_info = explode(".", $FOOD_IMG);
            $ext = end($image_info);

            $FOOD_IMG = "FOOD_IMAGE_" . $FOOD_NAME . "." . $ext;

            $src = $_FILES['image']['tmp_name'];
            $dst = "images/" . $FOOD_IMG;

            $upload    = move_uploaded_file($src, $dst);

            if ($upload = false) {
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                header('location:' . SITEURL . 'employee-home.php');
                die();
            }
        }
    } else {
        $FOOD_IMG = "";
    }
    $insert = "INSERT INTO food( FOOD_NAME, FOOD_PRICE, FOOD_DESC, FOOD_IMG, FOOD_STOCK, FOOD_ACTIVE, FOOD_TYPE) 
                       VALUES( '$FOOD_NAME', '$FOOD_PRICE', '$FOOD_DESC', '$FOOD_IMG', '$FOOD_STOCK', '$FOOD_ACTIVE', '$FOOD_TYPE')";
    mysqli_query($conn, $insert);

    header("location: employee-inventory.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product | Employee</title>
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
                    <p>EMPLOYEE</p>
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
                        <h2>Add New Product</h2>
                        <a href="<?php echo SITEURL; ?>employee-inventory.php">Back</a>
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
                                            <input class="js-user" type="text" id="product-name" name="product-name"><!-- 20 characters only, letter only, with spaces -->
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="product-name">Description</label>
                                            <input class="js-user" type="text" id="product-desc" name="product-desc"><!-- 20 characters only, letter only, with spaces -->
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="price">Price ₱ </label>
                                            <input class="js-user" type="text" id="price" name="price">
                                            <div class="error"></div>
                                        </div>

                                        <div class="form-field-input">
                                            <label for="price">Stock </label>
                                            <input class="js-user" type="number" id="stock" name="stock">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="type">Type</label>
                                            <select class="dropdown" name="type" id="type">
                                                <option value="Customer">Customer</option>
                                                <option value="Wholesaler">Wholesaler</option>
                                            </select>
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="active">Active</label>
                                            <select class="dropdown" name="active" id="active">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
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
                                <button class="big-btn" name="submit">Add Product</button>
                            </form>
                        </section>
                    </section>
                </div>
            </div>
        </section>
    </main>
</body>
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

</html>