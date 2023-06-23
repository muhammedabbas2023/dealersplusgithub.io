<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // Leave it empty if you didn't set a password during XAMPP installation
    $database = "mydatabase";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
	$mobile = $_POST['mobile'];
    $location = $_POST['location'];
    $rental_price = $_POST['rental_price'];
	$description = $_POST['description'];
	

    $image1 = file_get_contents($_FILES['image1']['tmp_name']);
    $image1_type = $_FILES['image1']['type'];
    $image1_data = base64_encode($image1);


    $stmt = $conn->prepare("INSERT INTO users (name, mobile, location, rental_price, description, image1, image1_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $mobile, $location, $rental_price, $description, $image1_data, $image1_type);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
?>
