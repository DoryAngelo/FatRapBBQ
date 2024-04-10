<?php

@include 'constants.php';

$PRSN_ID = $_GET['PRSN_ID'];
$EMP_ID = $_GET['EMP_ID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Edit Employee | Admin</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="admin-styles.css"><!--change css file-->
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
                    <p>ADMIN</p>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
                    <label class='menu-button-container' for="menu-toggle">
                        <div class='menu-button'></div>
                    </label>
                <ul class = 'menubar'>
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
        <section class="section">
            <div class="container">
                <div class="section-heading row back">
                    <h2>Edit Employee Information</h2>
                    <a href="<?php echo SITEURL; ?>admin-employee-accounts.php">Back</a>
                </div>
                <section class="section-body">
                    <section class="main-section column">
                        <form id="form" class="column" method="post" enctype="multipart/form-data">
                            <div class="block layout">
                                <?php
                                $sql = "SELECT * FROM person, employee WHERE employee.PRSN_ID = person.PRSN_ID AND EMP_ID = $EMP_ID";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);
                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $PRSN_ID = $row['PRSN_ID'];
                                        $EMP_IMAGE = $row['EMP_IMAGE'];
                                        $EMP_FNAME = $row['EMP_FNAME'];
                                        $EMP_LNAME = $row['EMP_LNAME'];
                                        $PRSN_NUMBER = $row['PRSN_PHONE'];
                                        $PRSN_NAME = $row['PRSN_NAME'];
                                        $PRSN_EMAIL = $row['PRSN_EMAIL'];
                                ?>
                                <section>
                                    <div class="form-title">
                                        <h1>Contact Information</h1>
                                    </div>
                                    <div class="form-field">
                                        <div class="form-field-input input-control">
                                            <label for="first-name">First Name</label>
                                            <input value="<?php echo $EMP_FNAME ?>" name="first-name" id="first-name" class="js-user" type="text">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input input-control">
                                            <label for="last-name">Last Name</label>
                                            <input value="<?php echo $EMP_LNAME ?>" name="last-name" id="last-name" class="js-user" type="text">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input input-control">
                                            <label for="number">Phone Number</label>
                                            <input value="<?php echo $PRSN_NUMBER ?>" class="js-user" type="text" id="number" name="number">
                                           <div class="error"></div>
                                        </div> 
                                        <!-- <div class="form-field-input input-control">
                                            <label for="email">Email</label>
                                            <input value="<?php echo $PRSN_EMAIL ?>" name="email" id="email" class="js-user" type="text">
                                            <div class="error"></div>
                                        </div> -->
                                        <div class="form-field-input">
                                            <label for="image">Image</label>
                                            <p>(accepted files: .jpg, .png)</p>
                                            <input name="image" id="image" class="image" type="file">
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="form-title">
                                        <h1>Login Credentials</h1>
                                    </div>
                                    <div class="form-field">
                                        <div class="form-field-input input-control">
                                            <label for="username">Username</label>
                                            <input value="<?php echo $PRSN_NAME ?>" name="username" id="username" class="js-user" type="text" >
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input">
                                            <div class="with-desc">
                                                <label for="password">Password</label>
                                                <p>Password must be 8 characters long, and includes at least 1 uppercase, 1 lowercase, 1 digit, and 1 special character</p>
                                            </div>
                                            <div class="input-container input-control">
                                                <input class="js-pass" type="password" id="password" name="password" >
                                                <span onclick="togglePassword('password')">
                                                    <svg class="showpass" id="eyeIconOpenPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z"/></svg>
                                                    <svg class="hidepass" id="eyeIconClosedPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z"/></svg>
                                                </span>
                                                <div class="error"></div>
                                            </div>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="cpassword">Re-enter Password</label>
                                            <div class="input-container input-control">
                                                <input class="js-cpass" type="password" id="cpassword" name="cpassword">
                                                <span onclick="togglePassword('cpassword')">
                                                    <svg class="showpass" id="eyeIconOpenCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z"/></svg>
                                                    <svg class="hidepass" id="eyeIconClosedCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z"/></svg>
                                                </span>
                                                <div class="error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <?php
                                        }
                                    } else {
                                ?>
                                    <p>Empty</p>
                                <?php

                                        }
                                ?>
                            </div>
                            <button name="submit" type="submit" class="big-btn">Save</button>
                        </form>


                        <!--<section class="block">
                            <?php

                            $sql = "SELECT * FROM person, employee WHERE employee.PRSN_ID = person.PRSN_ID AND EMP_ID = $EMP_ID";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $PRSN_ID = $row['PRSN_ID'];
                                    $EMP_IMAGE = $row['EMP_IMAGE'];
                                    $EMP_FNAME = $row['EMP_FNAME'];
                                    $EMP_LNAME = $row['EMP_LNAME'];
                                    $PRSN_NUMBER = $row['PRSN_PHONE'];
                                    $PRSN_NAME = $row['PRSN_NAME'];
                                    $PRSN_EMAIL = $row['PRSN_EMAIL'];
                            ?>
                                    <form action="#" id="form" class="form" method="post" enctype="multipart/form-data">
                                        <section>
                                            <div class="form-title">
                                                <h1>Contact Information</h1>
                                            </div>
                                            <div class="form-field">
                                                <div class="form-field-input input-control">
                                                    <label for="first-name">First Name</label>
                                                    <input value="<?php echo $EMP_FNAME ?>" name="first-name" id="first-name" class="js-user" type="text">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input input-control">
                                                    <label for="last-name">Last Name</label>
                                                    <input value="<?php echo $EMP_LNAME ?>" name="last-name" id="last-name" class="js-user" type="text">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input input-control">
                                                    <label for="number">Phone Number</label>
                                                    <input value="<?php echo $PRSN_NUMBER ?>" class="js-user" type="text" id="number" name="number">
                                                     numbers only, starts with 09, must have 11-digits -->
                                                    <!--<div class="error"></div>
                                                </div> 
                                                <div class="form-field-input input-control">
                                                    <label for="email">Email</label>
                                                    <input value="<?php echo $PRSN_EMAIL ?>" name="email" id="email" class="js-user" type="text">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="image">Image</label>
                                                    <p>(accepted files: .jpg, .png)</p>
                                                    <input name="image" id="image" class="image" type="file">
                                                </div>
                                            </div>
                                        </section>
                                        <div class="line"></div>
                                        <section>
                                            <div class="form-title">
                                                <h1>Login Credentials</h1>
                                            </div>
                                            <div class="form-field">
                                                <div class="form-field-input input-control">
                                                    <label for="username">Username</label>
                                                    <input value="<?php echo $PRSN_NAME ?>" name="username" id="username" class="js-user" type="text" >
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <div class="with-desc">
                                                        <label for="password">Password</label>
                                                        <p>Password must be 8 characters long, and includes at least 1 uppercase, 1 lowercase, 1 digit, and 1 special character</p>
                                                    </div>
                                                    <div class="input-container input-control">
                                                        <input class="js-pass" type="password" id="password" name="password" >
                                                        <span onclick="togglePassword('password')">
                                                            <svg class="showpass" id="eyeIconOpenPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z"/></svg>
                                                            <svg class="hidepass" id="eyeIconClosedPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z"/></svg>
                                                        </span>
                                                        <div class="error"></div>
                                                    </div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="cpassword">Re-enter Password</label>
                                                    <div class="input-container input-control">
                                                        <input class="js-cpass" type="password" id="cpassword" name="cpassword">
                                                        <span onclick="togglePassword('cpassword')">
                                                            <svg class="showpass" id="eyeIconOpenCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z"/></svg>
                                                            <svg class="hidepass" id="eyeIconClosedCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z"/></svg>
                                                        </span>
                                                        <div class="error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                        </section>
                        <button name="submit" type="submit" class="big-btn">Save</button>
                        </form>
                    <?php
                                }
                            } else {
                    ?>
                    <tr>
                        <td colspan="5" class="error">Empty</td>
                    </tr>
                <?php

                            }
                ?>
                    </section>
                </section>
            </div>
        </section>
    </main>
    <script>
        //for eye icon password
        function togglePassword(passwordFieldId) {
            const passwordField = document.getElementById(passwordFieldId);
            const eyeIconOpen = document.getElementById(`eyeIconOpen${passwordFieldId.toUpperCase()}`);
            const eyeIconClosed = document.getElementById(`eyeIconClosed${passwordFieldId.toUpperCase()}`);

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIconOpen.style.display = 'none';
                eyeIconClosed.style.display = 'block';
            } else {
                passwordField.type = 'password';
                eyeIconOpen.style.display = 'block';
                eyeIconClosed.style.display = 'none';
            }
        }

        //input validation
        const form = document.getElementById('form');
        const firstName = document.getElementById('first-name');
        const lastName = document.getElementById('last-name');
        const email = document.getElementById('email');
        const number = document.getElementById('number');
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const password2 = document.getElementById('cpassword');

        form.addEventListener('submit', e => {
            e.preventDefault();

            validateInputs();
        });

        const setError = (element, message) => {
            const inputControl = element.parentElement; //element should have input-control as its parent, with div.error as its sibling
            const errorDisplay = inputControl.querySelector('.error');

            errorDisplay.innerText = message;
            inputControl.classList.add('error');
            inputControl.classList.remove('success')
        }

        const setSuccess = element => {
            const inputControl = element.parentElement;
            const errorDisplay = inputControl.querySelector('.error');

            errorDisplay.innerText = '';
            inputControl.classList.add('success');
            inputControl.classList.remove('error');
        };

        const isValidEmail = email => {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        const validateInputs = () => {
            const firstNameValue = firstName.value.trim();
            const lastNameValue = lastName.value.trim();
            const emailValue = email.value.trim();
            const numberValue = number.value.trim();
            const usernameValue = username.value.trim();
            const passwordValue = password.value.trim();
            const password2Value = password2.value.trim();

            //Regular expressions for input validation
            const nameRegex = /^[a-zA-Z ]+$/; //letters only
            const numberRegex = /^09\d{9}$/; //numbers only
            const uppercaseRegex = /[A-Z]/;
            const lowercaseRegex = /[a-z]/;
            const digitRegex = /\d/;
            const specialCharRegex = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;

            if (firstNameValue === '') {
                setError(firstName, 'Please enter your first name');
            } else if (!nameRegex.test(firstNameValue)) {
                setError(firstName, 'Name must contain only letters');
            } else {
                setSuccess(firstName);
            }

            if (lastNameValue === '') {
                setError(lastName, 'Please enter your last name');
            } else if (!nameRegex.test(lastNameValue)) {
                setError(lastName, 'Name must contain only letters');
            } else {
                setSuccess(lastName);
            }

            if(emailValue === '') {
                setError(email, 'Please enter your email');
            } else if (!isValidEmail(emailValue)) {
                setError(email, 'Provide a valid email address');
            } else {
                setSuccess(email);
            }

            if (numberValue === '') {
                setError(number, 'Please enter your number');
            } else if (!numberRegex.test(numberValue)) {
                setError(number, 'Invalid number');
            } else {
                setSuccess(number);
            }

            if (usernameValue === '') {
                setError(username, 'Please enter your username');
            // } else if (!nameRegex.test(usernameValue)) {
            //     setError(username, 'Invalid username');
            } else if (usernameValue.length < 8 ) {
                setError(username, 'Invalid username');
            } else {
                setSuccess(username);
            }

            if(passwordValue === '') {
                setError(password, 'Please enter your password');
            } else if (passwordValue.length < 8 ) {
                setError(password, 'Password must be at least 8 character.')
            } 
            else if (!uppercaseRegex.test(passwordValue)) {
                setError(password, 'Password must contain at least one uppercase letter.');
            } 
            else if (!lowercaseRegex.test(passwordValue)) {
                setError(password, 'Password must contain at least one lowercase letter.');
            } 
            else if (!digitRegex.test(passwordValue)) {
                setError(password, 'Password must contain at least one digit');
            } 
            else if (!specialCharRegex.test(passwordValue)) {
                setError(password, 'Password must contain at least one special character.');
            } 
            else {
                setSuccess(password);
            }

            if(password2Value === '') {
                setError(password2, 'Please confirm your password');
            } else if (password2Value !== passwordValue) {
                setError(password2, "Password doesn't match");
            } else {
                setSuccess(password2);
            }
        };
    </script>
</body>

</html>

<?php

if (isset($_POST['submit'])) {
    $EMP_FNAME = mysqli_real_escape_string($conn, $_POST['first-name']);
    $EMP_LNAME = mysqli_real_escape_string($conn, $_POST['last-name']);
    $PRSN_EMAIL = mysqli_real_escape_string($conn, $_POST['email']);
    $PRSN_PHONE = $_POST['phone-number'];
    $PRSN_UNAME = mysqli_real_escape_string($conn, $_POST['username']);
    $PRSN_PASSWORD = md5($_POST['password']);
    $PRSN_CPASSWORD = md5($_POST['cpassword']);
    $PRSN_ROLE = 'Employee';
    $current_image = $EMP_IMAGE;

    if (isset($_FILES['image']['name'])) {
        //get the image details
        $EMP_IMG = $_FILES['image']['name'];

        //check whether image is available
        if ($EMP_IMG != "") {
            $image_info = explode(".", $EMP_IMG);
            $ext = end($image_info);

            $EMP_IMG = "EMP_IMAGE_" . $EMP_LNAME . "." . $ext;

            $src = $_FILES['image']['tmp_name'];
            $dst = "images/" . $EMP_IMG;

            $upload    = move_uploaded_file($src, $dst);

            //check whether the image is uploaded
            if ($upload == false) {
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                header('loaction:' . SITEURL . 'admin/manage_food.php');
                die();
            }
            //remove current image if available
            if ($current_image != "") {
                $remove_path = "images/" . $EMP_IMAGE;
                $remove = unlink($remove_path);
                //check whether image is removed
                if ($remove == false) {
                    $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image</div>";
                    header('location:' . SITEURL . 'admin-home.php');
                    die();
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }


    if ($PRSN_PASSWORD != $PRSN_CPASSWORD) {
        $error[] = "Password not matched";
    } else {
        $update = "UPDATE person 
        SET PRSN_NAME = '$PRSN_UNAME',
            PRSN_EMAIL = '$PRSN_EMAIL',
            PRSN_PASSWORD = '$PRSN_PASSWORD',
            PRSN_PHONE = '$PRSN_PHONE'
        WHERE PRSN_ID = $PRSN_ID";

        if (mysqli_query($conn, $update)) {
            $update2 = "UPDATE employee SET
                                        EMP_FNAME = '$EMP_FNAME',
                                        EMP_LNAME = '$EMP_LNAME',
                                        EMP_IMAGE = '$EMP_IMG'
                                        WHERE EMP_ID = $EMP_ID
                                        ";
            if (!mysqli_query($conn, $update2)) {
                $error[] = "Error updating data into employee table: " . mysqli_error($conn);
            }
        } else {
            $error[] = "Error updating data into person table: " . mysqli_error($conn);
        }
    }
}

?>