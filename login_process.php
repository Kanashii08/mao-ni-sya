<?php
session_start();

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

$username = $_POST['username'];
$password = $_POST['password'];

// Prepare SQL statement to retrieve user from database
$sql = "SELECT * FROM signlog WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Username and password match found, redirect accordingly
    $row = $result->fetch_assoc();
    if ($username === "admin") {
        $_SESSION['username'] = $username;
        header("Location: index_1.php"); // Redirect to admin dashboard
    } else {
        $_SESSION['username'] = $username;
        header("Location: user.php"); // Redirect to user dashboard
    }
    exit(); // Ensure no further code execution after redirection
} else {
    // Username and password match not found, display error message
    $_SESSION['login_error'] = "Invalid username or password";
    echo "<script>alert('Invalid username or password'); window.location.href = 'login.php';</script>";
    exit(); // Ensure no further code execution after displaying the message
}

// Close database connection
$conn->close();
?>
