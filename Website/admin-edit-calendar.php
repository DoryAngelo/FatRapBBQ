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
        <title>Edit Calendar | Admin</title>
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
                    <img id="logo" src="images/client-logo.jpg">
                    <div class="text">
                        <h1>Fat Rap's Barbeque's Online Store</h1>
                        <p>ADMIN</p>
                    </div>
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
                <div class="section-heading row">
                    <h2>Edit Calendar</h2>
                </div> 
                <section class="section-body">
                    <section class="calendar">
                        <section class="calendar-block"> <!-- reference code: https://www.youtube.com/watch?v=OcncrLyddAs-->
                            <div class="header">
                                <button id="prevBtn">
                                    <i class='bx bx-chevron-left'></i>
                                </button>
                                <div class="monthYear" id="monthYear"></div>
                                <button id="nextBtn">
                                    <i class='bx bx-chevron-right'></i>
                                </button>
                            </div>
                            <div class="days">
                                <div class="day">Mon</div>
                                <div class="day">Tue</div>
                                <div class="day">Wed</div>
                                <div class="day">Thur</div>
                                <div class="day">Fri</div>
                                <div class="day">Sat</div>
                                <div class="day">Sun</div>
                            </div>
                            <div class="dates" id="dates"></div>
                        </section>
                    </section>
                    <section class="right-side">
                        <section class="group">
                            <h3>This month</h3>
                            <div class="grid-container">
                                <div class="box green">
                                    <p>Available</p>
                                    <h1>10</h1>
                                    <p>days</p>
                                </div>
                                <div class="box red">
                                    <p>Fully Booked</p>
                                    <h1>10</h1>
                                    <p>days</p>
                                </div>
                                <div class="box">
                                    <p>Closed</p>
                                    <h1>10</h1>
                                    <p>days</p>
                                </div>
                            </div>
                        </section>
                        <section class="group block">
                            <div class="top">
                                <h3>November 1</h3>
                                <hr>
                                <div class="btn-wrapper">
                                    <button class="button green">Available</button>
                                    <button class="button red">Fully Booked</button>
                                    <button class="button black">Closed</button>
                                </div>
                            </div>
                            <button class="save-btn">Save</button>
                        </section>
                    </section>
                </section>
            </section>
        </main>
        <script src="calendar.js"></script>
    </body>
</html>