<?php 
include('../connect.php');

if(!isset($_SESSION['uid'])){
  echo "<script> window.location.href='../login.php';  </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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

<body class="bg-light">

<?php include('header.php'); ?>

<div class="container" style="margin-top: 120px;">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-dark text-white text-center fs-4">
                    <?= isset($_GET['editid']) ? 'Edit Category' : 'Add Category' ?>
                </div>
                <div class="card-body">
                    <form action="categories.php" method="post">
                        <?php 
                        if(isset($_GET['editid'])) {
                            $editid = $_GET['editid'];
                            $sql = "SELECT * FROM `categories` WHERE catid='$editid'";
                            $res = mysqli_query($con, $sql);
                            $editdata = mysqli_fetch_array($res);
                        ?>
                        <input type="hidden" name="catid" value="<?= $editdata['catid'] ?>">
                        <?php } ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control rounded-3 shadow-sm" name="catname" value="<?= $editdata['catname'] ?? '' ?>" placeholder="Enter category name" required>
                        </div>
                        
                        <button type="submit" class="btn btn-<?= isset($_GET['editid']) ? 'warning' : 'warning' ?> w-100 fw-bold rounded-3" name="<?= isset($_GET['editid']) ? 'update' : 'add' ?>">
                            <i class="fas fa-save"></i> <?= isset($_GET['editid']) ? 'Update' : 'Add' ?> Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-10 mx-auto my-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-dark text-white text-center fs-4">Categories List</div>
                <div class="card-body">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `categories`";
                            $res = mysqli_query($con, $sql);
                            if(mysqli_num_rows($res) > 0){
                                while($data = mysqli_fetch_array($res)){
                            ?>
                            <tr>
                                <td><?= $data['catid'] ?></td>
                                <td><?= $data['catname'] ?></td>
                                <td>
                                    <a href="categories.php?editid=<?= $data['catid'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <a href="categories.php?deleteid=<?= $data['catid'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php 
                                } 
                            } else { 
                                echo '<tr><td colspan="3" class="text-danger fw-bold">No categories found</td></tr>'; 
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
if(isset($_POST['add'])){
 
  $name = $_POST['catname'];
  $sql = "INSERT INTO `categories`( `catname`) VALUES ('$name')";

  if(mysqli_query($con, $sql)){
    echo "<script> alert('cateogry added')</script>";
    echo "<script> window.location.href='categories.php' </script>";
  }else{
    echo "<script> alert('cateogry not added')</script>";
  }
}

if(isset($_POST['update'])){
  $catid = $_POST['catid'];
  $name = $_POST['catname'];

  $sql = "UPDATE `categories` SET `catname`='$name' WHERE  catid = '$catid'";

  if(mysqli_query($con, $sql)){
    echo "<script> alert('cateogry udpated')</script>";
    echo "<script> window.location.href='categories.php' </script>";
  }else{
    echo "<script> alert('cateogry not updated')</script>";
  }
}


if(isset($_GET['deleteid'])){

  $deleteid = $_GET['deleteid'];
  $sql = "DELETE FROM `categories` WHERE catid = '$deleteid'";
 
  if(mysqli_query($con, $sql)){
    echo "<script> alert('cateogry deleted')</script>";
    echo "<script> window.location.href='categories.php' </script>";
  }else{
    echo "<script> alert('cateogry not deleted')</script>";
  }
}

?>
