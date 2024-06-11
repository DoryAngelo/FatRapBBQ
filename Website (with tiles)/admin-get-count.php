<?php
@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];
$sql = "SELECT 
            SUM(CASE WHEN DATE_STATUS = 'available' THEN 1 ELSE 0 END) AS available_count,
            SUM(CASE WHEN DATE_STATUS = 'fullybooked' THEN 1 ELSE 0 END) AS fullybooked_count,
            SUM(CASE WHEN DATE_STATUS = 'closed' THEN 1 ELSE 0 END) AS closed_count
        FROM calendar";

$res = mysqli_query($conn, $sql);

if ($res) {
    $row = mysqli_fetch_assoc($res);
    $counts = array(
        'available_count' => $row['available_count'],
        'fullybooked_count' => $row['fullybooked_count'],
        'closed_count' => $row['closed_count']
    );
    echo json_encode($counts); // Return counts in JSON format
} else {
    echo json_encode(array()); // Return empty array if query fails
}
?>
