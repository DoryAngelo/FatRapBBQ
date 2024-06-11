<?php

@include 'constants.php';

if (isset($_SESSION['prsn_id'])) {
    $PRSN_ID = $_SESSION['prsn_id'];
} else if (isset($_SESSION['guest_id'])) {
    $_SESSION['prsn_role'] = "Customer";
    $GUEST_ID = $_SESSION['guest_id'];
} else {
    $random = random_bytes(16);
    $GUEST_ID = bin2hex($random);
    $_SESSION['prsn_role'] = "Customer";
    $_SESSION['guest_id'] =   $GUEST_ID;
}

$PRSN_ROLE = $_SESSION['prsn_role'];

$FOOD_ID = $_GET['FOOD_ID'];

$sql = "SELECT * FROM food WHERE FOOD_ID = '$FOOD_ID'";

$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);
$hourly_capacity = [];
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $FOOD_NAME = $row['FOOD_NAME'];
        $FOOD_DESC = $row['FOOD_DESC'];
        $FOOD_IMG = $row['FOOD_IMG'];
        $FOOD_PRICE = $row['FOOD_PRICE'];
        $FOOD_STOCK = $row['FOOD_STOCK'];
        $HOURLY_CAP = $row['HOURLY_CAP'];
        $hourly_capacity = array_fill(0, 7, $row['HOURLY_CAP']);
    }
}

$SELECTED_DATE = isset($_SESSION['DATE_SELECTED']) ? $_SESSION['DATE_SELECTED'] : date('M j Y');

$avail = $hourly_capacity;

$sql_orders = "
    SELECT DELIVERY_HOUR, SUM(in_order_quantity) AS total_quantity
    FROM in_order
    WHERE placed_order_id IS NOT NULL
    AND DELIVERY_DATE = '$SELECTED_DATE'
    AND FOOD_ID = '$FOOD_ID'
    GROUP BY DELIVERY_HOUR
";

$res = mysqli_query($conn, $sql_orders);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $delivery_hour = $row['DELIVERY_HOUR'];
        $total_quantity = $row['total_quantity'];
        $avail[$delivery_hour - 10] -= $total_quantity;
    }
}

