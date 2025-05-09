<?php
include('../connect.php');

if (!isset($_SESSION['uid'])) {
  echo "<script> window.location.href='../login.php';  </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
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

<body>
  <?php include('header.php') ?>
  <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="bg-dark text-white p-4 mb-4" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
      <h2><strong>Welcome to Admin dashboard!!</strong></h2>
    </div>
    <div class="row">
      <div class="col-lg-4 mb-2">
        <div class="card">
          <div class="card-body">
            <div class="card-text">
              <h5 class="text-center"><strong>CATEGORIES</strong></h5>
              <?php
                $sql = "SELECT count(catid) as 'category' FROM `categories`";
                $res = mysqli_query($con, $sql);
                $catdata = mysqli_fetch_array($res);
              ?>
              <h6 class="text-center"><?= $catdata['category'] ?></h6>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-2">
        <div class="card shadow">
          <div class="card-body">
            <div class="card-text">
              <h5 class="text-center"><strong>MOVIES</strong></h5>
              <?php
                $sql = "SELECT count(movieid) as 'total_movies' FROM `movies`";
                $res = mysqli_query($con, $sql);
                $moviedata = mysqli_fetch_array($res);
              ?>
              <h6 class="text-center"><?= $moviedata['total_movies'] ?></h6>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-2">
        <div class="card">
          <div class="card-body">
            <div class="card-text">
              <h5 class="text-center"><strong>THEATER</strong></h5>
              <?php
                $sql = "SELECT count(theaterid) as 'total_theater' FROM `theater`";
                $res = mysqli_query($con, $sql);
                $theaterdata = mysqli_fetch_array($res);
              ?>
              <h6 class="text-center"><?= $theaterdata['total_theater'] ?></h6>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-2">
        <div class="card">
          <div class="card-body">
            <div class="card-text">
              <h5 class="text-center"><strong>BOOKING</strong></h5>
              <?php
                $sql = "SELECT count(bookingid) as 'total_booking' FROM `booking` where status = 1";
                $res = mysqli_query($con, $sql);
                $bookingdata = mysqli_fetch_array($res);
              ?>
              <h6 class="text-center"><?= $bookingdata['total_booking'] ?></h6>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-2">
        <div class="card">
          <div class="card-body">
            <div class="card-text">
              <h5 class="text-center"><strong>USERS</strong></h5>
              <?php
                $sql = "SELECT count(userid) as 'total_users' FROM `users` where roteype=2";
                $res = mysqli_query($con, $sql);
                $userdata = mysqli_fetch_array($res);
              ?>
              <h6 class="text-center"><?= $userdata['total_users'] ?></h6>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-2">
        <div class="card">
          <div class="card-body">
            <div class="card-text">
              <h5 class="text-center"><strong>SALES</strong></h5>
              <?php
                $sql = "select sum(theater.price) as 'total_sale', booking.status 
                    from booking
                    inner join theater on theater.theaterid = booking.theaterid
                    where booking.status = 1";
                $res = mysqli_query($con, $sql);
                $salesdata = mysqli_fetch_array($res);
              ?>
              <h6 class="text-center"><?= $salesdata['total_sale'] ?></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include('footer.php') ?>
</body>
</html>