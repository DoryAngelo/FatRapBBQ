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
    <title>Admin Profile | Admin</title>
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
            <ul class='menubar'>
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
        <section class="section add-edit-menu admin-profile">
            <div class="container">
                <div class="section-wrapper">
                    <div class="section-heading row back">
                        <h2>Admin Profile</h2>
                        <a href="<?php echo SITEURL; ?>admin-home.php">Back</a>
                    </div>
                    <section class="section-body">
                        <section class="main-section column">
                            <form action="#" class="column" method="post" enctype="multipart/form-data">
                                <?php
                                $sql = "SELECT *
                                FROM person
                                INNER JOIN employee ON person.PRSN_ID = employee.PRSN_ID
                                WHERE person.PRSN_ID = '$PRSN_ID';
                                ";

                                $res = mysqli_query($conn, $sql);

                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $PRSN_NAME = $row['PRSN_NAME'];
                                        $EMP_ID = $row['EMP_ID'];
                                        $EMP_IMG = $row['EMP_IMAGE'];
                                        $EMP_BRANCH = $row['EMP_BRANCH'];
                                        $PRSN_ROLE = $row['PRSN_ROLE'];
                                ?>
                                        <div class="block">
                                            <div class="image-group">
                                                <img src="<?php echo SITEURL; ?>images/<?php echo $EMP_IMG; ?>" alt="">
                                                <p><?php echo $PRSN_NAME ?></p>
                                            </div>
                                            <table>
                                                <tr>
                                                    <th>Username</th>
                                                    <td><?php echo $PRSN_NAME?></td>
                                                </tr>
                                                <tr>
                                                    <th>Branch</th>
                                                    <td><?php echo $EMP_BRANCH?></td>
                                                </tr>
                                                <tr>
                                                    <th>Role</th>
                                                    <td><?php echo $PRSN_ROLE?></td>
                                                </tr>
                                            </table>
                                    <?php
                                    }
                                }
                                    ?>

                                        </div>
                                        <a href="<?php echo SITEURL; ?>admin-edit-profile.php?PRSN_ID=<?php echo $PRSN_ID ?>&EMP_ID=<?php echo $EMP_ID ?>" class="big-btn">Edit</a>
                                        
                            </form>
                        </section>
                    </section>
                </div>
            </div>
        </section>
    </main>
</body>

</html>