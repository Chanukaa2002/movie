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

<?php include('connect.php')  ?>
<?php include('header.php')  ?>

<section>
    <div class="container" data-aos="fade-up" style="margin-top: 50px;">
        <?php 
        $categories = [
            1 => "Hollywood",
            2 => "Bollywood",
            5 => "Kollywood"
        ];
        foreach ($categories as $catid => $category) :
        ?>

        <div class="section-title text-center">
            <h3><?= $category ?> <span>Movies</span></h3>
        </div>
        <div class="row mt-1">
            <?php
            $sql = "SELECT movies.*, categories.catname
                    FROM movies
                    INNER JOIN categories ON categories.catid = movies.catid
                    WHERE movies.catid = $catid
                    ORDER BY movies.movieid DESC";

            $res = mysqli_query($con, $sql);
            if(mysqli_num_rows($res) > 0) {
                while($data = mysqli_fetch_array($res)) {
            ?>
            <div class="col-lg-3 col-md-6 col-sm-12 mb-1">
                <div class="card movie-card border-2 shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="movie-img-container position-relative">
                        <img src="admin/uploads/<?= $data['image'] ?>" class="card-img-top" alt="<?= $data['title'] ?>">
                        <div class="overlay d-flex align-items-center justify-content-center">
                            <a href="admin/uploads/<?= $data['trailer'] ?>" target="_blank" class="btn btn-light btn-sm px-3">Watch Trailer</a>
                        </div>
                    </div>
                    <div class="card-body text-center" style="background: rgb(0, 0, 0);">
                        <h5 class="card-title text-white"><?= $data['title'] ?></h5>
                        <span class="badge bg-warning"><?= $data['catname'] ?></span>
                    </div>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include('footer.php')  ?>

</body>
</html>