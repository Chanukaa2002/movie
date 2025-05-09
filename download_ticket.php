<?php
require('fpdf/fpdf.php'); // Include FPDF library
include('connect.php');   // Database connection
require('phpqrcode/qrlib.php'); // Include the QR code library

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Fetch booking details
    $sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, 
                   theater.theater_name, theater.timing, theater.days, 
                   theater.price, theater.location, movies.title, categories.catname, 
                   users.name AS 'username' 
            FROM booking
            INNER JOIN theater ON theater.theaterid = booking.theaterid
            INNER JOIN users ON users.userid = booking.userid
            INNER JOIN movies ON movies.movieid = theater.movieid
            INNER JOIN categories ON categories.catid = movies.catid 
            WHERE booking.bookingid = '$booking_id'";

    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        $data = mysqli_fetch_array($res);

        // Create a PDF instance
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Title
        $pdf->Cell(190, 10, 'Movie Ticket', 1, 1, 'C');

        $pdf->SetFillColor(230, 230, 230); // Light gray background
        $pdf->Cell(50, 10, 'Booking ID:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, $data['bookingid'], 1, 1);
        
        $pdf->Cell(50, 10, 'User:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, $data['username'], 1, 1);
        
        $pdf->Cell(50, 10, 'Movie:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, $data['title'], 1, 1);
        
        $pdf->Cell(50, 10, 'Category:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, $data['catname'], 1, 1);
        
        $pdf->Cell(50, 10, 'Theater:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, $data['theater_name'], 1, 1);
        
        $pdf->Cell(50, 10, 'Date:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, $data['days'], 1, 1);
        
        $pdf->Cell(50, 10, 'Time:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, $data['timing'], 1, 1);
        
        $pdf->Cell(50, 10, 'Price:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, '$' . $data['price'], 1, 1);
        
        $pdf->Cell(50, 10, 'Location:', 1, 0, 'L', true);
        $pdf->Cell(140, 10, $data['location'], 1, 1);
        
        $pdf->Ln(10); // Line break

        // Generate QR code for the booking ID link
        $qr_code_content = 'https://filmhallbookingsystem.com/booking?bookingid=' . $data['bookingid']; // URL or information to encode
        $qr_code_file = 'qrcode_' . $data['bookingid'] . '.png';
        QRcode::png($qr_code_content, $qr_code_file, 'L', 4, 4); // Generate QR code

        // Add the QR code to the PDF
        $pdf->Image($qr_code_file, 10, $pdf->GetY(), 30, 30); // Adjust position and size

        // Footer
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(190, 10, 'Thank you for booking with us! Enjoy your movie.', 0, 1, 'C');

        // Output the PDF
        $pdf->Output('D', 'Movie_Ticket_' . $booking_id . '.pdf');

        // Delete the temporary QR code image after the PDF generation
        unlink($qr_code_file);
    } else {
        echo "Invalid Booking ID!";
    }
} else {
    echo "No Booking ID Provided!";
}
?>
