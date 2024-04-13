<?php

@include 'constants.php';

if (isset($_POST['submit'])) {

    $PRSN_NAME =  mysqli_real_escape_string($conn, $_POST['name']);
    $PRSN_EMAIL =  mysqli_real_escape_string($conn, $_POST['email']);
    $PRSN_PHONE = str_replace(' ', '', $_POST['number']);
    $PRSN_PASSWORD =  md5($_POST['password']);
    $PRSN_CPASSWORD =  md5($_POST['cpassword']);
    $PRSN_ROLE = 'Customer';

    $select = " SELECT * FROM `person` WHERE PRSN_EMAIL = '$PRSN_EMAIL' && PRSN_NAME= '$PRSN_NAME' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $error[] = "User already exists";
    } else {
        if ($PRSN_PASSWORD != $PRSN_CPASSWORD) {
            $error[] = "Password not matched";
        } else {
            $insert = "INSERT INTO person(PRSN_NAME, PRSN_EMAIL, PRSN_PASSWORD, PRSN_PHONE, PRSN_ROLE) 
			VALUES('$PRSN_NAME', '$PRSN_EMAIL',	'$PRSN_PASSWORD',	'$PRSN_PHONE', '$PRSN_ROLE')";
            mysqli_query($conn, $insert);
            header('location:login-page.php');
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
                <form action="#" class="form reg-form" method="post" onsubmit="return validateInputs()">
                    <div class="form-title">
                        <h1>Register</h1>
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
                                <small>Password must be 8 characters long, and include at least 1 uppercase, 1 lowercase, and 1 digit</small>
                            </div>
                            <div class="input-container input-control">
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
                            </div>
                        </div>
                        <div class="form-field-input">
                            <label for="cpassword">Re-enter Password</label>
                            <div class="input-container input-control">
                                <input class="js-cpass" type="password" id="cpassword" name="cpassword">
                                <div class="error"></div> <!-- Error message for confirm password -->
                                <span onclick="togglePassword('cpassword')">
                                    <svg class="showpass" id="eyeIconOpenCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                    </svg>
                                    <svg class="hidepass" id="eyeIconClosedCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
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

    function setError(input, message) {
        const errorDiv = input.nextElementSibling;
        errorDiv.innerHTML = `<span class="error-text">${message}</span>`;
    }

    function clearError(input) {
        const errorDiv = input.nextElementSibling;
        errorDiv.innerHTML = ''; // Clear the error message
    }

    function validateInputs() {
        let isValid = true;

        const nameValue = nameInput.value.trim();
        const emailValue = emailInput.value.trim();
        const numberValue = numberInput.value.trim();
        const passwordValue = passwordInput.value.trim();
        const cpasswordValue = cpasswordInput.value.trim();

        const nameRegex = /^[a-zA-Z\s]+$/;
        const numberRegex = /^(?! )\S*(?<! )09\d{9}$/;
        const passwordRegex = /^(?=.*\d)[a-zA-Z0-9]{8,}$/; // Password should not contain special characters
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Email must contain an '@'

        if (nameValue === '') {
            setError(nameInput, 'Please enter your name');
            isValid = false;
        } else if (!nameRegex.test(nameValue)) {
            setError(nameInput, 'Name must contain only letters');
            isValid = false;
        } else {
            clearError(nameInput);
        }

        if (emailValue === '') {
            setError(emailInput, 'Please enter your email');
            isValid = false;
        } else if (!emailRegex.test(emailValue)) {
            setError(emailInput, 'Invalid email format');
            isValid = false;
        } else {
            clearError(emailInput);
        }

        if (numberValue === '') {
            setError(numberInput, 'Please enter your number');
            isValid = false;
        } else if (!numberRegex.test(numberValue)) {
            setError(numberInput, 'Invalid number');
            isValid = false;
        } else {
            clearError(numberInput);
        }

        if (passwordValue === '') {
            setError(passwordInput, 'Please enter your password');
            isValid = false;
        } else if (!passwordRegex.test(passwordValue)) {
            setError(passwordInput, 'Invalid password format');
            isValid = false;
        } else {
            clearError(passwordInput);
        }

        if (cpasswordValue === '') {
            setError(cpasswordInput, 'Please confirm your password');
            isValid = false;
        } else if (cpasswordValue !== passwordValue) {
            setError(cpasswordInput, 'Passwords do not match');
            isValid = false;
        } else {
            clearError(cpasswordInput);
        }

        return isValid;
    }
</script>
    <footer>
        <div class="footer-container">
            <div class="left-container">
                <h1>Fat Rap's Barbeque's Online Store</h1>
                <div class="list">
                    <ul>
                        <li><a href="#">Home</a></li>
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