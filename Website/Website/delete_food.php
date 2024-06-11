<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];
$PRSN_ROLE = $_SESSION['prsn_role'];

$FOOD_ID = $_GET['FOOD_ID'];

// Retrieve the image name before deleting the food item
$sql = "SELECT FOOD_IMG FROM food WHERE FOOD_ID=$FOOD_ID";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $image_name = $row['FOOD_IMG'];

    // Delete the image file if it exists
    if ($image_name != "") {
        $image_path = "images/" . $image_name;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}

// Delete the food item from the database
$sql = "DELETE FROM food WHERE FOOD_ID=$FOOD_ID";
$res = mysqli_query($conn, $sql);

header('Location: ' . SITEURL . $PRSN_ROLE . '-inventory.php');
exit();

?>
