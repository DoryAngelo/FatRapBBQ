<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

if ($PRSN_ROLE !== 'Admin') {
    header('location:' . SITEURL . 'login-page.php');
}

if (isset($_POST['submit'])) {
    $PRSN_FNAME = mysqli_real_escape_string($conn, trim($_POST['first-name']));
    $PRSN_LNAME = mysqli_real_escape_string($conn, trim($_POST['last-name']));
    $PRSN_PHONE = str_replace(' ', '', trim($_POST['number']));
    $PRSN_UNAME = mysqli_real_escape_string($conn, trim($_POST['username']));
    $EMP_BRANCH = mysqli_real_escape_string($conn, trim($_POST['branch']));
    $PRSN_PASSWORD = md5($_POST['password']);
    $PRSN_CPASSWORD = md5($_POST['cpassword']);
    $PRSN_ROLE = $_POST['role'];
    $EMP_STATUS = $_POST['status'];

    if (isset($_FILES['image']['name'])) {
        $EMP_IMG = $_FILES['image']['name'];

        if ($EMP_IMG != "") {
            $image_info = explode(".", $EMP_IMG);
            $ext = end($image_info);

            $EMP_IMG = "EMP_IMAGE_" . $PRSN_LNAME . "." . $ext;

            $src = $_FILES['image']['tmp_name'];
            $dst = "images/" . $EMP_IMG;

            $upload    = move_uploaded_file($src, $dst);

            if ($upload = false) {
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                header('location:' . SITEURL . 'admin-home.php');
                die();
            }
        }
    } else {
        $EMP_IMG = "";
    }

    $select = "SELECT * FROM `person` WHERE PRSN_EMAIL = '$PRSN_UNAME'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        // User already exists, set error message in session
        $_SESSION['error_message'] = "User already exists";
        header('Location: admin-add-employee.php');
        exit();
    } else {
        $PRSN_NAME = $PRSN_FNAME . " " . $PRSN_LNAME;
        $insert = "INSERT INTO person(PRSN_NAME, PRSN_EMAIL, PRSN_PASSWORD, PRSN_PHONE, PRSN_ROLE) 
                       VALUES('$PRSN_NAME', '$PRSN_UNAME', '$PRSN_PASSWORD', '$PRSN_PHONE', '$PRSN_ROLE')";
        if (mysqli_query($conn, $insert)) {
            $PRSN_ID = mysqli_insert_id($conn);
            $insert2 = "INSERT INTO employee(PRSN_ID, EMP_FNAME, EMP_LNAME, EMP_IMAGE, EMP_BRANCH, EMP_STATUS) 
                            VALUES('$PRSN_ID', '$PRSN_FNAME', '$PRSN_LNAME', '$EMP_IMG', '$EMP_BRANCH', '$EMP_STATUS')";
            if (!mysqli_query($conn, $insert2)) {
                echo "Error inserting data into employee table: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting data into person table: " . mysqli_error($conn);
        }
    }
    header("location: admin-employee-accounts.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Add Employee | Admin</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="admin-styles.css"><!--change css file-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="input-validation.js" defer></script>
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
                <li><a href="<?php echo SITEURL; ?>admin-edit-menu.php">Menu</a></li>
                <li><a href="<?php echo SITEURL; ?>admin-new-orders.php">Orders</a></li>
                <?php
                if (isset($_SESSION['prsn_id'])) {
                ?>
                    <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a></li>
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
                    <h2>Add a New Employee</h2>
                    <a href="<?php echo SITEURL; ?>admin-employee-accounts.php">Back</a>
                </div>
                <section class="section-body">
                    <section class="main-section column">
                        <style>
                            .error-text {
                                color: red;
                                font-size: 12px;
                            }
                        </style>
                        <form class="column" method="post" enctype="multipart/form-data" onsubmit="return validateInputs()">
                            <div class="block layout">
                                <section>
                                    <?php
                                    if (isset($_SESSION['error_message'])) {
                                        echo "<div class='error-text'>" . $_SESSION['error_message'] . "</div>";
                                        unset($_SESSION['error_message']);
                                    }
                                    ?>
                                    <div class="form-title">
                                        <h1>Contact Information</h1>
                                    </div>
                                    <div class="form-field">
                                        <div class="form-field-input input-control">
                                            <label for="first-name">First Name</label>
                                            <input name="first-name" id="first-name" class="js-user" type="text">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input input-control">
                                            <label for="last-name">Last Name</label>
                                            <input name="last-name" id="last-name" class="js-user" type="text">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input input-control">
                                            <label for="number">Phone Number</label>
                                            <p>(e.g. 09xxxxxxxxx)</p>
                                            <input class="js-user" type="text" id="number" name="number">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input input-control">
                                            <label for="branch">Branch</label>
                                            <input name="branch" id="branch" class="js-user" type="text">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="role">Role</label>
                                            <select class="dropdown" name="role" id="role" required>
                                                <option value="Employee">Employee</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                        </div>
                                        <div class="form-field-input">
                                            <label for="role">Status</label>
                                            <select class="dropdown" name="status" id="status" required>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
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
                                            <input name="username" id="username" class="js-user" type="text">
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
                            </div>
                            <button name="submit" type="submit" class="big-btn">Add Employee</button>
                        </form>
                    </section>
                </section>
            </div>
        </section>
    </main>
    <script>
        const firstNameInput = document.getElementById('first-name');
        const lastNameInput = document.getElementById('last-name');
        const numberInput = document.getElementById('number');
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
            let isValid = true;

            const firstNameValue = firstNameInput.value.trim();
            const lastNameValue = lastNameInput.value.trim();
            const numberValue = numberInput.value.trim();
            const branchValue = branchInput.value.trim();
            const usernameValue = usernameInput.value.trim();
            const passwordValue = passwordInput.value.trim();
            const cpasswordValue = cpasswordInput.value.trim();
            const imageValue = imageInput.value.trim();

            const nameRegex = /^[a-zA-Z\s]+$/;
            const numberRegex = /^(?! )\S*(?<! )09\d{9}$/;
            const usernameRegex = /^[a-zA-Z0-9]+$/;
            const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,}$/; // Password should include at least 1 digit, 1 lowercase, 1 uppercase, exclude special characters.

            // Email and username regex are omitted assuming they can be validated on the backend

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

            if (numberValue === '') {
                setError(numberInput, 'Please enter your number');
                isValid = false;
            } else if (!numberRegex.test(numberValue)) {
                setError(numberInput, 'Invalid number');
                isValid = false;
            } else {
                clearError(numberInput);
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

            // Check if file extension is valid
            const validExtensions = ['png', 'jpg', 'jpeg'];
            const fileExtension = imageValue.split('.').pop().toLowerCase();
            if (imageValue === '') {
                setError(imageInput, 'Please select an image file');
                isValid = false;
            } else if (!validExtensions.includes(fileExtension)) {
                setError(imageInput, 'Only PNG, JPG, and JPEG files are allowed');
                isValid = false;
            } else {
                clearError(imageInput);
            }

            return isValid;
        }
    </script>
</body>
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

</html>