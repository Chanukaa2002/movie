<?php 
include('../connect.php');

if(!isset($_SESSION['uid'])){
  echo "<script> window.location.href='../login.php';  </script>";
}

// Handle Delete
if (isset($_GET['deleteid'])) {
    $deleteid = intval($_GET['deleteid']);
    $delete_sql = "DELETE FROM `movies` WHERE `movieid` = $deleteid";
    
    if (mysqli_query($con, $delete_sql)) {
        echo "<script>alert('Movie deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting movie');</script>";
    }
    echo "<script>window.location.href='movies.php';</script>";
    exit();
}

// Handle Edit
$edit_mode = false;
$edit_movie = [
    'movieid' => '',
    'catid' => '',
    'title' => '',
    'description' => '',
    'releasedate' => '',
    'image' => '',
    'trailer' => '',
    'movie' => ''
];

if (isset($_GET['editid'])) {
    $editid = intval($_GET['editid']);
    $result = mysqli_query($con, "SELECT * FROM `movies` WHERE `movieid` = $editid");

    if ($result && mysqli_num_rows($result) > 0) {
        $edit_movie = mysqli_fetch_assoc($result);
        $edit_mode = true;
    }
}

// Handle Add or Edit Submission
if (isset($_POST['submit'])) {
    $catid = mysqli_real_escape_string($con, $_POST['catid']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $releasedate = mysqli_real_escape_string($con, $_POST['releasedate']);

    if (empty($catid) || empty($title) || empty($description) || empty($releasedate)) {
        echo "<script>alert('Please fill all fields');</script>";
    } else {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        // File Handling
        $image = $_FILES['image']['name'] ? basename($_FILES['image']['name']) : $edit_movie['image'];
        $trailer = $_FILES['trailer']['name'] ? basename($_FILES['trailer']['name']) : $edit_movie['trailer'];
        $movie = $_FILES['movie']['name'] ? basename($_FILES['movie']['name']) : $edit_movie['movie'];

        if ($_FILES['image']['name']) move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image);
        if ($_FILES['trailer']['name']) move_uploaded_file($_FILES['trailer']['tmp_name'], $upload_dir . $trailer);
        if ($_FILES['movie']['name']) move_uploaded_file($_FILES['movie']['tmp_name'], $upload_dir . $movie);

        if ($edit_mode) {
            $sql = "UPDATE `movies` SET 
                    `title`='$title', `description`='$description', `releasedate`='$releasedate', 
                    `image`='$image', `trailer`='$trailer', `movie`='$movie', `catid`='$catid' 
                    WHERE `movieid` = ".$edit_movie['movieid'];
        } else {
            $sql = "INSERT INTO `movies`(`title`, `description`, `releasedate`, `image`, `trailer`, `movie`, `catid`) 
                    VALUES ('$title', '$description', '$releasedate', '$image', '$trailer', '$movie', '$catid')";
        }

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Movie " . ($edit_mode ? "updated" : "added") . " successfully!');</script>";
            echo "<script>window.location.href='movies.php';</script>";
        } else {
            echo "<script>alert('Error occurred. Try again!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

<div class="container" style="margin-top: 120px;">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-dark text-white text-center fs-4">
                  <h3><?= $edit_mode ? "Edit" : "Add" ?> Movie</h3>
                </div>
                <div class="card-body">
                  <form action="movies.php<?= $edit_mode ? "?editid=".$edit_movie['movieid'] : "" ?>" method="post" enctype="multipart/form-data">
                      <div class="mb-3">
                          <label class="form-label">Category</label>
                          <select name="catid" class="form-control">
                              <option value="">Select Category</option>
                              <?php
                              $sql = "SELECT * FROM `categories`";
                              $res = mysqli_query($con, $sql);
                              while ($data = mysqli_fetch_array($res)) {
                                  $selected = ($edit_movie['catid'] == $data['catid']) ? "selected" : "";
                                  echo "<option value='{$data['catid']}' $selected>{$data['catname']}</option>";
                              }
                              ?>
                          </select>
                      </div>
                      <div class="mb-3">
                          <input type="text" class="form-control" name="title" value="<?= $edit_movie['title'] ?>" placeholder="Enter title">
                      </div>
                      <div class="mb-3">
                          <input type="text" class="form-control" name="description" value="<?= $edit_movie['description'] ?>" placeholder="Enter description">
                      </div>
                      <div class="mb-3">
                          <input type="date" class="form-control" name="releasedate" value="<?= $edit_movie['releasedate'] ?>">
                      </div>
                      <div class="mb-3">
                          <label class="form-label">Poster</label>
                          <input type="file" class="form-control" name="image">
                      </div>
                      <div class="mb-3">
                          <label class="form-label">Trailer</label>
                          <input type="file" class="form-control" name="trailer">
                      </div>
                      <div class="mb-3">
                          <label class="form-label">Movie</label>
                          <input type="file" class="form-control" name="movie">
                      </div>

                      <button type="submit" class="btn btn-warning w-100 fw-bold rounded-3" name="submit"><i class="fas fa-save"></i> <?= $edit_mode ? "Update" : "Add" ?> Movie</button>
                  </form>
                </div>
            </div>
        </div>

        <div class="col-lg-10 mx-auto my-5">
            <div class="card shadow-lg border-0 rounded-4">
              <h3 class="card-header bg-dark text-white text-center fs-4">Movie List</h3>
              <div class="card-body">
                  <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                      <tr>
                          <th>#</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Poster</th>
                          <th>Actions</th>
                      </tr>
                    </thead>
                      <?php
                        $sql = "SELECT movies.*, categories.catname FROM movies INNER JOIN categories ON categories.catid = movies.catid";
                        $res = mysqli_query($con, $sql);
                        while ($data = mysqli_fetch_array($res)) {
                            echo "<tr>
                                <td>{$data['movieid']}</td>
                                <td>{$data['title']}</td>
                                <td>{$data['catname']}</td>
                                <td><img src='uploads/{$data['image']}' height='50' width='50'></td>
                                <td>
                                    <a href='movies.php?editid={$data['movieid']}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
                                    <a href='movies.php?deleteid={$data['movieid']}' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a>
                                </td>
                            </tr>";
                        }
                      ?>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

</body>
</html>
