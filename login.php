<?php include('connect.php')  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

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
    

<section>
  <div class="container aos-init aos-animate" data-aos="fade-up">
    <div class="section-title">
      <h2 class="text-dark">Login Admin / User</h2>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
        <div class="card shadow-lg p-4 rounded-lg w-100">
          <div class="card-body bg-black">
            <h5 class="card-title text-center mb-4 text-white">Login to Your Account</h5>
            <form action="login.php" method="post" role="form" class="php-email-form">
              <div class="form-group mb-3">
                <label for="email" class="form-label text-white">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
              </div>
              <div class="form-group mb-3">
                <label for="password" class="form-label text-white">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Your Password" required>
              </div>
              <div class="text-center">
                <button type="submit" name="login" class="btn btn-warning w-100"><strong>Login</strong></button>
              </div>
            </form>
            <div class="text-center mt-3">
              <p class="text-white">You are not registered yet. Please, <a href="register.php" class="btn btn-outline-secondary w-50 text-white">Register</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


</body>
</html>
<?php

if(isset($_POST['login'])){

  $email    = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM `users` WHERE email = '$email' and password = '$password' ";

  $rs = mysqli_query($con, $sql);
  
  if(mysqli_num_rows($rs) > 0){
     $data = mysqli_fetch_array($rs);

     $role = $data['roteype'];

     $_SESSION['uid'] = $data['userid'];
     $_SESSION['type'] = $role;

     if($role == 1){
      echo "<script> alert('admin login successfully!!') </script>";
      echo "<script> window.location.href='admin/dashboard.php';  </script>";
     }
     else if($role == 2){
      echo "<script> alert('user login successfully!!') </script>";
      echo "<script> window.location.href='index.php';  </script>";
     }

  }else{
    echo "<script> alert('Invalid email & password') </script>";
  }

}


?>