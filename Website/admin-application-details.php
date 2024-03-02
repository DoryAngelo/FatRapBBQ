<?php

@include 'constants.php';

$WHL_ID = $_GET['WHL_ID'];
$PRSN_NAME = $_GET['PRSN_NAME'];
$PRSN_EMAIL = $_GET['PRSN_EMAIL'];
$WHL_IMAGE = $_GET['WHL_IMAGE'];

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>XXXX Application Details | Admin</title>
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
            <div class="section-heading row">
                <h2>Application Details</h2>
                <p>#<?php echo $WHL_ID ?></p>
            </div>
            <section class="section-body">
                <section class="main-section column">
                    <section class="table-wrapper">
                        <table class="app-det-tbl">
                            <tr>
                                <td class="bold-font top">Name:</td>
                                <td class="top"><?php echo $PRSN_NAME ?></td>
                            </tr>
                            <tr>
                                <td class="bold-font bottom">Email:</td>
                                <td class="bottom"><?php echo $PRSN_EMAIL ?></td>
                            </tr>
                        </table>
                    </section>
                    <section class="column valid-id">
                        <p class="bold-font">Valid ID</p>
                        <img src="<?php echo SITEURL; ?>images/<?php echo $WHL_IMAGE; ?>" alt="">
                    </section>
                </section>
                <section class="side-menu">
                    <div class="group">
                        <h3>Wholesale Users</h3>
                        <div class="position-notif">
                            <a href="" class="view">Total Count</a>
                            <p class="notif">+99</p>
                        </div>
                    </div>
                    <div class="group">
                        <h3>Actions</h3>
                        <form method="POST">
                            <button name="accept" class="view accept">Accept</button>
                            <button name="reject" class="view reject">Reject</button>
                        </form>

                        <button>
                    </div>
                </section>
            </section>
        </section>
    </main>
</body>

</html>