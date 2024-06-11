<?php
@include 'constants.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["IN_ORDER_ID"]) && isset($_POST["IN_ORDER_QUANTITY"])) {

    $IN_ORDER_ID = intval($_POST["IN_ORDER_ID"]);
    $quantity = intval($_POST["IN_ORDER_QUANTITY"]);
    $FOOD_PRICE = intval($_POST["FOOD_PRICE"]);
    $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'] + ($quantity * $FOOD_PRICE);
    
    $query = "UPDATE in_order SET 
    IN_ORDER_QUANTITY = '$quantity',
    IN_ORDER_TOTAL =  '$IN_ORDER_TOTAL'
     WHERE IN_ORDER_ID = '$IN_ORDER_ID'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity";
    }
} else {
    echo "Invalid request";
}
?>
