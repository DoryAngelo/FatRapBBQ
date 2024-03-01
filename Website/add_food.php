<?php

include('constants.php');

$PRSN_ID = $_GET['PRSN_ID'];
$FOOD_ID = $_GET['FOOD_ID'];
$FOOD_PRICE = $_GET['FOOD_PRICE'];

$sql = "INSERT INTO in_order SET
    FOOD_ID = '$FOOD_ID',
    CUS_ID = '$PRSN_ID',
    IN_ORDER_QUANTITY = 1,
    IN_ORDER_TOTAL = $FOOD_PRICE,
    IN_ORDER_STATUS = 'Ordered'
    ";

    $res2 = mysqli_query($conn,$sql);
    header('location:cus-home-page.php');
?>