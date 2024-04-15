<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];
$sql = "SELECT 
            SUM(CASE WHEN DATE_STATUS = 'available' THEN 1 ELSE 0 END) AS available_count,
            SUM(CASE WHEN DATE_STATUS = 'fullybooked' THEN 1 ELSE 0 END) AS fullybooked_count,
            SUM(CASE WHEN DATE_STATUS = 'closed' THEN 1 ELSE 0 END) AS closed_count
        FROM calendar";

$res = mysqli_query($conn, $sql);

if ($res) {
    $row = mysqli_fetch_assoc($res);
    $available_count = $row['available_count'];
    $fullybooked_count = $row['fullybooked_count'];
    $closed_count = $row['closed_count'];
}

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
    <!-- <script src="app.js" defer></script> -->
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
        <section class="section" id="admin-calendar">
            <div class="container">
                <div class="section-heading row">
                    <h2>Edit Calendar</h2>
                </div>
                <section class="section-body row">
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
                                    <h1><?php echo $available_count ?></h1>
                                    <p class="bottom">days</p>
                                </div>
                                <div class="box red">
                                    <p>Fully Booked</p>
                                    <h1><?php echo $fullybooked_count ?></h1>
                                    <p class="bottom">days</p>
                                </div>
                                <div class="box">
                                    <p>Closed</p>
                                    <h1><?php echo $closed_count ?></h1>
                                    <p class="bottom">days</p>
                                </div>
                            </div>
                        </section>
                        <section class="group block">
                            <div class="top">
                                <div id="selectedDate">
                                    <h3>Select a Date</h3>
                                </div>
                                <hr>
                                <div class="btn-wrapper">
                                    <button id="availBtn" class="button green">Available</button>
                                    <button id="fullBtn" class="button red">Fully Booked</button>
                                    <button id="closedBtn" class="button black">Closed</button>
                                    <button id="clearBtn" class="button clear">Clear</button>
                                </div>
                            </div>
                            <button id="saveBtn" class="save-btn">Save</button>
                        </section>
                    </section>
                </section>
            </div>

        </section>
    </main>
    <?php
    $sql = "SELECT * FROM calendar";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    $calendar_data = array();

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $calendar_data[] = $row;
        }
    }
    $calendar_json = json_encode($calendar_data);
    ?>
    <script>
        var calendarData = <?php echo $calendar_json; ?>;
    </script>
    <script src="calendar.js"></script>
</body>

</html>