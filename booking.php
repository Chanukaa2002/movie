<?php 
include('connect.php');

if(!isset($_SESSION['uid'])){
  echo "<script> window.location.href='login.php';  </script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking</title>
    <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
       body {
        position: relative;
        background-image: url('https://miro.medium.com/v2/resize:fit:1400/1*WoT0DeG-gXTqC4_veycuHg.png') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        height: 100vh;
      }
      body::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.64);
        z-index: -1;
      }
    </style>

</head>
<body>
    
<?php
  $theaterid = $_GET['id'];
?>

<section class="py-5">
  <div class="container aos-init aos-animate" data-aos="fade-up"> 
    <div class="section-title text-center">
      <h2 class="fw-bold text-primary">🎟 Ticket Booking for Theater</h2>
      <p class="text-white">Reserve your seats in just a few clicks!</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-6">
        <div class="card shadow-lg border-0 rounded-4 p-4">
          <form action="booking.php" method="post">
            <input type="hidden" name="theaterid" value="<?=$theaterid?>">
            <div class="mb-3">
              <label class="form-label fw-semibold">Number of People</label>
              <input type="number" class="form-control rounded-3" name="person" placeholder="Enter no of People" required="">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Select Date</label>
              <input type="date" class="form-control rounded-3" name="date" required="">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-warning w-100 py-2 fw-bold" name="ticketbook">
                📅 Book Ticket
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>

<?php

if(isset($_POST['ticketbook'])){

  $person     = $_POST['person'];
  $date       = $_POST['date'];
  $theaterid  = $_POST['theaterid'];

  $uid = $_SESSION['uid'];

  $sql = "INSERT INTO `booking`(`theaterid`, `bookingdate`, `person`, `userid`) VALUES ('$theaterid','$date','$person','$uid')";

  if(mysqli_query($con, $sql)){
     echo "<script> alert('Ticket book successfully!!') </script>";
     echo "<script> window.location.href='index.php';  </script>";

  }else{
    echo "<script> alert('ticket not book')";
  }

}

?>


