<?php

@include 'constants.php';

$PRSN_ROLE = $_SESSION['prsn_role'];
if ($PRSN_ROLE !== 'Admin') {
    header('location:' . SITEURL . 'login-page.php');
}

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
            <ul class='menubar'>
                <li><a href="<?php echo SITEURL; ?>admin-home.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-inventory.php">Menu</a></li>
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
                <style>
                    .error-text {
                        color: red;
                        font-size: 12px;
                    }
                </style>
                <section class="section-body">
                    <section class="main-section column">
                        <form id="form" class="column" method="post" enctype="multipart/form-data" onsubmit="return validateInputs()">
                            <div class="block layout">
                                <?php
                                $sql = "SELECT * FROM person, employee WHERE employee.PRSN_ID = person.PRSN_ID AND EMP_ID = '$EMP_ID'";
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
                                        $PRSN_ROLE = $row['PRSN_ROLE'];
                                        $EMP_BRANCH = $row['EMP_BRANCH'];
                                        $EMP_STATUS = $row['EMP_STATUS'];
                                ?>
                                        <section>
                                            <?php
                                            if (isset($_SESSION['error_message'])) {
                                                echo "<div class='error-text'>" . $_SESSION['error_message'] . "</div>";
                                                unset($_SESSION['error_message']);
                                            }
                                            ?>
                                            <div class="form-title">
                                                <?php
                                                if (isset($_SESSION['error_message'])) {
                                                    echo "<div class='error-text'>" . $_SESSION['error_message'] . "</div>";
                                                    unset($_SESSION['error_message']);
                                                }
                                                ?>
                                                <h1>Contact Information</h1>
                                                <div class="error"></div>
                                            </div>
                                            <div class="form-field">
                                                <div class="form-field-input input-control">
                                                    <label for="first-name">First Name</label>
                                                    <input name="first-name" id="first-name" class="js-user" type="text" value="<?php echo $EMP_FNAME; ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input input-control">
                                                    <label for="last-name">Last Name</label>
                                                    <input name="last-name" id="last-name" class="js-user" type="text" value="<?php echo $EMP_LNAME; ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input input-control">
                                                    <label for="number">Phone Number</label>
                                                    <p>(e.g. 09xxxxxxxxx)</p>
                                                    <input class="js-user" type="text" id="number" name="number" value="<?php echo $PRSN_NUMBER; ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input input-control">
                                                    <label for="branch">Branch</label>
                                                    <input name="branch" id="branch" class="js-user" type="text" value="<?php echo $EMP_BRANCH; ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="role">Role</label>
                                                    <select class="dropdown" name="role" id="role" required>
                                                        <option value="Employee" <?php if ($PRSN_ROLE == 'Employee') echo ' selected'; ?>>Employee</option>
                                                        <option value="Admin" <?php if ($PRSN_ROLE == 'Admin') echo ' selected'; ?>>Admin</option>
                                                    </select>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="role">Status</label>
                                                    <select class="dropdown" name="status" id="status" required>
                                                        <option value="Active" <?php if ($EMP_STATUS == 'Active') echo ' selected'; ?>>Active</option>
                                                        <option value="Inactive" <?php if ($EMP_STATUS == 'Inactive') echo ' selected'; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="image">Image</label>
                                                    <p>(accepted files: .jpg, .png)</p>
                                                    <input name="image" id="image" class="image" type="file">
                                                    <div class="error"></div>
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
                                                    <p>Username should exclude special characters.</p>
                                                    <input name="username" id="username" class="js-user" type="text" value="<?php echo $PRSN_EMAIL; ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <div class="with-desc">
                                                        <label for="password">Password</label>
                                                        <p>Password at least 8 characters long. Include at least 1 uppercase, 1 lowercase, and 1 digit. Exclude special characters.</p>
                                                    </div>
                                                    <div class="input-container input-control">
                                                        <input class="js-pass" type="password" id="password" name="password">
                                                        <div class="error"></div>
                                                        <span onclick="togglePassword('password')">
                                                            <svg class="showpass" id="eyeIconClosedPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                                            </svg>
                                                            <svg class="hidepass" id="eyeIconOpenPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="cpassword">Re-enter Password</label>
                                                    <div class="input-container input-control">
                                                        <input class="js-cpass" type="password" id="cpassword" name="cpassword">
                                                        <div class="error"></div>
                                                        <span onclick="togglePassword('cpassword')">
                                                            <svg class="showpass" id="eyeIconClosedCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                                            </svg>
                                                            <svg class="hidepass" id="eyeIconOpenCPASSWORD" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z" />
                                                            </svg>
                                                        </span>
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
                        <script>
                            // Function to check for new orders via AJAX
                            function checkForNewOrders() {
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        if (this.responseText.trim() === "NewOrder") {
                                            notifyNewOrder(); // Play notification sound
                                        }
                                    }
                                };
                                xhttp.open("GET", "order-notification.php", true);
                                xhttp.send();
                            }

                            // Function to play notification sound
                            function notifyNewOrder() {
                                var audio = new Audio('sound/notification.mp3'); // Replace with correct path
                                audio.play();
                            }

                            // Check for new orders every 5 seconds 
                            setInterval(checkForNewOrders, 2000);
                        </script>
                        <script>
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

                            const firstNameInput = document.getElementById('first-name');
                            const lastNameInput = document.getElementById('last-name');
                            const numberInput = document.getElementById('number');
                            const branchInput = document.getElementById('branch');
                            const usernameInput = document.getElementById('username');
                            const passwordInput = document.getElementById('password');
                            const cpasswordInput = document.getElementById('cpassword');
                            const imageInput = document.getElementById('image');

                            firstNameInput.addEventListener('input', validateFirstName);
                            lastNameInput.addEventListener('input', validateLastName);
                            numberInput.addEventListener('input', validateNumber);
                            branchInput.addEventListener('input', validateBranch);
                            usernameInput.addEventListener('input', validateUsername);
                            passwordInput.addEventListener('input', validatePassword);
                            cpasswordInput.addEventListener('input', validateConfirmPassword);
                            imageInput.addEventListener('change', validateImage);

                            function setError(input, message) {
                                const errorDiv = input.nextElementSibling;
                                errorDiv.innerHTML = `<span class="error-text">${message}</span>`;
                                console.log("Error set:", message);
                            }

                            function clearError(input) {
                                const errorDiv = input.nextElementSibling;
                                if (errorDiv) {
                                    errorDiv.innerHTML = ''; // Clear the error message
                                    console.log("Error cleared");
                                }
                            }



                            function validateFirstName() {
                                const firstNameValue = firstNameInput.value.trim();
                                const nameRegex = /^[a-zA-Z\s]+$/;

                                if (firstNameValue === '') {
                                    setError(firstNameInput, 'Please enter your first name');
                                } else if (!nameRegex.test(firstNameValue)) {
                                    setError(firstNameInput, 'First name must contain only letters');
                                } else {
                                    clearError(firstNameInput);
                                }
                            }

                            function validateLastName() {
                                const lastNameValue = lastNameInput.value.trim();
                                const nameRegex = /^[a-zA-Z\s]+$/;

                                if (lastNameValue === '') {
                                    setError(lastNameInput, 'Please enter your last name');
                                } else if (!nameRegex.test(lastNameValue)) {
                                    setError(lastNameInput, 'Last name must contain only letters');
                                } else {
                                    clearError(lastNameInput);
                                }
                            }

                            function validateNumber() {
                                const numberValue = numberInput.value.trim();
                                const numberRegex = /^(?!\s)(09\d{9})$/;

                                if (numberValue === '') {
                                    setError(numberInput, 'Please enter your number');
                                } else if (!numberRegex.test(numberValue)) {
                                    setError(numberInput, 'Invalid number');
                                } else {
                                    clearError(numberInput);
                                }
                            }



                            function validateBranch() {
                                const branchValue = branchInput.value.trim();

                                if (branchValue === '') {
                                    setError(branchInput, 'Please enter your branch');
                                } else {
                                    clearError(branchInput);
                                }
                            }

                            function validateUsername() {
                                const usernameValue = usernameInput.value.trim();
                                const usernameRegex = /^[a-zA-Z0-9]+$/;

                                if (usernameValue === '') {
                                    setError(usernameInput, 'Please enter your username');
                                } else if (!usernameRegex.test(usernameValue)) {
                                    setError(usernameInput, 'Invalid username format');
                                } else {
                                    clearError(usernameInput);
                                }
                            }

                            function validatePassword() {
                                const passwordValue = passwordInput.value.trim();
                                const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,}$/;

                                if (passwordValue === '') {
                                    clearError(passwordInput);
                                    return;
                                }

                                if (!passwordRegex.test(passwordValue)) {
                                    setError(passwordInput, 'Invalid password format');
                                } else {
                                    clearError(passwordInput);
                                }
                            }

                            function validateConfirmPassword() {
                                const cpasswordValue = cpasswordInput.value.trim();
                                const passwordValue = passwordInput.value.trim();

                                if (cpasswordValue === '') {
                                    clearError(cpasswordValue);
                                    return;
                                }

                                if (cpasswordValue !== passwordValue) {
                                    setError(cpasswordInput, 'Passwords do not match');
                                } else {
                                    clearError(cpasswordInput);
                                }
                            }

                            function validateImage() {
                                const imageValue = imageInput.value.trim();

                                // Check if the input field is empty
                                if (imageValue === '') {
                                    // Clear error message if input is empty
                                    clearError(imageInput);
                                    return; // Exit the function without further validation
                                }

                                // Check if file extension is valid
                                const validExtensions = ['png', 'jpg', 'jpeg'];
                                const fileExtension = imageValue.split('.').pop().toLowerCase();

                                if (!validExtensions.includes(fileExtension)) {
                                    setError(imageInput, 'Only PNG, JPG, and JPEG files are allowed');
                                } else {
                                    clearError(imageInput);
                                }
                            }

                            function validateInputs() {
                                validateFirstName();
                                validateLastName();
                                validateNumber();
                                validateBranch();
                                validateUsername();
                                validatePassword();
                                validateConfirmPassword();
                                validateImage();

                                console.log("Form submission intercepted for validation");
                                const errors = document.querySelectorAll('.error-text');
                                if (errors.length > 0) {
                                    return false; // Prevent form submission if there are errors
                                }
                                return true; // Allow form submission if there are no errors
                            }
                        </script>
                        <?php

                        if (isset($_POST['submit'])) {

                            $EMP_FNAME = mysqli_real_escape_string($conn, trim($_POST['first-name']));
                            $EMP_LNAME = mysqli_real_escape_string($conn, trim($_POST['last-name']));
                            $EMP_BRANCH =  $_POST['branch'];
                            $PRSN_PHONE = str_replace(' ', '', $_POST['number']);
                            $PRSN_UNAME = mysqli_real_escape_string($conn, trim($_POST['username']));
                            $PRSN_ROLE = $_POST['role'];
                            $EMP_STATUS = $_POST['status'];
                            $current_image = $EMP_IMAGE;

                            // Check if a new image is uploaded
                            if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                                // Get the image details
                                $EMP_IMG = $_FILES['image']['name'];

                                // Check if the uploaded file is an image
                                $image_info = getimagesize($_FILES['image']['tmp_name']);
                                if ($image_info === false) {
                                    // Handle non-image files here
                                    $_SESSION['upload'] = "<div class='error'>Please upload a valid image file</div>";
                                    header('location:' . $_SERVER['PHP_SELF'] . '?EMP_ID=' . $EMP_ID);
                                    exit();
                                }

                                // Generate a unique filename for the image
                                $image_info = pathinfo($EMP_IMG);
                                $ext = strtolower($image_info['extension']);
                                $EMP_IMG = "EMP_IMAGE_" . $PRSN_UNAME . "_" . uniqid() . "." . $ext;

                                // Set the destination path for the uploaded image
                                $dst = "images/" . $EMP_IMG;

                                // Upload the image
                                if (!move_uploaded_file($_FILES['image']['tmp_name'], $dst)) {
                                    // Handle upload failure
                                    $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                                    header('location:' . $_SERVER['PHP_SELF'] . '?EMP_ID=' . $EMP_ID);
                                    exit();
                                }

                                // Remove the previous image if it exists
                                if (!empty($current_image)) {
                                    $remove_path = "images/" . $current_image;
                                    if (!unlink($remove_path)) {
                                        // Handle image removal failure
                                        $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image</div>";
                                        header('location:' . SITEURL . 'admin-home.php');
                                        exit();
                                    }
                                }
                            } else {
                                // No new image uploaded, retain the current image
                                $EMP_IMG = $current_image;
                            }

                            // Check if password is provided
                            if (!empty($_POST['password'])) {
                                $PRSN_PASSWORD = md5($_POST['password']);
                                $updatePassword = "PRSN_PASSWORD = '$PRSN_PASSWORD',";
                            } else {
                                $updatePassword = ""; // If no password is provided, leave the password unchanged
                            }

                            $PRSN_NAME = $EMP_FNAME . " " . $EMP_LNAME;

                            $select = "SELECT * FROM `person` WHERE PRSN_EMAIL = '$PRSN_UNAME' AND PRSN_ID != '$PRSN_ID'";

                            $result = mysqli_query($conn, $select);

                            if (mysqli_num_rows($result) > 0) {
                                $errorMessage = "User already exists!";
                                echo "<script>document.querySelector('.error').innerHTML = '<span class=\"error-text\">$errorMessage</span>';</script>";
                            } else {
                                // Update the person table
                                $updatePerson = "UPDATE person 
                    SET PRSN_NAME = '$PRSN_NAME',
                        PRSN_EMAIL = '$PRSN_UNAME',
                        $updatePassword
                        PRSN_PHONE = '$PRSN_PHONE',
                        PRSN_ROLE = '$PRSN_ROLE'
                    WHERE PRSN_ID = $PRSN_ID";

                                if (mysqli_query($conn, $updatePerson)) {
                                    // Update the employee table
                                    $updateEmployee = "UPDATE employee 
                            SET EMP_FNAME = '$EMP_FNAME',
                                EMP_LNAME = '$EMP_LNAME',
                                EMP_IMAGE = '$EMP_IMG',
                                EMP_BRANCH = '$EMP_BRANCH',
                                EMP_STATUS = '$EMP_STATUS'
                            WHERE EMP_ID = $EMP_ID";

                                    if (!mysqli_query($conn, $updateEmployee)) {
                                        $error[] = "Error updating data into employee table: " . mysqli_error($conn);
                                    }
                                } else {
                                    $error[] = "Error updating data into person table: " . mysqli_error($conn);
                                }

                                // Redirect to employee accounts page
                                echo "<script> window.location.href = 'admin-employee-accounts.php'; </script>";
                                exit();
                            }
                        }

                        ?>