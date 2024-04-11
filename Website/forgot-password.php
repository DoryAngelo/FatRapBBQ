<?php

@include 'constants.php';

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="forgot-password-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
    <!-- <script src="app.js" defer></script> -->
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
        <form action="email-success.php" id="form" class="form forgot-pass-form" method="post"> <!--should go to email-success.php-->
            <div class="form-title">
                <h1>Forgot Password?</h1>
                <p class="title-desc"><i>Enter your email so we can send a link to reset your password.</i></p>
            </div>
            <div class="form-field">
                <div class="form-field-input">
                    <label for="email">Email</label>
                    <input name="email" id="email" class="js-user" type="text">
                </div>
                <p class="error"></p>
                <button type="submit" class="primary-btn">Send</button>
                <!-- <span class="divider">Or</span> -->
                <a href="login-page.php" class="back-btn">Back to Login</a>
                <a href="<?php echo SITEURL; ?>reset-password.php">go to reset page</a>
            </div>
        </form> 
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
                        <i class='bx bxl-instagram' ></i>
                    </a>
                </div>
                <div class="list">
                    <div class="list-items">
                        <i class='bx bxs-envelope' ></i>
                        <p>email@gmail.com</p>
                    </div>
                    <div class="list-items">
                        <i class='bx bxs-phone'></i>
                        <p>0912 345 6789 | 912 1199</p>
                    </div>
                    <div class="list-items">
                        <i class='bx bxs-map' ></i>
                        <p>123 Magaling St., Brgy. Something, Somewhere City</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script defer>
        const form = document.getElementById('form');
        const email = document.getElementById('email');
        const errorDisplay = document.querySelector('.error');

        form.addEventListener('submit', e => {
            e.preventDefault();

            validateInputs();
        });

        const setError = (message) => {
            errorDisplay.innerText = message;
        };

        const setSuccess = () => {
            errorDisplay.innerText = '';
        };

        const isValidEmail = (email) => {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        };

        const validateInputs = () => {
            const emailValue = email.value.trim();

            if(emailValue === '') { //empty email field
                setError('Please enter your email address');
            } else {
                //temporary code
                    setSuccess();
                    if (!isValidEmail(emailValue)) {//check if input is NOT in email format
                        setError('Email address is invalid');
                    } 
                    //else: check email address is not found in the database

                //end of temporary code

                // for security reason, make AJAX request to PHP script 
                // const xhr = new XMLHttpRequest();
                // xhr.open('POST', 'validate_credentials.php'); //this file will handle the validation stuff and connect from the database
                // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                // xhr.onload = function() {
                //     if (xhr.status === 200) {
                //         const response = JSON.parse(xhr.responseText);
                //         if (response.success) {
                //             setSuccess();
                //         } else {
                //             setError(response.message);
                //         }
                //     }
                // };
                // xhr.send(`email=${encodeURIComponent(emailValue)}&password=${encodeURIComponent(passwordValue)}`);
            }
        };
    </script>
</body>
</html>

