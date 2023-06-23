<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // Enter your MySQL password here
    $database = "mydatabase"; // Replace with your database name

    // Create a new MySQLi object
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
		$registermobile = $_POST['registermobile'];


        // Check if the username already exists in the database
        $existingUserQuery = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $existingUserQuery);

        if (mysqli_num_rows($result) > 0) {
            // Username already exists, display an alert message and redirect to signup.html
            echo "<script>alert('Username already exists. Please choose a different username.'); window.location.href = 'signup.html';</script>";
        } else {
            // Username is unique, proceed with user registration
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the SQL statement to insert the user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, password, registermobile) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashedPassword, $registermobile);

            if ($stmt->execute()) {
                // Registration successful, display an alert message and redirect to login.html
                echo "<script>alert('Registration successful. Please log in.'); window.location.href = 'login.html';</script>";
            } else {
                // Registration failed, display an alert message and redirect to signup.html
                echo "<script>alert('Registration failed. Please try again.'); window.location.href = 'signup.html';</script>";
            }

            $stmt->close();
        }
    }

    $conn->close();
?>
