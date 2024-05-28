<?php

    // File upload handling
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			// File uploaded successfully, proceed with database insertion
			$servername = "localhost";

			$username = "root";
			$password = "";
			$dbname = "record";
		
			$idno = $_POST['idno'];
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$image = $target_file; // Use $target_file here
		
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			}
		
			$sql = "INSERT INTO stud_info VALUES ('$idno', '$fname', '$lname', '$image')";
		
			if ($conn->query($sql) === TRUE) {
			  echo "New student created successfully";
			  echo "<script>";
			  echo "alert('New student created successfully');";
			  echo "window.location.href = 'view.php';";
			  echo "</script>";
			} else {
			  echo "Error: " . $sql . "<br>" . $conn->error;
			}
		
			$conn->close();
		}
	}
		