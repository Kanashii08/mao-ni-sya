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
  <h1>View School</h1>
		
  <!-- Search form -->
  <form action="" method="GET" class="form-inline mb-3">
    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
  </form>

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

	// Check if a search query is submitted
	if(isset($_GET['query'])) {
		$search_query = $_GET['query'];
		$sql = "SELECT * FROM stud_info WHERE IDno LIKE '%$search_query%' OR FName LIKE '%$search_query%' OR LName LIKE '%$search_query%'";
	} else {
		$sql = "SELECT * FROM stud_info";
	}

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  echo "<table border=1 style='border-collapse: collapse'>";
	  echo "<tr>";
	  echo "<th>ID</th>";
	  echo "<th>Address</th>";
	  echo "<th>Courses</th>";
	  echo "<th>Image</th>";
	  echo "</tr>";
	  while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row["IDno"] . "</td>";
		echo "<td>" . $row["FName"] . "</td>";
		echo "<td>" . $row["LName"] . "</td>";
		echo "<td><img src='" . $row["image"] . "' width='100' height='100'></td>"; // Display the image
		echo "</tr>";
	  }
	  
	  echo "</table>";
	} else {
	  echo "0 results";
	}
	$conn->close();
  ?>
</div>

</body>
</html>
