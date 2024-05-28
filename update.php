<!DOCTYPE html>
<html lang="en">
<head>
  <title>.:: Update School Info ::.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->
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
  <h1>Update Student</h1>
  
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $original_id = $_POST["original_IDno"]; // Get the original ID number
        $id = $_POST["IDno"];
        $fname = $_POST["FName"];
        $lname = $_POST["LName"];
        
        // Handle the image upload
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
          $target_dir = "img/";
          $target_file = $target_dir . basename($_FILES["image"]["name"]);
          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file; // Use the new image path
          }
        } else {
          $image = $_POST["current_image"]; // Use the current image path if no new image is uploaded
        }

        // Check for duplicate ID
        $check_duplicate_sql = "SELECT * FROM stud_info WHERE IDno='$id' AND IDno != '$original_id'";
        $duplicate_result = $conn->query($check_duplicate_sql);
        if ($duplicate_result->num_rows > 0) {
            echo "<script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Duplicate ID. Try again with a different ID.'
                    }).then(function() {
                      window.location.href = 'update.php?id=$original_id';
                    });
                  </script>";
        } else {
            $sql = "UPDATE stud_info SET IDno='$id', FName='$fname', LName='$lname', image='$image' WHERE IDno='$original_id'"; // Update the image path in the database
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                        Swal.fire({
                          icon: 'success',
                          title: 'Success',
                          text: 'Record updated successfully!'
                        }).then(function() {
                          window.location.href = 'view.php';
                        });
                      </script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
    
    $sql = "SELECT * FROM stud_info";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table border=1 style='border-collapse: collapse' class='table table-bordered'>";
      echo "<tr>";
      echo "<th>ID</th>";
      echo "<th>Address</th>";
      echo "<th>Courses</th>";
      echo "<th>Image</th>";
      echo "<th>Action</th>";
      echo "</tr>";
      while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["IDno"] . "</td>";
        echo "<td>" . $row["FName"] . "</td>";
        echo "<td>" . $row["LName"] . "</td>";
        echo "<td><img src='" . $row["image"] . "' width='100' height='100'></td>"; // Display the image
        echo "<td><a href='update.php?id=".$row["IDno"]."' class='btn btn-warning'>Update</a></td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "0 results";
    }

  ?>

  <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the existing record based on the ID
        $sql = "SELECT * FROM stud_info WHERE IDno='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $fname = $row["FName"];
          $lname = $row["LName"];
          $image = $row["image"];
        }
        echo "<form method='post' action='".$_SERVER['PHP_SELF']."' enctype='multipart/form-data' class='mt-4'>";
        echo "<input type='hidden' name='original_IDno' value='".$id."'>"; // Add this line
        echo "<input type='hidden' name='current_image' value='".$image."'>"; // Add this line
        echo "<div class='form-group'>";
        echo "<label for='IDno'>ID:</label>";
        echo "<input type='number' class='form-control' name='IDno' value='".$id."' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='FName'>Address:</label>";
        echo "<input type='text' class='form-control' name='FName' value='".$fname."' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='LName'>Courses:</label>";
        echo "<input type='text' class='form-control' name='LName' value='".$lname."' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='current_image'>Current Image:</label><br>";
        echo "<img src='".$image."' width='100' height='100'><br>";
        echo "<label for='image'>Update Image:</label>";
        echo "<input type='file' class='form-control-file' name='image'>";
        echo "</div>";
        echo "<button type='submit' class='btn btn-primary'>Update</button>";
        echo "</form>";
    }

    // Close connection
    $conn->close();
  ?>
</div>

</body>
</html>
