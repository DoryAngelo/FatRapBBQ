<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

if(!isset($_SESSION['prsn_id'])){
	header('location:'.SITEURL.'login_admin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--change title-->
        <title>Home | Admin</title>
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
                    <img id="logo" src="images/client-logo.jpg">
                    <h1>Fat Rap's Barbeque's Online Store</h1>
                </div>
                <nav>
                    <ul>
                        <!--TODO: ADD LINKS-->
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Menu</a></li>
                        <li><a href="#">Orders</a></li>
                        <!-- Text below should change to 'Logout'once user logged in-->
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <section class="section">
                <section class="left-section">
                    <div class="heading">
                        <h2>Dashboard</h2>
                        <div class="inline">
                            <p>Date range:</p>
                            <p class="dropdown">Today</p>
                        </div>
                    </div>
                    <section class="grid-container">
                        <div class="box">
                            <p>New Orders</p>
                            <h1>100</h1>
                            <p class="notif">+99</p>
                        </div>
                        <div class="box">
                            <p>Paid Orders</p>
                            <h1>100</h1>
                            <p class="notif">+99</p>
                        </div>
                        <div class="box">
                            <p>Preparing Orders</p>
                            <h1>100</h1>
                            <p class="notif">+99</p>
                        </div>
                        <div class="box">
                            <p>Packing Orders</p>
                            <h1>100</h1>
                            <p class="notif">+99</p>
                        </div>
                        <div class="box">
                            <p>Shipped Orders</p>
                            <h1>100</h1>
                            <p class="notif">+99</p>
                        </div>
                        <div class="box">
                            <p>Completed Orders</p>
                            <h1>100</h1>
                            <p class="notif">+99</p>
                        </div>
                        <div class="box">
                            <p>Canceled Orders</p>
                            <h1>100</h1>
                            <p class="notif">+99</p>
                        </div>
                    </section>
                </section>
                <section class="side-menu">
                    <div class="group inventory">
                        <h3>Inventory</h3>
                        <div class="inventory-box">
                            <div class="inline">
                                <p>Pork BBQ</p>
                                <p class="number">10</p>
                            </div>
                            <a href="" class="edit">Edit</a>
                        </div>
                    </div>
                    <div class="group">
                        <h3>Calendar</h3>
                        <a href="" class="view">View</a>
                    </div>
                    <div class="group">
                        <h3>Wholesale Users</h3>
                        <a href="" class="view">View</a>
                    </div>
                    <div class="group">
                        <h3>Employee</h3>
                        <a href="" class="view">View</a>
                    </div>
                </section>
            </section>
            
        </main>
    </body>
</html>