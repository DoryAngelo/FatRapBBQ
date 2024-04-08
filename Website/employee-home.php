<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

$PRSN_ROLE = $_SESSION['prsn_role'];

if($PRSN_ROLE !== 'Employee'){
	header('location:'.SITEURL.'login-page.php');
}

$selectPa = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'Paid'";

$resPa = mysqli_query($conn, $selectPa);

$countPa = mysqli_num_rows($resPa);

$selectPr = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'Preparing'";

$resPr = mysqli_query($conn, $selectPr);

$countPr = mysqli_num_rows($resPr);

$selectFD = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'For Delivery'";

$resFD = mysqli_query($conn, $selectFD);

$countFD = mysqli_num_rows($resFD);

$selectCo = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'Completed'";

$resCo = mysqli_query($conn, $selectCo);

$countCo = mysqli_num_rows($resCo);

$selectCa = "SELECT * 
FROM placed_order
WHERE PLACED_ORDER_STATUS = 'Cancelled'";

$resCa = mysqli_query($conn, $selectCa);

$countCa = mysqli_num_rows($resCa);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--change title-->
        <title>Home | Employee</title>
        <link rel="stylesheet" href="header-styles.css">
        <link rel="stylesheet" href="admin-styles.css"><!--change css file-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"> 
        <script src="app.js" defer></script>
    </head>
    <body>
        <header class="backend">
            <div class="header-container">
                <div class="website-title">
                    <img id="logo" src="images/client-logo.png">
                    <div class="text">
                        <h1>Fat Rap's Barbeque's Online Store</h1>
                        <p>EMPLOYEE</p>
                    </div>
                </div>
                <input type="checkbox" id="menu-toggle">
                    <label class='menu-button-container' for="menu-toggle">
                        <div class='menu-button'></div>
                    </label>
                <ul class = 'menubar'>
                        <li><a href="<?php echo SITEURL ;?>employee-home.php">Home</a></li>
                        <li><a href="<?php echo SITEURL ;?>employee-to-prepare-orders.php">Orders</a></li>
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
            </div>
        </header>
        <main>
            <section class="section">
                <div class="section-heading">
                    <h2>Dashboard</h2>
                    <div class="inline">
                        <p>Date range:</p>
                        <!-- <p class="dropdown">Today</p> -->
                        <input type="date">
                    </div>
                </div> 
                <section class="section-body">
                    <section class="main-section">
                        <div class="grid-container">
                            <a class="box blue" href="<?php echo SITEURL ;?>employee-to-prepare-orders.php">
                                <p>To Prepare</p>
                                <h1><?php echo $countPa?></h1>
                                <p class="notif">+99</p>
                            </a>
                            <a class="box" href="<?php echo SITEURL ;?>employee-preparing-orders.php">
                                <p>Currently Preparing</p>
                                <h1><?php echo $countPr?></h1>
                                <p class="notif">+99</p>
                            </a>
                            <a class="box" href="<?php echo SITEURL ;?>employee-to-deliver-orders.php">
                                <p>To Deliver</p>
                                <h1><?php echo $countFD?></h1>
                                <p class="notif">+99</p>
                            </a>
                        </div>
                    </section>
                    <section class="side-menu">
                        <div class="group inventory">
                            <h3>Inventory</h3>
                            <div class="inventory-box">
                                <div class="inline">
                                    <p>Pork BBQ</p>
                                    <p class="number">10</p>
                                </div>
                                <a href="<?php echo SITEURL ;?>employee-inventory.php" class="edit">Edit</a>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
        </main>
    </body>
</html>