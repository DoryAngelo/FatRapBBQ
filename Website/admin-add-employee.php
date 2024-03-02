<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

if (isset($_POST['submit'])) {
    $PRSN_FNAME = mysqli_real_escape_string($conn, $_POST['first-name']);
    $PRSN_LNAME = mysqli_real_escape_string($conn, $_POST['last-name']);
    $PRSN_EMAIL = mysqli_real_escape_string($conn, $_POST['email']);
    $PRSN_PHONE = $_POST['phone-number'];
    $PRSN_UNAME = mysqli_real_escape_string($conn, $_POST['username']);
    $PRSN_PASSWORD = md5($_POST['password']);
    $PRSN_CPASSWORD = md5($_POST['cpassword']);
    $PRSN_ROLE = 'Employee';

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

    $select = "SELECT * FROM `person` WHERE PRSN_EMAIL = '$PRSN_EMAIL'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = "User already exists";
    } else {
        if ($PRSN_PASSWORD != $PRSN_CPASSWORD) {
            $error[] = "Password not matched";
        } else {
            $insert = "INSERT INTO person(PRSN_NAME, PRSN_EMAIL, PRSN_PASSWORD, PRSN_PHONE, PRSN_ROLE) 
                       VALUES('$PRSN_UNAME', '$PRSN_EMAIL', '$PRSN_PASSWORD', '$PRSN_PHONE', '$PRSN_ROLE')";
            if (mysqli_query($conn, $insert)) {
                $PRSN_ID = mysqli_insert_id($conn);
                $insert2 = "INSERT INTO employee(PRSN_ID, EMP_FNAME, EMP_LNAME, EMP_IMAGE) 
                            VALUES('$PRSN_ID', '$PRSN_FNAME', '$PRSN_LNAME', '$EMP_IMG')";
                if (!mysqli_query($conn, $insert2)) {
                    $error[] = "Error inserting data into employee table: " . mysqli_error($conn);
                }
            } else {
                $error[] = "Error inserting data into person table: " . mysqli_error($conn);
            }
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
    <!--change title-->
    <title>Add Employee | Admin</title>
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
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                    <p>ADMIN</p>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="<?php echo SITEURL ;?>admin-home.php">Home</a></li>
                    <li><a href="<?php echo SITEURL ;?>admin-edit-menu.php">Menu</a></li>
                    <li><a href="<?php echo SITEURL ;?>admin-new-orders.php">Orders</a></li>
                    <?php
                        if(isset($_SESSION['prsn_id'])){
                    ?>  
                        <li><a href="<?php echo SITEURL ;?>logout.php">Logout</a><li>
                    <?php
                        } 
                        else 
                        {
                    ?>
                        <li><a href="<?php echo SITEURL ;?>login-page.php">Login</a></li>
                    <?php
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="section">
            <div class="section-heading row back">
                <h2>Add a New Employee</h2>
                <a href="<?php echo SITEURL ;?>admin-employee-accounts.php">Back</a>
            </div>
            <section class="section-body">
                <section class="main-section column">
                    <section class="block">
                        <form action="#" class="form" method="post" enctype="multipart/form-data">
                            <section>
                                <div class="form-title">
                                    <h1>Contact Information</h1>
                                </div>
                                <div class="form-field">
                                    <div class="form-field-input">
                                        <label for="first-name">First Name</label>
                                        <input name="first-name" id="first-name" class="js-user" type="text" required>
                                    </div>
                                    <div class="form-field-input">
                                        <label for="last-name">Last Name</label>
                                        <input name="last-name" id="last-name" class="js-user" type="text" required>
                                    </div>
                                    <div class="form-field-input">
                                        <label for="phone-number">Phone Number</label>
                                        <input class="js-user" type="text" id="phone-number" name="phone-number" required pattern="^(09)[0-9]{9}$"><!-- numbers only, starts with 09, must have 11-digits -->
                                    </div>
                                    <div class="form-field-input">
                                        <label for="email">Email</label>
                                        <input name="email" id="email" class="js-user" type="text" required>
                                    </div>
                                    <div class="form-field-input">
                                        <label for="image">Image</label>
                                        <p>(accepted files: .jpg, .png)</p>
                                        <input name="image" id="image" class="image" type="file" required>
                                    </div>
                                </div>
                            </section>
                            <div class="line"></div>
                            <section>
                                <div class="form-title">
                                    <h1>Login Credentials</h1>
                                </div>
                                <div class="form-field">
                                    <div class="form-field-input">
                                        <label for="username">Username</label>
                                        <input name="username" id="username" class="js-user" type="text" required>
                                    </div>
                                    <div class="form-field-input">
                                        <label for="password">Password</label>
                                        <input class="js-pass" type="password" id="password" name="password" required>
                                        <svg class="showpass" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                        </svg>
                                        <svg class="hidepass" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z" />
                                        </svg>
                                    </div>
                                    <div class="form-field-input">
                                        <label for="cpassword">Re-enter Password</label>
                                        <input class="js-cpass" type="password" id="cpassword" name="cpassword" required>
                                        <svg class="showcpass" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3z" />
                                        </svg>
                                        <svg class="hidecpass" xmlns="http://www.w3.org/2000/svg" style="vertical-align: -0.125em;" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3h-.17m-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7Z" />
                                        </svg>
                                    </div>
                                </div>
                            </section>
                    </section>
                    <button name="submit" class="big-btn">Add Employee</button>
                    </form>
                    <!-- <a href="" class="page-btn"></a> -->
                </section>
            </section>
        </section>
    </main>
</body>

</html>