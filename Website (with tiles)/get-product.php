<?php

@include 'constants.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["FOOD_ID"]) && isset($_POST["date"]) && isset($_POST["time"])) {


    $FOOD_ID = mysqli_real_escape_string($conn, $_POST["FOOD_ID"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $time = mysqli_real_escape_string($conn, $_POST["time"]);


    $datetime = date("Y-m-d H:i:s", strtotime("$date $time"));


    $query = "SELECT menu_stock FROM menu WHERE food_id = '$FOOD_ID' AND '$datetime' BETWEEN STR_TO_DATE(menu_start, '%M %d, %Y %r') AND STR_TO_DATE(menu_end, '%M %d, %Y %r')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $menuStock = $row['menu_stock'];
            echo json_encode(array("menu_stock" => $menuStock));
        } else {
            echo json_encode(array("error" => "Product not available at the selected date and time."));
        }
    } else {
        echo json_encode(array("error" => "Error executing query."));
    }
} else {
    echo json_encode(array("error" => "Invalid request."));
}
?>
