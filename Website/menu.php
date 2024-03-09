<!-- customer menu page -->
<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

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

<body>
    <header>
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                </div>
            </div>
            <nav>
                <ul>
                    <!--TODO: ADD LINKS-->
                    <li><a href="cus-home-page.php">Home</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
                    <!-- Text below should change to 'Logout'once user logged in-->
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
            </nav>
        </div>
    </header>
    <main>
        <section class="section menu">
            <div class="section-heading">
                <h2>Menu</h2>
            </div>
            <section class="section-body">
            <?php

            $sql = "SELECT * FROM food WHERE FOOD_ACTIVE = 'Yes'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $FOOD_ID = $row['FOOD_ID'];
                    $FOOD_NAME = $row['FOOD_NAME'];
                    $FOOD_IMG = $row['FOOD_IMG'];
                    $FOOD_PRICE = $row['FOOD_PRICE'];
            ?>
                    <a class="menu-item" href="<?php echo SITEURL; ?>product-info.php?FOOD_ID=<?php echo $FOOD_ID?>">
                        <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                        <div class="text">
                            <p class="name"><?php echo $FOOD_NAME?></p>
                            <div class="inline">
                                <h2>₱<?php echo $FOOD_PRICE ?></h3>
                                    <p>1 stick</p>
                            </div>
                        </div>
                    </a>
            <?php
                }
            }
            ?>
            </section>
        </section>
        <!-- <section class="section menu">
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
            </section>
        </section> -->
    </main>
    <footer>
        <div class="footer-container">
            <div class="left-container">
                <h1>Fat Rap's Barbeque's Online Store</h1>
                <div class="list">
                    <ul>
                        <li><a href="<?php echo SITEURL; ?>cus-home-page.php">Home</a></li>
                        <li><a href="<?php echo SITEURL; ?>menu.php">Menu</a></li>
                        <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
                        <li><a href="<?php echo SITEURL; ?>track-order.php">Track order</a></li>
                    </ul>
                </div>
            </div>
            <div class="right-container">
                <div class="icons-block">
                    <a href="https://www.youtube.com/">
                        <i class='bx bxl-facebook-circle'></i>
                    </a>
                    <a href="https://www.youtube.com/">
                        <i class='bx bxl-tiktok'></i>
                    </a>
                    <a href="https://www.youtube.com/">
                        <i class='bx bxl-instagram'></i>
                    </a>
                </div>
                <div class="list">
                    <div class="list-items">
                        <i class='bx bxs-envelope'></i>
                        <p>email@gmail.com</p>
                    </div>
                    <div class="list-items">
                        <i class='bx bxs-phone'></i>
                        <p>0912 345 6789 | 912 1199</p>
                    </div>
                    <div class="list-items">
                        <i class='bx bxs-map'></i>
                        <p>123 Magaling St., Brgy. Something, Somewhere City</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>