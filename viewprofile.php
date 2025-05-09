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
    <title>Users</title>
    <style>
      body {
        position: relative;
        background-image: url('https://wallpapers.com/images/featured/action-movie-pb93e7r343erqgtt.jpg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        height: 100vh;
      }
    </style>
</head>
<body>
<?php include('header.php')  ?>

<div class="container" style="margin-top: 120px;">
  <div class="row">
    <div class="col-lg-10 mx-auto my-5">
      <div class="card shadow-lg border-0 rounded-4">
        <h3 class="card-header bg-dark text-white text-center fs-4">Profile Details</h3>
        <div class="card-body">
          <table class="table table-hover align-middle text-center">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>     
              </tr>
            </thead>
                <?php
                  $uid = $_SESSION['uid'];
                  $sql = "SELECT * FROM `users` where userid = '$uid'";
                  $res  = mysqli_query($con, $sql);
                  if(mysqli_num_rows($res) > 0){
                    while($data = mysqli_fetch_array($res)){
                ?>
              <tr>
                <td><?= $data['userid'] ?></td>
                <td><?= $data['name'] ?></td>
                <td><?= $data['email'] ?> </td>
                <td><?= $data['password'] ?> </td>       
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


