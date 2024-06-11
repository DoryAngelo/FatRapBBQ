<?php
@include 'constants.php';

// Check if the request method is POST and if the date parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["date"])) {
    // Get the date from the POST parameters
    $date = $_POST["date"];

    // Prepare the query to fetch status for the given date
    $query = "SELECT DATE_STATUS FROM calendar WHERE CALENDAR_DATE = ?";
    
    // Prepare and bind the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);

    // Execute the statement
    $stmt->execute();

    // Bind the result variable
    $stmt->bind_result($status);

    // Fetch the status
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Check if status is fetched successfully
    if ($status !== null) {
        // Return status as JSON
        echo json_encode(array("status" => $status));
    } else {
        // Return an error message if status is not found
        echo json_encode(array("error" => "Status not found for the given date"));
    }
} else {
    // Return an error message if the request is invalid
    echo json_encode(array("error" => "Invalid request"));
}
?>
