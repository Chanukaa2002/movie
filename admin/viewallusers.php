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
    <title>Users</title>
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

<?php include('header.php')  ?>
<div class="container">
  <div class="row">
    <div class="col-lg-10 mx-auto my-5">
      <div class="card shadow-lg border-0 rounded-4">
        <h3 class="card-header bg-dark text-white text-center fs-4">Users List</h3>
        <div class="card-body">
          <table class="table table-hover align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role Type</th>      
                <th>Action</th>
              </tr>  
            </thead>
              <?php
                $sql = "SELECT * FROM `users`";
                $res  = mysqli_query($con, $sql);
                if(mysqli_num_rows($res) > 0){
                  while($data = mysqli_fetch_array($res)){
              ?>
            
            <tr>
              <td><?= $data['userid'] ?></td>
              <td><?= $data['name'] ?></td>
              <td><?= $data['email'] ?> </td>
              <td><?= $data['password'] ?> </td>       
              <td>
                <?php
                  if($data['roteype'] == 1){
                    echo "ADMIN";
                  }else{
                    echo "USER";
                  }
                ?>
              </td>
              <td>
                <a href="viewallusers.php?userid=<?= $data['userid'] ?>" class="btn btn-danger"> Delete </a>
              </td>
            </tr>
            <?php
                }
              }else{
                echo 'no user found';
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

<?php

if(isset($_GET['userid'])){

  $userid = $_GET['userid'];

  $sql = "delete from users WHERE userid ='$userid'";

  if(mysqli_query($con, $sql)){
    echo "<script> alert('user deleted successfully')</script>";
    echo "<script> window.location.href='viewallusers.php' </script>";
  }else{
    echo "<script> alert('user not deleted')</script>";
  }

}
?>
