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
                                    <th class="header">Date and Time</th>
                                    <th class="header">Application #</th>
                                    <th class="header">Name</th>
                                    <th class="header">Email</th>
                                    <th class="header"></th>
                                </tr>
                                <?php
                                $sql = "SELECT * FROM person, wholesaler WHERE wholesaler.PRSN_ID = person.PRSN_ID AND PRSN_ROLE = 'Wholesaler' AND WHL_STATUS = 'New' ";
                                $res = mysqli_query($conn, $sql);
                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $DATE_OF_REGISTRATION = $row['DATE_OF_REGISTRATION'];
                                        $WHL_ID = $row['WHL_ID'];
                                        $PRSN_NAME = $row['PRSN_NAME'];
                                        $PRSN_EMAIL = $row['PRSN_EMAIL'];
                                        $WHL_IMAGE = $row['WHL_IMAGE'];
                                ?>
                                        <tr>
                                            <td data-cell="Date and Time"><?php echo $DATE_OF_REGISTRATION ?></td>
                                            <td data-cell="Application #"><a class="link" href="<?php echo SITEURL ?>admin-application-details.php?WHL_ID=<?php echo $WHL_ID; ?>&PRSN_NAME=<?php echo $PRSN_NAME ?>&PRSN_EMAIL=<?php echo $PRSN_EMAIL ?>&WHL_IMAGE=<?php echo $WHL_IMAGE ?>"><?php echo $WHL_ID ?></a></td>
                                            <td data-cell="Name"><?php echo $PRSN_NAME ?></td>
                                            <td data-cell="Email"><?php echo $PRSN_EMAIL ?></td>
                                            <td data-cell="Confimed">
                                                <div class="btn-wrapper">
                                                    <!-- <form method="post"> -->
                                                    <button name="accept" class="btn-check"><i class='bx bxs-check-circle js-accept' data-whl-id="<?php echo $WHL_ID; ?>"></i></button>
                                                    <button name="reject" class="btn-cross"><i class='bx bxs-x-circle js-reject' data-whl-id="<?php echo $WHL_ID; ?>"></i></button>
                                                    <!-- </form> -->
                                                </div>
                                            </td>
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

</html>