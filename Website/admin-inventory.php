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
    <title>Inventory | Admin</title>
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
                <div class="section-heading row">
                    <h2>Inventory</h2>
                    <select name="food-type" id="food-type" class="dropdown">
                        <option value="all" <?php echo ($food_type === 'all') ? 'selected' : ''; ?>>All</option>
                        <option value="Customer" <?php echo ($food_type === 'Customer') ? 'selected' : ''; ?>>Customer</option>
                        <option value="Wholesaler" <?php echo ($food_type === 'Wholesaler') ? 'selected' : ''; ?>>Wholesaler</option>
                    </select>
                </div>
                <script>
                    document.getElementById('food-type').addEventListener('change', function() {
                        var selectedFoodType = this.value;
                        window.location.href = "admin-inventory.php?type=" + selectedFoodType;
                    });
                </script>
                <section class="section-body">
                    <section class="main-section column">
                        <div class="table-wrapper">
                            <table class="alternating">
                                <tr>
                                    <th class="header">Image</th>
                                    <th class="header">Product Name</th>
                                    <th class="header">Price</th>
                                    <th class="header">Stock</th>
                                    <th class="header">Type</th>
                                    <th class="header">Action</th>
                                    <th class="header"></th>
                                </tr>
                                <?php
                                $CUS_ID = $_SESSION['prsn_id'];
                                $food_type = isset($_GET['type']) ? $_GET['type'] : 'all';

                                if ($food_type === 'all') {
                                    $sql = "SELECT * FROM food";
                                } else {
                                    $sql = "SELECT * FROM food WHERE FOOD_TYPE = '$food_type'";
                                }

                                $res = mysqli_query($conn, $sql);

                                $count = mysqli_num_rows($res);

                                if ($count > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $FOOD_ID = $row['FOOD_ID'];
                                        $FOOD_NAME = $row['FOOD_NAME'];
                                        $FOOD_PRICE = $row['FOOD_PRICE'];
                                        $FOOD_IMG = $row['FOOD_IMG'];
                                        $FOOD_STOCK = $row['FOOD_STOCK'];
                                        $FOOD_ACTIVE = $row['FOOD_ACTIVE'];
                                        $FOOD_TYPE = $row['FOOD_TYPE'];
                                ?>
                                        <tr>
                                            <td data-cell="Image">
                                                <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                                            </td>
                                            <td data-cell="Product Name"><?php echo $FOOD_NAME ?></td>
                                            <td data-cell="Price">₱<?php echo $FOOD_PRICE ?></td>
                                            <td data-cell="Stock">
                                                <span class="<?php echo ($FOOD_STOCK < 100) ? 'red-text' : ''; ?>">
                                                    <p><?php echo $FOOD_STOCK ?></p>
                                                </span>
                                            </td>
                                            <td data-cell="Price"><?php echo $FOOD_TYPE ?></td>
                                            <td data-cell="Action"><a href="<?php echo SITEURL; ?>admin-edit-product.php?FOOD_ID=<?php echo $FOOD_ID ?>" class="edit">Edit</a></td>
                                            <td data-cell="Action"><a href="#" onclick="confirmDelete(<?php echo $FOOD_ID; ?>)" class="bx bxs-trash-alt trash"></a></td>
                                            <script>
                                                function confirmDelete(foodId) {
                                                    if (confirm("Are you sure you want to delete this item?")) {
                                                        window.location.href = "delete_food.php?FOOD_ID=" + foodId;
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
                                        <td colspan="5" class="error">Empty</td>
                                    </tr>
                                <?php

                                }
                                ?>
                            </table>
                        </div>
                        <a href="<?php echo SITEURL; ?>admin-add-product.php" class="page-btn"><button class="big-btn">Add a new product</button></a>
                    </section>
                </section>
            </div>
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
        </section>
    </main>
</body>

</html>