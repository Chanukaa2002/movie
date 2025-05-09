<?php 
include('../connect.php');

// Check if the user is logged in
if (!isset($_SESSION['uid'])) {
    echo "<script> window.location.href='../login.php'; </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <style>
      body {
        position: relative;
        background-image: url('https://wallpapercave.com/wp/wp2633733.jpg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
      }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-10 mx-auto my-5">
            <div class="card shadow-lg border-0 rounded-4">
                <h3 class="card-header bg-dark text-white text-center fs-4">Booking List</h3>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Handle the search functionality
                        if (isset($_POST['btnsearch'])) {
                            $start = $_POST['start'];
                            $end = $_POST['end'];
                            $status = $_POST['status'];
                            $total_sale = 0;

                            $sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, 
                                    theater.timing, theater.days, theater.price, theater.location, movies.title,  
                                    categories.catname, users.name AS 'username', booking.status
                                    FROM booking
                                    INNER JOIN theater ON theater.theaterid = booking.theaterid
                                    INNER JOIN users ON users.userid = booking.userid
                                    INNER JOIN movies ON movies.movieid = theater.movieid
                                    INNER JOIN categories ON categories.catid = movies.catid
                                    WHERE booking.bookingdate BETWEEN '$start' AND '$end' AND booking.status = '$status'";

                            $res = mysqli_query($con, $sql);
                            if (mysqli_num_rows($res) > 0) {
                                while ($data = mysqli_fetch_array($res)) {
                                    $total_sale += $data['price'];
                                    ?>
                                    <tr>
                                        <td><?= $data['bookingid'] ?></td>
                                        <td><?= $data['theater_name'] ?></td>
                                        <td><?= $data['title'] ?> - <?= $data['catname'] ?></td>
                                        <td><?= $data['bookingdate'] ?></td>
                                        <td><?= $data['days'] ?> - <?= $data['timing'] ?></td>
                                        <td><?= $data['price'] ?></td>
                                        <td><?= $data['location'] ?></td>
                                        <td><?= $data['username'] ?></td>
                                        <td>
                                            <?php
                                            if ($data['status'] == 0) {
                                                echo "<a href='#' class='btn btn-warning'>Pending</a>";
                                            } else {
                                                echo "<a href='#' class='btn btn-success'>Approved</a>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($data['status'] == 1) {
                                                echo "<button type='button' class='btn btn-light' disabled>Completed</button>";
                                            } else {
                                                echo "<a href='viewallbooking.php?bookingid=".$data['bookingid']."' class='btn btn-primary'>Approve</a>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                echo "<tr><td colspan='10'>Total Sale: <strong>Rs. ".$total_sale."</strong></td></tr>";
                            }
                        } else {
                            // Default query when no filter is applied
                            $sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, 
                                    theater.timing, theater.days, theater.price, theater.location, movies.title,  
                                    categories.catname, users.name AS 'username', booking.status
                                    FROM booking
                                    INNER JOIN theater ON theater.theaterid = booking.theaterid
                                    INNER JOIN users ON users.userid = booking.userid
                                    INNER JOIN movies ON movies.movieid = theater.movieid
                                    INNER JOIN categories ON categories.catid = movies.catid";

                            $res = mysqli_query($con, $sql);
                            if (mysqli_num_rows($res) > 0) {
                                while ($data = mysqli_fetch_array($res)) {
                                    ?>
                                    <tr>
                                        <td><?= $data['bookingid'] ?></td>
                                        <td><?= $data['theater_name'] ?></td>
                                        <td><?= $data['title'] ?> - <?= $data['catname'] ?></td>
                                        <td><?= $data['bookingdate'] ?></td>
                                        <td><?= $data['days'] ?> - <?= $data['timing'] ?></td>
                                        <td><?= $data['price'] ?></td>
                                        <td><?= $data['location'] ?></td>
                                        <td><?= $data['username'] ?></td>
                                        <td>
                                            <?php
                                            if ($data['status'] == 0) {
                                                echo "<a href='#' class='btn btn-warning'>Pending</a>";
                                            } else {
                                                echo "<a href='#' class='btn btn-success'>Approved</a>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($data['status'] == 1) {
                                                echo "<button type='button' class='btn btn-light' disabled>Completed</button>";
                                            } else {
                                                echo "<a href='viewallbooking.php?bookingid=".$data['bookingid']."' class='btn btn-primary'>Approve</a>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='10'>No bookings found</td></tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>

<?php
// Handle booking approval
if (isset($_GET['bookingid'])) {
    $bookingid = $_GET['bookingid'];
    $sql = "UPDATE booking SET status = 1 WHERE bookingid = '$bookingid'";

    if (mysqli_query($con, $sql)) {
        echo "<script> alert('Booking approved successfully!') </script>";
        echo "<script> window.location.href='viewallbooking.php'; </script>";
    } else {
        echo "<script> alert('Booking approval failed!') </script>";
    }
}
?>
