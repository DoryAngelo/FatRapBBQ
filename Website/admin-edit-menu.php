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
    <title>Edit Menu | Admin</title>
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
                <h2>Edit Menu</h2>
                <input type="date">
                <!-- <div class="inline">
                        <p>Date range:</p>
                        <input type="date">
                    </div> -->
            </div>
            <section class="section-body">
                <section class="main-section column">
                    <div class="table-wrapper">
                        <table class="alternating">
                            <tr>
                                <th class="header">Image</th>
                                <th class="header">Product Name</th>
                                <th class="header">Category</th>
                                <th class="header">Price</th>
                                <th class="header">Active</th>
                                <th class="header"></th>
                            </tr>
                            <?php

                            $CUS_ID = $_SESSION['prsn_id'];

                            $sql = "SELECT * 
                                FROM food
                                JOIN category ON food.ctgy_id = category.ctgy_id";

                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {

                                    $FOOD_NAME = $row['FOOD_NAME'];
                                    $FOOD_PRICE = $row['FOOD_PRICE'];
                                    $FOOD_IMG = $row['FOOD_IMG'];
                                    $CTGY_NAME = $row['CTGY_NAME'];
                                    $FOOD_ACTIVE = $row['FOOD_ACTIVE'];
                            ?>

                                    <tr>
                                        <td data-cell="Image"><img class="prod-img" src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt=""></td>
                                        <td data-cell="Product Name"><?php echo $FOOD_NAME?></td>
                                        <td data-cell="Category"><?php echo $CTGY_NAME?></td>
                                        <td data-cell="Price">₱<?php echo $FOOD_PRICE?></td>
                                        <td data-cell="Display"><?php echo $FOOD_ACTIVE?></td>
                                        <td data-cell="Action"><a href="">Edit</a></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <a href="" class="page-btn"><button class="big-btn">Add a new product</button></a>
                </section>
            </section>
        </section>
    </main>
</body>

</html>