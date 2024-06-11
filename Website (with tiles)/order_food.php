<?php

include('constants.php');

$PRSN_ID = $_GET['PRSN_ID'];
$FOOD_ID = $_GET['FOOD_ID'];
$FOOD_PRICE = $_GET['FOOD_PRICE'];


    $sql2 = "INSERT INTO in_order SET
    FOOD_ID = '$FOOD_ID',
    CUS_ID = '$PRSN_ID',
    IN_ORDER_QUANTITY = 1,
    IN_ORDER_TOTAL = $FOOD_PRICE,
    IN_ORDER_STATUS = 'Ordered'
    ";

    $res2 = mysqli_query($conn,$sql2);
    if($res2==true)
    {
        $_SESSION['add-order'] = "<div class='success text-center'>Order Added Successfull</div>";
        header('location:home.php');;

    }
    else
    {
        $_SESSION['add-order'] = "<div class='error text-center'>Failed To Add Order</div>";
        header('location:home.php');;
    }
?>