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
    <title>Edit Profile | Admin</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="admin-styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        <style>
            .error-text {
                color: red;
                font-size: 12px;
            }
        </style>
        <section class="section add-edit-menu">
            <div class="container">
                <div class="section-wrapper">
                    <div class="section-heading row back">
                        <h2>Edit Profile</h2>

                        <a href="<?php echo SITEURL; ?>admin-profile.php">Back</a>
                    </div>
                    <section class="section-body">
                        <section class="main-section column">
                            <div class="error"></div>
                            <form id="form" class="column" method="post" enctype="multipart/form-data" onsubmit="return validateInputs()">
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
                                        $EMP_BRANCH = $row['EMP_BRANCH'];
                                ?>
                                        <div class="block">
                                            <div class="form-field">
                                                <div class="form-field-input input-control">
                                                    <label for="first-name">First Name</label>
                                                    <input name="first-name" id="first-name" class="js-user" type="text" value="<?php echo $EMP_FNAME ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input input-control">
                                                    <label for="last-name">Last Name</label>
                                                    <input name="last-name" id="last-name" class="js-user" type="text" value="<?php echo $EMP_LNAME ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input input-control">
                                                    <label for="username">Username</label>
                                                    <input name="username" id="username" class="js-user" type="text" value="<?php echo $PRSN_EMAIL ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input input-control">
                                                    <label for="branch">Branch</label>
                                                    <input name="branch" id="branch" class="js-user" type="text" value="<?php echo $EMP_BRANCH ?>">
                                                    <div class="error"></div>
                                                </div>
                                                <div class="form-field-input">
                                                    <div class="with-desc">
                                                        <label for="password">Password</label>
                                                        <p>Password must be 8 characters long, and includes at least 1 uppercase, 1 lowercase, 1 digit, and 1 special character</p>
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
                                                <div class="form-field-input">
                                                    <label for="role">Role</label>
                                                    <select class="dropdown" name="role" id="role" required>
                                                        <option value="Employee">Employee</option>
                                                        <option value="Admin">Admin</option>
                                                    </select>
                                                </div>
                                                <div class="form-field-input">
                                                    <label for="valid-id">Image</label>
                                                    <p class="label-desc">(accepted files: .jpg, .png)</p>
                                                    <input class="image" type="file" name="image" id="image">
                                                    <div class="error"></div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                                <button class="big-btn" type="submit" name="submit" type="submit">Save</button>
                            </form>
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
                                const branchInput = document.getElementById('branch');
                                const usernameInput = document.getElementById('username');
                                const passwordInput = document.getElementById('password');
                                const cpasswordInput = document.getElementById('cpassword');
                                const imageInput = document.getElementById('image');

                                function setError(input, message) {
                                    const errorDiv = input.nextElementSibling;
                                    errorDiv.innerHTML = `<span class="error-text">${message}</span>`;
                                }

                                function clearError(input) {
                                    const errorDiv = input.nextElementSibling;
                                    errorDiv.innerHTML = ''; // Clear the error message
                                }

                                function validateInputs() {

                                    document.querySelector('.error').innerHTML = '';

                                    let isValid = true;

                                    const firstNameValue = firstNameInput.value.trim();
                                    const lastNameValue = lastNameInput.value.trim();
                                    const branchValue = branchInput.value.trim();
                                    const usernameValue = usernameInput.value.trim();
                                    const passwordValue = passwordInput.value.trim();
                                    const cpasswordValue = cpasswordInput.value.trim();
                                    const imageValue = imageInput.value.trim();

                                    const nameRegex = /^[a-zA-Z\s]+$/;
                                    const usernameRegex = /^[a-zA-Z0-9]+$/;
                                    const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,}$/; // Password should include at least 1 digit, 1 lowercase, 1 uppercase

                                    if (firstNameValue === '') {
                                        setError(firstNameInput, 'Please enter your first name');
                                        isValid = false;
                                    } else if (!nameRegex.test(firstNameValue)) {
                                        setError(firstNameInput, 'First name must contain only letters');
                                        isValid = false;
                                    } else {
                                        clearError(firstNameInput);
                                    }

                                    if (lastNameValue === '') {
                                        setError(lastNameInput, 'Please enter your last name');
                                        isValid = false;
                                    } else if (!nameRegex.test(lastNameValue)) {
                                        setError(lastNameInput, 'Last name must contain only letters');
                                        isValid = false;
                                    } else {
                                        clearError(lastNameInput);
                                    }

                                    if (branchValue === '') {
                                        setError(branchInput, 'Please enter your branch');
                                        isValid = false;
                                    } else {
                                        clearError(branchInput);
                                    }

                                    if (usernameValue === '') {
                                        setError(usernameInput, 'Please enter your username');
                                        isValid = false;
                                    } else if (!usernameRegex.test(usernameValue)) {
                                        setError(usernameInput, 'Invalid username format');
                                        isValid = false;
                                    } else {
                                        clearError(usernameInput);
                                    }

                                    if (passwordValue !== '') {
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
                                    }

                                    // Check if file extension is valid only if an image is selected
                                    if (imageValue !== '') {
                                        const validExtensions = ['png', 'jpg', 'jpeg'];
                                        const fileExtension = imageValue.split('.').pop().toLowerCase();

                                        if (!validExtensions.includes(fileExtension)) {
                                            setError(imageInput, 'Only PNG, JPG, and JPEG files are allowed');
                                            isValid = false;
                                        } else {
                                            clearError(imageInput);
                                        }
                                    }

                                    return isValid;
                                }
                            </script>
                        </section>
                    </section>
                </div>
            </div>

        </section>
    </main>
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
</body>

</html>
<?php
if (isset($_POST['submit'])) {

    $EMP_FNAME = mysqli_real_escape_string($conn, trim($_POST['first-name']));
    $EMP_LNAME = mysqli_real_escape_string($conn, trim($_POST['last-name']));
    $EMP_BRANCH =  $_POST['branch'];
    $PRSN_UNAME = mysqli_real_escape_string($conn, trim($_POST['username']));
    $PRSN_ROLE = $_POST['role'];
    $current_image = $EMP_IMAGE;

    // Check if a new image is uploaded
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Get the image details
        $EMP_IMG = $_FILES['image']['name'];

        // Generate a unique filename for the image
        $image_info = pathinfo($EMP_IMG);
        $ext = strtolower($image_info['extension']);
        $EMP_IMG = "EMP_IMAGE_" . $PRSN_UNAME . "." . $ext;

        // Set the destination path for the uploaded image
        $dst = "images/" . $EMP_IMG;

        // Upload the image
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $dst)) {
            // Handle upload failure
            $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
            header('location:' . $_SERVER['PHP_SELF'] . '?RPSN_ID=' . $PRSN_ID);
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
$updatePassword
    PRSN_EMAIL = '$PRSN_UNAME'
WHERE PRSN_ID = $PRSN_ID";


        if (mysqli_query($conn, $updatePerson)) {
            // Update the employee table
            $updateEmployee = "UPDATE employee 
    SET EMP_FNAME = '$EMP_FNAME',
        EMP_LNAME = '$EMP_LNAME',
        EMP_IMAGE = '$EMP_IMG',
        EMP_BRANCH = '$EMP_BRANCH'
    WHERE EMP_ID = $EMP_ID";

            if (!mysqli_query($conn, $updateEmployee)) {
                $error[] = "Error updating data into employee table: " . mysqli_error($conn);
            }
        } else {
            $error[] = "Error updating data into person table: " . mysqli_error($conn);
        }

        echo "<script> window.location.href = 'admin-profile.php'; </script>";
        exit();
    }
}

?>