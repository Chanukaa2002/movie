<?php
include('../connect.php');

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
  <title>Snacks Corner</title>
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

  <?php
  if (isset($_GET['editid'])) {

    $editid = $_GET['editid'];
    $sql = "SELECT * FROM `snacks` WHERE snackid = '$editid'";
    $res = mysqli_query($con, $sql);

    $editdata = mysqli_fetch_array($res);
  ?>

  <div class="container" style="margin-top: 120px;">
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-header bg-dark text-white text-center fs-4">
            <h3>Edit Snacks</h3>
          </div>
          <div class="card-body">
            <form action="snacks.php" method="post" enctype="multipart/form-data">
              <input type="hidden" class="form-control" value="<?= $editdata['snackid'] ?>" name="snackid">
              <div class="form-group mb-4">
                <input type="text" class="form-control" name="snackname" value="<?= $editdata['snackname'] ?>" placeholder="Enter snack name">
              </div>
              <div class="form-group mb-4">
                <input type="number" class="form-control" name="price" value="<?= $editdata['price'] ?>" placeholder="Enter price" step="0.01">
              </div>
              <div class="form-group mb-4">
                <input type="number" class="form-control" name="quantity" value="<?= $editdata['quantity'] ?>" placeholder="Enter quantity">
              </div>
              <div class="form-group mb-4">
                <input type="file" class="form-control" name="image" accept="image/*">
              </div>
              <div class="form-group">
              <button type="submit" class="btn btn-warning w-100 fw-bold rounded-3" name="update"><i class="fas fa-save"></i> Update Snack</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  } else {
  ?>

  <div class="container" style="margin-top: 120px;">
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-header bg-dark text-white text-center fs-4">
            <h3>Add Snacks</h3>
          </div>
          <div class="card-body">
            <form action="snacks.php" method="post" enctype="multipart/form-data">
              <div class="form-group mb-4">
                <input type="text" class="form-control" name="snackname" value="" placeholder="Enter snack name">
              </div>
              <div class="form-group mb-4">
                <input type="number" class="form-control" name="price" value="" placeholder="Enter price" step="0.01">
              </div>
              <div class="form-group mb-4">
                <input type="number" class="form-control" name="quantity" value="" placeholder="Enter quantity">
              </div>
              <div class="form-group mb-4">
                <input type="file" class="form-control" name="image" accept="image/*">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-warning w-100 fw-bold rounded-3" name="add"><i class="fas fa-save"></i> Add Snack</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php } ?>

  <div class="col-lg-10 mx-auto my-5">
    <div class="card shadow-lg border-0 rounded-4">
      <h3 class="card-header bg-dark text-white text-center fs-4">Snacks List</h3>
      <div class="card-body">
        <table class="table table-hover align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM `snacks`";
            $res = mysqli_query($con, $sql);
            if (mysqli_num_rows($res) > 0) {
              while ($data = mysqli_fetch_array($res)) {
            ?>
                <tr>
                  <td><?= $data['snackid'] ?></td>
                  <td><?= $data['snackname'] ?></td>
                  <td><?= $data['price'] ?></td>
                  <td><?= $data['quantity'] ?></td>
                  <td><img src="uploads/<?= $data['image'] ?>" width="50" height="50"></td>
                  <td>
                    <a href="snacks.php?editid=<?= $data['snackid'] ?>" class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
                    <a href="snacks.php?deleteid=<?= $data['snackid'] ?>" class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a>
                  </td>
                </tr>
            <?php
              }
            } else {
              echo '<tr><td colspan="6">No snacks found</td></tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include('footer.php'); ?>

</body>

</html>

<?php
if (isset($_POST['add'])) {
  $name = $_POST['snackname'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];

  // Handle image upload
  $image = $_FILES['image']['name'];
  $image_tmp = $_FILES['image']['tmp_name'];
  $image_path = 'uploads/' . $image;
  move_uploaded_file($image_tmp, $image_path);

  $sql = "INSERT INTO `snacks`(`snackname`, `price`, `quantity`, `image`) 
          VALUES ('$name', '$price', '$quantity', '$image')";

  if (mysqli_query($con, $sql)) {
    echo "<script> alert('Snack added')</script>";
    echo "<script> window.location.href='snacks.php' </script>";
  } else {
    echo "<script> alert('Snack not added')</script>";
  }
}

if (isset($_POST['update'])) {
  $snackid = $_POST['snackid'];
  $name = $_POST['snackname'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];

  // Handle image update (only if a new image is uploaded)
  if ($_FILES['image']['name'] != '') {
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = 'uploads/' . $image;
    move_uploaded_file($image_tmp, $image_path);
    $sql = "UPDATE `snacks` SET `snackname`='$name', `price`='$price', `quantity`='$quantity', `image`='$image' WHERE snackid = '$snackid'";
  } else {
    $sql = "UPDATE `snacks` SET `snackname`='$name', `price`='$price', `quantity`='$quantity' WHERE snackid = '$snackid'";
  }

  if (mysqli_query($con, $sql)) {
    echo "<script> alert('Snack updated')</script>";
    echo "<script> window.location.href='snacks.php' </script>";
  } else {
    echo "<script> alert('Snack not updated')</script>";
  }
}

if (isset($_GET['deleteid'])) {
  $deleteid = $_GET['deleteid'];
  $sql = "DELETE FROM `snacks` WHERE snackid = '$deleteid'";

  if (mysqli_query($con, $sql)) {
    echo "<script> alert('Snack deleted')</script>";
    echo "<script> window.location.href='snacks.php' </script>";
  } else {
    echo "<script> alert('Snack not deleted')</script>";
  }
}
?>
