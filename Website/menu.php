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
        <?php
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
                </div>
                <section class="section-body">
                    <?php

                    if ($PRSN_ROLE === 'Admin') {
                        $sql = "SELECT m.*, f.*
                FROM menu m
                JOIN food f ON m.food_id = f.food_id
                WHERE f.food_active = 'Yes'";
                    } else {
                        $sql = "SELECT m.*, f.*
                FROM menu m
                JOIN food f ON m.food_id = f.food_id
                WHERE f.food_active = 'Yes' 
                AND f.food_type = '$PRSN_ROLE'
                AND NOW() BETWEEN STR_TO_DATE(m.menu_start, '%M %d, %Y %h:%i:%s %p') AND STR_TO_DATE(m.menu_end, '%M %d, %Y %h:%i:%s %p')";
                    }

                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $FOOD_ID = $row['FOOD_ID'];
                            $FOOD_NAME = $row['FOOD_NAME'];
                            $FOOD_IMG = $row['FOOD_IMG'];
                            $FOOD_PRICE = $row['FOOD_PRICE'];
                    ?>
                            <a class="menu-item" href="<?php echo SITEURL; ?>product-info.php?FOOD_ID=<?php echo $FOOD_ID ?>">
                                <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                <div class="text">
                                    <p class="name"><?php echo $FOOD_NAME ?></p>
                                    <div class="inline">
                                        <h2>₱<?php echo $FOOD_PRICE ?></h2>
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
        <!-- <section class="section menu">
            <div class="container">
                <div class="section-heading">
                    <h2>Menu</h2>                
                </div> 
                <section class="section-body">
                    <a class="menu-item" >
                        <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="">
                        <div class="text">
                            <p class="name">Pork BBQ</p>
                            <div class="inline">
                                <h2>₱25.00</h3>
                                <p>1 stick</p>
                            </div>
                        </div>
                    </a>
                    <a class="menu-item" >
                        <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="">
                        <div class="text">
                            <p class="name">Pork BBQ</p>
                            <div class="inline">
                                <h2>₱25.00</h3>
                                <p>1 stick</p>
                            </div>
                        </div>
                    </a>
                    <a class="menu-item" >
                        <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="">
                        <div class="text">
                            <p class="name">Pork BBQ</p>
                            <div class="inline">
                                <h2>₱25.00</h3>
                                <p>1 stick</p>
                            </div>
                        </div>
                    </a>
                    <a class="menu-item" >
                        <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="">
                        <div class="text">
                            <p class="name">Pork BBQ</p>
                            <div class="inline">
                                <h2>₱25.00</h3>
                                <p>1 stick</p>
                            </div>
                        </div>
                    </a>
                    <a class="menu-item" >
                        <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="">
                        <div class="text">
                            <p class="name">Pork BBQ</p>
                            <div class="inline">
                                <h2>₱25.00</h3>
                                <p>1 stick</p>
                            </div>
                        </div>
                    </a>
                    <a class="menu-item" >
                        <img src="https://urbanblisslife.com/wp-content/uploads/2021/06/Filipino-Pork-BBQ-FEATURE.jpg" alt="">
                        <div class="text">
                            <p class="name">Pork BBQ</p>
                            <div class="inline">
                                <h2>₱25.00</h3>
                                <p>1 stick</p>
                            </div>
                        </div>
                    </a>
                </section>
            </div>
        </section> -->
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