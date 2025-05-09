<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
  body {
    position: relative;
    background-image: url('https://c8.alamy.com/comp/AWN13R/35mm-film-and-cassette-AWN13R.jpg') !important;
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
  }

</style>
</head>
<body>

<?php include('connect.php')  ?>
<?php include('header.php')  ?>

<section>
  <div class="container aos-init aos-animate" style="margin-top: 50px;" data-aos="fade-up">
    <div class="section-title text-center bg-black py-1 mb-0">
      <h3 class="fw-bold text-white">Our <span class="text-primary">Theater</span></h3>
    </div>
    <p class="text-black text-center">Discover the latest movies and book your tickets now!</p>
    <div class="row mt-4">
      <?php
        $sql = "SELECT theater.*, movies.*, categories.catname
                FROM theater
                INNER JOIN movies ON movies.movieid = theater.movieid
                INNER JOIN categories ON categories.catid = movies.catid
                ORDER BY theater.theaterid DESC";
        $res  = mysqli_query($con, $sql);
        
        if(mysqli_num_rows($res) > 0){
          while($data = mysqli_fetch_array($res)){
      ?>
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
          <div class="card theater-card shadow-sm border-0">
            <div class="card-img-top position-relative">
              <img src="admin/uploads/<?= $data['image'] ?>" class="img-fluid rounded-top w-100" alt="Movie Image" style="height: 300px; object-fit: cover;">
              <div class="overlay position-absolute top-50 start-50 translate-middle">
                <a href="admin/uploads/<?= $data['trailer'] ?>" target="_blank" class="btn btn-light btn-sm">Watch Trailer</a>
              </div>
            </div>

            <div class="card-body text-center" style="background: rgb(0, 0, 0);">
              <h5 class="fw-bold text-white"><?= $data['theater_name'] ?></h5>
              <h6 class="text-white"><?= $data['title'] ?> <span class="badge bg-primary"><?= $data['catname'] ?></span></h6>
              <p class="small text-white">
                <i class="bi bi-clock"></i> <?= $data['timing'] ?> | <?= $data['days'] ?> <br>
                <i class="bi bi-calendar"></i> <?= $data['date'] ?> <br>
                <i class="bi bi-geo-alt"></i> <?= $data['location'] ?>
              </p>
              <h6 class="fw-bold text-danger">Per Ticket: Rs.<?= $data['price'] ?></h6>
              <a href="booking.php?id=<?= $data['theaterid'] ?>" target="_blank" class="btn btn-primary btn-sm w-100">Book Now</a>
            </div>
          </div>
        </div>
      <?php
          }
        }
      ?>
    </div>
  </div>
</section>

<?php include('footer.php')  ?>

</body>
</html>