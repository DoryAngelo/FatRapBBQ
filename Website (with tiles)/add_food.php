<?php

include('constants.php');

$PRSN_ID = $_GET['PRSN_ID'];
$FOOD_ID = $_GET['FOOD_ID'];
$FOOD_PRICE = $_GET['FOOD_PRICE'];

$sql = "SELECT * FROM in_order WHERE FOOD_ID = $FOOD_ID AND PRSN_ID = $PRSN_ID";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if ($count > 0) {

    while ($row = mysqli_fetch_assoc($res)) {
        $IN_ORDER_ID = $row['IN_ORDER_ID'];
        $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'] + 1;
        $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'] + $FOOD_PRICE;

        $sql = "UPDATE in_order SET 
                        IN_ORDER_QUANTITY = $IN_ORDER_QUANTITY,
                        IN_ORDER_TOTAL = $IN_ORDER_TOTAL
                        WHERE IN_ORDER_ID = $IN_ORDER_ID";
        $res_update = mysqli_query($conn, $sql_update);
        header('location:cus-home-page.php');
    }
} else {

    $sql2 = "INSERT INTO in_order SET
            FOOD_ID = '$FOOD_ID',
            CUS_ID = '$CUS_ID',
            IN_ORDER_QUANTITY = 1,
            IN_ORDER_TOTAL = $FOOD_PRICE,
            IN_ORDER_STATUS = 'Ordered'
            ";

    $res2 = mysqli_query($conn, $sql2);
    header('location:cus-home-page.php');
}
?>