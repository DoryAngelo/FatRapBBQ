<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

$EMP_IMAGE = $_GET['EMP_IMAGE'];

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
        <section class="section add-edit-menu">
            <div class="container">
                <div class="section-wrapper">
                    <div class="section-heading row back">
                        <h2>Edit Profile</h2>
                        <a href="<?php echo SITEURL; ?>admin-profile.php">Back</a>
                    </div>
                    <section class="section-body">
                        <section class="main-section column">
                            <form action="#" class="column" method="post" enctype="multipart/form-data" onsubmit="return validateInputs()">
                                <div class="block">
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
                                            <label for="username">Username</label>
                                            <input name="username" id="username" class="js-user" type="text">
                                            <div class="error"></div>
                                        </div>
                                        <div class="form-field-input input-control">
                                            <label for="branch">Branch</label>
                                            <input name="branch" id="branch" class="js-user" type="text">
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
                                                <div class="error"></div>
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
                                            <input required class="image" type="file" name="image" id="image">
                                        </div>
                                    </div>
                                </div>
                                <button class="big-btn" type="submit" name="submit" type="submit">Save</button>
                            </form>
                        </section>
                    </section>
                </div>
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

        const firstnameInput = document.getElementById('first-name');
        const lastnameInput = document.getElementById('last-name');
        const usernameInput = document.getElementById('username');
        const branchInput = document.getElementById('branch');
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

            const firstnameValue = firstnameInput.value.trim();
            const lastnameValue = lastnameInput.value.trim();
            const usernameValue = usernameInput.value.trim();
            const branchValue = usernameInput.value.trim();
            const passwordValue = passwordInput.value.trim();
            const cpasswordValue = cpasswordInput.value.trim();

            const nameRegex = /^[a-zA-Z\s]+$/;
            const passwordRegex = /^[a-zA-Z0-9]{8,}$/; // Password should not contain special characters

            if (firstnameValue === '') {
                setError(firstnameInput, 'Please enter your first-name');
                isValid = false;
            } else if (!nameRegex.test(firstnameValue)) {
                setErrorfirst(nameInput, 'Name must contain only letters');
                isValid = false;
            } else {
                clearError(firstnameInput);
            }

            if (lastnameValue === '') {
                setError(lastnameInput, 'Please enter your last-name');
                isValid = false;
            } else if (!nameRegex.test(lastnameValue)) {
                setError(lastnameInput, 'Name must contain only letters');
                isValid = false;
            } else {
                clearError(lastnameInput);
            }

            if (usernameValue === '') {
                setError(usernameInput, 'Please enter your username');
                isValid = false;
            } else {
                clearError(usernameInput);
            }

            if (branchValue === '') {
                setError(branchInput, 'Please enter your branch');
                isValid = false;
            } else {
                clearError(branchInput);
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

</body>

</html>
<?php
if (isset($_POST['submit'])) {

    $PRSN_NAME = mysqli_real_escape_string($conn, $_POST['username']);
    $EMP_FNAME = mysqli_real_escape_string($conn, $_POST['first-name']);
    $EMP_LNAME = mysqli_real_escape_string($conn, $_POST['last-name']);
    $EMP_BRANCH = mysqli_real_escape_string($conn, $_POST['branch']);
    $PRSN_PASSWORD = md5($_POST['password']);
    $PRSN_ROLE = $_POST['role'];
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

            $upload = move_uploaded_file($src, $dst);

            //check whether the image is uploaded
            if ($upload == false) {
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                die();
            }
            //remove current image if available
            if ($current_image != "") {
                $remove_path = "images/" . $current_image;
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

    // Update person table
    $update_person = "UPDATE person 
                  SET PRSN_NAME = '$PRSN_NAME', 
                      PRSN_PASSWORD = '$PRSN_PASSWORD',
                      PRSN_ROLE = '$PRSN_ROLE' 
                  WHERE PRSN_ID = '$PRSN_ID'"; 
    mysqli_query($conn, $update_person);

    // Update employee table
    $update_employee = "UPDATE employee 
                    SET EMP_FNAME = '$EMP_FNAME', 
                        EMP_LNAME = '$EMP_LNAME', 
                        EMP_IMAGE = '$EMP_IMG',
                        EMP_BRANCH = '$EMP_BRANCH' 
                    WHERE PRSN_ID = '$PRSN_ID'";

    mysqli_query($conn, $update_employee);
}
?>