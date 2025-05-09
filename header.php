<link href="assets/img/favicon.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">

<link href="assets/css/style.css" rel="stylesheet">

<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<header id="header" class="fixed-top bg-dark shadow">
    <nav class="navbar navbar-expand-lg bg-black navbar-dark p-3 shadow">
      <a href="index.php" class="navbar-brand text-white text-decoration-none" style="font-size: 30px;">
        <i class="fa fa-film mx-4"></i>Fillm Hall System<span class="text-warning">.</span>
      </a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ms-auto">
        <li class="nav-item me-3"><a class="nav-link text-white" href="index.php">Home</a></li>
          
          <?php if (!isset($_SESSION['uid'])) { ?>
            <li class="nav-item me-3"><a class="nav-link text-white" href="allmovies.php">Movies</a></li>
            <li class="nav-item me-3"><a class="nav-link text-white" href="alltheater.php">Theater</a></li>
            <li class="nav-item me-3"><a class="nav-link text-white" href="login.php">Login</a></li>
            <li class="nav-item me-3"><a class="nav-link text-white" href="register.php">Register</a></li>
          <?php } else { 
              if ($_SESSION['type'] == 2) { ?>
                <li class="nav-item me-3"><a class="nav-link text-white" href="allmovies.php">Movies</a></li>
                <li class="nav-item me-3"><a class="nav-link text-white" href="alltheater.php">Theater</a></li>
                <li class="nav-item me-3"><a class="nav-link text-white" href="allsnacks.php">Snack Corner</a></li>
                <li class="nav-item me-3"><a class="nav-link text-white" href="viewuserbooking.php">Booking</a></li>
                <li class="nav-item me-3"><a class="nav-link text-white" href="viewprofile.php">Profile</a></li>
                <li class="nav-item me-3">
                  <a class="nav-link btn btn-danger text-white px-3 py-1 rounded" href="logout.php">
                    <i class="fa fa-sign-out-alt"></i> Logout
                  </a>
                </li>
          <?php } } ?>
        </ul>
      </div>
    </nav>
</header>

