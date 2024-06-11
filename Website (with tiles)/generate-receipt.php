<?php

@include 'constants.php';

require('fpdf185/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
          
        $this->Image('images/client-logo.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(40);
        $this->Cell(30, 10, 'Fat Rap BBQ', 0, 1, 'C');

        $this->SetFont('Arial', "I", 8);
        $this->Cell(38);
        $this->Cell(30, 5, 'Sta. Ignaciana, Brgy. Kalusugan,', 0, 1);
        $this->Cell(38);
        $this->Cell(30, 5, 'Quezon City, Metro Manila, Philippines', 0, 1);
        $this->Cell(38);
        $this->Cell(30, 5, '09178073760 | 09190873861', 0, 0);
        $this->Ln(20);

        $width = $this->GetPageWidth();
        $height = $this->GetPageHeight();
        $this->Line(13, 20 * 2, $width - 13, 20 * 2);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 10, 'Page' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Ln(20);
    }
}



if (isset($_GET['id'])) {
    $PLACED_ORDER_ID = $_GET['id'];

    $pdf = new PDF('P', 'mm', "A4");
    $pdf->AliasNbPages();

    $pdf->AddPage();

    $sql = "SELECT *
    FROM placed_order WHERE PLACED_ORDER_ID = '$PLACED_ORDER_ID'";

    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $PLACED_ORDER_ID = $row['PLACED_ORDER_ID'];
            $CUS_NAME = $row['CUS_NAME'];
            $CUS_NUMBER = $row['CUS_NUMBER'];
            $CUS_EMAIL = $row['CUS_EMAIL'];
            $PLACED_ORDER_DATE_TIME = $row['PLACED_ORDER_DATE'];
            $PLACED_ORDER_TOTAL = $row['PLACED_ORDER_TOTAL'];
            $DELIVERY_ADDRESS = $row['DELIVERY_ADDRESS'];
            $DELIVERY_DATE_TIME = $row['DELIVERY_DATE'];
            $PLACED_ORDER_STATUS = $row['PLACED_ORDER_STATUS'];
            $REFERENCE_NUMBER = $row['REFERENCE_NUMBER'];

            $placedOrderDateTime = strtotime($PLACED_ORDER_DATE_TIME);
            $placedOrderDate = date('Y-m-d', $placedOrderDateTime); // Date format
            $placedOrderTime = date('h:i:sa', $placedOrderDateTime); // Time format

            $deliveryDateTime = strtotime($DELIVERY_DATE_TIME);
            $deliveryDate = date('Y-m-d', $deliveryDateTime); // Date format
            $deliveryTime = date('h:i:sa', $deliveryDateTime); // Time format

            // Add the details to the PDF
            $pdf->SetFont('Arial', "B", 15);
            $pdf->Cell(2);
            $pdf->Cell(100, 5, 'Order Details', 0, 0);
            $pdf->Cell(50, 5, 'Ship To', 0, 1);
            $pdf->SetFont('Arial', "", 10);
            $pdf->Cell(2);
            $pdf->Cell(100, 5, "Order #: $PLACED_ORDER_ID", 0, 0);
            $pdf->Cell(50, 5, "Name: $CUS_NAME", 0, 1);
            $pdf->Cell(2);
            $pdf->Cell(100, 5, "Date: $placedOrderDate", 0, 0); // Display placed order date
            $pdf->Cell(50, 5, "Contact Number: $CUS_NUMBER", 0, 1);
            $pdf->Cell(2);
            $pdf->Cell(100, 5, "Time: $placedOrderTime", 0, 0); // Display placed order time
            $pdf->Cell(50, 5, "Email: $CUS_EMAIL", 0, 1);
            $pdf->Cell(2);
            $pdf->Cell(100, 5, '', 0, 0);
            $pdf->Cell(50, 5, "Delivery Date: $deliveryDate", 0, 1); // Display delivery date
            $pdf->Cell(2);
            $pdf->Cell(100, 5, '', 0, 0);
            $pdf->Cell(50, 5, "Delivery Time: $deliveryTime", 0, 1); // Display delivery time
            $pdf->Cell(2);
            $pdf->Cell(100, 5, '', 0, 0);
            $pdf->MultiCell(0, 5, "Delivery Address: $DELIVERY_ADDRESS"); // MultiCell for wrapping
            $pdf->Cell(2);
        }
    }


    $pdf->SetFont('Arial', "B", 10);
    $pdf->Cell(189, 5, '', 0, 1);

    $pdf->Cell(50, 5, '', 0, 1);
    $pdf->SetFont('Arial', "B", 10);

    /*Heading of table*/
    $pdf->Cell(80, 6, 'Description', 1, 0, 'C');
    $pdf->Cell(23, 6, 'Qty', 1, 0, 'C');
    $pdf->Cell(40, 6, 'Unit Price', 1, 0, 'C');
    $pdf->Cell(35, 6, 'Total', 1, 1, 'C');

    $sql = "SELECT IN_ORDER_ID, FOOD_NAME, FOOD_IMG, FOOD_PRICE, FOOD_STOCK, PRSN_ID, IN_ORDER_QUANTITY, IN_ORDER_TOTAL 
FROM food, in_order WHERE food.FOOD_ID = in_order.FOOD_ID AND IN_ORDER_STATUS != 'Delivered' AND PLACED_ORDER_ID = '$PLACED_ORDER_ID'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    $pdf->SetFont('Arial', '', 10);

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $IN_ORDER_ID = $row['IN_ORDER_ID'];
            $FOOD_NAME = $row['FOOD_NAME'];
            $FOOD_PRICE = $row['FOOD_PRICE'];
            $FOOD_IMG = $row['FOOD_IMG'];
            $FOOD_STOCK = $row['FOOD_STOCK'];
            $IN_ORDER_QUANTITY = $row['IN_ORDER_QUANTITY'];
            $IN_ORDER_TOTAL = $row['IN_ORDER_TOTAL'];


            $pdf->Cell(80, 6, $FOOD_NAME, 1, 0);
            $pdf->Cell(23, 6, $IN_ORDER_QUANTITY, 1, 0, 'R');
            $pdf->Cell(40, 6, $FOOD_PRICE, 1, 0, 'R');
            $pdf->Cell(35, 6, $IN_ORDER_TOTAL, 1, 1, 'R');
        }
    }


    $sql2 = "SELECT SUM(IN_ORDER_TOTAL) AS Total FROM  in_order WHERE PLACED_ORDER_ID = '$PLACED_ORDER_ID'";
    $res2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($res2);
    $total = $row2['Total'];

    $pdf->Cell(118, 6, '', 0, 0);
    $pdf->Cell(25, 6, 'Subtotal', 0, 0);
    $pdf->Cell(35, 6, $total, 1, 1, 'R');



    $pdf->Output();
} else {
    die("Error: PLACED_ORDER_ID is not provided");
}
