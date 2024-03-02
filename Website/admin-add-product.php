<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

if (isset($_POST['submit'])) {

    $PRSN_NAME = mysqli_real_escape_string($conn, $_POST['name']);
    $PRSN_EMAIL = mysqli_real_escape_string($conn, $_POST['email']);
    $PRSN_PHONE = $_POST['number'];
    $PRSN_PASSWORD = md5($_POST['password']);
    $PRSN_CPASSWORD = md5($_POST['cpassword']);
    $PRSN_ROLE = 'Wholesaler';


    if (isset($_FILES['image']['name'])) {
        $WHL_IMG = $_FILES['image']['name'];

        if ($WHL_IMG != "") {
            $image_info = explode(".", $WHL_IMG);
            $ext = end($image_info);

            $WHL_IMG = "WHL_IMAGE_" . $PRSN_NAME . "." . $ext;

            $src = $_FILES['image']['tmp_name'];
            $dst = "images/" . $WHL_IMG;

            $upload = move_uploaded_file($src, $dst);

            if ($upload = false) {
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                header('location:' . SITEURL . 'cus-home-page.php');
                die();
            }
        }
    } else {
        $WHL_IMG = "";
    }
    
    $select = "SELECT * FROM `person` WHERE PRSN_EMAIL = '$PRSN_EMAIL'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = "User already exists";
    } else {
        if ($PRSN_PASSWORD != $PRSN_CPASSWORD) {
            $error[] = "Password not matched";
        } else {
            $insert = "INSERT INTO person(PRSN_NAME, PRSN_EMAIL, PRSN_PASSWORD, PRSN_PHONE, PRSN_ROLE) 
                       VALUES('$PRSN_NAME', '$PRSN_EMAIL', '$PRSN_PASSWORD', '$PRSN_PHONE', '$PRSN_ROLE')";
            if (mysqli_query($conn, $insert)) {
                $PRSN_ID = mysqli_insert_id($conn);
                $DATE_OF_REGISTRATION = date("Y-m-d h:i:sa");
                $insert2 = "INSERT INTO wholesaler(PRSN_ID, WHL_DISC, WHL_IMAGE, DATE_OF_REGISTRATION) 
                            VALUES('$PRSN_ID', '00.05', '$WHL_IMG', '$DATE_OF_REGISTRATION')";
                if (!mysqli_query($conn, $insert2)) {
                    $error[] = "Error inserting data into wholesaler table: " . mysqli_error($conn);
                }
            } else {
                $error[] = "Error inserting data into person table: " . mysqli_error($conn);
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
    <title>Add Menu Item | Fat Rap's Barbeque's Online Store</title>
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
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo SITEURL ;?>admin-home.php">Home</a></li>
                    <li><a href="<?php echo SITEURL ;?>admin-edit-menu.php">Menu</a></li>
                    <li><a href="<?php echo SITEURL ;?>admin-new-orders.php">Orders</a></li>
                    <?php
                        if(isset($_SESSION['prsn_id'])){
                    ?>  
                        <li><a href="<?php echo SITEURL ;?>logout.php">Logout</a><li>
                    <?php
                        } 
                        else 
                        {
                    ?>
                        <li><a href="<?php echo SITEURL ;?>login-page.php">Login</a></li>
                    <?php
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="green-block">
            <form action="#" class="form reg-form" method="post" enctype="multipart/form-data">
                <div class="form-title">
                    <h1>Add Menu Item</h1>
                </div>
                <div class="form-field">
                    <div class="form-field-input">
                        <label for="name">Product Name</label>
                        <input class="js-user" type="text" id="name" name="name" required  pattern="[a-zA-Z ]{1,20}$"><!-- 20 characters only, letter only, with spaces -->
                    </div>
                    <div class="form-field-input">
                        <label for="email">Category</label>
                        <input name="email" id="email" class="js-user" type="text" required >
                    </div>
                    <div class="form-field-input">
                        <label for="number">Price</label>
                        <input class="js-user" type="text" id="number" name="number" required pattern="^(09)[0-9]{9}$"><!-- numbers only, starts with 09, must have 11-digits -->
                    </div>
                    <div class="form-field-input">
                        <label for="password">Active</label>
                        <input class="js-pass" type="password" id="password" name="password" >
                    </div>
                    <div class="form-field-input">
                        <label for="valid-id">Image</label>
                        <p class="label-desc">(accepted files: .jpg, .png)</p>
                        <input name="image" id="image" class="image" type="file" required><!-- numbers only, starts with 09, must have 11-digits -->
                    </div>
                    <button class="primary-btn" name="submit">Add Product</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>