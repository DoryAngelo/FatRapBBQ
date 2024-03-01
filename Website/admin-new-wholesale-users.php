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
    <title>New Registering Wholesale Users | Admin</title>
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
                    <li><a href="<?php echo SITEURL; ?>admin-home.php">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin-edit-menu.php">Menu</a></li>
                    <li><a href="<?php echo SITEURL; ?>admin-new-orders.php">Orders</a></li>
                    <?php
                    if (isset($_SESSION['prsn_id'])) {
                    ?>
                        <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a>
                        <li>
                        <?php
                    } else {
                        ?>
                        <li><a href="<?php echo SITEURL; ?>login-page.php">Login</a></li>
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
                <h2>New Registering Wholesale Users</h2>
                <div class="inline">
                    <p>Filter by date:</p>
                    <input type="date">
                </div>
            </div>
            <section class="section-body">
                <section class="main-section table-wrapper">
                    <table class="alternating">
                        <tr>
                            <th class="header">Date and Time</th>
                            <th class="header">Application #</th>
                            <th class="header">Name</th>
                            <th class="header">Email</th>
                            <th class="header">Confirmed</th>
                        </tr>
                        <?php
                            $sql = "SELECT * FROM person, wholesaler WHERE wholesaler.PRSN_ID = person.PRSN_ID AND PRSN_ROLE = 'Wholesaler' ";
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
                                                <form method="post">
                                                    <button name="accept" class="btn-check"><i class='bx bxs-check-circle'></i></button>
                                                    <button name="reject" class="btn-cross"><i class='bx bxs-x-circle'></i></button>
                                                </form>
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
                </section>
                <section class="side-menu">
                    <div class="group inventory">
                        <h3>Wholesale Users</h3>
                        <div class="position-notif">
                            <a href="<?php echo SITEURL; ?>admin-accepted-wholesale-users.php" class="view">Accepted</a>
                            <p class="notif">+99</p>
                        </div>
                        <div class="position-notif">
                            <a href="<?php echo SITEURL; ?>admin-new-wholesale-users.php" class="view">New</a>
                            <p class="notif">+99</p>
                        </div>
                    </div>
                </section>
            </section>
        </section>
    </main>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>

</html>
<?php

if (isset($_POST['accept'])) {
    $sql = "UPDATE wholesaler SET WHL_STATUS = 'Accepted' WHERE WHL_ID = $WHL_ID";

    $res2 = mysqli_query($conn, $sql);
    header('location:admin-accepted-wholesale-users.php');
}

if (isset($_POST['reject'])) {
    $sql = "UPDATE wholesaler SET WHL_STATUS = 'Rejected' WHERE WHL_ID = $WHL_ID";

    $res2 = mysqli_query($conn, $sql);
    header('location:admin-accepted-wholesale-users.php');
} 
?>