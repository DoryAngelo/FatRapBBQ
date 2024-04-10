<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];

if (isset($_POST['submit'])) {
    $FOOD_NAME = mysqli_real_escape_string($conn, $_POST['product-name']);
    $FOOD_DESC = mysqli_real_escape_string($conn, $_POST['product-desc']);
    $FOOD_PRICE =  $_POST['price'];
    $FOOD_STOCK = $_POST['stock'];
    $FOOD_ACTIVE = $_POST['active'];
    $CTGY_ID = $_POST['category'];


    if (isset($_FILES['image']['name'])) {
        $FOOD_IMG = $_FILES['image']['name'];

        if ($FOOD_IMG != "") {
            $image_info = explode(".", $FOOD_IMG);
            $ext = end($image_info);

            $FOOD_IMG = "FOOD_IMAGE_" . $FOOD_NAME . "." . $ext;

            $src = $_FILES['image']['tmp_name'];
            $dst = "images/" . $FOOD_IMG;

            $upload    = move_uploaded_file($src, $dst);

            if ($upload = false) {
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
                header('location:' . SITEURL . 'admin-home.php');
                die();
            }
        }
    } else {
        $FOOD_IMG = "";
    }
    $insert = "INSERT INTO food(CTGY_ID, FOOD_NAME, FOOD_PRICE, FOOD_DESC, FOOD_IMG, FOOD_STOCK, FOOD_ACTIVE) 
                       VALUES('$CTGY_ID', '$FOOD_NAME', '$FOOD_PRICE', '$FOOD_DESC', '$FOOD_IMG', '$FOOD_STOCK', '$FOOD_ACTIVE')";
    mysqli_query($conn, $insert);
}

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
        <section class="section calendar2">
            <div class="container">
                <div class="section-heading row back">
                    <h2>Calendar Slots</h2>
                    <a href="<?php echo SITEURL; ?>admin-home.php">Back</a>
                </div>
                <section class="section-body">
                    <section class="main-section">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="block">
                                <div class="header">
                                    <!-- <button id="prevBtn">
                                        <i class='bx bx-chevron-left'></i>
                                    </button>
                                    <h2>March</h2>
                                    <button id="nextBtn">
                                        <i class='bx bx-chevron-right'></i>
                                    </button> -->
                                    <button id="prevBtn">
                                        <i class='bx bx-chevron-left'></i>
                                    </button>
                                    <div class="monthYear" id="monthYear"></div>
                                    <button id="nextBtn">
                                        <i class='bx bx-chevron-right'></i>
                                    </button>
                                </div>
                                <div class="block-body">
                                    <div class="wrapper">
                                        <h3>Available</h3>
                                        <table class="alternating">
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="wrapper">
                                        <h3>Fully Booked</h3>
                                        <table class="alternating">
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="wrapper">
                                        <h3>Closed</h3>
                                        <table class="alternating">
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                            <tr>
                                                <td data-cell="Date and Time">03/25/2024</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                            <a class="big-btn" name="submit" href="<?php echo SITEURL; ?>admin-edit-calendar-slots.php">Edit</a>
                        </form>
                    </section>
                </section>
            </div>
                
        </section>
    </main>
    <script>
        const monthYearElement = document.getElementById('monthYear');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentDate = new Date();

        const updateCalendar = () => {
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();

            const monthYearString = currentDate.toLocaleString
            ('default', {month: 'long', year: 'numeric'});
            monthYearElement.textContent = monthYearString;

        }

        //NEED HELP WITH THIS
        prevBtn.addEventListener('click', () => {
            const displayedMonthYear = monthYearElement.innerText.split(' ');
            const displayedMonth = getMonthIndex(displayedMonthYear[0]); // Convert month name to index
            const displayedYear = parseInt(displayedMonthYear[1]);
            // if(
            //     currentDate.getMonth() === displayedMonth &&
            //     currentDate.getFullYear() === displayedYear
            // ) {
            //     prevBtn.classList.add("disabled");
            // } else {
            //     currentDate.setMonth(currentDate.getMonth() - 1);
            //     updateCalendar(); // Call the function to update the calendar
            // }
            
            // Check if the displayed month and year match the current date's month and year
            if (currentDate.getFullYear() === displayedYear && currentDate.getMonth() === displayedMonth) {
                // Check if the current date is within the displayed month
                const today = new Date();
                if (currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear()) {
                    prevBtn.classList.add("disabled");
                }
            } else {
                currentDate.setMonth(currentDate.getMonth() - 1);
                updateCalendar(); // Call the function to update the calendar
                prevBtn.classList.remove("disabled"); // Ensure the previous button is enabled
            }

        });

        nextBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateCalendar(); // Call the function to update the calendar
        });

        // Function to get the month index from its name
        function getMonthIndex(monthName) {
            const months = [
                'January', 'February', 'March', 'April',
                'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ];
            return months.indexOf(monthName);
        }

        updateCalendar();
    </script>
</body>

</html>