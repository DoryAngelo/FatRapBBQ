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
    $insert = "INSERT INTO food(CTGY_ID, FOOD_NAME, FOOD_PRICE, FOOD_DESC, FOOD_IMG, FOOD_STOCK, FOOD_ACTIVE) 
                       VALUES('$CTGY_ID', '$FOOD_NAME', '$FOOD_PRICE', '$FOOD_DESC', '$FOOD_IMG', '$FOOD_STOCK', '$FOOD_ACTIVE')";
    mysqli_query($conn, $insert);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile | Admin</title>
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
        <section class="section add-edit-menu admin-profile">
            <div class="container">
                <div class="section-wrapper">
                    <div class="section-heading row back">
                        <h2>Admin Profile</h2>
                        <a href="<?php echo SITEURL; ?>admin-home.php">Back</a>
                    </div>
                    <section class="section-body">
                        <section class="main-section column">
                            <form action="#" class="column" method="post" enctype="multipart/form-data">
                                <?php
                                $sql = "SELECT * 
                                    FROM person
                                    WHERE PRSN_ID = '$PRSN_ID'";

                                $res = mysqli_query($conn, $sql);

                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {

                                        $PRSN_NAME = $row['PRSN_NAME'];
                                        $PRSN_EMAIL = $row['PRSN_EMAIL'];

                                ?>
                                        <div class="block">
                                            <div class="image-group">
                                                <img src="https://static-00.iconduck.com/assets.00/profile-circle-icon-2048x2048-cqe5466q.png" alt="">
                                                <p><?php echo $PRSN_NAME?></p>
                                            </div>
                                            <table>
                                                <tr>
                                                    <th>Email</th>
                                                    <td><?php echo $PRSN_EMAIL ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Username</th>
                                                    <td>johndoe1</td>
                                                </tr>
                                                <tr>
                                                    <th>Password</th>
                                                    <td><input type="password" value="admin" readonly></td>
                                                </tr>
                                            </table>
                                    <?php
                                    }
                                }
                                    ?>

                                        </div>
                                        <a href="<?php echo SITEURL; ?>admin-edit-profile.php" class="big-btn">Edit</a>
                            </form>
                        </section>
                    </section>
                </div>
            </div>
            
        </section>
    </main>
</body>

</html>