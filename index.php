<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <style>
    .movie-card {
      border-radius: 10px;
      overflow: hidden;
      transition: transform 0.3s ease-in-out;
    }

    .movie-card:hover {
      transform: scale(1.05);
    }

    .movie-img-container {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
    }

    .movie-img-container img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      transition: transform 0.3s ease-in-out;
    }

    .movie-card:hover .movie-img-container img {
      transform: scale(1.1);
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }

    .movie-card:hover .overlay {
      opacity: 1;
    }

    .overlay a {
      color: #000;
      background-color: #fff;
      padding: 8px 15px;
      border-radius: 5px;
      font-weight: bold;
      text-transform: uppercase;
    }
  </style>
</head>

<body style="background-color: lightblue;">

  <?php include('connect.php'); ?>
  <?php include('header.php'); ?>

  <section>
    <div class="container" data-aos="fade-up" style="margin-top: 50px;">
      <div class="section-title">
        <h2>Latest Movies</h2>
        <h3>Our <span>Movies</span></h3>
      </div>

      <form action="index.php" method="post" class="bg-black py-2 flex justify-center items-center">
        <div class="row">
        <div class="col-lg-3 col-md-3 d-flex"></div>
          <div class="col-lg-2 col-md-2 d-flex">
            <div class="form-group">
              <input type="text" class="form-control" name="movie_search" placeholder="Search Movie Name">
            </div>
          </div>

          <div class="col-lg-2 col-md-2 d-flex">
            <div class="form-group">
              <select name="catid" class="form-control">
                <option value="">Select Category</option>
                <?php
                $sql = "SELECT * FROM `categories`";
                $res = mysqli_query($con, $sql);
                if (mysqli_num_rows($res) > 0) {
                  while ($data = mysqli_fetch_array($res)) { ?>
                    <option value="<?= $data['catid'] ?>"><?= $data['catname'] ?></option>
                <?php }
                } else { ?>
                  <option value="">No Category found</option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="col-lg-2 col-md-2 d-flex">
              <button type="submit" class="btn btn-primary w-100 fw-bold rounded-3" name="btnSearch">
                  Search
              </button>
          </div>
          <div class="col-lg-3 col-md-2 d-flex"></div>
        </div>
      </form>

      <div class="row mt-5">
        <?php
        if (isset($_POST['btnSearch'])) {
          $movie_search = $_POST['movie_search'];
          $catid = $_POST['catid'];

          $sql = "SELECT movies.*, categories.catname
                  FROM movies
                  INNER JOIN categories ON categories.catid = movies.catid
                  WHERE movies.title LIKE '%$movie_search%' AND movies.catid = '$catid'";
        } else {
          $sql = "SELECT movies.*, categories.catname
                  FROM movies
                  INNER JOIN categories ON categories.catid = movies.catid
                  ORDER BY movies.movieid DESC";
        }

        $res = mysqli_query($con, $sql);
        if (mysqli_num_rows($res) > 0) {
          while ($data = mysqli_fetch_array($res)) { ?>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
              <div class="card movie-card border-2 shadow-lg" data-aos="fade-up" data-aos-delay="100">
                <div class="movie-img-container position-relative">
                  <img src="admin/uploads/<?= $data['image'] ?>" class="card-img-top" alt="<?= $data['title'] ?>">
                  <div class="overlay d-flex align-items-center justify-content-center">
                    <a href="admin/uploads/<?= $data['trailer'] ?>" target="_blank" class="btn btn-light btn-sm px-3">
                      Watch Trailer
                    </a>
                  </div>
                </div>
                <div class="card-body text-center" style="background: rgb(0, 0, 0);">
                  <h5 class="card-title text-white"><?= $data['title'] ?></h5>
                  <span class="badge bg-warning"><?= $data['catname'] ?></span>
                </div>
              </div>
            </div>
        <?php }
        } ?>
      </div>
    </div>
  </section>

  <?php include('footer.php'); ?>

</body>
</html>
