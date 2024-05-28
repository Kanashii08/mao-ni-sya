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
  <a class="navbar-brand" href="#">School Info Sys</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
  
    <form class="form-inline my-2 my-lg-0" action="#" method="get">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <form class="form-inline my-2 my-lg-0" action="logout.php" method="post">
      <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
    </form>
  </div>  
</nav>

<div class="container">
  <h1>View School</h1>
		
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

	// Handle search
	if(isset($_GET['search'])) {
		$search = $_GET['search'];
		$sql = "SELECT * FROM stud_info WHERE FName LIKE '%$search%' OR LName LIKE '%$search%'";
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
