<?php
@include 'constants.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["WHL_ID"]) && isset($_POST["WHL_STATUS"])) {

    $WHL_ID = intval($_POST["WHL_ID"]);
    $WHL_STATUS = $_POST["WHL_STATUS"]; 

    $query = "UPDATE wholesaler 
              SET WHL_STATUS = '$WHL_STATUS'
              WHERE WHL_ID = $WHL_ID"; 
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
