<?php

@include 'constants.php';

$PRSN_ID = $_SESSION['prsn_id'];


$FOOD_ID = $_GET['FOOD_ID'];

$sql = "DELETE FROM food WHERE FOOD_ID=$FOOD_ID";

$res = mysqli_query($conn, $sql);

header('location:' . SITEURL . 'admin-edit-menu.php');
