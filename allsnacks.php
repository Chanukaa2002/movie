<?php 
include('connect.php');

if(!isset($_SESSION['uid'])){
  echo "<script> window.location.href='login.php';  </script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $uid = $_SESSION['uid']; 
    $snackid = $_POST['snackid'];
    $snackname = $_POST['snackname'];
    $totalprice = $_POST['totalPrice'];
    $paymentmethod = $_POST['paymentMethod'];
    $quantity = $_POST['quantity']; 

    $sql = "INSERT INTO purchases (userid, snackid, snackname, totalprice, paymentmethod, quantity) 
            VALUES ('$uid', '$snackid', '$snackname', '$totalprice', '$paymentmethod', '$quantity')";

    if (mysqli_query($con, $sql)) {
        echo "Purchase successfully recorded!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snacks Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            position: relative;
            background-image: url('https://i0.wp.com/goepicurista.com/wp-content/uploads/2020/09/French-Movie-Night-Lead-scaled.jpeg?fit=2560%2C1920&ssl=1') !important;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }

        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(119, 1, 1, 0.43);
            z-index: -1;
        }
        </style>
</head>
<body>

<?php include('header.php')  ?>

<section id="snacks" class="snacks" style="margin-top: 50px;">
    <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="section-title text-center bg-black py-1 mb-0">
            <h3 class="fw-bold text-white">Our <span class="text-success">Snacks</span></h3>
        </div>

        <div class="row mt-4">
            <?php
                $sql = "SELECT * FROM `snacks` ORDER BY snackid DESC";
                $res = mysqli_query($con, $sql);
                if (mysqli_num_rows($res) > 0) {
                    while ($data = mysqli_fetch_array($res)) {
            ?>
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card snack-card shadow-sm border-0 text-center" style="background: rgba(0, 0, 0, 0.77);">
                    <div class="snack-img p-3">
                        <img src="admin/uploads/<?= $data['image'] ?>" class="img-fluid rounded" alt="" style="height: 200px; object-fit: cover;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-white"><?= $data['snackname'] ?></h5>
                        <p class="text-white mb-3">Price: <span class="fw-bold text-success">Rs. <?= $data['price'] ?></span></p>
                        <a href="#paymentModal" class="btn btn-success w-100" data-toggle="modal" 
                           data-target="#paymentModal" 
                           data-snackid="<?= $data['snackid'] ?>" 
                           data-snackname="<?= $data['snackname'] ?>" 
                           data-snackprice="<?= $data['price'] ?>">Buy Now</a>
                    </div>
                </div>
            </div>

            <?php
                }
            } else {
                echo "<p class='text-center text-muted'>No snacks available</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <div class="col-lg-12 mx-auto">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-dark text-white text-center fs-4">
                        <h5 class="modal-title" id="paymentModalLabel">Payment for <strong><span class="text-danger" id="snackName"></span></strong> Snack</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-body">
                <p>One Price: Rs. <span id="snackPrice"></span></p>
                <label for="quantity">Quantity:</label>
                <div class="row pb-2">
                    <div class="col-lg-6">
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-lg-6">
                        <p class="mb-0">Total Price: Rs. <span id="totalPrice">0</span></p>
                    </div>
                </div>
                <form action="allsnacks.php" method="post">
                    <input type="hidden" name="snackid" id="snackId">
                    <input type="hidden" name="snackname" id="snackNameInput">
                    <input type="hidden" name="price" id="snackPriceInput">
                    <input type="hidden" name="totalPrice" id="totalPriceInput">
                    <input type="hidden" name="quantity" id="quantityInput">
                    <label for="paymentMethod">Select Payment Method:</label>
                    <select name="paymentMethod" id="paymentMethod" class="form-control">
                        <option value="card">Credit/Debit Card</option>
                        <option value="paypal">PayPal</option>
                    </select>
                    <button type="submit" class="btn btn-warning w-100 fw-bold rounded-3 mt-3">Pay Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>

    $('#paymentModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var snackId = button.data('snackid'); // Extract info from data-* attributes
        var snackName = button.data('snackname');
        var snackPrice = button.data('snackprice');

        // Set snack details in modal
        $('#snackId').val(snackId);
        $('#snackName').text(snackName);
        $('#snackPrice').text(snackPrice);
        $('#snackNameInput').val(snackName);
        $('#snackPriceInput').val(snackPrice);

        // Calculate the total price based on quantity
        $('#quantity').on('input', function() {
            var quantity = $(this).val();
            var total = quantity * snackPrice;
            $('#totalPrice').text(total);
            $('#totalPriceInput').val(total);
            $('#quantityInput').val(quantity);
        });
    });
</script>

</body>
</html>
