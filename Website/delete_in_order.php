<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];


$IN_ORDER_ID = $_GET['IN_ORDER_ID'];

$sql = "DELETE FROM in_order WHERE IN_ORDER_ID=$IN_ORDER_ID";

$res = mysqli_query($conn, $sql);

header('location:'.SITEURL.'cart.php');
?>