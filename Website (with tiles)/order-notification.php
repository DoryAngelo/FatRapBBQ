<?php

@include 'constants.php';

// Check if session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in as Admin or Employee
if ($_SESSION['prsn_role'] !== 'Admin' && $_SESSION['prsn_role'] !== 'Employee') {
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$current_date = date('Y-m-d');

$sql = "DELETE FROM calendar WHERE STR_TO_DATE(CALENDAR_DATE, '%M %d %Y') < '$current_date'";
$res = mysqli_query($conn, $sql);



// Check for new orders
if ($_SESSION['prsn_role'] === 'Admin') {
    $selectNO = "SELECT * FROM placed_order WHERE PLACED_ORDER_STATUS = 'Placed'";
} else { 
    $selectNO = "SELECT * FROM placed_order WHERE PLACED_ORDER_STATUS = 'To Prepare'";
}
$resNO = mysqli_query($conn, $selectNO);
$countNO = mysqli_num_rows($resNO);

// Send appropriate response
if ($countNO > 0) {
    echo "NewOrder";
} else {
    echo "NoNewOrder";
}

// Close database connection
mysqli_close($conn);