$total_sum = array_sum($avail);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $FOOD_PRICE = $_POST['price'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
    $time = isset($_POST['selectedTime']) ? $_POST['selectedTime'] : null;

    if (isset($_SESSION['prsn_id'])) {
        $sql = "SELECT * FROM in_order WHERE FOOD_ID = $FOOD_ID AND PRSN_ID = $PRSN_ID AND PLACED_ORDER_ID IS NULL";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
    } else {
        $sql = "SELECT * FROM in_order WHERE FOOD_ID = $FOOD_ID AND GUEST_ORDER_IDENTIFIER = '$GUEST_ID' AND PLACED_ORDER_ID IS NULL";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
    }
    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $IN_ORDER_ID = $row['IN_ORDER_ID'];
            $IN_ORDER_QUANTITY += $quantity;
            $IN_ORDER_TOTAL = $IN_ORDER_QUANTITY * $FOOD_PRICE;
            $sql = "UPDATE in_order SET 
                            IN_ORDER_QUANTITY = $IN_ORDER_QUANTITY,
                            IN_ORDER_TOTAL = $IN_ORDER_TOTAL,
                            DELIVERY_HOUR = '$time'
                            WHERE IN_ORDER_ID = $IN_ORDER_ID";
            $res_update = mysqli_query($conn, $sql);
        }
    } else {
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
        $IN_ORDER_TOTAL = (float)$quantity * (float)$FOOD_PRICE;
        if (isset($_SESSION['prsn_id'])) {
            $sql2 = "INSERT INTO in_order (FOOD_ID, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS, DELIVERY_DATE, DELIVERY_HOUR)
            VALUES ('$FOOD_ID', '$PRSN_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered', '$SELECTED_DATE', '$time')";
        } else {
            $sql2 = "INSERT INTO in_order (FOOD_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL, IN_ORDER_STATUS, GUEST_ORDER_IDENTIFIER, DELIVERY_DATE, DELIVERY_HOUR)
            VALUES ('$FOOD_ID', '$quantity', '$IN_ORDER_TOTAL', 'Ordered', '$GUEST_ID', '$SELECTED_DATE', '$time')";
        }
        $res2 = mysqli_query($conn, $sql2);
    }
    // Redirect to the home page after processing
    $_SESSION['fromProdInfo'] = 'yes';
    header('location:menu.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--change title-->
    <title>Product Information | Fat Rap's Barbeque's Online Store</title>
    <link rel="stylesheet" href="header-styles.css">
    <link rel="stylesheet" href="customer-styles.css"><!--change css file-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="app.js" defer></script>
    <!-- add the code below to load the icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .tile {
            flex: 1;
            max-width: 100px;
            height: 100px;
            margin: 10px;
            background-color: lightblue;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .disabled {
            background-color: gray;
            pointer-events: none;
        }

        .selected {
            background-color: darkblue;
        }
    </style>
</head>

<body class="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'wholesaler' : ''; ?>">
    <header class="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'wholesaler' : ''; ?>">
        <div class="header-container">
            <div class="website-title">
                <img id="logo" src="images/client-logo.png">
                <div class="text">
                    <h1>Fat Rap's Barbeque</h1>
                    <?php
                    if ($PRSN_ROLE == "Wholesaler") {
                    ?>
                        <p>WHOLESALE</p>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <input type="checkbox" id="menu-toggle">
            <label class='menu-button-container' for="menu-toggle">
                <div class='menu-button'></div>
            </label>
            <ul class='menubar'>
                <li><a href="<?php echo SITEURL; ?>cus-home-page.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>menu.php">Menu</a></li>
                <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
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
        <section class="section product-info-page">
            <div class="container">
                <div class="wrapper">
                    <a href="<?php echo SITEURL; ?>menu.php" class="back">Back</a>
                    <section class="block">
                        <img src="<?php echo SITEURL; ?>images/<?php echo $FOOD_IMG; ?>" alt="">
                        <div class="right-grp">
                            <div class="top">
                                <h1><?php echo $FOOD_NAME ?></h1>
                                <p><?php echo $FOOD_DESC ?></p>
                            </div>
                            <?php

                            $IN_ORDER_QUANTITY = isset($IN_ORDER_QUANTITY) ? $IN_ORDER_QUANTITY : 1;

                            if (isset($_SESSION['prsn_id'])) {
                                $sql = "SELECT io.IN_ORDER_QUANTITY
            FROM in_order io
            JOIN food f ON io.FOOD_ID = f.FOOD_ID
            WHERE io.IN_ORDER_STATUS != 'Delivered' 
            AND io.PRSN_ID = '$PRSN_ID'
            AND io.placed_order_id IS NULL
            AND io.food_id = '$FOOD_ID'
            ";
                            } else {
                                $sql = "SELECT io.IN_ORDER_QUANTITY
            FROM in_order io
            JOIN food f ON io.FOOD_ID = f.FOOD_ID
            WHERE io.IN_ORDER_STATUS != 'Delivered' 
            AND io.GUEST_ORDER_IDENTIFIER = '$GUEST_ID'
            AND io.placed_order_id IS NULL
            AND io.food_id = '$FOOD_ID'
            ";
                            }
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);
                            $stockValues = array();
                            $flagValues = array();
                            $quantityExceedsStock = false;

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'];
                                }
                            }
                            ?>

                            <form class="bottom" id="addToDatabaseForm" method="POST" onsubmit="return addToDatabase()">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <div class="inline">
                                    <h1>₱<?php echo $FOOD_PRICE ?></h1>
                                    <p id="<?php echo ($PRSN_ROLE === 'Wholesaler') ? 'stick-hidden' : ''; ?>">per stick</p>
                                    <div class="quantity-grp">
                                        <input name="quantity" type="number" id="quantity" class="amount js-num" value="<?php echo $IN_ORDER_QUANTITY ?>" min="1" max="<?php echo $total_sum ?>" oninput="checkCapacity()">
                                    </div>
                                    <!-- <?php if ($PRSN_ROLE === "Wholesaler") { ?>
                                        <p id="cumulativeCapacity" class="remaining">available</p>
                                    <?php } else { ?>
                                        <p></p>
                                        <p id="cumulativeCapacity" class="remaining"> sticks available</p>
                                    <?php } ?> -->
                                    <p id="cumulativeCapacity" class="remaining"></p>
                                </div>
                                <!-- <input type="hidden" id="selected_time" name="selected_time" value="">
                                <input type="hidden" id="quantity" name="quantity" value="1"> -->
                                <input type="hidden" id="selectedTime" name="selectedTime">
                                <!-- <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" min="1"> -->
                                <input type="hidden" name="price" value="<?php echo $FOOD_PRICE ?>">
                                <!-- <input type="number" id="quantity" placeholder="Enter quantity" oninput="checkCapacity()" min="1"> -->
                                <div class="container" id="tileContainer"></div>
                                <button name="order" type="submit" <?php echo ($avail <= 0 || (isset($_POST['quantity']) && ($IN_ORDER_QUANTITY + intval($_POST['quantity']) > $avail))) ? 'disabled' : ''; ?>>Add to Cart</button>
                            </form>
                            <script>
                                // Pass the $avail array from PHP to JavaScript
                                const avail = <?php echo json_encode($avail); ?>;
                                let selectedTile = null;

                                function createHourTiles() {
                                    const container = document.getElementById('tileContainer');
                                    const startHour = 10;
                                    const endHour = 16;

                                    for (let hour = startHour; hour <= endHour; hour++) {
                                        const tile = document.createElement('div');
                                        tile.className = 'tile';
                                        const period = hour < 12 ? 'AM' : 'PM';
                                        const displayHour = hour % 12 === 0 ? 12 : hour % 12;
                                        tile.textContent = `${displayHour}:00 ${period}`;
                                        tile.id = `tile-${hour}`;
                                        tile.addEventListener('click', () => selectTile(tile, displayHour, period));
                                        container.appendChild(tile);
                                    }
                                }

                                function checkCapacity() {
                                    const quantity = parseInt(document.getElementById('quantity').value, 10);
                                    const startHour = 10;
                                    const endHour = 16; // 4:00 PM
                                    let cumulativeCapacity = 0;

                                    for (let hour = startHour; hour <= endHour; hour++) {
                                        cumulativeCapacity += Number(avail[hour - startHour]);
                                        const tile = document.getElementById(`tile-${hour}`);
                                        if (quantity > cumulativeCapacity) {
                                            tile.classList.add('disabled');
                                        } else {
                                            tile.classList.remove('disabled');
                                        }
                                    }


                                    const lastHourCapacity = cumulativeCapacity + " remaining";


                                    document.getElementById('cumulativeCapacity').textContent = lastHourCapacity;
                                }

                                function selectTile(tile, displayHour, period) {
                                    if (tile.classList.contains('disabled')) return;

                                    if (selectedTile) {
                                        selectedTile.classList.remove('selected');
                                    }

                                    tile.classList.add('selected');
                                    selectedTile = tile;
                                    addToDatabase();
                                }

                                function addToDatabase() {
                                    // Retrieve the selected time
                                    let selectedTime = null;
                                    const selectedTile = document.querySelector('.selected');
                                    if (selectedTile) {
                                        selectedTime = selectedTile.textContent.trim();
                                        document.getElementById('selectedTime').value = selectedTime;
                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Please select time!",
                                            iconColor: 'yellow',
                                            confirmButtonText: '<font color="3A001E">OK</font>',
                                            confirmButtonColor: '#F5D636',
                                            color: 'white',
                                            background: '#C13B24',
                                        });
                                        return false; // Return false to prevent form submission
                                    }
                                }

                                window.onload = function() {
                                    createHourTiles();
                                    checkCapacity();
                                };
                            </script>

                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <div class="left-container">
                <h2>Fat Rap's Barbeque</h2>
                <div class="list">
                    <ul>
                        <li><a href="<?php echo SITEURL; ?>cus-home-page.php">Home</a></li>
                        <li><a href="<?php echo SITEURL; ?>menu.php">Menu</a></li>
                        <li><a href="<?php echo SITEURL; ?>cart.php">Cart</a></li>
                        <li><a href="cus-home-page.php#track-order-section">Track order</a></li>
                    </ul>
                </div>
            </div>
            <div class="right-container">
                <div class="icons-block">
                    <a href="https://www.facebook.com/profile.php?id=100077565231475">
                        <i class='bx bxl-facebook-circle'></i>
                    </a>
                </div>
                <div class="list">
                    <!-- <div class="list-items">
                        <i class='bx bxs-envelope'></i>
                        <p>email@gmail.com</p>
                    </div> -->
                    <div class="list-items">
                        <i class='bx bxs-phone'></i>
                        <p>09178073760 | 09190873861</p>
                    </div>
                    <div class="list-items">
                        <i class='bx bxs-map'></i>
                        <p>Sta. Ignaciana, Brgy. Kalusugan, Quezon City, Metro Manila, Philippines</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputField = document.querySelector('.js-num');
            const quantityInput = document.getElementById("quantity");
            const addButton = document.querySelector('[name="order"]');
            const maxStock = <?php echo $total_sum; ?>;
            const quantityData = <?php echo isset($IN_ORDER_QUANTITY) ? $IN_ORDER_QUANTITY : 0; ?>;

            inputField.addEventListener('input', function() {
                let currentValue = parseInt(inputField.value, 10);
                if (isNaN(currentValue) || currentValue < 1) {
                    inputField.value = 1;
                } else if (currentValue > maxStock) {
                    Swal.fire({
                        icon: "error",
                        title: "The quantity exceeds the available stock!",
                        text: "Please review your order.",
                        iconColor: 'yellow',
                        confirmButtonText: '<font color="3A001E">OK</font>',
                        confirmButtonColor: '#F5D636',
                        color: 'white',
                        background: '#C13B24',
                    });
                    inputField.value = maxStock;
                }

                quantityInput.value = inputField.value;
                updateButtonState();
            });

            function updateButtonState() {
                const currentQuantity = parseInt(inputField.value, 10);
                addButton.disabled = (maxStock <= 0 || currentQuantity + quantityData > maxStock);
            }

            updateButtonState();
        });
    </script>

    <!-- floating button -->
    <a href="<?php echo SITEURL; ?>cart.php" class="material-icons floating-btn" style="font-size: 45px;">shopping_cart</a>

</body>

</html>