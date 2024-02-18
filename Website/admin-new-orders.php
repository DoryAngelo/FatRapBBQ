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
    <title>New Orders | Admin</title>
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
            <div class="section-heading">
                <h2>New Orders</h2>
                <div class="inline">
                    <p>Date range:</p>
                    <input type="date">
                </div>
            </div>
            <section class="section-body">
                <section class="main-section table-wrapper">
                    <table class="alternating">
                        <tr>
                            <th class="header">Date and Time</th>
                            <th class="header">Customer</th>
                            <th class="header">Order #</th>
                            <th class="header">Payment</th>
                            <th class="header">Confirmed</th>
                        </tr>
                        <!-- PLACEHOLDER TABLE ROWS FOR FRONTEND TESTING PURPOSES -->
                        <?php
                        $sql = "SELECT * FROM placed_order";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        if ($count > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $PLACED_ORDER_ID = $row['PLACED_ORDER_ID'];
                                $CUS_ID = $row['CUS_ID'];
                                $CUS_NAME = $row['CUS_NAME'];
                                $PLACED_ORDER_DATE = $row['PLACED_ORDER_DATE'];
                                $PLACED_ORDER_TOTAL = $row['PLACED_ORDER_TOTAL'];
                                $DELIVERY_ADDRESS = $row['DELIVERY_ADDRESS'];
                                $DELIVERY_DATE = $row['DELIVERY_DATE'];
                                $PLACED_ORDER_STATUS = $row['PLACED_ORDER_STATUS'];
                        ?>
                                <tr>
                                    <td data-cell="Date and Time"><?php echo $PLACED_ORDER_DATE?></td>
                                    <td data-cell="customer"><?php echo $CUS_NAME?></td>
                                    <td data-cell="Order #"><?php echo $PLACED_ORDER_ID?></td>
                                    <td data-cell="Payment">₱<?php echo $PLACED_ORDER_TOTAL?></td>
                                    <td data-cell="Confimed">
                                        <div class="btn-wrapper">
                                            <button class="btn-check"><i class='bx bxs-check-circle'></i></button>
                                            <button class="btn-cross"><i class='bx bxs-x-circle'></i></button>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<div class='error'>No Order Found</div>";
                        }
                        ?>
                    </table>
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
                        <a href="" class="view big-font">Paid Orders</a>
                        <a href="" class="view big-font">Preparing Orders</a>
                        <a href="" class="view big-font">For Delivery</a>
                        <a href="" class="view big-font">Completed Orders</a>
                        <a href="" class="view big-font">Cancelled Orders</a>
                    </div>
                </section>
            </section>
        </section>
    </main>
</body>

</html>