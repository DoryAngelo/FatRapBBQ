<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Employees | Admin</title>
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
                    <!-- Text below should change to 'Logout'once user logged in-->
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
            <div class="section-heading row">
                <h2>Employees</h2>
            </div>
            <section class="section-body">
                <section class="main-section column">
                    <div class="table-wrapper">
                        <table class="alternating">
                            <tr>
                                <th class="header">Picture</th>
                                <th class="header">First Name</th>
                                <th class="header">Last Name</th>
                                <th class="header">Contact #</th>
                                <th class="header">Username</th>
                                <th class="header">Email</th>
                                <th class="header">Password</th>
                                <th class="header">Action</th>
                            </tr>
                            <tr>
                                <td data-cell="Image">
                                    <img src="https://i.imgflip.com/1lbeyi.jpg?a474552" alt="">
                                </td>
                                <td data-cell="First Name">John John John John</td>
                                <td data-cell="Last Name">Doe dsjlkfjsalds</td>
                                <td data-cell="Contact #">09123456789</td>
                                <td data-cell="Username">jando1jando1jando1</td>
                                <td data-cell="Email">johndoejohndoejohndoe@gmail.com</td>
                                <td data-cell="Password">johndoe123</td>
                                <td data-cell="Action"><a href="<?php echo SITEURL ;?>admin-edit-employee.php" class="edit">Edit</a></td>
                            </tr>
                            <tr>
                                <td data-cell="Image">
                                    <img src="https://i.imgflip.com/1lbeyi.jpg?a474552" alt="">
                                </td>
                                <td data-cell="First Name">John</td>
                                <td data-cell="Last Name">Doe</td>
                                <td data-cell="Contact #">09123456789</td>
                                <td data-cell="Username">jando1</td>
                                <td data-cell="Email">johndoe@gmail.com</td>
                                <td data-cell="Password">johndoe123</td>
                                <td data-cell="Action"><a href="<?php echo SITEURL ;?>admin-edit-employee.php" class="edit">Edit</a></td>
                            </tr>
                            <tr>
                                <td data-cell="Image">
                                    <img src="https://i.imgflip.com/1lbeyi.jpg?a474552" alt="">
                                </td>
                                <td data-cell="First Name">John</td>
                                <td data-cell="Last Name">Doe</td>
                                <td data-cell="Contact #">09123456789</td>
                                <td data-cell="Username">jando1</td>
                                <td data-cell="Email">johndoe@gmail.com</td>
                                <td data-cell="Password">johndoe123</td>
                                <td data-cell="Action"><a href="<?php echo SITEURL ;?>admin-edit-employee.php" class="edit">Edit</a></td>
                            </tr>
                        </table>
                    </div>
                    <a href="<?php echo SITEURL ;?>admin-add-employee.php" class="page-btn"><button class="big-btn">Add a new employee</button></a>
                </section>
            </section>
        </section>
    </main>
</body>

</html>