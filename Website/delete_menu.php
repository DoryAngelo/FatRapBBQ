<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];
$PRSN_ROLE = $_SESSION['prsn_role'];

$MENU_ID = $_GET['MENU_ID'];


// Delete the food item from the database
$sql = "DELETE FROM menu WHERE MENU_ID=$MENU_ID";
$res = mysqli_query($conn, $sql);

header('Location: ' . SITEURL . $PRSN_ROLE . '-edit-menu.php');
exit();

?>
