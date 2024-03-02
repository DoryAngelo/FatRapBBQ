<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

$PRSN_ROLE = $_SESSION['prsn_role'];

if($PRSN_ROLE !== 'Employee'){
	header('location:'.SITEURL.'login-page.php');
}
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
                <nav>
                    <ul>
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
                </nav>
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
                                <h1>100</h1>
                                <p class="notif">+99</p>
                            </a>
                            <a class="box" href="<?php echo SITEURL ;?>employee-preparing-orders.php">
                                <p>Currently Preparing</p>
                                <h1>100</h1>
                                <p class="notif">+99</p>
                            </a>
                            <a class="box" href="<?php echo SITEURL ;?>employee-to-deliver-orders.php">
                                <p>To Deliver</p>
                                <h1>100</h1>
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