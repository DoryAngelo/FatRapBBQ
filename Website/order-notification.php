<?php
// Include necessary files/constants and establish database connection
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

// Check for new orders
if ($_SESSION['prsn_role'] === 'Admin') {
    $selectNO = "SELECT * FROM placed_order WHERE PLACED_ORDER_STATUS = 'Placed'";
} else { // For employees, check if there are orders in preparing status
    $selectNO = "SELECT * FROM placed_order WHERE PLACED_ORDER_STATUS = 'Preparing'";
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
?>
