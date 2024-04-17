<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];


$PLACED_ORDER_ID = $_GET['PLACED_ORDER_ID'];

$sql = "DELETE FROM in_order WHERE PLACED_ORDER_ID=$PLACED_ORDER_ID";

$res = mysqli_query($conn, $sql);

$sql2 = "DELETE FROM placed_order WHERE PLACED_ORDER_ID=$PLACED_ORDER_ID";

$res = mysqli_query($conn, $sql2);

// Redirect back to the page it came from
$redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : SITEURL . 'admin-home.php';
header('location: ' . $redirect_url);
exit();
?>