<?php

@include 'constants.php';

$PRSN_ROLE = $_SESSION['prsn_role'];
if ($PRSN_ROLE !== 'Admin') {
    header('location:' . SITEURL . 'login-page.php');
}

$PRSN_ID = $_SESSION['prsn_id'];

$food_type = isset($_GET['type']) ? $_GET['type'] : 'all';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Menu | Admin</title>
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
        <section class="section">
            <div class="container">
                <div class="section-heading row">
                    <h2>Menu</h2>
                    <select name="food-type" id="food-type" class="dropdown">
                        <option value="all" <?php echo ($food_type === 'all') ? 'selected' : ''; ?>>All</option>
                        <option value="Customer" <?php echo ($food_type === 'Customer') ? 'selected' : ''; ?>>Customer</option>
                        <option value="Wholesaler" <?php echo ($food_type === 'Wholesaler') ? 'selected' : ''; ?>>Wholesaler</option>
                    </select>
                </div>
                <script>
                    document.getElementById('food-type').addEventListener('change', function() {
                        var selectedFoodType = this.value;
                        window.location.href = "admin-edit-menu.php?type=" + selectedFoodType;
                    });
                </script>
                <section class="section-body">
                    <section class="main-section column">
                        <div class="table-wrapper">
                            <table class="alternating">
                                <tr>
                                    <th class="header">Image</th>
                                    <th class="header">Product Name</th>
                                    <th class="header">Stock</th>
                                    <th class="header">Start</th>
                                    <th class="header">End</th>
                                    <!-- <th class="header">Action</th>for edit button column -->
                                    <th class="header"></th> <!-- for delete button column-->
                                </tr>
                                <?php

                                $CUS_ID = $_SESSION['prsn_id'];

                                $food_type = isset($_GET['type']) ? $_GET['type'] : 'all';

                                if ($food_type === 'all') {
                                    $sql = "SELECT m.*, f.*
                                    FROM menu m
                                    JOIN food f ON m.food_id = f.food_id";
                                } else {
                                    $sql = "SELECT m.*, f.*
                                    FROM menu m
                                    JOIN food f ON m.food_id = f.food_id
                                    WHERE f.food_type = '$food_type'";
                                }

                                $res = mysqli_query($conn, $sql);

                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $MENU_ID = $row['MENU_ID'];
                                        $FOOD_ID = $row['FOOD_ID'];
                                        $FOOD_IMG = $row['FOOD_IMG'];
                                        $FOOD_NAME = $row['FOOD_NAME'];
                                        $MENU_STOCK = $row['MENU_STOCK'];
                                        $MENU_START = $row['MENU_START'];
                                        $MENU_END = $row['MENU_END'];

                                ?>

                                        <tr>
                                            <td data-cell="Image">
                                                <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                            </td>
                                            <td data-cell="Product Name"><?php echo $FOOD_NAME ?></td>
                                            <td data-cell="Stock">
                                                <span class="<?php echo ($MENU_STOCK < 100) ? 'red-text' : ''; ?>">
                                                    <p><?php echo $MENU_STOCK ?></p>
                                                </span>
                                            </td>
                                            <td data-cell="Start"><?php echo $MENU_START?></td>
                                            <td data-cell="End"><?php echo $MENU_END ?></td>
                                            <!-- <td data-cell="Action"> -->
                                                <!-- <a href="<?php echo SITEURL; ?>admin-edit-product.php?FOOD_ID=<?php echo $FOOD_ID ?>" class="edit">Edit</a> -->
                                                <!-- <a href="<?php echo SITEURL; ?>admin-add-menu.php?FOOD_ID=<?php echo $FOOD_ID ?>" class="edit">Edit</a> "Display" link in inventory page -->
                                            <!-- </td> -->
                                            <td data-cell="Action"><a href="#" onclick="confirmDelete(<?php echo $MENU_ID; ?>)" class="bx bxs-trash-alt trash"></a></td>
                                            <script>
                                                function confirmDelete(menuId) {
                                                    if (confirm("Are you sure you want to delete this item?")) {
                                                        window.location.href = "delete_menu.php?MENU_ID=" + menuId;
                                                    } else {
                                                        // Do nothing
                                                    }
                                                }
                                            </script>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <!-- <div class="error">No new orders</div> -->
                                    <tr>
                                        <td colspan="9" class="error">No items added</td>
                                    </tr>
                                <?php

                                }
                                ?>
                            </table>
                        </div>
                        <!-- <a href="<?php echo SITEURL; ?>admin-add-product.php" class="page-btn"><button class="big-btn">Add a new product</button></a> -->
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