<?php 
include('../connect.php');

if (!isset($_SESSION['uid'])) {
    echo "<script> window.location.href='../login.php';  </script>";
}

// Handle delete operation
if (isset($_GET['deleteid'])) {
    $deleteid = intval($_GET['deleteid']);
    $sql = "DELETE FROM `theater` WHERE `theaterid` = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $deleteid);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Theater deleted successfully');</script>";
        echo "<script>window.location.href='theater.php';</script>";
    } else {
        echo "<script>alert('Error deleting theater: " . mysqli_error($con) . "');</script>";
    }
    mysqli_stmt_close($stmt);
}

// Handle add/edit operation
if (isset($_POST['add'])) {
    // Sanitize input
    $movieid = intval($_POST['movieid']);
    $theater_name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['theater_name']));
    $days = htmlspecialchars(mysqli_real_escape_string($con, $_POST['days']));
    $timing = $_POST['timing'];
    $price = floatval($_POST['price']);
    $date = $_POST['date'];
    $location = htmlspecialchars(mysqli_real_escape_string($con, $_POST['location']));

    // Validation check
    if (empty($movieid) || empty($theater_name) || empty($days) || empty($timing) || empty($price) || empty($date) || empty($location)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        if (isset($_POST['editid']) && !empty($_POST['editid'])) {
            // Update theater
            $editid = intval($_POST['editid']);
            $sql = "UPDATE `theater` SET `theater_name`=?, `timing`=?, `days`=?, `date`=?, `price`=?, `location`=?, `movieid`=? WHERE `theaterid`=?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssssdsii", $theater_name, $timing, $days, $date, $price, $location, $movieid, $editid);
        } else {
            // Insert new theater
            $sql = "INSERT INTO `theater`(`theater_name`, `timing`, `days`, `date`, `price`, `location`, `movieid`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssssdsi", $theater_name, $timing, $days, $date, $price, $location, $movieid);
        }

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Theater saved successfully');</script>";
            echo "<script>window.location.href='theater.php';</script>";
        } else {
            echo "<script>alert('Error saving theater: " . mysqli_error($con) . "');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}

// For edit, fetch the existing data for the form if editid is set
if (isset($_GET['editid'])) {
    $editid = intval($_GET['editid']);
    $sql = "SELECT * FROM `theater` WHERE `theaterid` = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $editid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $editData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater Management</title>
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
                  <h3><?= isset($editData) ? 'Update Theater' : 'Add Theater'; ?></h3>
                </div>
                <div class="card-body">
                  <form action="theater.php" method="post">
                      <input type="hidden" name="editid" value="<?= isset($editData) ? $editData['theaterid'] : ''; ?>">
                      
                      <div class="form-group mb-4">
                          <input type="text" class="form-control" name="theater_name" placeholder="Enter Theater Name" value="<?= isset($editData) ? $editData['theater_name'] : ''; ?>" required>
                      </div>
                      <div class="form-group mb-4">
                          <select name="movieid" class="form-control" required>
                              <option value="">Select Movie</option>
                              <?php
                              $sql = "SELECT * FROM `movies`";
                              $res = mysqli_query($con, $sql);
                              while ($data = mysqli_fetch_array($res)) {
                                  echo "<option value='{$data['movieid']}' " . (isset($editData) && $data['movieid'] == $editData['movieid'] ? 'selected' : '') . ">{$data['title']}</option>";
                              }
                              ?>
                          </select>
                      </div>                     
                      <div class="form-group mb-4">
                          <input type="time" class="form-control" name="timing" value="<?= isset($editData) ? $editData['timing'] : ''; ?>" required>
                      </div>                    
                      <div class="form-group mb-4">
                          <input type="text" class="form-control" name="days" placeholder="Enter Days" value="<?= isset($editData) ? $editData['days'] : ''; ?>" required>
                      </div>      
                      <div class="form-group mb-4">
                          <input type="date" class="form-control" name="date" value="<?= isset($editData) ? $editData['date'] : ''; ?>" required>
                      </div>    
                      <div class="form-group mb-4">
                          <input type="number" class="form-control" name="price" placeholder="Enter Price" value="<?= isset($editData) ? $editData['price'] : ''; ?>" required>
                      </div> 
                      <div class="form-group mb-4">
                          <input type="text" class="form-control" name="location" placeholder="Enter Location" value="<?= isset($editData) ? $editData['location'] : ''; ?>" required>
                      </div>  
                      <div class="form-group">
                          <button type="submit" class="btn btn-warning w-100 fw-bold rounded-3" name="add"><i class="fas fa-save"></i> <?= isset($editData) ? 'Update Theater' : 'Add Theater'; ?></button>
                      </div>
                  </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-10 mx-auto my-5">
          <div class="card shadow-lg border-0 rounded-4">
            <h3 class="card-header bg-dark text-white text-center fs-4">Theater List</h3>
            <div class="card-body">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Theater</th>
                            <th>Movie</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Days/Time</th>
                            <th>Ticket</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php
                    $sql = "SELECT theater.*, movies.title, categories.catname 
                            FROM theater
                            INNER JOIN movies ON movies.movieid = theater.movieid
                            INNER JOIN categories ON categories.catid = movies.catid";
                    $res = mysqli_query($con, $sql);

                    while ($data = mysqli_fetch_array($res)) {
                        echo "<tr>
                            <td>{$data['theaterid']}</td>
                            <td>{$data['theater_name']}</td>
                            <td>{$data['title']}</td>
                            <td>{$data['catname']}</td>
                            <td>{$data['date']}</td>
                            <td>{$data['days']} - {$data['timing']}</td>
                            <td>{$data['price']}</td>
                            <td>{$data['location']}</td>
                            <td>
                                <a href='theater.php?editid={$data['theaterid']}' class='btn btn-sm btn-warning'>
                                    <i class='fas fa-edit'></i>
                                </a>
                                <a href='theater.php?deleteid={$data['theaterid']}' class='btn btn-sm btn-danger'>
                                    <i class='fas fa-trash'></i>
                                </a>
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
