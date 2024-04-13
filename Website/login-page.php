<?php
@include 'constants.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    $loginValue = $_POST['login_value'];

    // Check if the input value contains an "@" symbol
    if (strpos($loginValue, '@') !== false) {
        $identifier = 'email';
    } else {
        $identifier = 'username';
    }

    $loginValue = mysqli_real_escape_string($conn, $loginValue);
    $PRSN_PASSWORD =  md5($_POST['password']);

    // Modify the SQL query to check either email or username based on the identified type
    if ($identifier === 'email') {
        $select = "SELECT * FROM `person` WHERE PRSN_EMAIL = '$loginValue' && PRSN_PASSWORD = '$PRSN_PASSWORD'";
    } else {
        $select = "SELECT * FROM `person` WHERE PRSN_NAME = '$loginValue' && PRSN_PASSWORD = '$PRSN_PASSWORD'";
    }

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);
        $PRSN_ROLE = $row['PRSN_ROLE'];
        $_SESSION['prsn_id'] = $row['PRSN_ID'];
        $_SESSION['prsn_role'] = $row['PRSN_ROLE'];

        if ($PRSN_ROLE == "Customer" || $PRSN_ROLE == "Wholesaler") {
            header('location:cus-home-page.php');
        } else if ($PRSN_ROLE == "Admin") {
            header('location:admin-home.php');
        } else {
            header('location:employee-home.php');
        }
    } else {
        $_SESSION['error_message'] = "Incorrect email or password";
        header('Location: login-page.php');
    }
} else if (isset($_POST['guest'])) {
    header('location:home.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="login-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="input-validation.js" defer></script>
    <!-- add the code below to load the icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque</h1>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section class="section">
            <div class="green-block">
                <div class="green-block-text">
                    <p class="welcome-text">WELCOME TO </p>
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                </div>
                <form action="#" class="form login-form" method="post" onsubmit="return validateLogin()">
                    <div class="form-title">
                        <h1>Log in</h1>
                        <?php
                        if (isset($_SESSION['error_message'])) {
                            echo "<div class='error'>" . $_SESSION['error_message'] . "</div>";
                            unset($_SESSION['error_message']);
                        }
                        ?>
                    </div>
                    <div class="form-field">
                        <div class="form-field-input">
                            <label for="login_value">Email or Username</label>
                            <input name="login_value" id="login_value" class="js-user" type="text">
                            <div class="error"></div> <!-- Error message for login value -->
                        </div>
                        <div class="form-field-input">
                            <label for="password">Password</label>
                            <input class="js-pass" type="password" id="password" name="password">
                            <div class="error"></div> <!-- Error message for password -->
                            <span onclick="togglePassword('password')">
                                <svg class="showpass" id="eyeIconOpenPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                </svg>
                                <svg class="hidepass" id="eyeIconClosedPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z" />
                                </svg>
                            </span>
                            <div class="remember-and-forgot-block">
                                <div class="checkbox">
                                    <input id="remember-me" type="checkbox">
                                    <label for="remember-me">Remember me</label>
                                </div>
                                <a class="forget-pass" href="<?php echo SITEURL; ?>forgot-password.php">Forgot Password?</a>
                            </div>
                        </div>

                        <div class="button-group">
                            <button name="submit" type="submit" class="primary-btn" onclick="clearErrorMessage()">Login</button>
                            <?php
                            $random = random_bytes(16);
                            $GUEST_ID = bin2hex($random);
                            $_SESSION['guest_id'] =   $GUEST_ID;
                            ?>
                            <a href="cus-home-page.php?GUEST_ID=<?php echo $GUEST_ID ?>" class="secondary-btn">Login as Guest</a>
                            <p class="small-text">Don't have an account? <a class="login-link" href="cus-register-page.php">Register</a></p>
                        </div>

                    </div>
                </form>
                <script>
                    const loginInput = document.getElementById('login_value');
                    const passwordInput = document.getElementById('password'); // Add password input

                    function setError(input, message) {
                        const errorDiv = input.nextElementSibling;
                        errorDiv.innerHTML = `<span class="error-text">${message}</span>`;
                    }

                    function clearError(input) {
                        const errorDiv = input.nextElementSibling;
                        errorDiv.innerHTML = ''; // Clear the error message
                    }

                    function clearErrorMessage() {
                        const errorDivs = document.querySelectorAll('.error');
                        errorDivs.forEach(div => div.innerHTML = '');
                    }


                    function validateLogin() {
                        let isValid = true;

                        const loginValue = loginInput.value.trim();
                        const passwordValue = passwordInput.value.trim();

                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        const passwordRegex = /^(?=.*\d)[a-zA-Z0-9]{8,}$/; // Password should not contain special characters

                        if (loginValue === '') { // Check if login value is empty
                            setError(loginInput, 'Please enter your email or username');
                            isValid = false;
                        } else if (loginValue.includes('@')) { // Check if login value contains '@' symbol
                            if (!emailRegex.test(loginValue)) {
                                setError(loginInput, 'Invalid email format');
                                isValid = false;
                            } else {
                                clearError(loginInput);
                            }
                        } else { // Assume it's a username
                            clearError(loginInput);
                        }
                        if (passwordValue === '') {
                            setError(passwordInput, 'Please enter your password');
                            isValid = false;
                        } else if (!passwordRegex.test(passwordValue)) {
                            setError(passwordInput, 'Password should be at least 8 characters long and contain only alphanumeric characters');
                            isValid = false;
                        } else {
                            clearError(passwordInput);
                        }

                        if (!isValid) {
                            return false;
                        }
                    }
                </script>
            </div>
        </section>

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