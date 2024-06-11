<?php

@include 'constants.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    $PRSN_NAME =  mysqli_real_escape_string($conn, trim($_POST['name']));
    $PRSN_EMAIL =  mysqli_real_escape_string($conn, trim($_POST['email']));
    $PRSN_PHONE = str_replace(' ', '', $_POST['number']);
    $PRSN_PASSWORD =  md5($_POST['password']);
    $PRSN_CPASSWORD =  md5($_POST['cpassword']);
    $PRSN_ROLE = 'Customer';

    $select = "SELECT * FROM `person` WHERE PRSN_EMAIL = '$PRSN_EMAIL' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        // User already exists, set error message in session
        $_SESSION['error_message'] = "User already exists";
        header('Location: cus-register-page.php');
        exit();
    } else {
        $insert = "INSERT INTO person(PRSN_NAME, PRSN_EMAIL, PRSN_PASSWORD, PRSN_PHONE, PRSN_ROLE) 
            VALUES('$PRSN_NAME', '$PRSN_EMAIL', '$PRSN_PASSWORD', '$PRSN_PHONE', '$PRSN_ROLE')";
        mysqli_query($conn, $insert);
        header('Location: registration-success.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="cus-reg-styles.css">
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
                <style>
                    .error-text {
                        color: red;
                        font-size: 12px;
                    }
                </style>
                <form action="" class="form reg-form" method="post" onsubmit="return validateInputs()">
                    <div class="form-title">
                        <h1>Register</h1>
                        <?php
                        if (isset($_SESSION['error_message'])) {
                            echo "<div class='error-text'>" . $_SESSION['error_message'] . "</div>";
                            unset($_SESSION['error_message']);
                        }
                        ?>
                    </div>
                    <div class="form-field">
                        <div class="form-field-input input-control">
                            <label for="name">Name</label>
                            <input class="js-user" type="text" id="name" name="name"><!-- 20 characters only, letter only, with spaces -->
                            <div class="error"></div>
                        </div>
                        <div class="form-field-input input-control">
                            <label for="email">Email</label>
                            <input name="email" id="email" class="js-user" type="text">
                            <div class="error"></div>
                        </div>
                        <div class="form-field-input input-control">
                            <div class="with-desc">
                                <label for="number">Phone Number </label>
                                <small>(e.g. 09xxxxxxxxx)</small>
                            </div>
                            <input class="js-user" type="text" id="number" name="number"><!-- numbers only, starts with 09, must have 11-digits -->
                            <div class="error"></div>
                        </div>
                        <div class="form-field-input">
                            <div class="with-desc">
                                <label for="password">Password</label>
                                <small>Password at least 8 characters long. Include at least 1 uppercase, 1 lowercase, and 1 digit. Exclude special characters.</small>
                            </div>
                            <div class="input-container input-control">
                                <input class="js-pass" type="password" id="password" name="password">
                                <div class="error"></div> <!-- Error message for password -->
                                <span onclick="togglePassword('password')">
                                    <svg class="hidepass" id="eyeIconClosedPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                    </svg>
                                    <svg class="showpass" id="eyeIconOpenPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="form-field-input">
                            <label for="cpassword">Re-enter Password</label>
                            <div class="input-container input-control">
                                <input class="js-cpass" type="password" id="cpassword" name="cpassword">
                                <div class="error"></div> <!-- Error message for confirm password -->
                                <span onclick="togglePassword('cpassword')">
                                    <svg class="hidepass" id="eyeIconClosedCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                    </svg>
                                    <svg class="showpass" id="eyeIconOpenCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <button class="primary-btn" type="submit" name="submit">Register</button>
                        <p class="small-text">Already have an account? <a class="login-link" href="login-page.php">Login</a></p>
                    </div>
                </form>
            </div>
        </section>

    </main>
    <script>
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const numberInput = document.getElementById('number');
        const passwordInput = document.getElementById('password');
        const cpasswordInput = document.getElementById('cpassword');

        nameInput.addEventListener('input', validateName);
        emailInput.addEventListener('input', validateEmail);
        numberInput.addEventListener('input', validateNumber);
        passwordInput.addEventListener('input', validatePassword);
        cpasswordInput.addEventListener('input', validateConfirmPassword);

        function setError(input, message) {
            const errorDiv = input.nextElementSibling;
            errorDiv.innerHTML = `<span class="error-text">${message}</span>`;
        }

        function clearError(input) {
            const errorDiv = input.nextElementSibling;
            errorDiv.innerHTML = ''; // Clear the error message
        }

        function validateInputs() {
            validateName();
            validateEmail();
            validateNumber();
            validatePassword();
            validateConfirmPassword();

            // Check if any error exists
            const errors = document.querySelectorAll('.error-text');
            if (errors.length > 0) {
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        function validateName() {
            const nameValue = nameInput.value.trim();
            const nameRegex = /^[a-zA-Z\s]+$/;

            if (nameValue === '') {
                setError(nameInput, 'Please enter your name');
            } else if (!nameRegex.test(nameValue)) {
                setError(nameInput, 'Name must contain only letters');
            } else {
                clearError(nameInput);
            }
        }

        function validateEmail() {
            const emailValue = emailInput.value.trim();
            const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]+$/;

            if (emailValue === '') {
                setError(emailInput, 'Please enter your email');
            } else if (!emailRegex.test(emailValue)) {
                setError(emailInput, 'Invalid email format');
            } else {
                clearError(emailInput);
            }
        }

        function validateNumber() {
            const numberValue = numberInput.value.trim();
            const numberRegex = /^(?! )\S*(?<! )09\d{9}$/;

            if (numberValue === '') {
                setError(numberInput, 'Please enter your number');
            } else if (!numberRegex.test(numberValue)) {
                setError(numberInput, 'Invalid number');
            } else {
                clearError(numberInput);
            }
        }

        function validatePassword() {
            const passwordValue = passwordInput.value.trim();
            const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,}$/;

            if (passwordValue === '') {
                setError(passwordInput, 'Please enter your password');
            } else if (!passwordRegex.test(passwordValue)) {
                setError(passwordInput, 'Invalid password format');
            } else {
                clearError(passwordInput);
            }
        }

        function validateConfirmPassword() {
            const cpasswordValue = cpasswordInput.value.trim();
            const passwordValue = passwordInput.value.trim();

            if (cpasswordValue === '') {
                setError(cpasswordInput, 'Please confirm your password');
            } else if (cpasswordValue !== passwordValue) {
                setError(cpasswordInput, 'Passwords do not match');
            } else {
                clearError(cpasswordInput);
            }
        }
    </script>

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