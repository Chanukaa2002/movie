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
    <title>User Booking</title>
    <style>
      body {
        position: relative;
        background-image: url('https://wallpapers.oneindia.com/ph-1024x768/2012/12/135486764126627.jpg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
      }
    </style>
</head>
<body>

<?php include('header.php')  ?>

<div class="container" style="margin-top: 120px;">
  <div class="row">
    <div class="col-lg-10 mx-auto my-5">
      <div class="card shadow-lg border-0 rounded-4">
        <h3 class="card-header bg-dark text-white text-center fs-4">Booking Details</h3>
        <div class="card-body">
          <table class="table table-hover align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Date</th>
                <th>Days/Time</th>
                <th>Ticket</th>
                <th>Location</th>
                <th>User</th>
                <th>Status</th>
                <th>Status</th>
              </tr>
            </thead>
              <?php
                $uid = $_SESSION['uid'];
                $sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, theater.timing, theater.days, theater.price, theater.location, movies.title, categories.catname, users.name AS 'username', booking.status
                        FROM booking
                        INNER JOIN theater ON theater.theaterid = booking.theaterid
                        INNER JOIN users ON users.userid = booking.userid
                        INNER JOIN movies ON movies.movieid = theater.movieid
                        INNER JOIN categories ON categories.catid = movies.catid 
                        WHERE booking.userid = '$uid'";
                $res = mysqli_query($con, $sql);
                if (mysqli_num_rows($res) > 0) {
                    while ($data = mysqli_fetch_array($res)) {
              ?>
              <tr>
                <td><?= $data['bookingid'] ?></td>
                <td><?= $data['theater_name'] ?></td>
                <td><?= $data['title'] ?> - <?= $data['catname'] ?></td>
                <td><?= $data['days'] ?> - <?= $data['timing'] ?></td>       
                <td><?= $data['price'] ?></td>
                <td><?= $data['bookingdate'] ?></td>
                <td><?= $data['location'] ?></td>
                <td><?= $data['username'] ?></td>
                <td>
                  <?php
                    if ($data['status'] == 0) {
                        echo "<a href='#' class='btn btn-warning'> Pending </a>";
                    } else {
                        echo "<a href='#' class='btn btn-success'> Approved </a>";
                    }
                  ?>
                </td>
                <td>
                  <?php
                  if ($data['status'] == 0) {
                      echo "<a href='#' class='btn btn-warning'> NOT, Ticket Available </a>";
                  } else {
                      echo "<a href='download_ticket.php?id=" . $data['bookingid'] . "' class='btn btn-danger'>Download Ticket</a>";
                  }
                  ?>
              </td>
              </tr>
              <?php
                    }
                } else {
                    echo 'No booking found';
                }
              ?>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-bottom: 120px;">
    <div class="col-lg-10 mx-auto">
      <div class="card shadow-lg border-0 rounded-4">
        <h3 class="card-header bg-dark text-white text-center fs-4">Purchase Details</h3>
        <div class="card-body">
          <table class="table table-hover align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>Snack Name</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Purchase Date</th>
                <th>Quantity</th>
              </tr>
            </thead>
              <?php
                $sql_purchase = "SELECT purchases.snackid, snacks.snackname, purchases.totalprice, purchases.paymentmethod, purchases.purchase_date, purchases.quantity
                                 FROM purchases
                                 INNER JOIN snacks ON snacks.snackid = purchases.snackid
                                 WHERE purchases.userid = '$uid'";

                $res_purchase = mysqli_query($con, $sql_purchase);
                if (mysqli_num_rows($res_purchase) > 0) {
                    while ($purchase = mysqli_fetch_array($res_purchase)) {
              ?>
              <tr>
                <td><?= $purchase['snackname'] ?></td>
                <td><?= $purchase['totalprice'] ?></td>
                <td><?= $purchase['paymentmethod'] ?></td>
                <td><?= $purchase['purchase_date'] ?></td>
                <td><?= $purchase['quantity'] ?></td>
              </tr>
              <?php
                    }
                } else {
                    echo '<tr><td colspan="6">No purchase history found</td></tr>';
                }
              ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php')  ?>

</body>
</html>
