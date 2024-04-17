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
    <title>Wholesale Customers | Admin</title>
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
                <!-- Text below should change to 'Logout'once user logged in-->
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
        <section class="section">
            <div class="container">
                <div class="section-heading">
                    <h2>Wholesale Customers</h2>
                    <!-- for filtering hidden accounts-->
                    <!-- <div class="inline">
                        <p>Filter:</p>
                        <select name="customer-type" id="customer-type" class="dropdown">
                            <option value="regular">REGULAR</option>
                            <option value="wholesale">WHOLESALE</option>
                        </select>
                    </div> -->
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
                                    <th class="header">Status</th>
                                    <th class="header">Action</th>
                                </tr>
                                <?php
                                $sql = "SELECT * FROM person, wholesaler WHERE wholesaler.PRSN_ID = person.PRSN_ID AND PRSN_ROLE = 'Wholesaler'";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $PRSN_ID = $row['PRSN_ID'];
                                        $WHL_ID = $row['WHL_ID'];
                                        $WHL_IMAGE = $row['WHL_IMAGE'];
                                        $WHL_FNAME = $row['WHL_FNAME'];
                                        $WHL_LNAME = $row['WHL_LNAME'];
                                        $PRSN_NUMBER = $row['PRSN_PHONE'];
                                        $PRSN_NAME = $row['PRSN_NAME'];
                                        $PRSN_EMAIL = $row['PRSN_EMAIL'];
                                        $WHL_STATUS = $row['WHL_STATUS'];
                                ?>
                                        <tr>
                                            <td data-cell="Image">
                                                <img src="<?php echo SITEURL; ?>images/<?php echo $WHL_IMAGE; ?>" alt="">
                                            </td>
                                            <td data-cell="Name"><?php echo $WHL_FNAME ?></td>
                                            <td data-cell="Name"><?php echo $WHL_LNAME ?></td>
                                            <td data-cell="Contact #"><?php echo $PRSN_NUMBER ?></td>
                                            <td data-cell="Username"><?php echo $PRSN_EMAIL ?></td>
                                            <td data-cell="Status"><?php echo $WHL_STATUS ?></td>
                                            <td data-cell="Action"><a href="<?php echo SITEURL; ?>admin-edit-wholesaler.php?PRSN_ID=<?php echo $PRSN_ID ?>&WHL_ID=<?php echo $WHL_ID ?>" class="edit">Edit</a></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="error">Empty</td>
                                    </tr>
                                <?php

                                }
                                ?>
                            </table>
                        </div>
                        <a href="<?php echo SITEURL; ?>admin-add-wholesaler.php" class="page-btn"><button class="big-btn">Add New Wholesale Customer</button></a>
                    </section>
                </section>
            </div>
        </section>
    </main>
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