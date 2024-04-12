<?php

@include 'constants.php';

$FOOD_ID = $_GET['FOOD_ID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item | Employee</title>
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
                    <p>Employee</p>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class='menubar'>
                <li><a href="<?php echo SITEURL; ?>employee-home.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>employee-to-prepare-orders.php">Orders</a></li>
                <!-- Text below should change to 'Logout'once user logged in-->
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
                        <a href="<?php echo SITEURL; ?>employee-inventory.php">Back</a>
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
                                    <form action="#" class="column" method="post" enctype="multipart/form-data">
                                        <div class="block">
                                            <div class="form-field">
                                                <div class="form-field-input">
                                                    <label for="product-name">Product Name</label>
                                                    <input value="<?php echo $FOOD_NAME ?>" class="js-user" type="text" id="product-name" name="product-name" required pattern="[a-zA-Z ]{1,20}$"><!-- 20 characters only, letter only, with spaces -->
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="product-name">Product Description</label>
                                                    <input value="<?php echo $FOOD_DESC ?>" class="js-user" type="text" id="product-name" name="product-desc" required pattern="[a-zA-Z ]{1,20}$"><!-- 20 characters only, letter only, with spaces -->
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="price">Price ₱ </label>
                                                    <input value="<?php echo $FOOD_PRICE ?>" class="js-user" type="number" id="price" name="price" required><!-- numbers only, starts with 09, must have 11-digits -->
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="price">Stock </label>
                                                    <input value="<?php echo $FOOD_STOCK ?>" class="js-user" type="number" id="price" name="stock" required><!-- numbers only, starts with 09, must have 11-digits -->
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="active">Active</label>
                                                    <select class="dropdown" name="active" id="active" required>
                                                        <option value="inactive">INACTIVE</option>
                                                        <option value="active">ACTIVE</option>
                                                    </select>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="valid-id">Image</label>
                                                    <p class="label-desc">(accepted files: .jpg, .png)</p>
                                                    <input class="image" type="file" name="image" id="image" required><!-- numbers only, starts with 09, must have 11-digits -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <input type="hidden" name="FOOD_IMG" value="<?php echo $FOOD_IMG; ?>"> -->
                                        <a href="<?php echo SITEURL; ?>employee-add-product.php" class="page-btn"><button class="big-btn">Add a new product</button></a>
                                    </form>
                                </section>
                            </section>
                    <?php
                        }
                    }
                    ?>

                </div>
            </div>
            
        </section>
    </main>
</body>

</html>
<?php
if (isset($_POST['submit'])) {

    $FOOD_NAME = mysqli_real_escape_string($conn, $_POST['product-name']);
    $FOOD_DESC = mysqli_real_escape_string($conn, $_POST['product-desc']);
    $FOOD_PRICE =  $_POST['price'];
    $FOOD_STOCK = $_POST['stock'];
    $FOOD_ACTIVE = $_POST['active'];
    $current_image = $FOOD_IMAGE;

    if (isset($_FILES['image']['name'])) {
        //get the image details
        $FOOD_IMG = $_FILES['image']['name'];

        //check whether image is available
        if ($FOOD_IMG != "") {
            $image_info = explode(".", $FOOD_IMG);
            $ext = end($image_info);

            $FOOD_IMG = "FOOD_IMAGE_" . $FOOD_NAME . "." . $ext;

            $src = $_FILES['image']['tmp_name'];
            $dst = "images/" . $FOOD_IMG;

            $upload    = move_uploaded_file($src, $dst);

            //check whether the image is uploaded
            if ($upload == false) {
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                die();
            }
            //remove current image if available
            if ($current_image != "") {
                $remove_path = "images/" . $FOOD_IMAGE;
                $remove = unlink($remove_path);
                //check whether image is removed
                if ($remove == false) {
                    $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image</div>";
                    header('location:' . SITEURL . 'employee-home.php');
                    die();
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }


    $update = "UPDATE food 
        SET FOOD_NAME = '$FOOD_NAME',
            FOOD_DESC = '$FOOD_DESC',
            FOOD_IMG = '$FOOD_IMG',
            FOOD_PRICE = '$FOOD_PRICE',
            FOOD_STOCK = '$FOOD_STOCK',
            FOOD_ACTIVE = '$FOOD_ACTIVE'
        WHERE FOOD_ID = '$FOOD_ID'";

    mysqli_query($conn, $update);
}
?>