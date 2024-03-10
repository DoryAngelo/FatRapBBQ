<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password reset | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="success-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
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
        </div>
    </header>
    <main>
        <div class="success-box reset-style">
            <div class="center">
                <div class="success-title">
                    <h1>Success!</h1>
                    <p class="title-desc"><i>Your password has been changed.</i></p>
                </div>
                <p class="small-text"><i>Click here to <a class="login-link" href="login-page.php">Login</a></i></p>
            </div>
        </div> 
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

