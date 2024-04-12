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
    <title>Add Menu Item | Admin</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="admin-styles.css">
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
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
                    <label class='menu-button-container' for="menu-toggle">
                        <div class='menu-button'></div>
                    </label>
                <ul class = 'menubar'>
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
                        <h2>Edit Calendar Slots</h2>
                        <a href="<?php echo SITEURL; ?>admin-calendar-slots.php">Back</a>
                    </div>
                    <section class="section-body">
                        <section class="main-section column">
                            <form action="#" class="column" method="post" enctype="multipart/form-data">
                                <div class="block">
                                    <div class="form-field">
                                        <div class="form-field-input">
                                            <label for="date">Date</label>
                                            <input class="js-user" type="date" id="date" name="date" required pattern="[a-zA-Z ]{1,20}$"><!-- 20 characters only, letter only, with spaces -->
                                        </div>
                                        <div class="form-field-input">
                                            <label for="active">Status</label>
                                            <select class="dropdown" name="active" id="active" required>
                                                <option value="available">Available</option>
                                                <option value="fully-booked">Fully Booked</option>
                                                <option value="closed">Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="big-btn" type="submit" name="submit">Save</button>
                            </form>
                        </section>
                    </section>
                </div>
            </div>
        </section>
    </main>
</body>

</html>