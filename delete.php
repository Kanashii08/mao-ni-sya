<!DOCTYPE html>
<html lang="en">
<head>
  <title>.:: School Info Sys ::.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="index_1.php">
    <img src="img/logo.png" alt="Logo" style="width:40px;">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="add.php">Add</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view.php">View</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="update.php">Update</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="delete.php">Delete</a>
      </li>
    </ul>
  </div>
</nav>
<br>

<div class="container">
  <h1>Delete Student</h1>
  
  <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "record";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['id'])) {
      $id = $_GET['id'];

      // Fetch the image file path before deleting the record
      $sql_fetch_image = "SELECT image FROM stud_info WHERE IDno='$id'";
      $result_fetch_image = $conn->query($sql_fetch_image);
      if ($result_fetch_image->num_rows > 0) {
        $row = $result_fetch_image->fetch_assoc();
        $image_path = $row["image"];
        // Delete the image file
        if (file_exists($image_path)) {
          unlink($image_path);
        }
      }

      // Delete the record from the database
      $sql = "DELETE FROM stud_info WHERE IDno='$id'";
      if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Record deleted successfully');
                window.location.href = 'delete.php';
              </script>";
      } else {
        echo "<div class='alert alert-danger'>Error deleting record: " . $conn->error . "</div>";
      }
    }

  

    $sql = "SELECT * FROM stud_info";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table class='table table-bordered'>";
      echo "<thead><tr><th>ID</th><th>Address</th><th>Courses</th><th>Image</th><th>Action</th></tr></thead><tbody>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["IDno"] . "</td>";
        echo "<td>" . $row["FName"] . "</td>";
        echo "<td>" . $row["LName"] . "</td>";
        echo "<td><img src='" . $row["image"] . "' width='100' height='100'></td>";
        echo "<td><a href='delete.php?id=" . $row["IDno"] . "' class='btn btn-danger'>Delete</a></td>";
        echo "</tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<div class='alert alert-warning'>0 results</div>";
    }

    $conn->close();
  ?>
</div>

</body>
</html>
