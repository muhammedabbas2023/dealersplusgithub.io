<?php
// Establish a connection to the database
$conn = mysqli_connect("localhost", "root", "", "mydatabase");

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the entered username and password from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare the SQL statement to retrieve the user from the database
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// Check if the user exists
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Verify the password
    if (password_verify($password, $row['password'])) {
        // Password is correct, redirect to post.html
        header("Location: post.html");
        exit();
    } else {
        // Invalid password
        echo "Invalid password. Please try again.";
    }
} else {
    // User not found
    echo "User not found. Please try again.";
}

// Close the database connection
mysqli_close($conn);
?>
