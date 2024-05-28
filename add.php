<?php
session_start();
?>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  <h1>Add Student</h1>

  <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>Swal.fire('Error', 'File is not an image.', 'error');</script>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo "<script>Swal.fire('Error', 'Sorry, your file is too large.', 'error');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>Swal.fire('Error', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.', 'error');</script>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>Swal.fire('Error', 'Sorry, your file was not uploaded.', 'error');</script>";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "record";

                $idno = $_POST['idno'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $image = $target_file;

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO stud_info (IDno, FName, LName, image) VALUES ('$idno', '$fname', '$lname', '$image')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>Swal.fire('Success', 'New student created successfully.', 'success').then(() => window.location.href = 'view.php');</script>";
                } else {
                    if ($conn->errno == 1062) {
                        echo "<script>Swal.fire('Error', 'Duplicate ID, please try again.', 'error');</script>";
                    } else {
                        echo "<script>Swal.fire('Error', 'Error: " . $sql . "<br>" . $conn->error . "', 'error');</script>";
                    }
                }

                $conn->close();
            } else {
                echo "<script>Swal.fire('Error', 'Sorry, there was an error uploading your file.', 'error');</script>";
            }
        }
    }
  ?>

  <form action="add.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="idno">ID Number:</label>
      <input type="number" class="form-control" id="idno" name="idno" required>
    </div>
    <div class="form-group">
      <label for="fname">First Name:</label>
      <input type="text" class="form-control" id="fname" name="fname" required>
    </div>
    <div class="form-group">
      <label for="lname">Last Name:</label>
      <input type="text" class="form-control" id="lname" name="lname" required>
    </div>
    <div class="form-group">
      <label for="image">Image:</label>
      <input type="file" class="form-control-file" id="image" name="image" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>

</body>
</html>
