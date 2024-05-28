<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "record";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

// Insert data into signlog table
$sql = "INSERT INTO signlog (username, password) VALUES ('$username', '$password')";

if ($conn->query($sql) === TRUE) {
    // Popup message
    echo "<script>alert('New record created successfully'); window.location.href = 'login.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
