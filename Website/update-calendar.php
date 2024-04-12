<?php
@include 'constants.php';

// Get data sent by JavaScript
$date = isset($_POST['date']) ? $_POST['date'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;

if ($date && $status) {
    // Check if the date already exists in the database
    $check_sql = "SELECT * FROM calendar WHERE CALENDAR_DATE = '$date'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Date already exists, update the status
        $update_sql = "UPDATE calendar SET DATE_STATUS = '$status' WHERE CALENDAR_DATE = '$date'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Data updated successfully";
        } else {
            echo "Error updating data: " . $conn->error;
        }
    } else {
        // Date doesn't exist, insert a new record
        $insert_sql = "INSERT INTO calendar (CALENDAR_DATE, DATE_STATUS) VALUES ('$date', '$status')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    }
} else {
    echo "Error: Date or status is missing";
}

$conn->close();
?>
