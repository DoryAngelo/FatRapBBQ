<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

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
                header('location:' . SITEURL . 'admin-home.php');
                die();
            }
        }
    } else {
        $FOOD_IMG = "";
    }
    $insert = "INSERT INTO food(CTGY_ID, FOOD_NAME, FOOD_PRICE, FOOD_DESC, FOOD_IMG, FOOD_STOCK, FOOD_ACTIVE, FOOD_TYPE) 
                       VALUES('$CTGY_ID', '$FOOD_NAME', '$FOOD_PRICE', '$FOOD_DESC', '$FOOD_IMG', '$FOOD_STOCK', '$FOOD_ACTIVE', '$FOOD_TYPE')";
    mysqli_query($conn, $insert);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item | Admin</title>
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
        <section class="section add-edit-menu">
            <div class="container">
                <div class="section-wrapper">
                    <div class="section-heading row back">
                        <h2>Add Menu Item</h2>
                        <a href="<?php echo SITEURL; ?>admin-edit-menu.php">Back</a>
                    </div>
                    <section class="section-body">
                        <section class="main-section column">
                            <form action="#" class="column" method="post" enctype="multipart/form-data">
                                <div class="block">
                                    <div class="form-field">
                                        <div class="form-field-input">
                                            <label for="product-name">Product Name</label>
                                            <input class="js-user" type="text" id="product-name" name="product-name" required pattern="[a-zA-Z ]{1,20}$"><!-- 20 characters only, letter only, with spaces -->
                                        </div>
                                        <div class="form-field-input">
                                            <label for="product-name">Description</label>
                                            <input class="js-user" type="text" id="product-name" name="product-desc" required pattern="[a-zA-Z ]{1,50}$"><!-- 20 characters only, letter only, with spaces -->
                                        </div>
                                        <div class="form-field-input">
                                            <label for="price">Price ₱ </label>
                                            <input class="js-user" type="number" id="price" name="price" required><!-- numbers only, starts with 09, must have 11-digits -->
                                        </div>
                                        <div class="form-field-input">
                                            <label for="price">Stock </label>
                                            <input class="js-user" type="number" id="price" name="stock" required><!-- numbers only, starts with 09, must have 11-digits -->
                                        </div>
                                        <div class="form-field-input">
                                            <label for="category">Category</label>
                                            <select class="dropdown" name="category" id="category" required>
                                                <?php
                                                    $sql = "SELECT * FROM category WHERE CTGY_ACTIVE='Yes'";
                                                    $res = mysqli_query($conn, $sql);
                                                    $count = mysqli_num_rows($res);
                                                    if ($count > 0) {
                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                            //get the details of category
                                                            $CTGY_ID = $row['CTGY_ID'];
                                                            $CTGY_NAME = $row['CTGY_NAME'];
                                                ?>
                                                            <option value="<?php echo $CTGY_ID; ?>"><?php echo $CTGY_NAME; ?></option>
                                                <?php
                                                        }
                                                    } else {
                                                ?>
                                                        <option value="0">No Category Found</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="type">Type</label>
                                            <select class="dropdown" name="type" id="type" required>
                                                <option value="Customer">Customer</option>
                                                <option value="Wholesaler">Wholesaler</option>
                                            </select>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="active">Active</label>
                                            <select class="dropdown" name="active" id="active" required>
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="valid-id">Image</label>
                                            <p class="label-desc">(accepted files: .jpg, .png)</p>
                                            <input class="image" type="file" name="image" id="image" required><!-- numbers only, starts with 09, must have 11-digits -->
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

</html>